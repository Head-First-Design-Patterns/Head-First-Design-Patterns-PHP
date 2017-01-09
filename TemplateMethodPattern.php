<?php
/**
 * Ported from Head First Design Patters Examples: http://www.headfirstlabs.com/books/hfdp/
 * Template Method Pattern - Defines the skeleton of an algorithm in a method,
 * deferring some steps to subclasses. Template Method lets subclasses redefine
 * certain steps of an algorithm without changing the algorithm's structure.
 */

abstract class CaffeineBeverage{
    final function prepareRecipe(){
        $this->boilWater();
        $this->brew();
        $this->pourInCup();
        $this->addCondiments();
    }
    abstract function brew();
    abstract function addCondiments();
    function boilWater(){ print "Boiling water\n"; }
    function pourInCup() { print "Pouring into cup\n"; }
}

class Tea extends CaffeineBeverage{
    public function brew(){ print "Steeping the tea\n"; }
    public function addCondiments(){ print "Adding Lemon\n"; }
}

class Coffee extends CaffeineBeverage{
    public function brew() { print "Dripping Coffee through filter\n"; }
    public function addCondiments() { "Adding Sugar and Milk\n"; }
}

$myTea = new Tea();
$myTea->prepareRecipe();