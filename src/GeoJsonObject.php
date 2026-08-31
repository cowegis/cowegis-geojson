<?php

declare(strict_types=1);

namespace Cowegis\GeoJson;

use JsonSerializable;
use Override;

/**
 * Interface GeoJsonObject is a marker for objects which a full geo json object representations.
 *
 * @template TSerialized
 */
interface GeoJsonObject extends JsonSerializable
{
    public const string FEATURE = 'Feature';

    public const string FEATURE_COLLECTION = 'FeatureCollection';

    public function type(): string;

    public function boundingBox(): BoundingBox|null;

    /** @return TSerialized */
    #[Override]
    public function jsonSerialize(): array;
}
