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

abstract class AbstractDuckFactory{
    abstract function createMallardDuck();
    abstract function createRedheadDuck();
    abstract function createDuckCall();
    abstract function createRubberDuck();
}

class DuckFactory extends AbstractDuckFactory{
    public function createMallardDuck() { return new MallardDuck(); }
    public function createRedheadDuck() { return new RedheadDuck(); }
    public function createDuckCall() { return new DuckCall(); }
    public function createRubberDuck() { return new RubberDuck(); }
}

class CountingDuckFactory extends AbstractDuckFactory{
    public function createMallardDuck() { return new QuackCounter(new MallardDuck()); }
    public function createRedheadDuck() { return new QuackCounter(new RedheadDuck()); }
    public function createDuckCall() { return new QuackCounter(new DuckCall()); }
    public function createRubberDuck() { return new QuackCounter(new RubberDuck()); }
}

class Flock implements Quackable{
    private $quackers;
    public function __construct() { $this->quackers = array(); }
    public function add($quacker) { $this->quackers[] = $quacker; }
    public function quack(){
        $ao = new ArrayObject($this->quackers);
        $iterator = $ao->getIterator();
        while($iterator->valid()) {
            print $iterator->key() . ' => ' . $iterator->current()->quack();
            $iterator->next();
        }
    }
}

class DuckSimulator{
    public function __construct(){
        $duckFactory = new CountingDuckFactory();
        $this->simulate($duckFactory);
    }
    private function simulate($duckFactory){
        $mallardDuck = $duckFactory->createMallardDuck();
        $redheadDuck = $duckFactory->createRedheadDuck();
        $duckCall = $duckFactory->createDuckCall();
        $rubberDuck = $duckFactory->createRubberDuck();
        $gooseDuck = new GooseAdapter(new Goose()); # The park ranger says don't count geese
        print "\nDuckSimulator: With Composite - Flocks\n";
        
        $flockOfDucks = new Flock();
        
        $flockOfDucks->add($mallardDuck);
        $flockOfDucks->add($redheadDuck);
        $flockOfDucks->add($duckCall);
        $flockOfDucks->add($rubberDuck);
        $flockOfDucks->add($gooseDuck);
        
        $flockOfMallards = new Flock();
        $flockOfMallards->add($duckFactory->createMallardDuck());
        $flockOfMallards->add($duckFactory->createMallardDuck());
        $flockOfMallards->add($duckFactory->createMallardDuck());
        $flockOfMallards->add($duckFactory->createMallardDuck());
        
        $flockOfDucks->add($flockOfMallards);
        
        print "\nDuck Simulator: Whole Flock Simulation\n";
        $this->simulateQuack($flockOfDucks);
        
        print "\nDuck Simulator: Mallard Flock Simulation\n";
        $this->simulateQuack($flockOfMallards);
        
        print "The ducks quacked " . QuackCounter::numberOfQuacks() . " times\n";
    }
    private function simulateQuack($duck) { $duck->quack(); } 
}

$simulator = new DuckSimulator();