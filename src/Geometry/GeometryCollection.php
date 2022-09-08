<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Geometry;

use Cowegis\GeoJson\BaseGeoJsonObject;
use Cowegis\GeoJson\BoundingBox;

use function array_map;

/**
 * @psalm-import-type TSerializedBoundingBox from BoundingBox
 * @psalm-import-type TSerializedLineString from LineString
 * @psalm-import-type TSerializedMultiLineString from MultiLineString
 * @psalm-import-type TSerializedMultiPoint from MultiPoint
 * @psalm-import-type TSerializedMultiPolygon from MultiPolygon
 * @psalm-import-type TSerializedPoint from Point
 * @psalm-import-type TSerializedPolygon from Polygon
 * @psalm-import-type TSerializedMultiGeometry from GeometryObject
 * @psalm-import-type TSerializedSingleGeometry from GeometryObject
 * @psalm-import-type TSerializedGeometry from GeometryObject
 * @psalm-type TSerializedGeometryCollection = array{
 *   type: string,
 *   geometries: list<TSerializedMultiGeometry|TSerializedSingleGeometry>,
 *   bbox?: TSerializedBoundingBox
 * }
 * @extends BaseGeoJsonObject<TSerializedGeometryCollection>
 */
final class GeometryCollection extends BaseGeoJsonObject implements GeometryObject
{
    /**
     * @var GeometryObject[]
     * @psalm-var list<GeometryObject>
     */
    private array $geometries = [];

    /**
     * @param GeometryObject[] $geometries
     * @psalm-param list<GeometryObject> $geometries
     */
    public function __construct(
        array $geometries,
        ?BoundingBox $boundingBox = null
    ) {
        parent::__construct($boundingBox);

        foreach ($geometries as $geometry) {
            $this->append($geometry);
        }
    }

    private function append(GeometryObject $geometry): void
    {
        $this->geometries[] = $geometry;
    }

    public function type(): string
    {
        return self::GEOMETRY_COLLECTION;
    }

    /**
     * @return GeometryObject[]
     * @psalm-return list<GeometryObject>
     */
    public function geometries(): array
    {
        return $this->geometries;
    }

    /** {@inheritDoc} */
    public function jsonSerialize(): array
    {
        $data               = parent::jsonSerialize();
        $data['geometries'] = array_map(
            static function (GeometryObject $geometryObject): array {
                return $geometryObject->jsonSerialize();
            },
            $this->geometries()
        );

        return $data;
    }
}
