<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Geometry;

use Cowegis\GeoJson\BaseGeoJsonObject;
use Cowegis\GeoJson\BoundingBox;
use Cowegis\GeoJson\Exception\InvalidArgumentException;
use JsonSerializable;

use function is_array;

/**
 * @psalm-import-type TSerializedGeometry from GeometryObject
 * @psalm-import-type TSerializedBoundingBox from BoundingBox
 * @template TCoordinates
 * @template TSerialized of TSerializedGeometry
 * @extends BaseGeoJsonObject<TSerialized>
 */
abstract class GeometryWithCoordinates extends BaseGeoJsonObject implements GeometryObject
{
    /** @psalm-return TCoordinates */
    abstract public function coordinates(): object|array;

    /**
     * @return TSerialized
     *
     * @psalm-suppress ImplementedReturnTypeMismatch
     * @psalm-suppress InvalidReturnType
     * @psalm-suppress InvalidReturnStatement
     */
    public function jsonSerialize(): array
    {
        $data                = parent::jsonSerialize();
        $data['coordinates'] = $this->serializeCoordinates($this->coordinates());

        return $data;
    }

    /**
     * @param TCoordinates $coordinates
     *
     * @return array<mixed,mixed>
     */
    private function serializeCoordinates(object|array $coordinates): array
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

        /** @psalm-var TCoordinates $value */
        foreach ($coordinates as $key => $value) {
            $coordinates[$key] = $this->serializeCoordinates($value);
        }

        return $coordinates;
    }
}
