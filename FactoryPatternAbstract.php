<?php
/* Ported from Head First Design Patters Examples: http://www.headfirstlabs.com/books/hfdp/
*  Abstract Factory - Provide an interface for creating families of related or dependent objects without specifying their concrete classes.
*/

interface Dough { public function __toString(); }
class ThickCrustDough implements Dough {
    public function __toString() { return "ThickCrust style extra thick crust dough";}
}
class ThinCrustDough implements Dough{
    public function __toString() { return "Thin Crust Dough"; }
}

interface Sauce { public function __toString(); }
class PlumTomatoSauce implements Sauce{
    public function __toString() { return "Tomato sauce with plum tomatoes"; }
}
class MarinaraSauce implements Sauce{
    public function __toString() { return "Marinara Sauce"; }
}

interface Cheese { public function __toString(); }
class MozzarellaCheese implements Cheese{
    public function __toString() { return "Shredded Mozzarella"; }
}
class ReggianoCheese implements Cheese{
    public function __toString() { return "Reggiano Cheese"; }
}

interface Veggies { public function __toString(); }
class Garlic implements Veggies {
    public function __toString() { return "Garlic"; }
}
class Onion implements Veggies{
    public function __toString() { return "Onion"; }
}
class Mushroom implements Veggies {
    public function __toString() { return "Mushrooms"; }
}
class RedPepper implements Veggies {
    public function __toString() { return "Red Pepper"; }
}
class BlackOlives implements Veggies {
    public function __toString() { return "Black Olives"; }
}
class Spinach implements Veggies {
    public function __toString() { return "Spinach"; }
}
class EggPlant implements Veggies {
    public function __toString() { return "Egg Plant"; }
}

interface Pepperoni { public function __toString(); }
class SlicedPepperoni implements Pepperoni {
    public function __toString() { return "Sliced Pepperoni"; }
}

interface Clams { public function __toString(); }
class FreshClams implements Clams {
    public function __toString() { return "Fresh Clams from Long Island Sound"; }
}
class FrozenClams implements Clams {
    public function __toString() { return "Frozen Clams from Chesapeake Bay"; }
}


interface PizzaIngredientFactory {
    public function createDough();
    public function createSauce();
    public function createCheese();
    public function createVeggies();
    public function createPepperoni();
    public function createClams();
}

class NYPizzaIngredientFactory implements PizzaIngredientFactory{
    public function createDough() { return new ThinCrustDough(); }
    public function createSauce() { return new MarinaraSauce(); }
    public function createCheese() { return new ReggianoCheese(); }
    public function createVeggies() { return array(new Garlic(), new Onion(), new Mushroom(), new RedPepper() ); }
    public function createPepperoni() { return new SlicedPepperoni(); }
    public function createClams() { return new FreshClams(); }
}

class ChicagoPizzaIngredientFactory implements PizzaIngredientFactory{
    public function createDough() { return new ThinCrustDough(); }
    public function createSauce() { return new PlumTomatoSauce(); }
    public function createCheese() { return new MozzarellaCheese(); }
    public function createVeggies() { return array(new BlackOlives(), new Spinach(), new EggPlant()); }
    public function createPepperoni() { return new SlicedPepperoni(); }
    public function createClams() { return new FrozenClams(); }
}

abstract class Pizza{
    protected $name;
    protected $dough;
    protected $sauce;
    protected $veggies = array();
    protected $cheese;
    protected $pepperoni;
    protected $clam;

    function prepare(){
        print "Preparing " . $this->name . "\n";
        print "Tossing dough...\n";
        print "Adding sauce...\n";
        print "Adding toppings: \n";
        foreach($this->veggies as $v){
            print "\t" . $v . "\n";
        }
    }

    function bake() { print "Bake for 25 minutes at 350\n"; }
    function cut() { print "Cutting the pizza into diagonal slices\n"; }
    function box() { print "Place pizza in official PizzaStore box\n"; }
    function getName() { return $this->name; }
    function setName( $n ) { $this->name = $n; }

    public function __toString(){
        $display  = "---- " . $this->name . " ----\n";
        $display .= $this->dough . "\n" . $this->sauce . "\n";
        foreach ($this->veggies as $v) {
            $display .= $v . "\n";
        }
        return $display;
    }
}

class CheesePizza extends Pizza{
    private $ingrediantFactory;

    public function __construct( $factory )
    {
        $this->ingrediantFactory = $factory;
    }

    public function prepare(){
        print "Preparing " . $this->getName() . "\n";
        $this->dough = $this->ingrediantFactory->createDough();
        $this->sauce = $this->ingrediantFactory->createSauce();
        $this->cheese = $this->ingrediantFactory->createCheese();
    }
}

class ClamPizza extends Pizza{
    private $ingrediantFactory;

    public function __construct( $factory )
    {
        $this->ingrediantFactory = $factory;
    }

    public function prepare(){
        print "Preparing " . $this->getName() . "\n";
        $this->dough = $this->ingrediantFactory->createDough();
        $this->sauce = $this->ingrediantFactory->createSauce();
        $this->cheese = $this->ingrediantFactory->createCheese();
        $this->clam = $this->ingrediantFactory->createClams();
    }
}

class PepperoniPizza extends Pizza{
    private $ingrediantFactory;

    public function __construct( $factory )
    {
        $this->ingrediantFactory = $factory;
    }

    public function prepare(){
        print "Preparing " . $this->getName() . "\n";
        $this->dough = $this->ingrediantFactory->createDough();
        $this->sauce = $this->ingrediantFactory->createSauce();
        $this->cheese = $this->ingrediantFactory->createCheese();
        $this->pepperoni = $this->ingrediantFactory->createPepperoni();
    }
}

class VeggiePizza extends Pizza{
    private $ingrediantFactory;

    public function __construct( $factory )
    {
        $this->ingrediantFactory = $factory;
    }

    public function prepare(){
        print "Preparing " . $this->getName() . "\n";
        $this->dough = $this->ingrediantFactory->createDough();
        $this->sauce = $this->ingrediantFactory->createSauce();
        $this->cheese = $this->ingrediantFactory->createCheese();
        $this->veggies = $this->ingrediantFactory->createVeggies();
    }
}

abstract class PizzaStore
{
    function orderPizza($type){
        $pizza = $this->createPizza($type);

        $pizza->prepare();
        $pizza->bake();
        $pizza->cut();
        $pizza->box();

        return $pizza;
    }

    abstract function createPizza($type);
}

class NYPizzaStore extends PizzaStore{
    public function createPizza($item)
    {
        $pizza = null;
        $ingredientFactory = new NYPizzaIngredientFactory();
        if($item === "cheese"){
            $pizza = new CheesePizza($ingredientFactory);
            $pizza->setName("New York Style Cheese Pizza");
        }
        else if($item === "veggie"){
            $pizza = new VeggiePizza($ingredientFactory);
            $pizza->setName("New York Style Veggie Pizza");
        }
        else if($item === "clam"){
            $pizza = new ClamPizza($ingredientFactory);
            $pizza->setName("New York Style Clam pizza");
        }
        else if($item === "pepperoni"){
            $pizza = new PepperoniPizza($ingredientFactory);
            $pizza->setName("New York Style Pepperoni Pizza");
        }

        return $pizza;
    }
}

class ChicagoPizzaStore extends PizzaStore{
    public function createPizza($item)
    {
        $pizza = null;
        $ingredientFactory = new ChicagoPizzaIngredientFactory();
        if($item === "cheese"){
            $pizza = new CheesePizza($ingredientFactory);
            $pizza->setName("Chicago Style Cheese Pizza");
        }
        else if($item === "veggie"){
            $pizza = new VeggiePizza($ingredientFactory);
            $pizza->setName("Chicago Style Veggie Pizza");
        }
        else if($item === "clam"){
            $pizza = new ClamPizza($ingredientFactory);
            $pizza->setName("Chicago Style Clam pizza");
        }
        else if($item === "pepperoni"){
            $pizza = new PepperoniPizza($ingredientFactory);
            $pizza->setName("Chicago Style Pepperoni Pizza");
        }

        return $pizza;
    }
}

class CaliforniaPizzaStore extends PizzaStore{
    function createPizza($item)
    {
        if($item === "cheese") return new CaliforniaStyleCheesePizza();
        else if($item === "veggie") return new CaliforniaStyleVeggiePizza();
        else if($item === "clam") return new CaliforniaStyleClamPizza();
        else if($item === "pepperoni") return new CaliforniaStylePepperoniPizza();
        else return null;
    }
}

$nyStore = new NYPizzaStore();
$chicagoStore = new ChicagoPizzaStore();

$pizza = $nyStore->orderPizza("cheese");
print "\n\nEthan ordered a \n" . $pizza . "\n" ;

$pizza = $chicagoStore->orderPizza("cheese");
print "\n\nJoel ordered a \n" . $pizza . "\n" ;

$pizza = $nyStore->orderPizza("clam");
print "\n\nEthan ordered a \n" . $pizza . "\n" ;

$pizza = $chicagoStore->orderPizza("clam");
print "\n\nJoel ordered a \n" . $pizza . "\n" ;

$pizza = $nyStore->orderPizza("pepperoni");
print "\n\nEthan ordered a \n" . $pizza . "\n" ;

$pizza = $chicagoStore->orderPizza("pepperoni");
print "\n\nJoel ordered a \n" . $pizza . "\n" ;

$pizza = $nyStore->orderPizza("veggie");
print "\n\nEthan ordered a \n" . $pizza . "\n" ;

$pizza = $chicagoStore->orderPizza("veggie");
print "\n\nJoel ordered a \n" . $pizza . "\n" ;
