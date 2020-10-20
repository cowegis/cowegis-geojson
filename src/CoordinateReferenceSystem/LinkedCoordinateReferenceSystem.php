<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\CoordinateReferenceSystem;

final class LinkedCoordinateReferenceSystem implements CoordinateReferenceSystem
{
    /**
     * @var string
     */
    private $href;

    /**
     * @var string|null
     */
    private $type;

    public function __construct(string $href, ?string $type = null)
    {
        $this->href = $href;
        $this->type = $type;
    }

    public function type(): string
    {
        return 'link';
    }

    /** @return array<string,string> */
    public function properties(): array
    {
        return [
            'name' => $this->href,
            'type' => $this->type()
        ];
        $data = ['name' => $this->href];
        $type = $this->type();

        if ($type !== null) {
            $data['type'] = $type;
        }

        return $data;
    }

    /** @return array<string,mixed> */
    public function jsonSerialize()
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

        if ($this->href !== $crs->href) {
            return false;
        }

        return $this->type === $crs->type;
    }
}
