<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Feature;

use Cowegis\GeoJson\BaseGeoJsonObject;
use Cowegis\GeoJson\BoundingBox;
use Cowegis\GeoJson\CoordinateReferenceSystem\CoordinateReferenceSystem;

final class FeatureCollection extends BaseGeoJsonObject
{
    /** @var Feature[] */
    private $features = [];

    public function __construct(
        array $features,
        ?BoundingBox $boundingBox = null,
        ?CoordinateReferenceSystem $crs = null
    ) {
        parent::__construct($boundingBox, $crs);

        foreach ($features as $feature) {
            $this->append($feature);
        }
    }

    private function append(Feature $feature) : void
    {
        $this->features[] = $this->validateCrs($feature, $this->crs());
    }

    public function type() : string
    {
        return self::FEATURE_COLLECTION;
    }

    /**
     * @return Feature[]
     */
    public function features() : array
    {
        return $this->features;
    }

    public function withoutCrs() : self
    {
        return new self($this->features(), $this->boundingBox());
    }

    public function jsonSerialize() : array
    {
        $data             = parent::jsonSerialize();
        $data['features'] = $this->features;

        return $data;
    }
}
