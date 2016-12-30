<?php
/**
 * Ported from Head First Design Patters Examples: http://www.headfirstlabs.com/books/hfdp/
 * Singleton Pattern - Ensure a class only has one instance and provide a global point to access it.
 * Also took some suggestions from: http://www.phptherightway.com/pages/Design-Patterns.html
 */

class ChocolateBoiler{
    private $empty;
    private $boiled;
    private static $uniqueInstance = null;

    private function __clone() {}
    private function __wakeup() {}
    private function __construct()
    {
        $this->empty = true;
        $this->boiled = false;
    }

    public static function getInstance(){
        if(self::$uniqueInstance === null){
            print "Creating unique instance of Chocolate Boiler\n";
            self::$uniqueInstance = new ChocolateBoiler();
        }
        print "Returning instance of Chocolate Boiler\n";
        return self::$uniqueInstance;
    }

    function fill(){
        if($this->isEmpty()){
            $this->empty = false;
            $this->boiled = false;
            // fill the boiler with a milk/chocolate mixture
        }
    }

    function drain(){
        if(!$this->isEmpty() && !$this->isBoiled()){
            // drain the boiled milk and chocolate
            $this->empty = true;
        }
    }

    function boil(){
        if(!$this->isEmpty() && !$this->isBoiled()){
            // bring the contents to a boil
            $this->boiled = true;
        }
    }

    function isEmpty(){
        return  $this->empty;
    }

    function isBoiled(){
        return $this->boiled;
    }
}

$boiler = ChocolateBoiler::getInstance();
$boiler->fill();
$boiler->boil();
$boiler->drain();


print "\nboiler id: " . spl_object_hash($boiler) . "\n";
// will return the existing instance
$boiler2 = ChocolateBoiler::getInstance();
print "boiler id: " . spl_object_hash($boiler) . "\n";