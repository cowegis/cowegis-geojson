<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Geometry;

use Cowegis\GeoJson\BoundingBox;
use Cowegis\GeoJson\CoordinateReferenceSystem\CoordinateReferenceSystem;
use Cowegis\GeoJson\Position\Coordinates;

final class Point extends GeometryWithCoordinates
{
    /**
     * @var Coordinates
     */
    private $coordinates;

    public function __construct(
        Coordinates $coordinates,
        ?BoundingBox $bbox = null,
        ?CoordinateReferenceSystem $crs = null
    ) {
        parent::__construct($bbox, $crs);

        $this->coordinates = $coordinates;
    }

    public function type(): string
    {
        return self::POINT;
    }

    public function coordinates(): Coordinates
    {
        return $this->coordinates;
    }

    public function withoutCrs(): self
    {
        return new self($this->coordinates(), $this->boundingBox());
    }
}
