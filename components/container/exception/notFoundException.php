<?php
namespace xy\framework\components\container\exception;

use Psr\Container\NotFoundExceptionInterface;
use \Exception;

/**
 * Class notFoundException
 * @package xy\framework\components\container\exception
 */
class notFoundException extends Exception implements NotFoundExceptionInterface
{

}