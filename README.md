# Head First Design Patterns in PHP
##Someone has already solved your problems

These patterns are ported from the Java examples in the O'Reilly book ["Head First Design Patterns"](http://www.headfirstlabs.com/books/hfdp/).

* [Strategy Pattern](StrategyPattern.php) - Defines a family of algorithms, encapsulates each one, and makes them interchangeable. Strategy lets the algorithm vary independently from clients that use it.
* [Observer Pattern](ObserverPattern.php) - Defines a one-to-many dependency between objects so that when one object changes state, all its dependents are notified and updated automatically
* [Decorator Pattern](DecoratorPattern.php) - Attach additional responsibilities to an object dynamically. Decorators provide a flexible alternative to subclassing for extending functionality.
* [Factory Method](FactoryMethod.php) - Define an interface for creating an object, but let subclasses decide which class to instantiate. Factory Method lets a class defer instantiation to the subclasses.

##OO Basics
* Abstraction
* Encapsulation
* Polymorphism
* Inheritance

##OO Principles
* Encapsulate what varies
* Favor composition over inheritance
* Program to interfaces, not implementations
* Strive for loosely coupled designs between objects that interact
* Classes should be open for extension but closed for modification.
* Depend on abstractions. Do not depend on concrete classes.