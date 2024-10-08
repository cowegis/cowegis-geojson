<?php

declare(strict_types=1);

namespace Cowegis\GeoJson;

use Cowegis\GeoJson\Exception\InvalidArgumentException;
use Cowegis\GeoJson\Position\Coordinates;
use JsonSerializable;

use function sprintf;

/**
 * @psalm-type TSerialized2DBoundingBox = array{0: float, 1: float, 2: float, 3:float}
 * @psalm-type TSerialized3DBoundingBox = array{0: float, 1: float, 2: float, 3:float, 4: float, 5:float}
 * @psalm-type TSerializedBoundingBox = TSerialized2DBoundingBox|TSerialized3DBoundingBox
 */
final class BoundingBox implements JsonSerializable
{
    public function __construct(private readonly Coordinates $southWest, private readonly Coordinates $northEast)
    {
        if ($this->southWest->longitude() > $this->northEast->longitude()) {
            throw new InvalidArgumentException(
                sprintf(
                    'South west longitude "%s" is not more western than north east longitude "%s"',
                    $this->southWest->longitude(),
                    $this->northEast->longitude(),
                ),
            );
        }

        if ($this->southWest->latitude() > $this->northEast->latitude()) {
            throw new InvalidArgumentException(
                sprintf(
                    'South west latitude "%s" is not more southern than north east latitude "%s"',
                    $this->southWest->latitude(),
                    $this->northEast->latitude(),
                ),
            );
        }

        if ($this->southWest->altitude() === null && $this->northEast->altitude() !== null) {
            throw new InvalidArgumentException('North east coordinates contains altitude but south west doesn\'t.');
        }

        if ($this->northEast->altitude() === null && $this->southWest->altitude() !== null) {
            throw new InvalidArgumentException('South west coordinates contains altitude but north east doesn\'t.');
        }
    }

    public function southWest(): Coordinates
    {
        return $this->southWest;
    }

    public function northEast(): Coordinates
    {
        return $this->northEast;
    }

    /**
     * @return float[]
     * @psalm-return TSerializedBoundingBox
     */
    public function jsonSerialize(): array
    {
        $swAltitude = $this->southWest->altitude();
        $neAltitude = $this->northEast->altitude();

        if ($swAltitude === null || $neAltitude === null) {
            return [
                $this->southWest->longitude(),
                $this->southWest->latitude(),
                $this->northEast->longitude(),
                $this->northEast->latitude(),
            ];
        }

        return [
            $this->southWest->longitude(),
            $this->southWest->latitude(),
            $swAltitude,
            $this->northEast->longitude(),
            $this->northEast->latitude(),
            $neAltitude,
        ];
    }
}
