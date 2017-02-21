<?php
/**
 * Ported from Head First Design Patters Examples: http://www.headfirstlabs.com/books/hfdp/
 * Command Pattern - Encapsulates a request as an object, thereby letting you parameterize clients
 * with different requests, queue or log requests, and support undoable operations.
 */

interface Command { public function execute(); }

class Light{
    public function on(){ print "Light is on\n"; }
    public function off(){ print "Light is off\n"; }
}

class LightOnCommand implements Command{
    private $light;
    public function __construct($l){ $this->light = $l; }
    public function execute() { $this->light->on(); }
}

class GarageDoor{
    public function up() { print "Garage Door is Open\n"; }
    public function down() { print "Garage Door is Closed\n"; }
    public function stop() { print "Garage Door is Stopped\n"; }
    public function lightOn() { print "Garage Door light is On\n"; }
    public function lightOff() { print "Garage Door light is Off\n"; }
}

class GarageDoorOpenCommand implements Command{
    private $garageDoor;
    public function __construct($gd) { $this->garageDoor = $gd; }
    public function execute() { $this->garageDoor->up(); }
}

class SimpleRemoteControl{
    private $slot;
    public function setCommand($c) { $this->slot = $c; }
    public function buttonWasPressed() { $this->slot->execute(); }
}

$remote = new SimpleRemoteControl();
$light = new Light();
$lightOn = new LightOnCommand($light);

$garageDoor = new GarageDoor();
$garageOpen = new GarageDoorOpenCommand($garageDoor);

$remote->setCommand($lightOn);
$remote->buttonWasPressed();
$remote->setCommand($garageOpen);
$remote->buttonWasPressed();