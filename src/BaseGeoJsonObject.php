<?php

declare(strict_types=1);

namespace Cowegis\GeoJson;

/**
 * @psalm-import-type TSerializedBoundingBox from \Cowegis\GeoJson\BoundingBox
 * @psalm-type TSerializedBaseGeoJsonObject = array{
 *   type: string,
 *   bbox?: TSerializedBoundingBox
 * }
 */
abstract class BaseGeoJsonObject implements GeoJsonObject
{
    /**
     * @var BoundingBox|null
     */
    private $boundingBox;

    public function __construct(?BoundingBox $boundingBox = null)
    {
        $this->boundingBox = $boundingBox;
    }

    public function boundingBox(): ?BoundingBox
    {
        return $this->boundingBox;
    }

    /**
     * @return array<string,mixed>
     *
     * @psalm-return TSerializedBaseGeoJsonObject
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
