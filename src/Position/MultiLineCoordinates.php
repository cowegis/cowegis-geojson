<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Position;

use InvalidArgumentException;
use JsonSerializable;

use function count;

final class MultiLineCoordinates implements JsonSerializable
{
    /**
     * @var MultiCoordinates[]
     */
    private $coordinates;

    public function __construct(MultiCoordinates ...$coordinates)
    {
        foreach ($coordinates as $value) {
            if (count($value) < 2) {
                throw new InvalidArgumentException();
            }
        }

        $this->coordinates = $coordinates;
    }

    /**
     * @return MultiCoordinates[]
     */
    public function coordinates(): array
    {
        return $this->coordinates;
    }

    /**
     * @return MultiCoordinates[]
     */
    public function jsonSerialize(): array
    {
        return $this->coordinates;
    }
}
