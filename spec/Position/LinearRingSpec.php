<?php

declare(strict_types=1);

namespace spec\Cowegis\GeoJson\Position;

use Cowegis\GeoJson\Exception\InvalidArgumentException;
use Cowegis\GeoJson\Position\Coordinates;
use Cowegis\GeoJson\Position\LinearRing;
use JsonSerializable;
use PhpSpec\ObjectBehavior;

final class LinearRingSpec extends ObjectBehavior
{
    public function let() : void
    {
        $this->beConstructedWith(
            new Coordinates(0, 0),
            new Coordinates(1, 0),
            new Coordinates(2, 0),
            new Coordinates(0, 0)
        );
    }

    public function it_is_initializable() : void
    {
        $this->shouldHaveType(LinearRing::class);
    }

    public function it_requires_at_least_four_coordinates() : void
    {
        $this->beConstructedWith(
            new Coordinates(0, 0),
            new Coordinates(1, 0),
            new Coordinates(2, 0)
        );
        $this->shouldThrow(InvalidArgumentException::class)->duringInstantiation();
    }

    public function it_requires_equal_start_and_end_coordinates() : void
    {
        $this->beConstructedWith(
            new Coordinates(0, 0),
            new Coordinates(1, 0),
            new Coordinates(2, 0),
            new Coordinates(3, 0)
        );
        $this->shouldThrow(InvalidArgumentException::class)->duringInstantiation();
    }

    public function it_has_coordinates() : void
    {
        $this->coordinates()[0]->equals(new Coordinates(0, 0))->shouldReturn(true);
        $this->coordinates()[1]->equals(new Coordinates(1, 0))->shouldReturn(true);
        $this->coordinates()[2]->equals(new Coordinates(2, 0))->shouldReturn(true);
        $this->coordinates()[3]->equals(new Coordinates(0, 0))->shouldReturn(true);
    }

    public function it_is_json_serializable() : void
    {
        $this->shouldImplement(JsonSerializable::class);
        $this->jsonSerialize()->shouldBeArray();
        $this->jsonSerialize()->shouldHaveCount(4);
        $this->jsonSerialize()[0]->equals(new Coordinates(0, 0))->shouldReturn(true);
        $this->jsonSerialize()[1]->equals(new Coordinates(1, 0))->shouldReturn(true);
        $this->jsonSerialize()[2]->equals(new Coordinates(2, 0))->shouldReturn(true);
        $this->jsonSerialize()[3]->equals(new Coordinates(0, 0))->shouldReturn(true);
    }
}
