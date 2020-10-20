<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Geometry;

use Cowegis\GeoJson\BoundingBox;
use Cowegis\GeoJson\CoordinateReferenceSystem\CoordinateReferenceSystem;
use Cowegis\GeoJson\Position\MultiCoordinates;
use InvalidArgumentException;

use function count;

final class LineString extends GeometryWithCoordinates
{
    /**
     * @var MultiCoordinates
     */
    private $coordinates;

    public function __construct(
        MultiCoordinates $coordinates,
        ?BoundingBox $bbox = null,
        ?CoordinateReferenceSystem $crs = null
    ) {
        parent::__construct($bbox, $crs);

        if (count($coordinates) < 2) {
            throw new InvalidArgumentException();
        }

        $this->coordinates = $coordinates;
    }

    public function type(): string
    {
        return self::LINE_STRING;
    }

    public function coordinates(): MultiCoordinates
    {
        return $this->coordinates;
    }

    public function withoutCrs(): self
    {
        return new self($this->coordinates, $this->boundingBox());
    }
}
