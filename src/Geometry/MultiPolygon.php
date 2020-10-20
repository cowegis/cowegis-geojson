<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Geometry;

use Cowegis\GeoJson\BoundingBox;
use Cowegis\GeoJson\CoordinateReferenceSystem\CoordinateReferenceSystem;
use Cowegis\GeoJson\Position\LinearRing;

final class MultiPolygon extends GeometryWithCoordinates
{
    /**
     * @var LinearRing[][]
     */
    private $coordinates;

    /**
     * @param LinearRing[][] $coordinates
     */
    public function __construct(
        array $coordinates,
        ?BoundingBox $bbox = null,
        ?CoordinateReferenceSystem $crs = null
    ) {
        parent::__construct($bbox, $crs);

        $this->coordinates = $coordinates;
    }

    public function type(): string
    {
        return self::MULTI_POLYGON;
    }

    /** @return LinearRing[][] */
    public function coordinates(): array
    {
        return $this->coordinates;
    }

    public function withoutCrs(): self
    {
        return new self($this->coordinates(), $this->boundingBox());
    }
}
