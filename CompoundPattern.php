<?php
/**
 * Ported from Head First Design Patters Examples: http://www.headfirstlabs.com/books/hfdp/
 * Compound Pattern - 
 */

interface Quackable{
    public function quack();
}

class MallardDuck implements Quackable{
    public function quack() { print "Quack\n"; }
}

class RedheadDuck implements Quackable{
    public function quack() { print "Quack\n"; }
}

class DuckCall implements Quackable{
    public function quack() { print "Kwak\n"; }
}

class RubberDuck implements Quackable{
    public function quack() { print "Squeak\n"; }
}

class Goose{
    public function honk() { print "Honk\n"; }
}

class GooseAdapter implements Quackable{
    private $goose;
    public function __construct($goose){ $this->goose = $goose; }
    public function quack(){ $this->goose->honk(); }
}

class QuackCounter implements Quackable{
    private $duck;
    static $numberOfQuacks = 0;
    public function __construct($duck){ $this->duck = $duck; }
    public function quack() { $this->duck->quack(); self::$numberOfQuacks++; }
    public static function numberOfQuacks() { return self::$numberOfQuacks; }
}

function simulate($duck) { $duck->quack(); } 

$mallardDuck = new QuackCounter(new MallardDuck());
$redheadDuck = new QuackCounter(new RedheadDuck());
$duckCall = new QuackCounter(new DuckCall());
$rubberDuck = new QuackCounter(new RubberDuck());
$gooseDuck = new GooseAdapter(new Goose()); # The park ranger says don't count geese

simulate($mallardDuck);
simulate($redheadDuck);
simulate($duckCall);
simulate($rubberDuck);
simulate($gooseDuck);

print "The ducks quacked " . QuackCounter::numberOfQuacks() . " times\n";