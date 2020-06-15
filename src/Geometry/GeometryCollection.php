<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Geometry;

use Cowegis\GeoJson\BaseGeoJsonObject;
use Cowegis\GeoJson\BoundingBox;
use Cowegis\GeoJson\CoordinateReferenceSystem\CoordinateReferenceSystem;

final class GeometryCollection extends BaseGeoJsonObject implements GeometryObject
{
    /** @var GeometryObject[] */
    private $geometries = [];

    /** @param GeometryObject[] $geometries */
    public function __construct(
        array $geometries,
        ?BoundingBox $boundingBox = null,
        ?CoordinateReferenceSystem $crs = null
    ) {
        parent::__construct($boundingBox, $crs);

        foreach ($geometries as $geometry) {
            $this->append($geometry);
        }
    }

    private function append(GeometryObject $geometry) : void
    {
        $this->geometries[] = $this->validateCrs($geometry, $this->crs());
    }

    public function type() : string
    {
        return self::GEOMETRY_COLLECTION;
    }

    public function geometries() : array
    {
        return $this->geometries;
    }

    public function withoutCrs() : self
    {
        return new self($this->geometries(), $this->boundingBox());
    }

    public function jsonSerialize() : array
    {
        $data               = parent::jsonSerialize();
        $data['geometries'] = $this->geometries();

        return $data;
    }
}
