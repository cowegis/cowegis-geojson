<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Position;

use Countable;
use JsonSerializable;

final class MultiCoordinates implements JsonSerializable, Countable
{
    /** @var Coordinates */
    private $positions;

    public function __construct(Coordinates ... $positions)
    {
        $this->positions = $positions;
    }

    public function count() : int
    {
        return count($this->positions);
    }

    /** @return Coordinates[] */
    public function coordinates() : array
    {
        return $this->positions;
    }

    public function jsonSerialize() : array
    {
        return $this->coordinates();
    }
}
