<?php
/**
 * Ported from Head First Design Patters Examples: http://www.headfirstlabs.com/books/hfdp/
 * Command Pattern - Encapsulates a request as an object, thereby letting you parameterize clients
 * with different requests, queue or log requests, and support undoable operations.
 */

interface Command {
    public function execute();
    public function undo();
}
class NoCommand implements Command {
    public function execute() {}
    public function undo() {}
}

class Light{
    private $location;
    public function __construct($l){ $this->location = $l; }
    public function on(){ print $this->location . " Light is on\n"; }
    public function off(){ print $this->location . " Light is off\n"; }
}

class Stereo{
    private $location;
    public function __construct($l){ $this->location = $l; }
    public function on(){ print $this->location . " Stereo is on\n"; }
    public function off(){ print $this->location . " Stereo is off\n"; }
    public function setCd(){ print $this->location . " Stereo set for CD input\n"; }
    public function setDVD(){ print $this->location . " Stereo set for DVD input\n"; }
    public function setRadio() { print $this->location . " Stereo set for Radio input\n"; }
    public function setVolume($volume){ print $this->location . " Stereo volume set to " . $volume . "\n"; }
}

class CeilingFan{
    private $location;
    private $level;
    public static $HIGH = 3;
    public static $MEDIUM = 2;
    public static $LOW = 1;
    public static $OFF = 0;

    public function __construct($l) { $this->location = $l; }
    public function getSpeed(){ return $this->level; }
    public function high(){
        $this->level = self::$HIGH;
        print $this->location . " ceiling fan is on high\n";
    }
    public function medium(){
        $this->level = self::$MEDIUM;
        print $this->location . " ceiling fan is on medium\n";
    }
    public function low(){
        $this->level = self::$LOW;
        print $this->location . " ceiling fan is on low\n";
    }
    public function off(){
        $this->level = self::$OFF;
        print $this->location . " ceiling fan is off\n";
    }
}

class GarageDoor{
    public function up() { print $this->location . " Garage Door is Open\n"; }
    public function down() { print $this->location . " Garage Door is Closed\n"; }
    public function stop() { print $this->location . " Garage Door is Stopped\n"; }
    public function lightOn() { print $this->location . " Garage Door light is On\n"; }
    public function lightOff() { print $this->location . " Garage Door light is Off\n"; }
}

class LightOnCommand implements Command{
    private $light;
    public function __construct($l){ $this->light = $l; }
    public function execute() { $this->light->on(); }
    public function undo() { $this->light->off(); }
}

class LightOffCommand implements Command{
    private $light;
    public function LightOffCommand($l) { $this->light = $l; }
    public function execute() { $this->light->off(); }
    public function undo() { $this->light->on(); }
}

class GarageDoorUpCommand implements Command{
    private $garageDoor;
    public function __construct($gd) { $this->garageDoor = $gd; }
    public function execute() { $this->garageDoor->up(); }
    public function undo() { $this->garageDoor->down(); }
}

class GarageDoorDownCommand implements Command{
    private $garageDoor;
    public function __construct($gd) { $this->garageDoor = $gd; }
    public function execute() { $this->garageDoor->down(); }
    public function undo() { $this->garageDoor->up(); }
}

class StereoOnWithCDCommand implements Command{
    private $stereo;
    public function __construct($s){ $this->stereo = $s; }
    public function execute()
    {
        $this->stereo->on();
        $this->stereo->setCD();
        $this->stereo->setVolume(11);
    }
    public function undo(){
        $this->stereo->setVolume(0);
        $this->stereo->off();
    }
}

class StereoOffCommand implements Command{
    private $stereo;
    public function __construct($s) { $this->stereo = $s; }
    public function execute() { $this->stereo->off(); }
    public function undo(){
        $this->stereo->on();
        $this->stereo->setCD();
        $this->stereo->setVolume(11);
    }
}

class CeilingFanOnCommand implements Command{
    private $fan;
    public function __construct($f) { $this->fan = $f; }
    public function execute() { $this->fan->high(); }
    public function undo() { $this->fan->off(); }
}

class CeilingFanOffCommand implements Command{
    private $fan;
    public function __construct($f) { $this->fan = $f; }
    public function execute() {
        $this->prevSpeed = $this->fan->getSpeed();
        $this->fan->off();
    }
    public function undo() {
        if ($this->prevSpeed === CeilingFan::$HIGH) $this->fan->high();
        elseif ($this->prevSpeed === CeilingFan::$MEDIUM) $this->fan->medium();
        elseif ($this->prevSpeed === CeilingFan::$LOW) $this->fan->low();
        elseif ($this->prevSpeed === CeilingFan::$OFF) $this->fan->off();
    }
}

class CeilingFanMediumCommand implements Command{
    private $fan;
    private $prevSpeed;
    public function __construct($f) { $this->fan = $f; }
    public function execute() {
        $this->prevSpeed = $this->fan->getSpeed();
        $this->fan->medium();
    }
    public function undo() {
        if ($this->prevSpeed === CeilingFan::$HIGH) $this->fan->high();
        elseif ($this->prevSpeed === CeilingFan::$MEDIUM) $this->fan->medium();
        elseif ($this->prevSpeed === CeilingFan::$LOW) $this->fan->low();
        elseif ($this->prevSpeed === CeilingFan::$OFF) $this->fan->off();
    }
}

class CeilingFanHighCommand implements Command{
    private $fan;
    private $prevSpeed;
    public function __construct($f) { $this->fan = $f; }
    public function execute() {
        $this->prevSpeed = $this->fan->getSpeed();
        $this->fan->high();
    }
    public function undo() {
        if ($this->prevSpeed === CeilingFan::$HIGH) $this->fan->high();
        elseif ($this->prevSpeed === CeilingFan::$MEDIUM) $this->fan->medium();
        elseif ($this->prevSpeed === CeilingFan::$LOW) $this->fan->low();
        elseif ($this->prevSpeed === CeilingFan::$OFF) $this->fan->off();
    }
}

class RemoteControl{
    private $onCommands;
    private $offCommands;
    private $undoCommand;

    public function __construct()
    {
        $this->onCommands = array();
        $this->offCommands = array();
        $noCommand = new NoCommand();
        for($i = 0; $i < 7; $i++){
            array_push($this->onCommands, $noCommand);
            array_push($this->offCommands, $noCommand);
        }
        $this->undoCommand = $noCommand;
    }

    public function setCommand($slot, $onCommand, $offCommand){
        $this->onCommands[$slot] = $onCommand;
        $this->offCommands[$slot] = $offCommand;
    }

    public function onButtonWasPushed($slot) {
        $this->onCommands[$slot]->execute();
        $this->undoCommand = $this->onCommands[$slot];
    }
    public function offButtonWasPushed($slot) {
        $this->offCommands[$slot]->execute();
        $this->undoCommand = $this->offCommands[$slot];
    }

    public function undoButtonWasPushed(){
        $this->undoCommand->undo();
    }

    public function __toString()
    {
        $retVal = "\n------ Remote Control ------\n";
        for($i = 0; $i < count($this->onCommands); $i++){
            $retVal .= "[slot " . $i . "] " .
                get_class($this->onCommands[$i]) . "\t" .
                get_class($this->offCommands[$i]) . "\n";
        }
        return $retVal;
    }
}

$remote = new RemoteControl();

// Create all the devices in their proper locations
$livingRoomLight = new Light("Living Room");
$kitchenLight = new Light("Kitchen");
$ceilingFan = new CeilingFan("Living Room");
$garageDoor = new GarageDoor("");
$stereo = new Stereo("Living Room");

// Create all the light command objects
$livingRoomLightOn = new LightOnCommand($livingRoomLight);
$livingRoomLightOff = new LightOffCommand($livingRoomLight);
$kitchenLightOn = new LightOnCommand($kitchenLight);
$kitchenLightOff = new LightOffCommand($kitchenLight);

// Create the On and Off for the ceiling fan
$ceilingFanOn = new CeilingFanOnCommand($ceilingFan);
$ceilingFanOff = new CeilingFanOffCommand($ceilingFan);

// Create the Up and Down commands for the Garage
$garageDoorUp = new GarageDoorUpCommand($garageDoor);
$garageDoorDown = new GarageDoorDownCommand($garageDoor);

// Create the stereo On and Off commands
$stereoOnWithCD = new StereoOnWithCDCommand($stereo);
$stereoOff = new StereoOffCommand($stereo);

// Now that we've got all our commands, we can load them into the remote slots
$remote->setCommand(0, $livingRoomLightOn, $livingRoomLightOff);
$remote->setCommand(1, $kitchenLightOn, $kitchenLightOff);
$remote->setCommand(2, $ceilingFanOn, $ceilingFanOff);
$remote->setCommand(3, $stereoOnWithCD, $stereoOff);

print $remote . "\n";

// Before undo test
/*
$remote->onButtonWasPushed(0);
$remote->offButtonWasPushed(0);
$remote->onButtonWasPushed(1);
$remote->offButtonWasPushed(1);
$remote->onButtonWasPushed(2);
$remote->offButtonWasPushed(2);
$remote->onButtonWasPushed(3);
$remote->offButtonWasPushed(3);
 */

// Undo test
/*
$remote->onButtonWasPushed(0);
$remote->offButtonWasPushed(0);
print $remote . "\n";
$remote->undoButtonWasPushed();
$remote->offButtonWasPushed(0);
$remote->onButtonWasPushed(0);
print $remote . "\n";
$remote->undoButtonWasPushed();
*/

// Ceiling fan undo test
$ceilingFan = new CeilingFan("Living Room");
$ceilingFanMedium = new CeilingFanMediumCommand($ceilingFan);
$ceilingFanHigh = new CeilingFanHighCommand($ceilingFan);
$ceilingFanOff = new CeilingFanOffCommand($ceilingFan);

$remote->setCommand(0, $ceilingFanMedium, $ceilingFanOff);
$remote->setCommand(1, $ceilingFanHigh, $ceilingFanOff);

$remote->onButtonWasPushed(0); // First, turn the fan on medium
$remote->offButtonWasPushed(0); // Then turn it off
print $remote . "\n";
$remote->undoButtonWasPushed(); // Undo! It should go back to medium

$remote->onButtonWasPushed(1); // Turn it on to high this time
print $remote . "\n";
$remote->undoButtonWasPushed(); // And, one more undo; it should go back to medium