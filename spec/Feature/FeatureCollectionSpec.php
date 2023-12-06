<?php

declare(strict_types=1);

namespace spec\Cowegis\GeoJson\Feature;

use Cowegis\GeoJson\BoundingBox;
use Cowegis\GeoJson\Feature\Feature;
use Cowegis\GeoJson\Feature\FeatureCollection;
use Cowegis\GeoJson\Geometry\GeometryObject;
use Cowegis\GeoJson\Position\Coordinates;
use JsonSerializable;
use PhpSpec\ObjectBehavior;

final class FeatureCollectionSpec extends ObjectBehavior
{
    private Feature $feature1;

    private Feature $feature2;

    public function let(GeometryObject $geometry1, GeometryObject $geometry2): void
    {
        $this->feature1 = new Feature($geometry1->getWrappedObject(), []);
        $this->feature2 = new Feature($geometry2->getWrappedObject(), []);
        $this->beConstructedWith([$this->feature1, $this->feature2]);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(FeatureCollection::class);
    }

    public function it_is_a_feature_collection(): void
    {
        $this->type()->shouldReturn(FeatureCollection::FEATURE_COLLECTION);
    }

    public function it_has_a_bounding_box(): void
    {
        $bbox = new BoundingBox(new Coordinates(1.0, 0.0), new Coordinates(2.0, 0.0));
        $this->beConstructedWith([$this->feature1, $this->feature2], $bbox);

        $this->boundingBox()->shouldReturn($bbox);
    }

    public function it_doesnt_require_a_bounding_box(): void
    {
        $this->boundingBox()->shouldReturn(null);
    }

    public function it_is_json_serializable(GeometryObject $geometry1, GeometryObject $geometry2): void
    {
        $this->shouldImplement(JsonSerializable::class);

        $geometry1->jsonSerialize()->shouldBeCalled()->willReturn(['type' => 'Point', 'coordinates' => [1.0, 1.0]]);
        $geometry2->jsonSerialize()->shouldBeCalled()->willReturn(['type' => 'Point', 'coordinates' => [0.0, 0.0]]);

        $this->jsonSerialize()->shouldReturn(
            [
                'type'     => 'FeatureCollection',
                'features' => [
                    [
                        'type'       => 'Feature',
                        'geometry'   => [
                            'type'        => 'Point',
                            'coordinates' => [1.0, 1.0],
                        ],
                        'properties' => [],
                    ],
                    [
                        'type'       => 'Feature',
                        'geometry'   => [
                            'type'        => 'Point',
                            'coordinates' => [0.0, 0.0],
                        ],
                        'properties' => [],
                    ],
                ],
            ],
        );
    }
}
