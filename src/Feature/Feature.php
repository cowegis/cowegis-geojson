<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Feature;

use Cowegis\GeoJson\BaseGeoJsonObject;
use Cowegis\GeoJson\BoundingBox;
use Cowegis\GeoJson\Geometry\GeometryObject;

/**
 * @psalm-import-type TSerializedBoundingBox from BoundingBox
 * @psalm-import-type TSerializedGeometry from GeometryObject
 * @psalm-type TSerializedFeature = array{
 *   type: string,
 *   id?: string|int,
 *   bbox?: TSerializedBoundingBox,
 *   geometry: TSerializedGeometry,
 *   properties: array<string,mixed>
 * }
 * @extends BaseGeoJsonObject<TSerializedFeature>
 * @SuppressWarnings(PHPMD.ShortVariable)
 * @SuppressWarnings(PHPMD.ShortMethodName)
 */
final class Feature extends BaseGeoJsonObject
{
    private GeometryObject $geometry;

    /** @var array<string,mixed> */
    private array $properties;

    /** @var string|int|null */
    private $id;

    /**
     * @param array<string,mixed> $properties
     * @param string|int|null     $id
     */
    public function __construct(
        GeometryObject $geometry,
        array $properties,
        ?BoundingBox $bbox = null,
        $id = null
    ) {
        parent::__construct($bbox);

        $this->geometry   = $geometry;
        $this->properties = $properties;
        $this->id         = $id;
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

    /** @return string|int|null */
    public function id()
    {
        return $this->id;
    }

    /** {@inheritDoc} */
    public function jsonSerialize(): array
    {
        $data               = parent::jsonSerialize();
        $data['geometry']   = $this->geometry()->jsonSerialize();
        $data['properties'] = $this->properties();

        if ($this->id !== null) {
            $data['id'] = $this->id;
        }

        return $data;
    }
}
