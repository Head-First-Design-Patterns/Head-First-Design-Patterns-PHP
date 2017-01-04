<?php
/**
 * Ported from Head First Design Patters Examples: http://www.headfirstlabs.com/books/hfdp/
 * Adapter Pattern - Converts the interface of a class into another interface clients expect.
 * Lets classes work together that couldn't otherwise because fo incompatible interfaces.
 */
 
interface Duck{
    public function quack();
    public function fly();
}

interface Turkey{
    public function gobble();
    public function fly();
}

class MallardDuck implements Duck{
    public function quack() { print "Quack\n"; }
    public function fly() { print "I'm flying\n"; }
}

class WildTurkey implements Turkey{
    public function gobble() { print "Gobble gobble\n"; }
    public function fly() { print "I'm flying a short distance\n"; }
}

class TurkeyAdapter implements Duck{
    private $turkey;
    public function __construct($t) { $this->turkey = $t; }
    public function quack() { $this->turkey->gobble(); }
    public function fly() {
        for($i = 0; $i < 5; $i++){
            $this->turkey->fly();
        }
    }
}

function testDuck($duck){
    $duck->quack();
    $duck->fly();
}

$duck = new MallardDuck();
$turkey = new WildTurkey();
$turkeyAdapter = new TurkeyAdapter($turkey);

print "The Turkey says...";
$turkey->gobble();
$turkey->fly();

print "\nThe Duck says...";
testDuck($duck);

print "\nThe Turkey says...";
testDuck($turkeyAdapter);