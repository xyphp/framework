<?php
namespace framework\components\container;

use Psr\Container\ContainerInterface;
use \ReflectionClass;


class container implements ContainerInterface
{
    /**
     * 获得类的对象实例
     * @param string $className
     * @param array  $userParams
     * @return mixed
     */
    public static function getInstance($className, $userParams=[]) {
        $paramArr = self::getMethodParams($className, '__construct', $userParams);
        return (new ReflectionClass($className))->newInstanceArgs($paramArr);
    }

    /**
     * 执行类的方法
     * @param  [type] $className  [类名]
     * @param  [type] $methodName [方法名称]
     * @param  [type] $params     [额外的参数]
     * @return [type]             [description]
     */
    public static function make($className, $methodName, $params = []) {

        // 获取类的实例
        empty($methodName) && $methodName = '__construct';
        // 获取类的实例
        $constructParams = ($methodName=='__construct') ? $params : [];
        $instance = self::getInstance($className, $constructParams);

        // 获取该方法所需要依赖注入的参数
        $paramArr = self::getMethodParams($className, $methodName, $params);

        return $instance->{$methodName}(...$paramArr);
    }

    /**
     * 获得类的方法参数，只获得有类型的参数
     * @param  [type] $className   [description]
     * @param  [type] $methodsName [description]
     * @return [type]              [description]
     */
    protected static function getMethodParams($className,
                                              $methodsName = '__construct', $userParams=[])
    {
        // 通过反射获得该类
        $class = new ReflectionClass($className);
        $paramArr = []; // 记录参数，和参数类型

        // 判断该类是否有构造函数
        if ($class->hasMethod($methodsName)) {
            // 获得构造函数
            $construct = $class->getMethod($methodsName);
            // 判断构造函数是否有参数
            $params = $construct->getParameters();
            $params = (array)$params;
            // 判断参数类型
            foreach ($params as $key => $param) {
                //如果参数是类对象，则可以获取
                if ($paramClass = $param->getClass()) {
                    $paramClassName = $paramClass->getName();
                    $paramArr[]     = self::getInstance($paramClassName);
                }else{
                    $paramArr[]     = array_shift($userParams);
                }
            }

        }

        return $paramArr;
    }
}