<?php
/*
 * Decorator Pattern - Attach additional responsibilities to an object dynamically.
 * Decorators provide a flexible alternative to subclassing for extending functionality.
 */

abstract class Beverage
{
    protected $description = "Unknown Beverage";
    public function getDescription(){ return $this->description; }
    protected abstract function cost();
}

abstract class CondimentDecorator extends Beverage
{
    // In PHP, abstract methods are implicitly passed to their child
    // http://stackoverflow.com/questions/17525620/php-fatal-error-cant-inherit-abstract-function
}

class Espresso extends Beverage{
    public function __construct() { $this->description = "Espresso"; }
    public function cost() { return 1.99; }
}

class HouseBlend extends Beverage{
    public function __construct() { $this->description = "House Blend Coffee"; }
    public function cost() { return .89; }
}

class DarkRoast extends Beverage{
    public function __construct() { $this->description = "Dark Roast"; }
    public function cost() { return .99; }
}

class Decaf extends Beverage{
    public function __construct() { $this->description = "Decaf Coffee"; }
    public function cost() { return 1.05; }
}

class Mocha extends CondimentDecorator{
    private $beverage;

    public function __construct($b) { $this->beverage = $b; }
    public function getDescription() { return $this->beverage->getDescription() . ", Mocha"; }
    public function cost() { return .2 + $this->beverage->cost(); }
}

class Soy extends CondimentDecorator{
    private $beverage;
    public function __construct($b) { $this->beverage = $b; }
    public function getDescription() { return $this->beverage->getDescription() . ", Soy"; }
    public function cost() { return .15 + $this->beverage->cost(); }
}

class Whip extends CondimentDecorator{
    private $beverage;
    public function __construct($b) { $this->beverage = $b; }
    public function getDescription() { return $this->beverage->getDescription() . ", Whip"; }
    public function cost() { return .1 + $this->beverage->cost(); }
}

$beverage = new Espresso();
print $beverage->getDescription() . " $" . $beverage->cost() . "\n";

$beverage2 = new DarkRoast();
$beverage2 = new Mocha($beverage2);
$beverage2 = new Mocha($beverage2);
$beverage2 = new Whip($beverage2);
print $beverage2->getDescription() . " $" . $beverage2->cost() . "\n";

$beverage3 = new HouseBlend();
$beverage3 = new Soy($beverage3);
$beverage3 = new Mocha($beverage3);
$beverage3 = new Whip($beverage3);
print $beverage3->getDescription() . " $" . $beverage3->cost() . "\n";