<?php

declare(strict_types=1);

namespace spec\Cowegis\GeoJson;

use Cowegis\GeoJson\BoundingBox;
use Cowegis\GeoJson\Exception\InvalidArgumentException;
use Cowegis\GeoJson\Position\Coordinates;
use PhpSpec\ObjectBehavior;

final class BoundingBoxSpec extends ObjectBehavior
{
    private Coordinates $southWest;

    private Coordinates $northEast;

    public function let(): void
    {
        $this->southWest = new Coordinates(100.0, 0.0);
        $this->northEast = new Coordinates(105.0, 1.0);

        $this->beConstructedWith($this->southWest, $this->northEast);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(BoundingBox::class);
    }

    public function it_contains_south_west_coordinate(): void
    {
        $this->southWest()->shouldReturn($this->southWest);
    }

    public function it_contains_north_heast_coordinate(): void
    {
        $this->northEast()->shouldReturn($this->northEast);
    }

    public function it_is_json_serializable(): void
    {
        $this->jsonSerialize()->shouldReturn([100.0, 0.0, 105.0, 1.0]);
    }

    public function it_requires_north_east_altitude_if_south_west_altitude_given(): void
    {
        $this->beConstructedWith(new Coordinates(100.0, 0.0, 50.0), new Coordinates(105.0, 1.0));
        $this->shouldThrow(InvalidArgumentException::class)->duringInstantiation();
    }

    public function it_requires_south_west_altitude_if_north_east_altitude_given(): void
    {
        $this->beConstructedWith(new Coordinates(100.0, 0.0), new Coordinates(105.0, 1.0, 50.0));
        $this->shouldThrow(InvalidArgumentException::class)->duringInstantiation();
    }

    public function it_serializes_altitude(): void
    {
        $this->beConstructedWith(new Coordinates(100.0, 0.0, 50.0), new Coordinates(105.0, 1.0, 20.0));

        $this->jsonSerialize()->shouldReturn([100.0, 0.0, 50.0, 105.0, 1.0, 20.0]);
    }

    public function it_validates_correct_order_of_longitude_of_coordinates(): void
    {
        $this->beConstructedWith(new Coordinates(100.0, 0.0), new Coordinates(90.0, 0.0));
        $this->shouldThrow(InvalidArgumentException::class)->duringInstantiation();
    }

    public function it_validatescorrect_order_of__latitude_of_coordinates(): void
    {
        $this->beConstructedWith(new Coordinates(100.0, 2.0), new Coordinates(105.0, 0.0));
        $this->shouldThrow(InvalidArgumentException::class)->duringInstantiation();
    }
}
