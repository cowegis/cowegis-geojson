<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Geometry;

use Cowegis\GeoJson\BaseGeoJsonObject;
use Cowegis\GeoJson\BoundingBox;

final class GeometryCollection extends BaseGeoJsonObject implements GeometryObject
{
    /**
     * @var GeometryObject[]
     */
    private $geometries = [];

    /**
     * @param GeometryObject[] $geometries
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

    /** @return GeometryObject[] */
    public function geometries(): array
    {
        return $this->geometries;
    }

    /** @return array<string,mixed> */
    public function jsonSerialize(): array
    {
        $data               = parent::jsonSerialize();
        $data['geometries'] = $this->geometries();

        return $data;
    }
}
