<?php
// Ported from Head First Design Patters Examples: http://www.headfirstlabs.com/books/hfdp/
// Observer Pattern - defines a one-to-many dependency between objects so that when one object
// changes state, all its dependents are notified and updated automatically

interface iSubject{
    public function registerObserver($o);
    public function removeObserver($o);
    public function notifyObservers();
}

interface iObserver{ public function update($temp, $humidity, $pressure); }
interface iDisplayElement{ public function display(); }

class WeatherData implements iSubject{
    private $observers;
    private $temperature;
    private $humidity;
    private $pressure;

    public function __construct(){ $this->observers = array(); }
    public function registerObserver($o){ $this->observers[] = $o; }
    public function removeObserver($o){
        $key = array_search($o, $this->observers);
        if($key !== False){
            unset($this->observers[$key]);
        }
    }
    public function notifyObservers(){
        foreach($this->observers as $o){
            $o->update($this->temperature, $this->humidity, $this->pressure);
        }
    }

    public function measurementsChanged(){ $this->notifyObservers(); }
    public function setMeasurements($temp, $humid, $press){
        $this->temperature = $temp;
        $this->humidity = $humid;
        $this->pressure = $press;
        $this->measurementsChanged();
    }
}

class CurrentConditionsDisplay implements iObserver, iDisplayElement{
    private $temperature;
    private $humidity;
    private $weatherData;

    function __construct($wd){
        $this->weatherData = $wd;
        $wd->registerObserver($this);
    }

    public function update($temp, $humid, $press){
        $this->temperature = $temp;
        $this->humidity = $humid;
        $this->display();
    }

    public function display(){
        print "Current conditions: ".$this->temperature."F degrees and ".$this->humidity."% humidity\n";
    }
}

$weatherData = new WeatherData;
$currentDisplay1 = new CurrentConditionsDisplay($weatherData);
$currentDisplay2 = new CurrentConditionsDisplay($weatherData);
$weatherData->setMeasurements(80, 65, 30.4);
$weatherData->setMeasurements(82, 70, 29.2);
$weatherData->setMeasurements(78, 90, 29.2);