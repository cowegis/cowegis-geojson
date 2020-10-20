<?php

declare(strict_types=1);

namespace Cowegis\GeoJson;

use JsonSerializable;

/**
 * Interface GeoJsonObject is a marker for objects which a full geo json object representations.
 */
interface GeoJsonObject extends JsonSerializable
{
    public const FEATURE = 'Feature';

    public const FEATURE_COLLECTION = 'FeatureCollection';

    public function type(): string;

    public function boundingBox(): ?BoundingBox;

    /** @return array<string,mixed> */
    public function jsonSerialize(): array;
}
