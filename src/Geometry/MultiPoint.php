<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Geometry;

use Cowegis\GeoJson\BoundingBox;
use Cowegis\GeoJson\Position\Coordinates;
use Cowegis\GeoJson\Position\MultiCoordinates;

/**
 * @psalm-import-type TSerializedBoundingBox from BoundingBox
 * @psalm-import-type TSerializedCoordinates from Coordinates
 * @psalm-type TSerializedMultiPoint = array{
 *   type: string,
 *   coordinates: list<TSerializedCoordinates>,
 *   bbox?: TSerializedBoundingBox
 * }
 * @extends GeometryWithCoordinates<MultiCoordinates, TSerializedMultiPoint>
 */
final class MultiPoint extends GeometryWithCoordinates
{
    private MultiCoordinates $coordinates;

    public function __construct(MultiCoordinates $coordinates, ?BoundingBox $bbox = null)
    {
        parent::__construct($bbox);

        $this->coordinates = $coordinates;
    }

    public function type(): string
    {
        return self::MULTI_POINT;
    }

    public function coordinates(): MultiCoordinates
    {
        return $this->coordinates;
    }
}
