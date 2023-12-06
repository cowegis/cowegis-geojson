<?php

declare(strict_types=1);

namespace spec\Cowegis\GeoJson\Feature;

use Cowegis\GeoJson\BoundingBox;
use Cowegis\GeoJson\Feature\Feature;
use Cowegis\GeoJson\Geometry\GeometryObject;
use Cowegis\GeoJson\Position\Coordinates;
use JsonSerializable;
use PhpSpec\ObjectBehavior;

final class FeatureSpec extends ObjectBehavior
{
    private const PROPERTIES = [
        'foo' => 'foo',
        'bar' => 'baz',
    ];

    public function let(GeometryObject $geometry): void
    {
        $this->beConstructedWith($geometry, self::PROPERTIES);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Feature::class);
    }

    public function it_is_a_feature(): void
    {
        $this->type()->shouldReturn(Feature::FEATURE);
    }

    public function it_may_have_an_id(GeometryObject $geometry): void
    {
        $this->beConstructedWith($geometry, self::PROPERTIES, null, 2);

        $this->id()->shouldBe(2);
    }

    public function it_belongs_to_a_geometry(GeometryObject $geometry): void
    {
        $this->geometry()->shouldReturn($geometry);
    }

    public function it_has_properties(): void
    {
        $this->properties()->shouldReturn(self::PROPERTIES);
    }

    public function it_has_a_bounding_box(GeometryObject $geometry): void
    {
        $bbox = new BoundingBox(new Coordinates(1.0, 0.0), new Coordinates(2.0, 0.0));
        $this->beConstructedWith($geometry, self::PROPERTIES, $bbox);

        $this->boundingBox()->shouldReturn($bbox);
    }

    public function it_doesnt_require_a_bounding_box(): void
    {
        $this->boundingBox()->shouldReturn(null);
    }

    public function it_is_json_serializable(GeometryObject $geometry): void
    {
        $this->shouldImplement(JsonSerializable::class);

        $geometry->jsonSerialize()->shouldBeCalled()->willReturn(['type' => 'Point', 'coordinates' => [1.0, 1.0]]);

        $this->jsonSerialize()->shouldBe(
            [
                'type'       => 'Feature',
                'geometry'   => [
                    'type'        => 'Point',
                    'coordinates' => [1.0, 1.0],
                ],
                'properties' => self::PROPERTIES,
            ],
        );
    }

    public function it_is_json_serializable_containing_optional_values(GeometryObject $geometry): void
    {
        $bbox = new BoundingBox(new Coordinates(1.0, 0.0), new Coordinates(2.0, 0.0));
        $this->beConstructedWith($geometry, self::PROPERTIES, $bbox, 2);

        $this->shouldImplement(JsonSerializable::class);

        $geometry->jsonSerialize()->shouldBeCalled()->willReturn(['type' => 'Point', 'coordinates' => [1.0, 1.0]]);

        $this->jsonSerialize()->shouldBe(
            [
                'type'       => 'Feature',
                'bbox'       => [
                    1.0,
                    0.0,
                    2.0,
                    0.0,
                ],
                'geometry'   => [
                    'type'        => 'Point',
                    'coordinates' => [1.0, 1.0],
                ],
                'properties' => self::PROPERTIES,
                'id'         => 2,
            ],
        );
    }
}
