<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Feature;

use Cowegis\GeoJson\BaseGeoJsonObject;
use Cowegis\GeoJson\BoundingBox;

use function array_map;

/**
 * @psalm-import-type TSerializedBoundingBox from \Cowegis\GeoJson\BoundingBox
 * @psalm-import-type TSerializedFeature from \Cowegis\GeoJson\Feature\Feature
 * @psalm-type TSerializedFeatureCollection = array{
 *   type: 'FeatureCollection',
 *   features: list<TSerializedFeature>,
 *   bbox?: TSerializedBoundingBox
 * }
 */
final class FeatureCollection extends BaseGeoJsonObject
{
    /**
     * @var Feature[]
     * @psalm-var list<Feature>
     */
    private $features = [];

    /**
     * @param Feature[] $features
     *
     * @psalm-param list<Feature> $features
     */
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
     *
     * @psalm-return list<Feature>
     */
    public function features(): array
    {
        return $this->features;
    }

    /**
     * @return array<string,mixed>
     *
     * @psalm-return TSerializedFeatureCollection
     */
    public function jsonSerialize(): array
    {
        $data             = parent::jsonSerialize();
        $data['features'] = array_map(
            static function (Feature $feature): array {
                return $feature->jsonSerialize();
            },
            $this->features()
        );

        return $data;
    }
}
