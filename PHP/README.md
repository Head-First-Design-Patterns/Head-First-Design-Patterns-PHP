# Head First Design Patterns in PHP
## Someone has already solved your problems

These patterns are ported from the Java examples in the O'Reilly book ["Head First Design Patterns"](http://www.headfirstlabs.com/books/hfdp/).

## OO Basics
* Abstraction
* Encapsulation
* Polymorphism
* Inheritance

## OO Principles
* Encapsulate what varies
* Favor composition over inheritance
* Program to interfaces, not implementations
* Strive for loosely coupled designs between objects that interact
* Classes should be open for extension but closed for modification.
* Depend on abstractions. Do not depend on concrete classes.
* Only talk to your friends.
* Don't call us, we'll call you.
* A class should have only one reason to change.

### Creational
* [Singleton Pattern](SingletonPattern.php) - Ensure a class only has one instance and provide a global point of access to it.
* [Factory Method](FactoryMethod.php) - Define an interface for creating an object, but let subclasses decide which class to instantiate. Factory Method lets a class defer instantiation to the subclasses.
* [Abstract Factory](FactoryPatternAbstract.php) - Provide an interface for creating families of related or dependent objects without specifying their concrete classes.

### Structural
* [Decorator Pattern](DecoratorPattern.php) - Attach additional responsibilities to an object dynamically. Decorators provide a flexible alternative to subclassing for extending functionality.
* [Composite Pattern](CompositePattern.php) - Compose objects into tree structures to represent part-whole hierarchies. Composite lets clients treat individual objects and compositions of objects uniformly.
* [Proxy Pattern](ProxyPattern.php) - Provides a surrogate or placeholder for another object to control access to it.
* [Facade Pattern](FacadePattern.php) - Provides a unified interface to a set of interfaces in a subsystem. Facade defines a higher-level interface that makes the subsystem easier to use.
* [Adapter Pattern](AdapterPattern.php) - Converts the interface of a class into another interface clients expect. Lets classes work together that couldn't otherwise because fo incompatible interfaces.

### Behavioral
* [Strategy Pattern](StrategyPattern.php) - Defines a family of algorithms, encapsulates each one, and makes them interchangeable. Strategy lets the algorithm vary independently from clients that use it.
* [Observer Pattern](ObserverPattern.php) - Defines a one-to-many dependency between objects so that when one object changes state, all its dependents are notified and updated automatically
* [Command Pattern](CommandPattern.php) [(Simple version)](CommandPatternSimple.php) - Encapsulates a request as an object, thereby letting you parameterize clients with different requests, queue or log requests, and support undoable operations.
* [Template Method Pattern](TemplateMethodPattern.php) - Defines the skeleton of an algorithm in a method, deferring some steps to subclasses. Template Method lets subclasses redefine certain steps of an algorithm without changing the algorithm's structure.
* [Iterator Pattern](IteratorPattern.php) - Provide a way to access the elements of an aggregate object sequentially without exposing its underlying representation.
* [State Pattern](StatePattern.php) - Allow an object to alter its behavior when its internal state changes. The object will appear to change its class.

### Compound
* [Compound Pattern](CompoundPatter.php) - Combines two or more patterns into a solution that solves a recurring or general problem.
