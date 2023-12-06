<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Geometry;

use Cowegis\GeoJson\BoundingBox;
use Cowegis\GeoJson\Position\Coordinates;

/**
 * @psalm-import-type TSerializedBoundingBox from BoundingBox
 * @psalm-import-type TSerializedCoordinates from Coordinates
 * @psalm-type TSerializedPoint = array{
 *   type: string,
 *   coordinates: TSerializedCoordinates,
 *   bbox?: TSerializedBoundingBox
 * }
 * @extends GeometryWithCoordinates<TSerializedCoordinates, TSerializedPoint>
 */
final class Point extends GeometryWithCoordinates
{
    public function __construct(private readonly Coordinates $coordinates, BoundingBox|null $bbox = null)
    {
        parent::__construct($bbox);
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
