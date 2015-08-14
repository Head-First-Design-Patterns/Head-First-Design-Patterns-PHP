<?php
// Strategy Pattern - Ported from Head First Design Patterns Java version
// Favoring composition over inheritance

// Strategy - defines a family of algorithms, encapsulates each one, and makes
// them interchangeable. Strategy lets the algorithm vary independently from
// the clients that use it.

interface iQuackBehavior{ public function quack(); }
interface iFlyBehavior{	public function fly(); }

class FlyWithWings implements iFlyBehavior{
    public function fly(){ print "I'm Flying!!\n"; }
}

class FlyNoWay implements iFlyBehavior{
    public function fly(){ print "I can't fly\n"; }
}

class FlyRocketPowered implements iFlyBehavior{
    public function fly(){ print "I'm flying with a rocket!"; }
}

class QuackLoud implements iQuackBehavior{
    public function quack(){ print "Quack\n"; }
}

class MuteQuack implements iQuackBehavior{
    public function quack(){ print "<< Silence >>\n"; }
}

class Squeak implements iQuackBehavior{
    public function quack(){ print "Squeak\n"; }
}

abstract class Duck{
    protected $flyBehavior;
    protected $quackBehavior;

    public function setFlyBehavior($fb){ $this->flyBehavior = $fb; }
    public function setQuackBehavoir($qb){ $this->quackBehavior = $qb; }

    abstract protected function display();

    public function performFly(){ $this->flyBehavior->fly(); }
    public function performQuack(){	$this->quackBehavior->quack(); }
    public function swim(){	print "All ducks float, even decoys!\n"; }
}

class MallardDuck extends Duck{
    function __construct(){
        $this->quackBehavior = new QuackLoud;
        $this->flyBehavior = new FlyWithWings;
    }
    public function display(){ print "I'm a real Mallard duck\n"; }
}

class ModelDuck extends Duck{
    function __construct(){
        $this->flyBehavior = new FlyNoWay;
        $this->quackBehavior = new QuackLoud;
    }
    public function display(){ print "I'm a model duck"; }
}

$mallard = new MallardDuck;
$mallard->performQuack();
$mallard->performFly();
$mallard->setFlyBehavior(new FlyRocketPowered);
$mallard->performFly();