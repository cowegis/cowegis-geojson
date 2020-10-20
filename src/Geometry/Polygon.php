<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Geometry;

use Cowegis\GeoJson\BoundingBox;
use Cowegis\GeoJson\Position\LinearRing;

/** @extends GeometryWithCoordinates<list<LinearRing>> */
final class Polygon extends GeometryWithCoordinates
{
    /**
     * @var LinearRing[]
     * @psalm-var list<LinearRing>
     */
    private $coordinates;

    /**
     * @param LinearRing[] $coordinates
     *
     * @psalm-param list<LinearRing> $coordinates
     */
    public function __construct(
        array $coordinates,
        ?BoundingBox $bbox = null
    ) {
        parent::__construct($bbox);

        $this->coordinates = $coordinates;
    }

    public function type(): string
    {
        return self::POLYGON;
    }

    /**
     * @return LinearRing[]
     *
     * @psalm-return list<LinearRing>
     */
    public function coordinates(): array
    {
        return $this->coordinates;
    }
}
