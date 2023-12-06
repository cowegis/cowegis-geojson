<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Geometry;

use Cowegis\GeoJson\BoundingBox;
use Cowegis\GeoJson\Exception\InvalidArgumentException;
use Cowegis\GeoJson\Position\Coordinates;
use Cowegis\GeoJson\Position\MultiCoordinates;

use function count;

/**
 * @psalm-import-type TSerializedBoundingBox from BoundingBox
 * @psalm-import-type TSerializedCoordinates from Coordinates
 * @psalm-type TSerializedLineString = array{
 *   type: string,
 *   coordinates: list<TSerializedCoordinates>,
 *   bbox?: TSerializedBoundingBox
 * }
 * @extends GeometryWithCoordinates<MultiCoordinates, TSerializedLineString>
 */
final class LineString extends GeometryWithCoordinates
{
    public function __construct(private readonly MultiCoordinates $coordinates, BoundingBox|null $bbox = null)
    {
        parent::__construct($bbox);

        if (count($this->coordinates) < 2) {
            throw new InvalidArgumentException('LineString requires at least 2 coordinates');
        }
    }

    public function type(): string
    {
        return self::LINE_STRING;
    }

    public function coordinates(): MultiCoordinates
    {
        return $this->coordinates;
    }
}
