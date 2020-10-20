<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Feature;

use Cowegis\GeoJson\BaseGeoJsonObject;
use Cowegis\GeoJson\BoundingBox;

final class FeatureCollection extends BaseGeoJsonObject
{
    /**
     * @var Feature[]
     */
    private $features = [];

    /** @param Feature[] $features */
    public function __construct(
        array $features,
        ?BoundingBox $boundingBox = null
    ) {
        parent::__construct($boundingBox);

        foreach ($features as $feature) {
            $this->append($feature);
        }
    }

    private function append(Feature $feature): void
    {
        $this->features[] = $feature;
    }

    public function type(): string
    {
        return self::FEATURE_COLLECTION;
    }

    /**
     * @return Feature[]
     */
    public function features(): array
    {
        return $this->features;
    }

    /** @return array<string,mixed> */
    public function jsonSerialize(): array
    {
        $data             = parent::jsonSerialize();
        $data['features'] = $this->features;

        return $data;
    }
}
