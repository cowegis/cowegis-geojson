<?php

declare(strict_types=1);

namespace spec\Cowegis\GeoJson\Position;

use Countable;
use Cowegis\GeoJson\Position\Coordinates;
use Cowegis\GeoJson\Position\MultiCoordinates;
use JsonSerializable;
use PhpSpec\ObjectBehavior;

final class MultiCoordinatesSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith(new Coordinates(0.0, 0.0), new Coordinates(1.0, 0.0, 0.5));
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(MultiCoordinates::class);
    }

    public function it_is_countable(): void
    {
        $this->shouldImplement(Countable::class);

        $this->count()->shouldReturn(2);
    }

    public function it_contains_coordinates(): void
    {
        $this->coordinates()->shouldBeArray();
        $this->coordinates()->shouldHaveCount(2);
        $this->coordinates()[0]->jsonSerialize()->shouldReturn([0.0, 0.0]);
        $this->coordinates()[1]->jsonSerialize()->shouldReturn([1.0, 0.0, 0.5]);
    }

    public function it_is_json_serializable(): void
    {
        $this->shouldImplement(JsonSerializable::class);

        $this->jsonSerialize()->shouldBeArray();
        $this->jsonSerialize()->shouldHaveCount(2);
        $this->jsonSerialize()[0]->jsonSerialize()->shouldReturn([0.0, 0.0]);
        $this->jsonSerialize()[1]->jsonSerialize()->shouldReturn([1.0, 0.0, 0.5]);
    }
}
