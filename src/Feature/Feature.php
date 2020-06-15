<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Feature;

use ArrayObject;
use Cowegis\GeoJson\BaseGeoJsonObject;
use Cowegis\GeoJson\BoundingBox;
use Cowegis\GeoJson\CoordinateReferenceSystem\CoordinateReferenceSystem;
use Cowegis\GeoJson\Geometry\GeometryObject;

final class Feature extends BaseGeoJsonObject
{
    /** @var GeometryObject */
    private $geometry;

    /** @var array */
    private $properties;

    public function __construct(
        GeometryObject $geometry,
        array $properties,
        ?BoundingBox $bbox = null,
        ?CoordinateReferenceSystem $crs = null
    ) {
        parent::__construct($bbox, $crs);

        $this->geometry   = $this->validateCrs($geometry, $crs);
        $this->properties = $properties;
    }

    public function type() : string
    {
        return self::FEATURE;
    }

    public function geometry() : GeometryObject
    {
        return $this->geometry;
    }

    public function properties() : array
    {
        return $this->properties;
    }

    public function jsonSerialize() : array
    {
        $data               = parent::jsonSerialize();
        $data['geometry']   = $this->geometry()->jsonSerialize();
        $data['properties'] = $this->properties();

        return $data;
    }

    public function withoutCrs() : self
    {
        return new self($this->geometry, $this->properties, $this->boundingBox());
    }
}
