<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\CoordinateReferenceSystem;

use JsonSerializable;

/** @extends JsonSerializable<array<string,mixed>> */
interface CoordinateReferenceSystem extends JsonSerializable
{
    public function type(): string;

    /** @return array<string,mixed> */
    public function properties(): array;

    public function equals(CoordinateReferenceSystem $crs): bool;
}
