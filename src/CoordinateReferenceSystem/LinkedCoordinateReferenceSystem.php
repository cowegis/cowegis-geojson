<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\CoordinateReferenceSystem;

final class LinkedCoordinateReferenceSystem implements CoordinateReferenceSystem
{
    /** @var string */
    private $href;

    /** @var string|null */
    private $type;

    public function __construct(string $href, ?string $type = null)
    {
        $this->href = $href;
        $this->type = $type;
    }

    public function type() : string
    {
        return 'link';
    }

    public function properties() : array
    {
        $data = ['name' => $this->href];
        if ($this->type() !== null) {
            $data['type'] = $this->type;
        }

        return $data;
    }

    public function jsonSerialize()
    {
        return [
            'type'       => $this->type(),
            'properties' => $this->properties(),
        ];
    }

    public function equals(CoordinateReferenceSystem $crs) : bool
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
