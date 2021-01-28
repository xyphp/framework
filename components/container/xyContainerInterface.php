<?php

namespace xy\framework\components\container;
/**
 * Interface xyContainerInterface
 * @package xy\framework\components\container
 */
interface xyContainerInterface
{
    /**
     * 获得类的对象实例
     * @param string  $name       要注册的实例名字
     * @param string  $className  类名
     * @param array   $userParams 用户自定义参数（类对象参数除外的普通参数）
     * @param boolean $rebind     是否强制绑定
     * @return mixed
     */
    public static function bind($name, $className, $userParams , $rebind );

    /**
     * 执行类的方法
     * @param  [type] $className  [类名]
     * @param  [type] $methodName [方法名称]
     * @param  [type] $params     [额外的参数]
     * @return [type]             [description]
     */
    public static function call($className, $methodName, $params);

}