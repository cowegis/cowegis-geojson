<?php

declare(strict_types=1);

namespace Cowegis\GeoJson\Exception;

use InvalidArgumentException as BaseInvalidArgumentException;

final class InvalidArgumentException extends BaseInvalidArgumentException implements Exception
{
}
