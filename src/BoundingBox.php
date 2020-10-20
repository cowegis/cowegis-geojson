<?php

declare(strict_types=1);

namespace Cowegis\GeoJson;

use JsonSerializable;

/** @extends JsonSerializable<array<string,mixed>> */
interface BoundingBox extends JsonSerializable
{
    // TODO: Implement bounding boxes for each geometry/feature
}
