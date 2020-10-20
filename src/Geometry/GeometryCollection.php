<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Geometry;

use Cowegis\GeoJson\BaseGeoJsonObject;
use Cowegis\GeoJson\BoundingBox;

use function array_map;

/**
 * @psalm-import-type TSerializedBoundingBox from \Cowegis\GeoJson\BoundingBox
 * @psalm-type TSerializedGeometryCollection = array{
 *   type: 'GeometryCollection',
 *   geometries: list<array<string,mixed>>,
 *   bbox?: TSerializedBoundingBox
 * }
 */
final class GeometryCollection extends BaseGeoJsonObject implements GeometryObject
{
    /**
     * @var GeometryObject[]
     * @psalm-var list<GeometryObject>
     */
    private $geometries = [];

    /**
     * @param GeometryObject[] $geometries
     *
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
     *
     * @psalm-return list<GeometryObject>
     */
    public function geometries(): array
    {
        return $this->geometries;
    }

    /**
     * @return array<string,mixed>
     *
     * @psalm-return TSerializedGeometryCollection
     */
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
