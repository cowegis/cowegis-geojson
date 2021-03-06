<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Feature;

use Cowegis\GeoJson\BaseGeoJsonObject;
use Cowegis\GeoJson\BoundingBox;
use Cowegis\GeoJson\Geometry\GeometryObject;

/**
 * @psalm-import-type TSerializedBoundingBox from \Cowegis\GeoJson\BoundingBox
 * @psalm-type TSerializedFeature = array{
 *   type: string,
 *   bbox?: TSerializedBoundingBox,
 *   geometry: array<string,mixed>,
 *   properties: array<string,mixed>
 * }
 */
final class Feature extends BaseGeoJsonObject
{
    /**
     * @var GeometryObject
     */
    private $geometry;

    /**
     * @var array<string,mixed>
     */
    private $properties;

    /** @param array<string,mixed> $properties */
    public function __construct(
        GeometryObject $geometry,
        array $properties,
        ?BoundingBox $bbox = null
    ) {
        parent::__construct($bbox);

        $this->geometry   = $geometry;
        $this->properties = $properties;
    }

    public function type(): string
    {
        return self::FEATURE;
    }

    public function geometry(): GeometryObject
    {
        return $this->geometry;
    }

    /** @return array<string,mixed> */
    public function properties(): array
    {
        return $this->properties;
    }

    /**
     * @return array<string,mixed>
     *
     * @psalm-return TSerializedFeature
     */
    public function jsonSerialize(): array
    {
        $data               = parent::jsonSerialize();
        $data['geometry']   = $this->geometry()->jsonSerialize();
        $data['properties'] = $this->properties();

        return $data;
    }
}
