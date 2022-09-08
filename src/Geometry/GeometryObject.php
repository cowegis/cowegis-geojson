<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Geometry;

use Cowegis\GeoJson\BoundingBox;
use Cowegis\GeoJson\GeoJsonObject;

/**
 * @psalm-import-type TSerializedBoundingBox from BoundingBox
 * @psalm-import-type TSerializedLineString from LineString
 * @psalm-import-type TSerializedMultiLineString from MultiLineString
 * @psalm-import-type TSerializedMultiPoint from MultiPoint
 * @psalm-import-type TSerializedMultiPolygon from MultiPolygon
 * @psalm-import-type TSerializedPoint from Point
 * @psalm-import-type TSerializedPolygon from Polygon
 * @psalm-import-type TSerializedGeometryCollection from GeometryCollection
 * @psalm-type TSerializedMultiGeometry = TSerializedMultiPoint|TSerializedMultiPolygon|TSerializedMultiLineString
 * @psalm-type TSerializedSingleGeometry = TSerializedLineString|TSerializedPoint|TSerializedPolygon
 * @psalm-type TSerializedGeometry = TSerializedGeometryCollection|TSerializedMultiGeometry|TSerializedSingleGeometry
 * @template TSerialized of TSerializedGeometry
 * @extends GeoJsonObject<TSerialized>
 */
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
