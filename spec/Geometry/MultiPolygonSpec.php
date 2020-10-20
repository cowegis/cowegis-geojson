<?php

declare(strict_types=1);

namespace spec\Cowegis\GeoJson\Geometry;

use Cowegis\GeoJson\BoundingBox;
use Cowegis\GeoJson\Geometry\MultiPolygon;
use Cowegis\GeoJson\Position\Coordinates;
use Cowegis\GeoJson\Position\LinearRing;
use PhpSpec\ObjectBehavior;

final class MultiPolygonSpec extends ObjectBehavior
{
    /** @var LinearRing */
    private $coordinates;

    public function let(): void
    {
        $this->coordinates = [
            [
                new LinearRing(
                    new Coordinates(0.0, 0.0),
                    new Coordinates(1.0, 0.0),
                    new Coordinates(2.0, 0.0),
                    new Coordinates(0.0, 0.0)
                ),
            ],
            [
                new LinearRing(
                    new Coordinates(4.0, 0.0),
                    new Coordinates(5.0, 0.0),
                    new Coordinates(6.0, 0.0),
                    new Coordinates(4.0, 0.0)
                ),
            ],
        ];
        $this->beConstructedWith($this->coordinates);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(MultiPolygon::class);
    }

    public function it_is_a_multi_polygon(): void
    {
        $this->type()->shouldReturn(MultiPolygon::MULTI_POLYGON);
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
                'type'        => 'MultiPolygon',
                'bbox'        => [1.0, 0.0, 2.0, 0.0],
                'coordinates' => [
                    [[[0.0, 0.0], [1.0, 0.0], [2.0, 0.0], [0.0, 0.0]]],
                    [[[4.0, 0.0], [5.0, 0.0], [6.0, 0.0], [4.0, 0.0]]],
                ],
            ]
        );
    }
}
