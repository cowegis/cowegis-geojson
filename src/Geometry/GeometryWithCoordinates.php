<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Geometry;

use Cowegis\GeoJson\BaseGeoJsonObject;
use Cowegis\GeoJson\BoundingBox;
use Cowegis\GeoJson\Exception\InvalidArgumentException;
use JsonSerializable;

use function is_array;

/**
 * @psalm-template TCoordinates
 * @psalm-import-type TSerializedBoundingBox from BoundingBox
 * @psalm-type TSerializedGeometryWithCoordinates = array{
 *   type: string,
 *   coordinates: mixed,
 *   bbox?: TSerializedBoundingBox
 * }
 */
abstract class GeometryWithCoordinates extends BaseGeoJsonObject implements GeometryObject
{
    /**
     * @return mixed
     * @psalm-return TCoordinates
     */
    abstract public function coordinates();

    /**
     * @return array<string, mixed>
     * @psalm-return TSerializedGeometryWithCoordinates
     */
    public function jsonSerialize(): array
    {
        $data                = parent::jsonSerialize();
        $data['coordinates'] = $this->serializeCoordinates($this->coordinates());

        return $data;
    }

    /**
     * @param array<int,mixed>|JsonSerializable $coordinates
     * @psalm-param TCoordinates|JsonSerializable $coordinates
     *
     * @return array<mixed,mixed>
     */
    private function serializeCoordinates($coordinates): array
    {
        if ($coordinates instanceof JsonSerializable) {
            /** @psalm-suppress MixedMethodCall */
            $data = $coordinates->jsonSerialize();
            if (! is_array($data)) {
                throw new InvalidArgumentException('Serialized value needs to be an array');
            }

            return $data;
        }

        if (! is_array($coordinates)) {
            throw new InvalidArgumentException('Coordinates have to be an instanceof \JsonSerializable or an array');
        }

        /** @psalm-var array<int,mixed>|JsonSerializable $value */
        foreach ($coordinates as $key => $value) {
            $coordinates[$key] = $this->serializeCoordinates($value);
        }

        return $coordinates;
    }
}
