<?php
/**
 * InvalidGeneratorRangeException class.
 *
 * Exception of invalid range for generator.
 *
 * @category   Exceptions
 * @package    App\Exception
 * @author     Rafal Malik <kontakt@raspberryvision.pl>
 * @copyright  03.2020 Raspberry Vision
 */

namespace App\Exception;

use LogicException;

/**
 * Triggered when $range array doesn't have two values.
 */
class InvalidGeneratorRangeException extends LogicException
{
}