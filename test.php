<?php

$methodOne = function (string $p) {
    echo "I am  doing one: " . $p . PHP_EOL;
};

$methodTwo = function (string $p) {
    echo "I am doing two: " . $p . PHP_EOL;
};

class Composite {

    function addMethod($name, $method) {
        $this->{$name} = $method;
    }

    public function __call($name, $arguments) {
        return call_user_func($this->{$name}, $arguments);
    }

}

$one = new Composite();
$one->addMethod("method1", $methodOne);
$one->method1('uno');
$one->addMethod("method2", $methodTwo);
$one->method2('dos');
