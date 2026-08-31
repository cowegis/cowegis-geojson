<?php

declare(strict_types=1);

namespace Cowegis\GeoJson;

use Override;

/**
 * @template TSerialized
 * @psalm-import-type TSerializedBoundingBox from BoundingBox
 * @psalm-type TSerializedBaseGeoJsonObject = array{
 *   type: string,
 *   bbox?: TSerializedBoundingBox
 * }
 * @implements GeoJsonObject<TSerialized>
 */
abstract class BaseGeoJsonObject implements GeoJsonObject
{
    public function __construct(private readonly BoundingBox|null $boundingBox = null)
    {
    }

    #[Override]
    public function boundingBox(): BoundingBox|null
    {
        return $this->boundingBox;
    }

    /** {@inheritDoc} */
    #[Override]
    public function jsonSerialize(): array
    {
        $data = ['type' => $this->type()];

        $boundingBox = $this->boundingBox();
        if ($boundingBox instanceof BoundingBox) {
            $data['bbox'] = $boundingBox->jsonSerialize();
        }

        return $data;
    }
}
