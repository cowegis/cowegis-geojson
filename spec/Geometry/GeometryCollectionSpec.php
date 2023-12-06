<?php

declare(strict_types=1);

namespace spec\Cowegis\GeoJson\Geometry;

use Cowegis\GeoJson\BoundingBox;
use Cowegis\GeoJson\Geometry\GeometryCollection;
use Cowegis\GeoJson\Geometry\GeometryObject;
use Cowegis\GeoJson\Position\Coordinates;
use PhpSpec\ObjectBehavior;

final class GeometryCollectionSpec extends ObjectBehavior
{
    public function let(GeometryObject $object1, GeometryObject $object2): void
    {
        $this->beConstructedWith([$object1, $object2]);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(GeometryCollection::class);
    }

    public function it_is_a_geometrty_collection(): void
    {
        $this->type()->shouldReturn(GeometryCollection::GEOMETRY_COLLECTION);
    }

    public function it_has_geometries(GeometryObject $object1, GeometryObject $object2): void
    {
        $this->geometries()->shouldReturn([$object1, $object2]);
    }

    public function it_has_a_bounding_box(GeometryObject $object1, GeometryObject $object2): void
    {
        $bbox = new BoundingBox(new Coordinates(0.0, 0.0), new Coordinates(0.0, 0.0));
        $this->beConstructedWith([$object1, $object2], $bbox);
        $this->boundingBox()->shouldReturn($bbox);
    }

    public function it_is_json_serializable(GeometryObject $object1, GeometryObject $object2): void
    {
        $bbox = new BoundingBox(new Coordinates(1.0, 0.0), new Coordinates(2.0, 0.0));
        $this->beConstructedWith([$object1, $object2], $bbox);

        $object1->jsonSerialize()->shouldBeCalled()->willReturn(['type' => 'Point', 'coordinates' => [0.0, 1.0]]);
        $object2->jsonSerialize()->shouldBeCalled()->willReturn(['type' => 'Point', 'coordinates' => [1.0, 1.0]]);

        $this->jsonSerialize()->shouldReturn(
            [
                'type' => 'GeometryCollection',
                'bbox' => [1.0, 0.0, 2.0, 0.0],
                'geometries' => [
                    ['type' => 'Point', 'coordinates' => [0.0, 1.0]],
                    ['type' => 'Point', 'coordinates' => [1.0, 1.0]],
                ],
            ],
        );
    }
}
