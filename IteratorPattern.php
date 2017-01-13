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

interface Menu{
    function createIterator();
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

class PancakeHouseMenu implements Menu{
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
    public function createIterator() { $ao = new ArrayObject($this->menuItems); return $ao->getIterator(); }
    
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
    public function remove(){
        if($this->position === 0){
            throw new Exception("You can't remove an item until you've done at least one next()");
        }
        if($this->items[$this->position] != null){
            for($i = $this->position - 1; $i < $this->items->count(); $i++){
                $this->items[$i] = $this->items[$i + 1];
            }
            $this->items[$this->items->count() - 1] = null;
        }
    }
}

class DinerMenu implements Menu{
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

class CafeMenu implements Menu{
    private $menuItems = array();
    
    public function __construct(){
        $this->addItem("Veggie Burger and Air Fries", "Veggie burger on a whole wheat bun, lettuce, tomato, and fries", true, 3.99);
        $this->addItem("Soup of the day", "A cup of the soup of the day, with a side salad", false, 3.69);
        $this->addItem("Burrito", "A large burrito, with whole pinto beans, salsa, guacamole", true, 4.29);
    }
    public function addItem($name, $description, $vegetarian, $price){
        $menuItem = new MenuItem($name, $description, $vegetarian, $price);
        $this->menuItems[$menuItem->getName()] = $menuItem;
    }
    public function createIterator() { $ao = new ArrayObject($this->menuItems); return $ao->getIterator(); }
}

class Waitress{
    private $menus;
    
    public function __construct($menus){ $this->menus = $menus; }
    public function printMenu(){
        foreach($this->menus as $menu){
            print "---\n";
            $this->printMenuHelper($menu->createIterator());
        }
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
$cafeMenu = new CafeMenu();

$waitress = new Waitress(array($pancakeHouseMenu, $dinerMenu, $cafeMenu));
$waitress->printMenu();