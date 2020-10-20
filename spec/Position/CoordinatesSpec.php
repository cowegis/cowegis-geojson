<?php

declare(strict_types=1);

namespace spec\Cowegis\GeoJson\Position;

use Cowegis\GeoJson\Position\Coordinates;
use JsonSerializable;
use PhpSpec\ObjectBehavior;

final class CoordinatesSpec extends ObjectBehavior
{
    private const LATITUDE  = 13.3888599;
    private const LONGITUDE = 52.5170365;
    private const ALTITUDE  = 2.0;

    public function let(): void
    {
        $this->beConstructedWith(self::LONGITUDE, self::LATITUDE, self::ALTITUDE);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Coordinates::class);
    }

    public function it_is_json_serializable(): void
    {
        $this->shouldImplement(JsonSerializable::class);
    }

    public function it_describes_a_coordinate(): void
    {
        $this->latitude()->shouldReturn(self::LATITUDE);
        $this->longitude()->shouldReturn(self::LONGITUDE);
        $this->altitude()->shouldReturn(self::ALTITUDE);

        $this->jsonSerialize()->shouldReturn(
            [
                self::LONGITUDE,
                self::LATITUDE,
                self::ALTITUDE,
            ]
        );
    }

    public function it_has_an_optional_altitude(): void
    {
        $this->beConstructedWith(self::LONGITUDE, self::LATITUDE);

        $this->latitude()->shouldReturn(self::LATITUDE);
        $this->longitude()->shouldReturn(self::LONGITUDE);
        $this->altitude()->shouldBeNull();

        $this->jsonSerialize()->shouldReturn(
            [
                self::LONGITUDE,
                self::LATITUDE,
            ]
        );
    }

    public function it_it_comparable(): void
    {
        $this->equals(new Coordinates(self::LONGITUDE, self::LATITUDE, self::ALTITUDE))->shouldReturn(true);
        $this->equals(new Coordinates(self::LONGITUDE, self::LATITUDE))->shouldReturn(false);
        $this->equals(new Coordinates(self::LONGITUDE, 0, self::ALTITUDE))->shouldReturn(false);
    }
}
