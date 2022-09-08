<?php

declare(strict_types=1);

namespace Cowegis\GeoJson;

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
    private ?BoundingBox $boundingBox;

    public function __construct(?BoundingBox $boundingBox = null)
    {
        $this->boundingBox = $boundingBox;
    }

    public function boundingBox(): ?BoundingBox
    {
        return $this->boundingBox;
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize(): array
    {
        $data = ['type' => $this->type()];

        $boundingBox = $this->boundingBox();
        if ($boundingBox !== null) {
            $data['bbox'] = $boundingBox->jsonSerialize();
        }

        return $data;
    }
}
