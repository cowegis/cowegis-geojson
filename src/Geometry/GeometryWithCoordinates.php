<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Geometry;

use Cowegis\GeoJson\BaseGeoJsonObject;

abstract class GeometryWithCoordinates extends BaseGeoJsonObject implements GeometryObject
{
    abstract public function coordinates();

    public function jsonSerialize() : array
    {
        $data                = parent::jsonSerialize();
        $data['coordinates'] = $this->coordinates();

        return $data;
    }
}
