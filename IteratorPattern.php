<?php
/**
 * Ported from Head First Design Patters Examples: http://www.headfirstlabs.com/books/hfdp/
 * Iterator Pattern - Provide a way to access the elements of an aggregate
 * object sequentially without exposing its underlying representation.
 */
interface MyIterator{
    function valid();
    function current();
    function next();
}

class MenuItem{
    private $name;
    private $description;
    private $vegetarian;
    private $price;
    
    public function __construct($n, $d, $v, $p){
        $this->name = $n;
        $this->description = $d;
        $this->vegetarian = $v;
        $this->price = $p;
    }
    public function getName() { return $this->name; }
    public function getDescription() { return $this->description; }
    public function getVegetarian() { return $this->vegetarian; }
    public function getPrice() { return $this->price; }
}

class PancakeHouseMenuIterator implements MyIterator{
    private $items;
    private $position = 0;
    
    public function __construct($items){
        $this->items = $items;
    }
    
    public function current(){ return $this->items[$this->position]; }
    public function next() { $this->position++; }
    public function valid(){
        if($this->position >= sizeof($this->items) || $this->items[$this->position] === null){
            return false;
        }
        else{
            return true;
        }
    }
}

class PancakeHouseMenu{
    private $menuItems = array();
    
    public function __construct(){
        $this->addItem("K&B's Pancake Breakfast", "Pancakes with scrambled eggs, and toast", true, 2.99);
        $this->addItem("Regular Pancake Breakfast", "Pancakes with fried eggs, sausage", true, 2.99);
        $this->addItem("Blueberry Pancakes", "Pancakes made with fresh blueberries", true, 3.49);
        $this->addItem("Waffles", "Waffles with your choice of blueberries or strawberries", true, 3.59);
    }
    public function addItem($name, $description, $vegetarian, $price){
        $menuItem = new MenuItem($name, $description, $vegetarian, $price);
        $this->menuItems[] = $menuItem;
    }
    public function createIterator() { return new PancakeHouseMenuIterator($this->menuItems); }
    
    // bunch of other code we don't want to change
}

class DinerMenuIterator implements Iterator{
    private $items;
    private $position = 0;
    
    public function __construct($items){ $this->items = $items; }
    public function key() { return $this->position; }
    public function current(){ return $this->items[$this->position]; }
    public function next() { $this->position++; }
    public function rewind() { $this->position = 0; }
    public function valid(){
        if($this->position >= $this->items->count() || $this->items[$this->position] === null){
            return false;
        }
        else{
            return true;
        }
    }
}

class DinerMenu{
    const MAX_ITEMS = 6;
    private $numberOfItems = 0;
    private $menuItems;
    
    public function __construct() {
        $this->menuItems = new SplFixedArray(self::MAX_ITEMS);
        $this->addItem("Vegetarian BLT", "(Fakin') Bacon with lettuce & tomato on whole wheat", true, 2.99);
        $this->addItem("BLT", "Bacon with lettuce & tomato on whole wheat", false, 2.99);
        $this->addItem("Soup of the day", "Soup of the day, with a side of potatoe salad", false, 3.29);
        $this->addItem("Hotdog", "A hot dog, with saurkraut, relish, onions, topped with cheese", false, 3.05);
        $this->addItem("Steamed Veggies and Brown Rice", "Steamed vegetables over brown rice", true, 3.99);
		$this->addItem("Pasta", "Spaghetti with Marinara Sauce, and a slice of sourdough bread", true, 3.89);
    }
    public function addItem($name, $description, $vegetarian, $price){
        $menuItem = new MenuItem($name, $description, $vegetarian, $price);
        if($numberOfItems >= self::MAX_ITEMS){
            throw new Exception("Sorry, menu is full! Can't add item to menu");
        }
        else{
            $this->menuItems[$this->numberOfItems] = $menuItem;
            $this->numberOfItems++;
        }
    }
    
    public function createIterator() { return new DinerMenuIterator($this->menuItems); }
    
    // bunch of other code we don't want to change
}

class Waitress{
    private $pancakeHouseMenu;
    private $dinerMenu;
    
    public function __construct($pancakeHouseMenu, $dinerMenu){
        $this->pancakeHouseMenu = $pancakeHouseMenu;
        $this->dinerMenu = $dinerMenu;
    }
    
    public function printMenu(){
        $pancakeIterator = $this->pancakeHouseMenu->createIterator();
        $dinerIterator = $this->dinerMenu->createIterator();
        print "MENU\n----\nBREAKFAST\n";
        $this->printMenuHelper($pancakeIterator);
        print "\nLUNCH\n";
        $this->printMenuHelper($dinerIterator);
    }
    
    private function printMenuHelper($iterator){
        while($iterator->valid()){
            $menuItem = $iterator->current();
            print $menuItem->getName() . ", " . $menuItem->getPrice() . " --";
            print $menuItem->getDescription() . "\n";
            $iterator->next();
        }
    }
}


$pancakeHouseMenu = new PancakeHouseMenu();
$dinerMenu = new DinerMenu();

$waitress = new Waitress($pancakeHouseMenu, $dinerMenu);
$waitress->printMenu();