<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Geometry;

use Cowegis\GeoJson\BoundingBox;
use Cowegis\GeoJson\Position\Coordinates;
use Cowegis\GeoJson\Position\MultiLineCoordinates;

/**
 * @psalm-import-type TSerializedBoundingBox from BoundingBox
 * @psalm-import-type TSerializedCoordinates from Coordinates
 * @psalm-type TSerializedMultiLineString = array{
 *   type: string,
 *   coordinates: list<list<TSerializedCoordinates>>,
 *   bbox?: TSerializedBoundingBox
 * }
 * @extends GeometryWithCoordinates<MultiLineCoordinates, TSerializedMultiLineString>
 */
final class MultiLineString extends GeometryWithCoordinates
{
    public function __construct(private readonly MultiLineCoordinates $coordinates, BoundingBox|null $bbox = null)
    {
        parent::__construct($bbox);
    }

    public function type(): string
    {
        return self::MULTI_LINE_STRING;
    }

    public function coordinates(): MultiLineCoordinates
    {
        return $this->coordinates;
    }
}
