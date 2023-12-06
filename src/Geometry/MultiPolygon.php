<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Geometry;

use Cowegis\GeoJson\BoundingBox;
use Cowegis\GeoJson\Position\Coordinates;
use Cowegis\GeoJson\Position\LinearRing;

/**
 * @psalm-import-type TSerializedBoundingBox from BoundingBox
 * @psalm-import-type TSerializedCoordinates from Coordinates
 * @psalm-type TSerializedMultiPolygon = array{
 *   type: string,
 *   coordinates: list<list<list<TSerializedCoordinates>>>,
 *   bbox?: TSerializedBoundingBox
 * }
 * @extends GeometryWithCoordinates<list<list<LinearRing>>, TSerializedMultiPolygon>
 */
final class MultiPolygon extends GeometryWithCoordinates
{
    /**
     * @param LinearRing[][] $coordinates
     * @psalm-param list<list<LinearRing>> $coordinates
     */
    public function __construct(private readonly array $coordinates, BoundingBox|null $bbox = null)
    {
        parent::__construct($bbox);
    }

    public function type(): string
    {
        return self::MULTI_POLYGON;
    }

    /**
     * @return LinearRing[][]
     * @psalm-return list<list<LinearRing>>
     */
    public function coordinates(): array
    {
        return $this->coordinates;
    }
}
