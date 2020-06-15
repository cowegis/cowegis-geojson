<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\CoordinateReferenceSystem;

use JsonSerializable;

interface CoordinateReferenceSystem extends JsonSerializable
{
    public function type() : string;

    public function properties() : array;

    public function equals(CoordinateReferenceSystem $crs) : bool;
}
