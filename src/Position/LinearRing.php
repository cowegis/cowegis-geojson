<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Position;

use Cowegis\GeoJson\Exception\InvalidArgumentException;
use JsonSerializable;

final class LinearRing implements JsonSerializable
{
    /** @var Coordinates */
    private $coordinates;

    public function __construct(Coordinates ... $coordinates)
    {
        $count = count($coordinates);
        if ($count < 4) {
            throw new InvalidArgumentException(sprintf('At least 4 coordinates required. %s given', $count));
        }

        if (! $coordinates[0]->equals($coordinates[$count - 1])) {
            throw new InvalidArgumentException('First and last coordinates needs to be the equal.');
        }

        $this->coordinates = $coordinates;
    }

    /**
     * @return Coordinates[]
     */
    public function coordinates() : array
    {
        return $this->coordinates;
    }

    public function jsonSerialize() : array
    {
        return $this->coordinates();
    }
}
