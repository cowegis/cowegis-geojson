<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Geometry;

use Cowegis\GeoJson\BaseGeoJsonObject;
use Cowegis\GeoJson\BoundingBox;
use Cowegis\GeoJson\Exception\InvalidArgumentException;
use JsonSerializable;

use function is_array;

/**
 * @template TCoordinates
 * @template TSerialized
 * @psalm-import-type TSerializedBoundingBox from BoundingBox
 * @extends BaseGeoJsonObject<TSerialized>
 */
abstract class GeometryWithCoordinates extends BaseGeoJsonObject implements GeometryObject
{
    /**
     * @return mixed
     * @psalm-return TCoordinates
     */
    abstract public function coordinates();

    /** {@inheritDoc} */
    public function jsonSerialize(): array
    {
        $data                = parent::jsonSerialize();
        $data['coordinates'] = $this->serializeCoordinates($this->coordinates());

        return $data;
    }

    /**
     * @param array<int,mixed>|JsonSerializable $coordinates
     * @psalm-param array|TCoordinates|JsonSerializable $coordinates
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
