<?php

class C
{
    public function doSomething()
    {
        echo __METHOD__, '我是C类|';
    }
}

class B
{
    private $c;

    public function __construct(C $c)
    {
        $this->c = $c;
    }

    public function doSomething()
    {
        $this->c->doSomething();
        echo __METHOD__, '我是B类|';
    }
}
class A
{
    private $b;

    public function __construct(B $b)
    {
        $this->b = $b;
    }

    public function doSomething()
    {
        $this->b->doSomething();
        echo __METHOD__, '我是A类|';;
    }
}
class IoC
{
    protected static $registry = [];

    public static function bind($name, Callable $resolver)
    {
        static::$registry[$name] = $resolver;
    }

    public static function make($name)
    {
        if (isset(static::$registry[$name])) {
            $resolver = static::$registry[$name];
            return $resolver();
        }
        throw new Exception('Alias does not exist in the IoC registry.');
    }
}

IoC::bind('xc', function () {
    return new C();
});
IoC::bind('xb', function () {
    return new B(IoC::make('xc'));
});
IoC::bind('xa', function () {
    return new A(IoC::make('xb'));
});


// 从容器中取得A
$foo = IoC::make('xa');
$foo->doSomething(); // C::doSomething我是C类|B::doSomething我是B类|A::doSomething我是A类|