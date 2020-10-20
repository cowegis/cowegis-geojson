<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\CoordinateReferenceSystem;

final class NamedCoordinateReferenceSystem implements CoordinateReferenceSystem
{
    /**
     * @var string
     */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function type(): string
    {
        return 'name';
    }

    /**
     * @return array<string,string>
     *
     * @psalm-return array{name: string}
     */
    public function properties(): array
    {
        return [
            'name' => $this->name,
        ];
    }

    /** @return array<string,mixed> */
    public function jsonSerialize(): array
    {
        return [
            'type'       => $this->type(),
            'properties' => $this->properties(),
        ];
    }

    public function equals(CoordinateReferenceSystem $crs): bool
    {
        if (! $crs instanceof self) {
            return false;
        }

        return $this->name === $crs->name;
    }
}
