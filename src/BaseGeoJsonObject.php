<?php

declare(strict_types=1);

namespace Cowegis\GeoJson;

use Cowegis\GeoJson\CoordinateReferenceSystem\CoordinateReferenceSystem;
use InvalidArgumentException;

/** @psalm-template TGeoJsonObject */
abstract class BaseGeoJsonObject implements GeoJsonObject
{
    /**
     * @var BoundingBox|null
     */
    private $boundingBox;

    public function __construct(?BoundingBox $boundingBox = null)
    {
        $this->boundingBox = $boundingBox;
    }

    public function crs(): ?CoordinateReferenceSystem
    {
        return $this->crs;
    }

    public function boundingBox(): ?BoundingBox
    {
        return $this->boundingBox;
    }

    /** @return array<string,mixed> */
    public function jsonSerialize(): array
    {
        $data = ['type' => $this->type()];
        $crs  = $this->crs();

        if ($crs !== null) {
            $data['crs'] = $crs->jsonSerialize();
        }

        $boundingBox = $this->boundingBox();
        if ($boundingBox !== null) {
            $data['bbox'] = $boundingBox->jsonSerialize();
        }

        return $data;
    }

    /**
     * @psalm-param TGeoJsonObject&GeoJsonObject $object
     * @psalm-return TGeoJsonObject&GeoJsonObject
     */
    protected function validateCrs(GeoJsonObject $object, ?CoordinateReferenceSystem $crs): GeoJsonObject
    {
        $objectCrs = $object->crs();
        if ($objectCrs === null) {
            return $object;
        }

        if ($crs === null) {
            throw new InvalidArgumentException();
        }

        if (! $objectCrs->equals($crs)) {
            throw new InvalidArgumentException();
        }

        return $object->withoutCrs();
    }
}
