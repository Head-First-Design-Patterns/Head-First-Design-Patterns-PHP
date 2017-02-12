<?php
/**
 * Ported from Head First Design Patters Examples: http://www.headfirstlabs.com/books/hfdp/
 * Compound Pattern - Combines two or more patterns into a solution that solves
 * a recurring or general problem.
 * 
 * p. 522
 * Question 1: So this was a compound pattern?
 * Answer: No, this was just a set of patterns working together. A compound
 * pattern is a set of a few patterns that are combined to solve a general
 * problem... the Model-View-Controller (MVC) pattern is a collection of a few
 * patterns that has been used over and over in many design solutions.
 */

interface Observer{
    public function update($duck);
}

class Quackologist implements Observer{
    public function update($duck) { print "Quackologist: " . $duck . " just quacked.\n"; }
}

interface QuackObservable{
    public function registerObserver($observer);
    public function notifyObservers();
}

interface Quackable extends QuackObservable{
    public function quack();
}

class Observable implements QuackObservable{
    private $observers = array();
    private $duck;
    public function __construct($duck) { $this->duck = $duck; }
    public function registerObserver($observer) { $this->observers[] = $observer; }
    public function notifyObservers(){
        $ao = new ArrayObject($this->observers);
        $iterator = $ao->getIterator();
        while($iterator->valid()) {
            $iterator->current()->update($this->duck);
            $iterator->next();
        }
    }
}

class MallardDuck implements Quackable{
    private $observable;
    public function __construct() { $this->observable = new Observable($this); }
    public function quack() {
        print "Quack\n";
        $this->notifyObservers();
    }
    public function registerObserver($observer) { $this->observable->registerObserver($observer); }
    public function notifyObservers() { $this->observable->notifyObservers(); }
    public function __toString() { return "Mallard Duck"; }
}

class RedheadDuck implements Quackable{
    private $observable;
    public function __construct() { $this->observable = new Observable($this); }
    public function quack() {
        print "Quack\n";
        $this->notifyObservers();
    }
    public function registerObserver($observer) { $this->observable->registerObserver($observer); }
    public function notifyObservers() { $this->observable->notifyObservers(); }
    public function __toString() { return "Redhead Duck"; }
}

class DuckCall implements Quackable{
    private $observable;
    public function __construct() { $this->observable = new Observable($this); }
    public function quack() {
        print "Kwak\n";
        $this->notifyObservers();
    }
    public function registerObserver($observer) { $this->observable->registerObserver($observer); }
    public function notifyObservers() { $this->observable->notifyObservers(); }
    public function __toString() { return "Duck Call"; }
}

class RubberDuck implements Quackable{
    private $observable;
    public function __construct() { $this->observable = new Observable($this); }
    public function quack() {
        print "Squeak\n";
        $this->notifyObservers();
    }
    public function registerObserver($observer) { $this->observable->registerObserver($observer); }
    public function notifyObservers() { $this->observable->notifyObservers(); }
    public function __toString() { return "Rubber Duck"; }
}

class Goose{
    public function honk() { print "Honk\n"; }
    public function __toString() { return "Goose"; }
}

class GooseAdapter implements Quackable{
    private $goose;
    private $observervable;
    public function __construct($goose){ $this->goose = $goose; $this->observable = new Observable($this); }
    public function quack(){ $this->goose->honk(); }
    public function registerObserver($observer) { $this->observable->registerObserver($observer); }
    public function notifyObservers() { $this->observable->notifyObservers(); }
}

class QuackCounter implements Quackable{
    private $duck;
    static $numberOfQuacks = 0;
    public function __construct($duck){ $this->duck = $duck; }
    public function quack() { $this->duck->quack(); self::$numberOfQuacks++; }
    public static function numberOfQuacks() { return self::$numberOfQuacks; }
    public function registerObserver($observer) { $this->duck->registerObserver($observer); }
    public function notifyObservers() { $this->duck->notifyObservers(); }
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
            $iterator->current()->quack();
            $iterator->next();
        }
    }
    public function registerObserver($observer){
        $ao = new ArrayObject($this->quackers);
        $iterator = $ao->getIterator();
        while($iterator->valid()) {
            $iterator->current()->registerObserver($observer);
            $iterator->next();
        }
    }
    public function notifyObservers(){
        // Each Quackable does its own notification, so Flock doesn't have to worry about it
        // This happens when Flock delegates quack() to each Quackable in the Flock
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
        
        print "\nDuck Simulator: With Observer\n";
        $quackologist = new Quackologist();
        $flockOfDucks->registerObserver($quackologist);
        
        print "\nDuck Simulator: Whole Flock Simulation\n";
        $this->simulateQuack($flockOfDucks);
        
        print "\nDuck Simulator: Mallard Flock Simulation\n";
        $this->simulateQuack($flockOfMallards);
        
        print "The ducks quacked " . QuackCounter::numberOfQuacks() . " times\n";
    }
    private function simulateQuack($duck) { $duck->quack(); } 
}

$simulator = new DuckSimulator();