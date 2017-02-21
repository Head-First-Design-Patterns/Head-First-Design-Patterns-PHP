<?php
/**
 * Ported from Head First Design Patters Examples: http://www.headfirstlabs.com/books/hfdp/
 * Composite Pattern - Compose objects into tree structures to represent
 * part-whole hierarchies. Composite lets clients treat individual objects and
 * compositions of objects uniformly.
 */

abstract class MenuComponent{
    public function add($menuComponent) { throw new BadMethodCallException(); }
    public function remove($menuComponent) { throw new BadMethodCallException(); }
    public function getChild($menuComponent) { throw new BadMethodCallException(); }
    public function getName($menuComponent) { throw new BadMethodCallException(); }
    public function getDescription($menuComponent) { throw new BadMethodCallException(); }
    public function getPrice($menuComponent) { throw new BadMethodCallException(); }
    public function isVegetarian($menuComponent) { throw new BadMethodCallException(); }
    public function printMenu($menuComponent) { throw new BadMethodCallException(); }
}

class MenuItem extends MenuComponent{
    private $name;
    private $description;
    private $vegetarian;
    private $price;
    
    public function __construct($name, $description, $vegetarian, $price){
        $this->name = $name;
        $this->description = $description;
        $this->vegetarian = $vegetarian;
        $this->price = $price;
    }
    public function getName() { return $this->name; }
    public function getDescription() { return $this->description; }
    public function getPrice() { return $this->price; }
    public function isVegetarian() { return $this->vegetarian; }
    public function printMenu() {
        print " " . $this->getName();
        if($this->isVegetarian()) print "(v)";
        print ", " . $this->getPrice() . "\n";
        print "     -- " . $this->getDescription() . "\n";
    }
}

class Menu extends MenuComponent{
    private $menuComponents = array();
    private $name;
    private $description;
    
    public function __construct($name, $description){
        $this->name = $name;
        $this->description = $description;
    }
    public function add($menuComponent) { $this->menuComponents[] = $menuComponent; }
    public function remove($menuComponent) { /* write this function */ }
    public function getChild($i) { return $this->menuComponents[$i]; }
    public function getName() { return $this->name; }
    public function getDescription() { return $this->description; }
    public function printMenu(){
        print "\n" . $this->getName();
        print ", " . $this->getDescription() . "\n";
        print "------------------------------------\n";
        
        $ao = new ArrayObject($this->menuComponents);
        $iterator = $ao->getIterator();
        while($iterator->valid()){
            $menuItem = $iterator->current();
            $menuItem->printMenu();
            $iterator->next();
        }
    }
}

class Waitress{
    private $allMenus;
    public function __construct($allMenus){ $this->allMenus = $allMenus; }
    public function printMenu(){ $this->allMenus->printMenu(); }
}


$pancakeHouseMenu = new Menu("PANCAKE HOUSE MENU", "Breakfast");
$dinerMenu = new Menu("DINER MENU", "Lunch");
$cafeMenu = new Menu("CAFE MENU", "Dinner");
$dessertMenu = new Menu("DESSERT MENU", "Dessert of course!");
$coffeeMenu = new Menu("COFFEE MENU", "Stuff to go with your afternoon coffee");

$allMenus = new Menu("ALL MENUS", "All menus combined");
$allMenus->add($pancakeHouseMenu);
$allMenus->add($dinerMenu);
$allMenus->add($cafeMenu);

$pancakeHouseMenu->add(new MenuItem("K&B's Pancake Breakfast", "Pancakes with scrambled eggs, and toast", true, 2.99));
$pancakeHouseMenu->add(new MenuItem("Regular Pancake Breakfast", "Pancakes with fried eggs, sausage", false, 2.99));
$pancakeHouseMenu->add(new MenuItem("Blueberry Pancakes", "Pancakes made with fresh blueberries, and blueberry syrup", true, 3.49));
$pancakeHouseMenu->add(new MenuItem("Waffles", "Waffles, with your choice of blueberries or strawberries", true, 3.59));

$dinerMenu->add(new MenuItem("Vegetarian BLT", "(Fakin') Bacon with lettuce & tomato on whole wheat",  true, 2.99));
$dinerMenu->add(new MenuItem("BLT", "Bacon with lettuce & tomato on whole wheat", false, 2.99));
$dinerMenu->add(new MenuItem("Soup of the day", "A bowl of the soup of the day, with a side of potato salad", false, 3.29));
$dinerMenu->add(new MenuItem("Hotdog", "A hot dog, with saurkraut, relish, onions, topped with cheese", false, 3.05));
$dinerMenu->add(new MenuItem("Steamed Veggies and Brown Rice", "Steamed vegetables over brown rice", true, 3.99));
$dinerMenu->add(new MenuItem("Pasta", "Spaghetti with Marinara Sauce, and a slice of sourdough bread", true, 3.89));
$dinerMenu->add($dessertMenu);

$dessertMenu->add(new MenuItem("Apple Pie", "Apple pie with a flakey crust, topped with vanilla icecream", true, 1.59));
$dessertMenu->add(new MenuItem("Cheesecake", "Creamy New York cheesecake, with a chocolate graham crust", true, 1.99));
$dessertMenu->add(new MenuItem("Sorbet", "A scoop of raspberry and a scoop of lime", true, 1.89));

$cafeMenu->add(new MenuItem("Veggie Burger and Air Fries", "Veggie burger on a whole wheat bun, lettuce, tomato, and fries", true, 3.99));
$cafeMenu->add(new MenuItem("Soup of the day", "A cup of the soup of the day, with a side salad", false, 3.69));
$cafeMenu->add(new MenuItem("Burrito", "A large burrito, with whole pinto beans, salsa, guacamole", true, 4.29));
$cafeMenu->add($coffeeMenu);

$coffeeMenu->add(new MenuItem("Coffee Cake", "Crumbly cake topped with cinnamon and walnuts", true, 1.59));
$coffeeMenu->add(new MenuItem("Bagel", "Flavors include sesame, poppyseed, cinnamon raisin, pumpkin", false, 0.69));
$coffeeMenu->add(new MenuItem("Biscotti", "Three almond or hazelnut biscotti cookies", true, 0.89));

$waitress = new Waitress($allMenus);
$waitress->printMenu();