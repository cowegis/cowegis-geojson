<?php

declare(strict_types=1);

namespace spec\Cowegis\GeoJson\Geometry;

use Cowegis\GeoJson\BoundingBox;
use Cowegis\GeoJson\Geometry\MultiLineString;
use Cowegis\GeoJson\Position\Coordinates;
use Cowegis\GeoJson\Position\MultiCoordinates;
use Cowegis\GeoJson\Position\MultiLineCoordinates;
use PhpSpec\ObjectBehavior;

final class MultiLineStringSpec extends ObjectBehavior
{
    /** @var MultiLineCoordinates */
    private $coordinates;

    public function let(): void
    {
        $this->coordinates = new MultiLineCoordinates(
            new MultiCoordinates(new Coordinates(0.0, 0.0), new Coordinates(1.0, 0.0)),
            new MultiCoordinates(new Coordinates(2.0, 0.0), new Coordinates(3.0, 0.0))
        );
        $this->beConstructedWith($this->coordinates);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(MultiLineString::class);
    }

    public function it_is_a_multi_line_string(): void
    {
        $this->type()->shouldReturn(MultiLineString::MULTI_LINE_STRING);
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
                'type'        => 'MultiLineString',
                'bbox'        => [1.0, 0.0, 2.0, 0.0],
                'coordinates' => [
                    [[0.0, 0.0], [1.0, 0.0]],
                    [[2.0, 0.0], [3.0, 0.0]],
                ],
            ]
        );
    }
}
