<?php
/* Ported from Head First Design Patters Examples: http://www.headfirstlabs.com/books/hfdp/
*  Factory Method - Define an interface for creating an object, but let subclasses decide which class to instantiate.
*  Factory Method lets a class defer instantiation to the subclasses.
*/

abstract class Pizza{
    protected $name;
    protected $dough;
    protected $sauce;
    protected $toppings = array();

    function prepare(){
        print "Preparing " . $this->name . "\n";
        print "Tossing dough...\n";
        print "Adding sauce...\n";
        print "Adding toppings: \n";
        foreach($this->toppings as $t){
            print "\t" . $t . "\n";
        }
    }

    function bake() { print "Bake for 25 minutes at 350\n"; }
    function cut() { print "Cutting the pizza into diagonal slices\n"; }
    function box() { print "Place pizza in official PizzaStore box\n"; }
    function getName() { return $this->name; }

    public function __toString(){
        $display  = "---- " . $this->name . " ----\n";
        $display .= $this->dough . "\n" . $this->sauce . "\n";
        foreach ($this->toppings as $topping) {
            $display .= $topping . "\n";
        }
        return $display;
    }
}

class CheesePizza extends Pizza{
    function __construct(){
        $this->name = "Cheese Pizza";
        $this->dough = "Regular Crust";
        $this->sauce = "Marinara Pizza Sauce";
        array_push($this->toppings, "Fresh Mozzarella");
        array_push($this->toppings, "Parmesan");
    }
}

class ClamPizza extends Pizza{
    function __construct(){
        $this->name = "Clam Pizza";
        $this->dough = "Thin Crust";
        $this->sauce = "White Garlic Sauce";
        array_push($this->toppings, "Clams");
        array_push($this->toppings, "Grated Parmesan Cheese");
    }
}

class PepperoniPizza extends Pizza{
    function __construct(){
        $this->name = "Pepperoni Pizza";
        $this->dough = "Crust";
        $this->sauce = "Marinara Sauce";
        array_push($this->toppings, "Sliced Pepperoni");
        array_push($this->toppings, "Sliced Onion");
        array_push($this->toppings, "Grated Parmesan Cheese");
    }
}

class VeggiePizza extends Pizza{
    function __construct(){
        $this->name = "Veggie Pizza";
        $this->dough = "Crust";
        $this->sauce = "Marinara Sauce";
        array_push($this->toppings, "Shredded Mozzarella");
        array_push($this->toppings, "Grated Parmesan");
        array_push($this->toppings, "Diced Onion");
        array_push($this->toppings, "Sliced Mushrooms");
        array_push($this->toppings, "Sliced Red Pepper");
        array_push($this->toppings, "Sliced Black Olives");
    }
}

class SimplePizzaFactory{
    function createPizza($type){
        $pizza = null;

        if ($type === "cheese") {
            $pizza = new CheesePizza();
        } else if ($type === "pepperoni") {
            $pizza = new PepperoniPizza();
        } else if ($type === "clam") {
            $pizza = new ClamPizza();
        } else if ($type === "veggie") {
            $pizza = new VeggiePizza();
        }
        return $pizza;
    }
}

class PizzaStore{
    private $simplePizzaFactory;

    public function __construct($factory){
        $this->simplePizzaFactory = $factory;
    }

    public function orderPizza($type){
        $pizza = $this->simplePizzaFactory->createPizza($type);

        $pizza->prepare();
        $pizza->bake();
        $pizza->cut();
        $pizza->box();

        return $pizza;
    }
}

$factory = new SimplePizzaFactory();
$store = new PizzaStore($factory);

$pizza = $store->orderPizza("cheese");
print (string)$pizza;

$pizza = $store->orderPizza("veggie");
print (string)$pizza;