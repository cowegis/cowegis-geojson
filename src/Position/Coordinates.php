<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Position;

use JsonSerializable;

/**
 * @psalm-type TSerializedCoordinates = array{0: float, 1: float, 2?: float}
 */
final class Coordinates implements JsonSerializable
{
    /**
     * @var float
     */
    private $longitude;

    /**
     * @var float
     */
    private $latitude;

    /**
     * @var float|null
     */
    private $altitude;

    public function __construct(float $longitude, float $latitude, ?float $altitude = null)
    {
        $this->longitude = $longitude;
        $this->latitude  = $latitude;
        $this->altitude  = $altitude;
    }

    public function latitude(): float
    {
        return $this->latitude;
    }

    public function longitude(): float
    {
        return $this->longitude;
    }

    public function altitude(): ?float
    {
        return $this->altitude;
    }

    public function equals(Coordinates $position): bool
    {
        if ($this->latitude !== $position->latitude) {
            return false;
        }

        if ($this->longitude !== $position->longitude) {
            return false;
        }

        return $this->altitude === $position->altitude;
    }

    /**
     * @return array<int,float>
     *
     * @psalm-return TSerializedCoordinates
     */
    public function jsonSerialize(): array
    {
        $data = [
            $this->longitude(),
            $this->latitude(),
        ];

        if ($this->altitude()) {
            $data[] = $this->altitude();
        }

        return $data;
    }
}
