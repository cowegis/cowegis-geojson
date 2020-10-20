<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Geometry;

use Cowegis\GeoJson\BoundingBox;
use Cowegis\GeoJson\Position\Coordinates;

final class MultiPoint extends GeometryWithCoordinates
{
    /**
     * @var Coordinates
     */
    private $coordinates;

    public function __construct(
        Coordinates $coordinates,
        ?BoundingBox $bbox = null
    ) {
        parent::__construct($bbox);

        $this->coordinates = $coordinates;
    }

    public function type(): string
    {
        return self::MULTI_POINT;
    }

    public function coordinates(): Coordinates
    {
        return $this->coordinates;
    }
}
