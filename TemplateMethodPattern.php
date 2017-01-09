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

abstract class CaffeineBeverageWithHook{
    final function prepareRecipe(){
        $this->boilWater();
        $this->brew();
        $this->pourInCup();
        if($this->customerWantsCondiments()) $this->addCondiments();
    }
    abstract function brew();
    abstract function addCondiments();
    function boilWater(){ print "Boiling water\n"; }
    function pourInCup() { print "Pouring into cup\n"; }
    function customerWantsCondiments() { return true; }
}

class Tea extends CaffeineBeverage{
    public function brew(){ print "Steeping the tea\n"; }
    public function addCondiments(){ print "Adding Lemon\n"; }
}

class TeaWithHook extends CaffeineBeverageWithHook{
    public function brew(){ print "Steeping the tea\n"; }
    public function addCondiments(){ print "Adding Lemon\n"; }
    public function customerWantsCondiments(){
        $answer = readline("Would you like lemon with your tea (y/n)?");
        if(strtolower($answer)[0] === "y") return true;
        else return false;
    }
}

class Coffee extends CaffeineBeverage{
    public function brew() { print "Dripping Coffee through filter\n"; }
    public function addCondiments() { "Adding Sugar and Milk\n"; }
}

class CoffeeWithHook extends CaffeineBeverageWithHook{
    public function brew() { print "Dripping Coffee through filter\n"; }
    public function addCondiments() { print "Adding Sugar and Milk\n"; }
    public function customerWantsCondiments(){
        $answer = readline("Would you like milk and sugar with your coffee (y/n)?");
        if(strtolower($answer)[0] === "y") return true;
        else return false;
    }
}


$tea = new Tea();
$teaHook = new TeaWithHook();
$coffee = new Coffee();
$coffeeHook = new CoffeeWithHook();

print "\nMaking tea...\n";
$tea->prepareRecipe();
print "\nMaking coffee...\n";
$coffee->prepareRecipe();

print "\nMaking tea...\n";
$teaHook->prepareRecipe();
print "\nMaking coffee...\n";
$coffeeHook->prepareRecipe();