<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Position;

use Countable;
use JsonSerializable;

use function array_map;
use function array_values;
use function count;

/** @psalm-import-type TSerializedCoordinates from Coordinates */
final class MultiCoordinates implements JsonSerializable, Countable
{
    /**
     * @psalm-var list<Coordinates>
     * @var Coordinates[]
     */
    private array $positions;

    public function __construct(Coordinates ...$positions)
    {
        $this->positions = array_values($positions);
    }

    public function count(): int
    {
        return count($this->positions);
    }

    /**
     * @return Coordinates[]
     * @psalm-return list<Coordinates>
     */
    public function coordinates(): array
    {
        return $this->positions;
    }

    /**
     * @return array<int, array<string,float>>
     * @psalm-return list<TSerializedCoordinates>
     */
    public function jsonSerialize(): array
    {
        return array_map(
            static function (Coordinates $coordinates) {
                return $coordinates->jsonSerialize();
            },
            $this->coordinates(),
        );
    }
}
