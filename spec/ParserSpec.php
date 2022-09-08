<?php

declare(strict_types=1);

namespace spec\Cowegis\GeoJson;

use Cowegis\GeoJson\Feature\Feature;
use Cowegis\GeoJson\Feature\FeatureCollection;
use Cowegis\GeoJson\Geometry\GeometryCollection;
use Cowegis\GeoJson\Geometry\LineString;
use Cowegis\GeoJson\Geometry\MultiLineString;
use Cowegis\GeoJson\Geometry\MultiPoint;
use Cowegis\GeoJson\Geometry\MultiPolygon;
use Cowegis\GeoJson\Geometry\Point;
use Cowegis\GeoJson\Geometry\Polygon;
use PhpSpec\ObjectBehavior;

final class ParserSpec extends ObjectBehavior
{
    public function it_parses_point_feature_from_string(): void
    {
        $json = <<<'GEOJSON'
{ 
    "type": "Feature",
    "geometry": {"type": "Point", "coordinates": [102.0, 0.5]},
    "properties": {"prop0": "value0"}
}
GEOJSON;

        $feature = $this->parseString($json);
        $feature->shouldBeAnInstanceOf(Feature::class);
        $feature->properties()->shouldBe(['prop0' => 'value0']);
        $feature->geometry()->shouldBeAnInstanceOf(Point::class);

        $feature->jsonSerialize()->shouldBe(
            [
                'type'       => 'Feature',
                'geometry'   => [
                    'type'        => 'Point',
                    'coordinates' => [102.0, 0.5],
                ],
                'properties' => ['prop0' => 'value0'],
            ]
        );
    }

    public function it_parses_multi_point_feature_from_string(): void
    {
        $json = <<<'GEOJSON'
{ 
    "type": "Feature",
    "geometry": {
        "type": "MultiPoint",
        "coordinates": [
          [102.0, 0.0], [103.0, 1.0], [104.0, 0.0], [105.0, 1.0]
        ]
    },
    "properties": {
        "prop0": "value0",
        "prop1": 0.0
    }
}
GEOJSON;

        $feature = $this->parseString($json);
        $feature->shouldBeAnInstanceOf(Feature::class);
        $feature->properties()->shouldBe(['prop0' => 'value0', 'prop1' => 0.0]);
        $feature->geometry()->shouldBeAnInstanceOf(MultiPoint::class);

        $feature->jsonSerialize()->shouldBe(
            [
                'type'       => 'Feature',
                'geometry'   => [
                    'type'        => 'MultiPoint',
                    'coordinates' => [
                        [102.0, 0.0],
                        [103.0, 1.0],
                        [104.0, 0.0],
                        [105.0, 1.0],
                    ],
                ],
                'properties' => [
                    'prop0' => 'value0',
                    'prop1' => 0.0,
                ],
            ]
        );
    }

    public function it_parses_line_string_feature_from_string(): void
    {
        $json = <<<'GEOJSON'
{ 
    "type": "Feature",
    "geometry": {
        "type": "LineString",
        "coordinates": [
          [102.0, 0.0], [103.0, 1.0], [104.0, 0.0], [105.0, 1.0]
        ]
    },
    "properties": {
        "prop0": "value0",
        "prop1": 0.0
    }
}
GEOJSON;

        $feature = $this->parseString($json);
        $feature->shouldBeAnInstanceOf(Feature::class);
        $feature->properties()->shouldBe(['prop0' => 'value0', 'prop1' => 0.0]);
        $feature->geometry()->shouldBeAnInstanceOf(LineString::class);

        $feature->jsonSerialize()->shouldBe(
            [
                'type'       => 'Feature',
                'geometry'   => [
                    'type'        => 'LineString',
                    'coordinates' => [
                        [102.0, 0.0],
                        [103.0, 1.0],
                        [104.0, 0.0],
                        [105.0, 1.0],
                    ],
                ],
                'properties' => [
                    'prop0' => 'value0',
                    'prop1' => 0.0,
                ],
            ]
        );
    }

    public function it_parses_multi_line_string_feature_from_string(): void
    {
        $json = <<<'GEOJSON'
{ 
    "type": "Feature",
    "geometry": {
        "type": "MultiLineString",
        "coordinates": [
          [[102.0, 0.0], [103.0, 1.0], [104.0, 0.0], [105.0, 1.0]],
          [[102.0, 0.0], [103.0, 1.0], [104.0, 0.0], [105.0, 1.0]]
        ]
    },
    "properties": {
        "prop0": "value0",
        "prop1": 0.0
    }
}
GEOJSON;

        $feature = $this->parseString($json);
        $feature->shouldBeAnInstanceOf(Feature::class);
        $feature->properties()->shouldBe(['prop0' => 'value0', 'prop1' => 0.0]);
        $feature->geometry()->shouldBeAnInstanceOf(MultiLineString::class);

        $feature->jsonSerialize()->shouldBe(
            [
                'type'       => 'Feature',
                'geometry'   => [
                    'type'        => 'MultiLineString',
                    'coordinates' => [
                        [
                            [102.0, 0.0],
                            [103.0, 1.0],
                            [104.0, 0.0],
                            [105.0, 1.0],
                        ],
                        [
                            [102.0, 0.0],
                            [103.0, 1.0],
                            [104.0, 0.0],
                            [105.0, 1.0],
                        ],
                    ],
                ],
                'properties' => [
                    'prop0' => 'value0',
                    'prop1' => 0.0,
                ],
            ]
        );
    }

    public function it_parses_polygon_feature_from_string(): void
    {
        $json = <<<'GEOJSON'
{ 
    "type": "Feature",
    "geometry": {
        "type": "Polygon",
        "coordinates": [
          [ [100.0, 0.0], [101.0, 0.0], [101.0, 1.0],
            [100.0, 1.0], [100.0, 0.0] ]
        ]
    },
    "properties": {
        "prop0": "value0",
        "prop1": {"this": "that"}
    }
}
GEOJSON;

        $feature = $this->parseString($json);
        $feature->shouldBeAnInstanceOf(Feature::class);
        $feature->properties()->shouldBe(['prop0' => 'value0', 'prop1' => ['this' => 'that']]);
        $feature->geometry()->shouldBeAnInstanceOf(Polygon::class);

        $feature->jsonSerialize()->shouldBe(
            [
                'type'       => 'Feature',
                'geometry'   => [
                    'type'        => 'Polygon',
                    'coordinates' => [
                        [
                            [100.0, 0.0],
                            [101.0, 0.0],
                            [101.0, 1.0],
                            [100.0, 1.0],
                            [100.0, 0.0],
                        ],
                    ],
                ],
                'properties' => [
                    'prop0' => 'value0',
                    'prop1' => ['this' => 'that'],
                ],
            ]
        );
    }

    public function it_parses_multi_polygon_feature_from_string(): void
    {
        $json = <<<'GEOJSON'
{ 
    "type": "Feature",
    "geometry": {
        "type": "MultiPolygon",
        "coordinates": [
          [[ [100.0, 0.0], [101.0, 0.0], [101.0, 1.0],
            [100.0, 1.0], [100.0, 0.0] ]],
          [[ [100.0, 0.0], [101.0, 0.0], [101.0, 1.0],
            [100.0, 1.0], [100.0, 0.0] ]]
        ]
    },
    "properties": {
        "prop0": "value0",
        "prop1": {"this": "that"}
    }
}
GEOJSON;

        $feature = $this->parseString($json);
        $feature->shouldBeAnInstanceOf(Feature::class);
        $feature->properties()->shouldBe(['prop0' => 'value0', 'prop1' => ['this' => 'that']]);
        $feature->geometry()->shouldBeAnInstanceOf(MultiPolygon::class);

        $feature->jsonSerialize()->shouldBe(
            [
                'type'       => 'Feature',
                'geometry'   => [
                    'type'        => 'MultiPolygon',
                    'coordinates' => [
                        [
                            [
                                [100.0, 0.0],
                                [101.0, 0.0],
                                [101.0, 1.0],
                                [100.0, 1.0],
                                [100.0, 0.0],
                            ],
                        ],
                        [
                            [
                                [100.0, 0.0],
                                [101.0, 0.0],
                                [101.0, 1.0],
                                [100.0, 1.0],
                                [100.0, 0.0],
                            ],
                        ],
                    ],
                ],
                'properties' => [
                    'prop0' => 'value0',
                    'prop1' => ['this' => 'that'],
                ],
            ]
        );
    }

    public function it_parses_geometry_collection_from_string(): void
    {
        $json = <<<'GEOJSON'
{ 
    "type": "Feature",
    "geometry": {
        "type": "GeometryCollection", 
        "geometries": [
            {
                "type": "LineString",
                "coordinates": [
                  [102.0, 0.0], [103.0, 1.0], [104.0, 0.0], [105.0, 1.0]
                ]
            },
            {"type": "Point", "coordinates": [102.0, 0.5]}
        ]
    },
    "properties": {"prop0": "value0"}
}
GEOJSON;

        $feature = $this->parseString($json);
        $feature->shouldBeAnInstanceOf(Feature::class);
        $feature->properties()->shouldBe(['prop0' => 'value0']);
        $feature->geometry()->shouldBeAnInstanceOf(GeometryCollection::class);

        $feature->jsonSerialize()->shouldBe(
            [
                'type'       => 'Feature',
                'geometry'   => [
                    'type'       => 'GeometryCollection',
                    'geometries' => [
                        [
                            'type'        => 'LineString',
                            'coordinates' => [
                                [102.0, 0.0],
                                [103.0, 1.0],
                                [104.0, 0.0],
                                [105.0, 1.0],
                            ],
                        ],
                        [
                            'type'        => 'Point',
                            'coordinates' => [102.0, 0.5],
                        ],
                    ],
                ],
                'properties' => ['prop0' => 'value0'],
            ]
        );
    }

    public function it_parses_feature_collection_from_string(): void
    {
        $json = <<<'GEOJSON'
{ 
    "type": "FeatureCollection",
    "features": [
        {
            "type": "Feature", 
            "geometry": {
                "type": "LineString",
                "coordinates": [
                  [102.0, 0.0], [103.0, 1.0], [104.0, 0.0], [105.0, 1.0]
                ]
            }
        },
        {
            "type": "Feature",
            "geometry": {
                "type": "Point", 
                "coordinates": [102.0, 0.5]
            }
        }
    ]
}
GEOJSON;

        $featureCollection = $this->parseString($json);
        $featureCollection->shouldBeAnInstanceOf(FeatureCollection::class);

        $featureCollection->jsonSerialize()->shouldBe(
            [
                'type'     => 'FeatureCollection',
                'features' => [
                    [
                        'type'       => 'Feature',
                        'geometry'   => [
                            'type'        => 'LineString',
                            'coordinates' => [
                                [102.0, 0.0],
                                [103.0, 1.0],
                                [104.0, 0.0],
                                [105.0, 1.0],
                            ],
                        ],
                        'properties' => [],
                    ],
                    [
                        'type'       => 'Feature',
                        'geometry'   => [
                            'type'        => 'Point',
                            'coordinates' => [102.0, 0.5],
                        ],
                        'properties' => [],
                    ],
                ],
            ]
        );
    }
}
