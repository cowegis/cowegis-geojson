<?php

declare(strict_types=1);

namespace spec\Cowegis\GeoJson\Exception;

use Cowegis\GeoJson\Exception\Exception;
use Cowegis\GeoJson\Exception\InvalidArgumentException;
use InvalidArgumentException as BaseInvalidArgumentException;
use PhpSpec\ObjectBehavior;

final class InvalidArgumentExceptionSpec extends ObjectBehavior
{
    public function it_is_initializable() : void
    {
        $this->shouldHaveType(InvalidArgumentException::class);
    }

    public function it_is_a_geojson_exception() : void
    {
        $this->shouldImplement(Exception::class);
    }

    public function it_inherits_from_base_invalid_argument_exception() : void
    {
        $this->shouldImplement(BaseInvalidArgumentException::class);
    }
}
