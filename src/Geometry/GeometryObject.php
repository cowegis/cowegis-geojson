<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Geometry;

use Cowegis\GeoJson\GeoJsonObject;

/** @extends GeoJsonObject<array<string,mixed>> */
interface GeometryObject extends GeoJsonObject
{
    public const POINT               = 'Point';
    public const MULTI_POINT         = 'MultiPoint';
    public const LINE_STRING         = 'LineString';
    public const MULTI_LINE_STRING   = 'MultiLineString';
    public const POLYGON             = 'Polygon';
    public const MULTI_POLYGON       = 'MultiPolygon';
    public const GEOMETRY_COLLECTION = 'GeometryCollection';
}
