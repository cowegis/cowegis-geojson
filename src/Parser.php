<?php

declare(strict_types=1);

namespace Cowegis\GeoJson;

use Cowegis\GeoJson\Exception\InvalidArgumentException;
use Cowegis\GeoJson\Feature\Feature;
use Cowegis\GeoJson\Feature\FeatureCollection;
use Cowegis\GeoJson\Geometry\GeometryCollection;
use Cowegis\GeoJson\Geometry\GeometryObject;
use Cowegis\GeoJson\Geometry\LineString;
use Cowegis\GeoJson\Geometry\MultiLineString;
use Cowegis\GeoJson\Geometry\MultiPoint;
use Cowegis\GeoJson\Geometry\MultiPolygon;
use Cowegis\GeoJson\Geometry\Point;
use Cowegis\GeoJson\Geometry\Polygon;
use Cowegis\GeoJson\Position\Coordinates;
use Cowegis\GeoJson\Position\LinearRing;
use Cowegis\GeoJson\Position\MultiCoordinates;
use Cowegis\GeoJson\Position\MultiLineCoordinates;

use function array_map;
use function count;
use function json_decode;
use function sprintf;

use const JSON_THROW_ON_ERROR;

/**
 * @psalm-import-type TSerializedBoundingBox from BoundingBox
 * @psalm-import-type TSerialized2DBoundingBox from BoundingBox
 * @psalm-import-type TSerialized3DBoundingBox from BoundingBox
 * @psalm-import-type TSerializedCoordinates from Coordinates
 * @psalm-import-type TSerializedFeature from Feature
 * @psalm-import-type TSerializedFeatureCollection from FeatureCollection
 * @psalm-import-type TSerializedGeometryCollection from GeometryCollection
 * @psalm-import-type TSerializedLineString from LineString
 * @psalm-import-type TSerializedMultiLineString from MultiLineString
 * @psalm-import-type TSerializedMultiPoint from MultiPoint
 * @psalm-import-type TSerializedMultiPolygon from MultiPolygon
 * @psalm-import-type TSerializedPoint from Point
 * @psalm-import-type TSerializedPolygon from Polygon
 * @psalm-import-type TSerializedGeometry from GeometryObject
 * @psalm-type TGeoJson = TSerializedFeature|TSerializedFeatureCollection
 */
final class Parser
{
    public static function create(): self
    {
        return new self();
    }

    public function parseString(string $geoJson): GeoJsonObject
    {
        /** @psalm-var TGeoJson $data */
        $data = json_decode($geoJson, true, 512, JSON_THROW_ON_ERROR);

        return $this->parseArray($data);
    }

    /** @param TGeoJson $geoJson */
    public function parseArray(array $geoJson): GeoJsonObject
    {
        switch ($geoJson['type']) {
            case 'FeatureCollection':
                /** @psalm-var TSerializedFeatureCollection $geoJson */
                return new FeatureCollection(
                    array_map([$this, 'parseFeature'], $geoJson['features']),
                    $this->parseBoundingBox($geoJson['bbox'] ?? null),
                );

            case 'Feature':
                /** @psalm-var TSerializedFeature $geoJson */
                return $this->parseFeature($geoJson);

            default:
                throw new InvalidArgumentException(sprintf('Unsupported type "%s"', $geoJson['type']));
        }
    }

    /** @param TSerializedFeature $geoJson */
    private function parseFeature(array $geoJson): Feature
    {
        return new Feature(
            $this->parseGeometry($geoJson['geometry']),
            $geoJson['properties'] ?? [],
            $this->parseBoundingBox($geoJson['bbox'] ?? null),
        );
    }

    /** @param TSerializedGeometry $geoJson */
    private function parseGeometry(array $geoJson): GeometryObject
    {
        switch ($geoJson['type']) {
            case GeometryObject::POINT:
                /** @psalm-var TSerializedPoint $geoJson */
                return new Point(
                    $this->parseCoordinates($geoJson['coordinates']),
                    $this->parseBoundingBox($geoJson['bbox'] ?? null),
                );

            case GeometryObject::MULTI_POINT:
                /** @psalm-var TSerializedMultiPoint $geoJson */
                return new MultiPoint(
                    new MultiCoordinates(...array_map([$this, 'parseCoordinates'], $geoJson['coordinates'])),
                    $this->parseBoundingBox($geoJson['bbox'] ?? null),
                );

            case GeometryObject::LINE_STRING:
                /** @psalm-var TSerializedLineString $geoJson */
                return new LineString(
                    new MultiCoordinates(...array_map([$this, 'parseCoordinates'], $geoJson['coordinates'])),
                    $this->parseBoundingBox($geoJson['bbox'] ?? null),
                );

            case GeometryObject::MULTI_LINE_STRING:
                /** @psalm-var TSerializedMultiLineString $geoJson */
                return $this->parseMultiLineString($geoJson);

            case GeometryObject::POLYGON:
                /** @psalm-var TSerializedPolygon $geoJson */
                return $this->parsePolygon($geoJson);

            case GeometryObject::MULTI_POLYGON:
                /** @psalm-var TSerializedMultiPolygon $geoJson */
                return $this->parseMultiPolygon($geoJson);

            case GeometryObject::GEOMETRY_COLLECTION:
                /**
                 * @psalm-var TSerializedGeometryCollection $geoJson
                 * @psalm-var list<TSerializedGeometry> $geometries
                 */
                $geometries = $geoJson['geometries'];

                return new GeometryCollection(
                    array_map([$this, 'parseGeometry'], $geometries),
                    $this->parseBoundingBox($geoJson['bbox'] ?? null),
                );

            default:
                throw new InvalidArgumentException('Unknown geojson type ' . $geoJson['type']);
        }
    }

    /** @param TSerializedBoundingBox $boundingBox */
    private function parseBoundingBox(array|null $boundingBox): BoundingBox|null
    {
        if ($boundingBox === null) {
            return null;
        }

        if (count($boundingBox) === 6) {
            $southWest = [$boundingBox[0], $boundingBox[1], $boundingBox[2]];
            $northEast = [$boundingBox[3], $boundingBox[4], $boundingBox[5]];
        } else {
            /** @psalm-var TSerialized2DBoundingBox $boundingBox */
            $southWest = [$boundingBox[0], $boundingBox[1]];
            $northEast = [$boundingBox[2], $boundingBox[3]];
        }

        return new BoundingBox($this->parseCoordinates($southWest), $this->parseCoordinates($northEast));
    }

    /** @param TSerializedCoordinates $coordinates */
    private function parseCoordinates(array $coordinates): Coordinates
    {
        return new Coordinates($coordinates[0], $coordinates[1], $coordinates[2] ?? null);
    }

    /** @param TSerializedMultiPolygon $geoJson */
    private function parseMultiPolygon(array $geoJson): MultiPolygon
    {
        $rings = [];
        foreach ($geoJson['coordinates'] as $coordinates) {
            $current = [];

            foreach ($coordinates as $ring) {
                $current[] = new LinearRing(...array_map([$this, 'parseCoordinates'], $ring));
            }

            $rings[] = $current;
        }

        return new MultiPolygon($rings, $this->parseBoundingBox($geoJson['bbox'] ?? null));
    }

    /** @param TSerializedMultiLineString $geoJson */
    private function parseMultiLineString(array $geoJson): MultiLineString
    {
        $coordinates = [];
        foreach ($geoJson['coordinates'] as $lineString) {
            $coordinates[] = new MultiCoordinates(...array_map([$this, 'parseCoordinates'], $lineString));
        }

        return new MultiLineString(
            new MultiLineCoordinates(...$coordinates),
            $this->parseBoundingBox($geoJson['bbox'] ?? null),
        );
    }

    /** @param TSerializedPolygon $geoJson */
    private function parsePolygon(array $geoJson): Polygon
    {
        $rings = [];
        foreach ($geoJson['coordinates'] as $coordinates) {
            $rings[] = new LinearRing(...array_map([$this, 'parseCoordinates'], $coordinates));
        }

        return new Polygon($rings, $this->parseBoundingBox($geoJson['bbox'] ?? null));
    }
}
