<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Position;

use JsonSerializable;

/** @psalm-type TSerializedCoordinates = array{0: float, 1: float, 2?: float} */
final class Coordinates implements JsonSerializable
{
    public function __construct(
        private readonly float $longitude,
        private readonly float $latitude,
        private readonly float|null $altitude = null,
    ) {
    }

    public function latitude(): float
    {
        return $this->latitude;
    }

    public function longitude(): float
    {
        return $this->longitude;
    }

    public function altitude(): float|null
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
     * @psalm-return TSerializedCoordinates
     */
    public function jsonSerialize(): array
    {
        $data = [
            $this->longitude(),
            $this->latitude(),
        ];

        if ($this->altitude() !== null) {
            $data[] = $this->altitude();
        }

        return $data;
    }
}
