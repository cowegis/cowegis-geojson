<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Geometry;

use Cowegis\GeoJson\BoundingBox;
use Cowegis\GeoJson\Position\Coordinates;

/** @extends GeometryWithCoordinates<Coordinates> */
final class Point extends GeometryWithCoordinates
{
    private Coordinates $coordinates;

    public function __construct(
        Coordinates $coordinates,
        ?BoundingBox $bbox = null
    ) {
        parent::__construct($bbox);

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
}
