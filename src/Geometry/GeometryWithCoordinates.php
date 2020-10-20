<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Geometry;

use Cowegis\GeoJson\BaseGeoJsonObject;

/**
 * @psalm-template TCoordinates
 * @psalm-import-type TSerializedBoundingBox from \Cowegis\GeoJson\BoundingBox
 * @psalm-type TSerializedGeometryWithCoordinates = array{
 *   type: string,
 *   coordinates: mixed,
 *   bbox?: TSerializedBoundingBox
 * }
 */
abstract class GeometryWithCoordinates extends BaseGeoJsonObject implements GeometryObject
{
    /**
     * @return mixed
     *
     * @psalm-return TCoordinates
     */
    abstract public function coordinates();

    /**
     * @return array<string, mixed>
     *
     * @psalm-return TSerializedGeometryWithCoordinates
     */
    public function jsonSerialize(): array
    {
        $data                = parent::jsonSerialize();
        $data['coordinates'] = $this->coordinates();

        return $data;
    }
}
