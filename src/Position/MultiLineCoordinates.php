<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Position;

use Countable;
use InvalidArgumentException;
use JsonSerializable;

use function array_map;
use function array_values;
use function count;

/** @psalm-import-type TSerializedCoordinates from Coordinates */
final class MultiLineCoordinates implements JsonSerializable, Countable
{
    /**
     * @var MultiCoordinates[]
     * @psalm-var list<MultiCoordinates>
     */
    private array $coordinates;

    public function __construct(MultiCoordinates ...$coordinates)
    {
        foreach ($coordinates as $value) {
            if (count($value) < 2) {
                throw new InvalidArgumentException();
            }
        }

        $this->coordinates = array_values($coordinates);
    }

    /**
     * @return MultiCoordinates[]
     * @psalm-return list<MultiCoordinates>
     */
    public function coordinates(): array
    {
        return $this->coordinates;
    }

    public function count(): int
    {
        return count($this->coordinates);
    }

    /**
     * @return float[][][]
     * @psalm-return list<list<TSerializedCoordinates>>
     */
    public function jsonSerialize(): array
    {
        return array_map(
            static function (MultiCoordinates $coordinates) {
                return $coordinates->jsonSerialize();
            },
            $this->coordinates()
        );
    }
}
