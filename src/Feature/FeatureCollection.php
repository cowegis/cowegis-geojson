<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Feature;

use Cowegis\GeoJson\BaseGeoJsonObject;
use Cowegis\GeoJson\BoundingBox;

use function array_map;

/**
 * @psalm-import-type TSerializedBoundingBox from BoundingBox
 * @psalm-import-type TSerializedFeature from Feature
 * @psalm-type TSerializedFeatureCollection = array{
 *   type: string,
 *   features: list<TSerializedFeature>,
 *   bbox?: TSerializedBoundingBox
 * }
 * @extends BaseGeoJsonObject<TSerializedFeatureCollection>
 */
final class FeatureCollection extends BaseGeoJsonObject
{
    /** @var list<Feature> */
    private array $features = [];

    /** @param list<Feature> $features */
    public function __construct(array $features, BoundingBox|null $boundingBox = null)
    {
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

    /** @return list<Feature> */
    public function features(): array
    {
        return $this->features;
    }

    /**
     * @return TSerializedFeatureCollection
     *
     * @psalm-suppress InvalidReturnStatement
     * @psalm-suppress InvalidReturnType
     */
    public function jsonSerialize(): array
    {
        $data             = parent::jsonSerialize();
        $data['features'] = array_map(
            static function (Feature $feature): array {
                return $feature->jsonSerialize();
            },
            $this->features(),
        );

        return $data;
    }
}
