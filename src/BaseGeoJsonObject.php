<?php

declare(strict_types=1);

namespace Cowegis\GeoJson;


use Cowegis\GeoJson\CoordinateReferenceSystem\CoordinateReferenceSystem;

abstract class BaseGeoJsonObject implements GeoJsonObject
{
    /** @var CoordinateReferenceSystem|null */
    private $crs;

    /** @var BoundingBox|null */
    private $boundingBox;

    public function __construct(?BoundingBox $boundingBox = null, ?CoordinateReferenceSystem $crs = null)
    {
        $this->crs         = $crs;
        $this->boundingBox = $boundingBox;
    }

    public function crs() : ?CoordinateReferenceSystem
    {
        return $this->crs;
    }

    public function boundingBox() : ?BoundingBox
    {
        return $this->boundingBox;
    }

    public function jsonSerialize() : array
    {
        $data = ['type' => $this->type()];

        if ($this->crs()) {
            $data['crs'] = $this->crs()->jsonSerialize();
        }

        if ($this->boundingBox()) {
            $data['bbox'] = $this->boundingBox()->jsonSerialize();
        }

        return $data;
    }

    protected function validateCrs(GeoJsonObject $object, ?CoordinateReferenceSystem $crs) : GeoJsonObject
    {
        if ($object->crs() === null) {
            return $object;
        }

        if ($crs === null) {
            throw new \InvalidArgumentException();
        }

        if (! $object->crs()->equals($crs)) {
            throw new \InvalidArgumentException();
        }

        return $object->withoutCrs();
    }
}
