<?php

declare(strict_types=1);

namespace Cowegis\GeoJson;

use JsonSerializable;

/**
 * Interface GeoJsonObject is a marker for objects which a full geo json object representations.
 *
 * @template TSerialized
 */
interface GeoJsonObject extends JsonSerializable
{
    public const FEATURE = 'Feature';

    public const FEATURE_COLLECTION = 'FeatureCollection';

    public function type(): string;

    public function boundingBox(): ?BoundingBox;

    /** @return TSerialized */
    public function jsonSerialize(): array;
}
