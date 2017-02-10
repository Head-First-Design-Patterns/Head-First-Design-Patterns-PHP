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

function simulate($duck) { $duck->quack(); } 

$mallardDuck = new MallardDuck();
$redheadDuck = new RedheadDuck();
$duckCall = new DuckCall();
$rubberDuck = new RubberDuck();

simulate($mallardDuck);
simulate($redheadDuck);
simulate($duckCall);
simulate($rubberDuck);