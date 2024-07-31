<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Geometry;

use Cowegis\GeoJson\BaseGeoJsonObject;
use Cowegis\GeoJson\BoundingBox;

use function array_map;

/**
 * @psalm-import-type TSerializedBoundingBox from BoundingBox
 * @psalm-import-type TSerializedMultiGeometry from GeometryObject
 * @psalm-import-type TSerializedSingleGeometry from GeometryObject
 * @psalm-import-type TSerializedGeometry from GeometryObject
 * @psalm-type TSerializedGeometryCollection = array{
 *   type: string,
 *   geometries: list<mixed>,
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
    public function __construct(array $geometries, BoundingBox|null $boundingBox = null)
    {
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

    /**
     * @return TSerializedGeometryCollection
     *
     * @psalm-suppress InvalidReturnStatement
     * @psalm-suppress InvalidReturnType
     */
    public function jsonSerialize(): array
    {
        $data               = parent::jsonSerialize();
        $data['geometries'] = array_map(
            /** @return TSerializedGeometry */
            static function (GeometryObject $geometryObject): array {
                return $geometryObject->jsonSerialize();
            },
            $this->geometries,
        );

        return $data;
    }
}
