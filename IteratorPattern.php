<?php
/**
 * Ported from Head First Design Patters Examples: http://www.headfirstlabs.com/books/hfdp/
 * Iterator Pattern - 
 */

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

class PancakeHouseMenu{
    private $menuItems;
    
    public function __construct(){
        $this->menuItems = array();
        $this->addItem("K&B's Pancake Breakfast", "Pancakes with scrambled eggs, and toast", true, 2.99);
        $this->addItem("Regular Pancake Breakfast", "Pancakes with fried eggs, sausage", true, 2.99);
        $this->addItem("Blueberry Pancakes", "Pancakes made with fresh blueberries", true, 3.49);
        $this->addItem("Waffles", "Waffles with your choice of blueberries or strawberries", true, 3.59);
    }
    public function addItem($name, $description, $vegetarian, $price){
        $menuItem = new MenuItem($name, $description, $vegetarian, $price);
        $this->menuItems[] = $menuItem;
    }
    public function getMenuItems() { return $this->menuItems; }
    
    // bunch of other code we don't want to change
}

class DinnerMenu{
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
    public function getMenuItems() { return $this->menuItems; }
    
    // bunch of other code we don't want to change
}


$pancakeHouseMenu = new PancakeHouseMenu();
$breakfastItems = $pancakeHouseMenu->getMenuItems();

$dinerMenu = new DinnerMenu();
$lunchItems = $dinerMenu->getMenuItems();

for($i = 0; $i < sizeof($breakfastItems); $i++){
    $menuItem = $breakfastItems[$i];
    print $menuItem->getName() . " ";
    print $menuItem->getPrice() . "\n";
    print $menuItem->getDescription() . "\n\n";
}

// I realize these loops are the same.
for($i = 0; $i < $lunchItems->count(); $i++){
    $menuItem = $lunchItems[$i];
    print $menuItem->getName() . " ";
    print $menuItem->getPrice() . "\n";
    print $menuItem->getDescription() . "\n\n";
}