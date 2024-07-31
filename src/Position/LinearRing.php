<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Position;

use Cowegis\GeoJson\Exception\InvalidArgumentException;
use JsonSerializable;

use function array_map;
use function array_values;
use function count;
use function sprintf;

/** @psalm-import-type TSerializedCoordinates from Coordinates */
final class LinearRing implements JsonSerializable
{
    /**
     * @var Coordinates[]
     * @psalm-var list<Coordinates>
     */
    private array $coordinates;

    public function __construct(Coordinates ...$coordinates)
    {
        $count       = count($coordinates);
        $coordinates = array_values($coordinates);

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
     * @psalm-return list<Coordinates>
     */
    public function coordinates(): array
    {
        return $this->coordinates;
    }

    /**
     * @return array<int, array<string,float>>
     * @psalm-return list<TSerializedCoordinates>
     */
    public function jsonSerialize(): array
    {
        return array_map(
            /** @return TSerializedCoordinates */
            static function (Coordinates $coordinates): array {
                return $coordinates->jsonSerialize();
            },
            $this->coordinates(),
        );
    }
}
