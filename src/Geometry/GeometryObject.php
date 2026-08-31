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
 * @extends GeoJsonObject<TSerializedGeometry>
 */
interface GeometryObject extends GeoJsonObject
{
    public const string POINT               = 'Point';
    public const string MULTI_POINT         = 'MultiPoint';
    public const string LINE_STRING         = 'LineString';
    public const string MULTI_LINE_STRING   = 'MultiLineString';
    public const string POLYGON             = 'Polygon';
    public const string MULTI_POLYGON       = 'MultiPolygon';
    public const string GEOMETRY_COLLECTION = 'GeometryCollection';
}
