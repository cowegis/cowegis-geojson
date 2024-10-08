<?php

declare(strict_types=1);

namespace spec\Cowegis\GeoJson\Geometry;

use Cowegis\GeoJson\BoundingBox;
use Cowegis\GeoJson\Geometry\Point;
use Cowegis\GeoJson\Position\Coordinates;
use PhpSpec\ObjectBehavior;

final class PointSpec extends ObjectBehavior
{
    private Coordinates $coordinates;

    public function let(): void
    {
        $this->coordinates = new Coordinates(0.0, 0.0);
        $this->beConstructedWith($this->coordinates);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Point::class);
    }

    public function it_is_a_point(): void
    {
        $this->type()->shouldReturn(Point::POINT);
    }

    public function it_has_coordinates(): void
    {
        $this->coordinates()->shouldReturn($this->coordinates);
    }

    public function it_has_a_bounding_box(): void
    {
        $bbox = new BoundingBox(new Coordinates(0.0, 0.0), new Coordinates(0.0, 0.0));
        $this->beConstructedWith($this->coordinates, $bbox);
        $this->boundingBox()->shouldReturn($bbox);
    }

    public function it_is_json_serializable(): void
    {
        $bbox = new BoundingBox(new Coordinates(1.0, 0.0), new Coordinates(2.0, 0.0));
        $this->beConstructedWith($this->coordinates, $bbox);

        $this->jsonSerialize()->shouldReturn(
            [
                'type'        => 'Point',
                'bbox'        => [1.0, 0.0, 2.0, 0.0],
                'coordinates' => [0.0, 0.0],
            ],
        );
    }
}
