<?php

declare(strict_types=1);

namespace Cowegis\GeoJson;

use Cowegis\GeoJson\Exception\InvalidArgumentException;
use Cowegis\GeoJson\Position\Coordinates;
use JsonSerializable;

/**
 * @psalm-type TSerialized2DBoundingBox = array{0: float, 1: float, 2: float, 3:float}
 * @psalm-type TSerialized3DBoundingBox = array{0: float, 1: float, 2: float, 3:float, 4: float, 5:float}
 * @psalm-type TSerializedBoundingBox = TSerialized2DBoundingBox|TSerialized3DBoundingBox
 */
final class BoundingBox implements JsonSerializable
{
    /** @var Coordinates */
    private $southWest;

    /** @var Coordinates */
    private $northEast;

    public function __construct(Coordinates $southWest, Coordinates $northEast)
    {
        // TODO: Validate both coordinates if the most south western is used as $southWest

        if ($southWest->altitude() === null && $northEast->altitude() !== null) {
            throw new InvalidArgumentException('North east coordinates contains altitude but south west doesn\t.');
        }

        if ($northEast->altitude() === null && $southWest->altitude() !== null) {
            throw new InvalidArgumentException('South west coordinates contains altitude but north east doesn\t.');
        }

        $this->southWest = $southWest;
        $this->northEast = $northEast;
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
     *
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
