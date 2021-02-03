<?php
namespace xy\framework\components\container\exceptions;

use Psr\Container\NotFoundExceptionInterface;
use \Exception;

/**
 * Class notFoundException
 * @package xy\framework\component\container\exceptions
 */
class notFoundException extends Exception implements NotFoundExceptionInterface
{

}