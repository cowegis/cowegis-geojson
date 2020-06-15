<?php

declare(strict_types=1);

namespace Cowegis\GeoJson;

use Cowegis\GeoJson\CoordinateReferenceSystem\CoordinateReferenceSystem;
use JsonSerializable;

/**
 * Interface GeoJsonObject is a marker for objects which a full geo json object representations.
 *
 * The difference between ConvertsToGeoJson and this interface is that ConvertsToGeoJson can also contain content
 * which is not convertable to the GeoJson format.
 */
interface GeoJsonObject extends JsonSerializable
{
    public const FEATURE = 'Feature';

    public  const FEATURE_COLLECTION = 'FeatureCollection';

    public function type() : string;

    public function crs() : ?CoordinateReferenceSystem;

    public function boundingBox() : ?BoundingBox;

    /**
     * Creates an instance without passing the bounding box.
     *
     * @return static
     */
    public function withoutCrs();
}
