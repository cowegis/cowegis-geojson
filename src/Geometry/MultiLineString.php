<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Geometry;

use Cowegis\GeoJson\BoundingBox;
use Cowegis\GeoJson\CoordinateReferenceSystem\CoordinateReferenceSystem;
use Cowegis\GeoJson\Position\MultiLineCoordinates;

final class MultiLineString extends GeometryWithCoordinates
{
    /** @var MultiLineCoordinates */
    private $coordinates;

    public function __construct(
        MultiLineCoordinates $coordinates,
        ?BoundingBox $bbox = null,
        ?CoordinateReferenceSystem $crs = null
    ) {
        parent::__construct($bbox, $crs);

        $this->coordinates = $coordinates;
    }

    public function type() : string
    {
        return self::MULTI_LINE_STRING;
    }

    public function coordinates() : MultiLineCoordinates
    {
        return $this->coordinates;
    }

    public function withoutCrs() : self
    {
        return new self($this->coordinates(), $this->boundingBox());
    }
}
