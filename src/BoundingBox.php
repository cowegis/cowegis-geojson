<?php

declare(strict_types=1);

namespace Cowegis\GeoJson;

use JsonSerializable;

interface BoundingBox extends JsonSerializable
{
    // TODO: Implement bounding boxes for each geometry/feature

    /** @return array<mixed,mixed> */
    public function jsonSerialize(): array;
}
