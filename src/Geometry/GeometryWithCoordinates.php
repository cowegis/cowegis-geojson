<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Geometry;

use Cowegis\GeoJson\BaseGeoJsonObject;

/**
 * @psalm-template TCoordinates
 */
abstract class GeometryWithCoordinates extends BaseGeoJsonObject implements GeometryObject
{
    /**
     * @return mixed
     *
     * @psalm-return TCoordinates
     */
    abstract public function coordinates();

    /** @return array<string, mixed> */
    public function jsonSerialize(): array
    {
        $data                = parent::jsonSerialize();
        $data['coordinates'] = $this->coordinates();

        return $data;
    }
}
