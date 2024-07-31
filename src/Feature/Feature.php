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
    /** @param array<string,mixed> $properties */
    public function __construct(
        private readonly GeometryObject $geometry,
        private readonly array $properties,
        BoundingBox|null $bbox = null,
        private readonly int|string|null $id = null,
    ) {
        parent::__construct($bbox);
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

    public function id(): string|int|null
    {
        return $this->id;
    }

    /**
     * @return TSerializedFeature
     *
     * @psalm-suppress InvalidReturnStatement
     * @psalm-suppress InvalidReturnType
     * @psalm-suppress LessSpecificImplementedReturnType
     */
    public function jsonSerialize(): array
    {
        $data               = parent::jsonSerialize();
        $data['geometry']   = $this->geometry->jsonSerialize();
        $data['properties'] = $this->properties;

        if ($this->id !== null) {
            $data['id'] = $this->id;
        }

        return $data;
    }
}
