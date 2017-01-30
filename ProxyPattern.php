<?php
/**
 * Ported from Head First Design Patters Examples: http://www.headfirstlabs.com/books/hfdp/
 * State Pattern - Allows an object to alter its behavior when its internal
 * state changes. The object will appear to change its class.
 */

interface State{
    function insertQuarter();
    function ejectQuarter();
    function turnCrank();
    function dispense();
}

class NoQuarterState implements State{
    private $gumballMachine;
    public function __construct($gumballMachine) { $this->gumballMachine = $gumballMachine; }
    public function insertQuarter(){
        print "You inserted a quarter\n";
        $this->gumballMachine->setState($this->gumballMachine->getHasQuarterState());
    }
    public function ejectQuarter(){ print "You haven't inserted a quarter\n"; }
    public function turnCrank() { print "You turned, but there's no quarter\n"; }
    public function dispense() { print "You need to pay first\n"; }
    public function __toString() { return "waiting for quarter"; }
}

class HasQuarterState implements State{
    private $gumballMachine;
    public function __construct($gumballMachine) { $this->gumballMachine = $gumballMachine; }
    public function insertQuarter(){ print "You can't insert another quarter\n"; }
    public function ejectQuarter(){
        print "Quarter returned\n";
        $this->setState($this->gumballMachine->getNoQuarterState());
    }
    public function turnCrank() {
        print "You turned...\n";
        $winner = rand(0, 9);
        if($winner === 0 && ($this->gumballMachine->getCount() > 1)){
            $this->gumballMachine->setState($this->gumballMachine->getWinnerState());
        }
        else{
            $this->setState($this->gumballMachine->getSoldState());
        }
    }
    public function dispense() { print "No gumball dispensed\n"; }
    public function __toString() { return "waiting for turn of crank"; }
}

class SoldState implements State{
    private $gumballMachine;
    public function __construct($gumballMachine) { $this->gumballMachine = $gumballMachine; }
    public function insertQuarter(){ print "Please wait, we're already giving you a gumball\n"; }
    public function ejectQuarter(){ print "Sorry, you alread turned the crank\n"; }
    public function turnCrank() { print "Turning twice doesn't get you another gumball!\n"; }
    public function dispense() {
        $this->gumballMachine->releaseBall();
        if($this->gumballMachine->getCount() > 0){
            $this->gumballMachine->setState($this->gumballMachine->getNoQuarterState());
        }
        else{
            print "Oops, out of gumballs!\n";
            $this->gumballMachine->setState($this->gumballMachine->getSoldOutState());
        }
    }
    public function __toString() { return "dispensing a gumball"; }
}

class SoldOutState implements State{
    private $gumballMachine;
    public function __construct($gumballMachine) { $this->gumballMachine = $gumballMachine; }
    public function insertQuarter(){ print "You can't insert a quarter, the machine is sold out\n"; }
    public function ejectQuarter(){ print "You can't eject, you haven't inserted a quarter yet\n"; }
    public function turnCrank() { print "You turned, but there are no gumballs\n"; }
    public function dispense() { print "No gumball dispensed\n"; }
    public function __toString() { return "sold out"; }
}

class WinnerState implements State{
    private $gumballMachine;
    public function __construct($gumballMachine) { $this->gumballMachine = $gumballMachine; }
    public function insertQuarter(){ print "Please wait, we're already giving you a gumball\n"; }
    public function ejectQuarter(){ print "Sorry, you alread turned the crank\n"; }
    public function turnCrank() { print "Turning twice doesn't get you another gumball!\n"; }
    public function dispense() {
        print "YOU'RE A WINNER! You get two gumballs for your quarter\n";
        $this->gumballMachine->releaseBall();
        if($this->gumballMachine->getCount() == 0){
            $this->gumballMachine->setState($this->gumballMachine->getSoldOutState());
        }
        else{
            $this->gumballMachine->releaseBall();
            if($this->gumballMachine->getCount() > 0){
                $this->gumballMachine->setState($this->gumballMachine->getNoQuarterState());
            }
            else{
                print "Oops, out of gumballs!\n";
                $this->gumballMachine->setState($this->gumballMachine->getSoldOutState());
            }
        }
    }
    public function __toString() { return "despensing two gumballs for your quarter, because YOU'RE A WINNER!"; }
}

class GumballMachine{
    private $soldOutState;
    private $noQuarterState;
    private $hasQuarterState;
    private $soldState;
    private $winnerState;
    private $location;
    
    private $state;
    private $count = 0;
    
    public function __construct($location, $numberGumballs){
        $this->location = $location;
        $this->soldOutState = new SoldOutState($this);
        $this->noQuarterState = new NoQuarterState($this);
        $this->hasQuarterState = new HasQuarterState($this);
        $this->soldState = new SoldState($this);
        $this->count = $numberGumballs;
        if($numberGumballs > 0) $this->state = $this->noQuarterState;
        else $this->state = $this->soldOutState;
    }
    public function insertQuarter() { $this->state->insertQuarter(); }
    public function ejectQuarter() { $this->state->ejectQuarter(); }
    public function turnCrank() { $this->state->turnCrank; $this->state->dispense(); }
    public function setState($state) { $this->state = $state; }
    public function releaseBall() {
        print "A gumball comes rolling out the slot...\n";
        if ($this->count != 0) $this->count--;
    }
    public function getLocation() { return $this->location; }
    public function getCount() { return $this->count; }
    public function refill($count) { $this->count = $count; $this->state = $this->noQuarterState; }
    public function getState() { return $this->state; }
    public function getSoldOutState() { return $this->soldOutState; }
    public function getNoQuarterState() { return $this->noQuarterState; }
    public function getHasQuarterState() { return $this->hasQuarterState; }
    public function getSoldState() { return $this->soldState; }
    public function getWinnerState() { return $this->winnerState; }
    public function __toString(){
        $result  = "\nMighty Gumball, Inc.";
        $result .= "\nJava-enables Standing Gumball Model #2004";
        $result .= "\nInventory: " . $this->count . " gumball";
        if($this->count != 1) $result .= "s";
        $result .= "\n";
        $result .= "Machine is " . $this->state . "\n";
        return $result;
    }
}

class GumballMonitor {
    private $machine;
    
    public function __construct($machine) { $this->machine = $machine; }
    public function report(){
        print "Gumball Machine: " . $this->machine->getLocation() . "\n";
        print "Current inventory: " . $this->machine->getCount() . " gumballs\n";
        print "Current state: " . $this->machine->getState() . "\n";
    }
}


/*
var_dump($argv);
print count($argv) . "\n";
print $argv[0] . "\n";
*/

if(count($argv) < 3){
    print "GumballMachine <name> <inventory>\n";
    exit();
}

$location = $argv[1];
$count = intval($argv[2]);
$gumballMachine = new GumballMachine($location, $count);
$monitor = new GumballMonitor($gumballMachine);
$monitor->report();

/*
$gumballMachine = new GumballMachine(5);

print $gumballMachine;

$gumballMachine->insertQuarter();
$gumballMachine->turnCrank();

print $gumballMachine;

$gumballMachine->insertQuarter();
$gumballMachine->turnCrank();
$gumballMachine->insertQuarter();
$gumballMachine->turnCrank();

print $gumballMachine;
*/