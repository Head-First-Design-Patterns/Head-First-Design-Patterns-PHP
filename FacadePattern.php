<?php
/**
 * Ported from Head First Design Patters Examples: http://www.headfirstlabs.com/books/hfdp/
 * Facade Pattern - 
 */
 
class Amplifier{
    private $description;
    private $tuner;
    private $dvd;
    private $cd;
    
    public function __construct($d) { $this->description = $d; }
    public function on() { print $this->description . " on\n"; }
    public function off() { print $this->description . " off\n"; }
    public function setStereoSound() { print $this->description . " stereo mode on\n"; }
    public function setSurroundSound() { print $this->description . " surround sound on (5 speakers, 1 subwoofer)\n"; }
    public function setVolume($level) { $this->description . " setting volume to " . $level . "\n"; }
    public function setTuner($t) { $this->tuner = $t; print $this->description . " setting tuner to " . $tuner . "\n"; }
    public function setDvd($d) { $this->dvd = $d; print $this->description . " setting DVD player to " . $d . "\n"; }
    public function setCd($c) { $this->cd = $c; print $this->description . " setting CD player to " . $c . "\n"; }
    public function __toString() { return $this->description; }
}

class CdPlayer{
    private $description;
    private $currentTrack;
    private $amplifier;
    private $title;
    
    public function __construct($d, $a) { $this->description = $d; $this->amplifier = $a; }
    public function on() { print $this->description . " on\n"; }
    public function off() { print $this->description . " off\n"; }
    public function eject() { $this->title = null; print $this->description . " eject\n"; }
    public function playTitle($t){
        $this->title = $t;
        $this->currentTrack = 0;
        print $this->description . ' playing "' . $this->title . "\"\n";
    }
    public function playTrack($t){
        if($this->title == null){
            print $this->description . " can't play track " . $this->currentTrack . ", no cd inserted\n";
        }
        else{
            $this->currentTrack = $t;
            print $this->description . " playing track " . currentTrack . "\n";
        }    
    }
    public function stop() {$this->currentTrack = 0; print $this->description . " stopped\n"; }
    public function pause() { print $this->description . ' paused "' . $this->title . "\"\n"; }
    public function __toString() { return description; }
}

class DvdPlayer{
    private $description;
    private $currentTrack;
    private $amplifier;
    private $movie;
    
    public function __construct($d, $a){ $this->description = $d; $this->amplifier = $a; }
    public function on() { print $this->description . " on\n"; }
    public function off() { print $this->description . " off\n"; }
    public function eject() { $this->movie = null; print $this->description . " eject\n"; }
    public function playMovie($m) {
        $this->movie = $m;
        $this->currentTrack = 0;
        print $this->description . ' playing "' . $m . "\"\n";
    }
    public function playTrack($t){
        if($this->movie == null){
            print $this->description . " can't play track " . $t . " no dvd inserted\n";
        }
        else{
            $this->currentTrack = $t;
            print $this->description . " playing track " . $t . ' of "' . $this->movie . '"';
        }
    }
    public function stop() { $this->currentTrack = 0; print $this->description . ' stopped "' . $this->movie . "\"\n"; }
    public function pause() { print $this->description . ' paused "' . $this->movie . "\"\n"; }
    public function setTwoChannelAudio() { print $this->description . " set two channel audio\n"; }
    public function setSurroundAudio() { print $this->description . " set surround audio\n"; }
    public function __toString() { return $this->description; }
}

class PopcornPopper{
    private $description;
    
    public function __construct($d) { $this->description = $d; }
    public function on() { print $this->description . " on\n"; }
    public function off() { print $this->description . " off\n"; }
    public function pop() { print $this->description . " popping popcorn!\n"; }
    public function toString() { return description; }
}

class Projector{
    private $description;
    private $dvdPlayer;
    
    public function __construct($description, $dvdPlayer){
        $this->description = $description;
        $this->dvdPlayer = $dvdPlayer;
    }
    public function on() { print $this->description . " on\n"; }
    public function off() { print $this->description . " off\n"; }
    public function wideScreenMode() { print $this->description . " in widescreen mode (16x9 aspect ratio)\n"; }
    public function tvMode() { print $this->description . " in tv mode (4x3 aspect ratio)\n"; }
    public function __toString() { return description; }
}

class Screen{
    private $description;
    
    public function __construct($d) { $this->description = $d; }
    public function up() { print $this->description . " going up\n"; }
    public function down() { print $this->description . " going down\n"; }
    public function __toString() { return $this->description; }
}

class TheaterLights{
    private $description;
    
    public function __construct($d) { $this->description = $d; }
    public function on() { print $this->description . " on\n"; }
    public function off() { print $this->description . " off\n"; }
    public function dim($l) { print $this->description . " dimming to " . $l . "%\n"; }
    public function __toString() { return $this->description; }
}

class Tuner{
    private $description;
    private $amplifier;
    private $frequency;
    
    public function __construct($d) { $this->description = $d; }
    public function on() { print $this->description . " on\n"; }
    public function off() { print $this->description . " off\n"; }
    public function setFrequency($f) { $this->frequency = $f; print $this->description . " setting the frequency to " . $f . "\n"; }
    public function setAm() { print $this->description . " setting AM mode\n"; }
    public function setFm() { print $this->description . " setting FM mode\n"; }
    public function __toString() { return $this->description; }
}

class HomeTheaterFacade{
    private $ampr;
    private $tuner;
    private $dvd;
    private $cd;
    private $projector;
    private $lights;
    private $screen;
    private $popper;
    
    public function __construct($a, $t, $d, $c, $pro, $s, $l, $pop) {
        $this->amp = $a;
        $this->tuner = $t;
        $this->dvd = $d;
        $this->cd = $c;
        $this->projector = $pro;
        $this->screen = $s;
        $this->lights = $l;
        $this->popper = $pop;
    }
    public function watchMovie($m){
        print "Get ready to watch a movie...\n";
        $this->popper->on();
        $this->popper->pop();
        $this->lights->dim(10);
        $this->screen->down();
        $this->projector->on();
        $this->projector->widescreenMode();
        $this->amp->on();
        $this->amp->setDvd($this->dvd);
        $this->amp->setSurroundSound();
        $this->amp->setVolume(5);
        $this->dvd->on();
        $this->dvd->playMovie($m);
    }
    public function endMovie(){
        print "Shutting movie theater down...\n";
        $this->popper->off();
        $this->lights->off();
        $this->screen->up();
        $this->projector->off();
        $this->amp->off();
        $this->dvd->stop();
        $this->dvd->eject();
        $this->dvd->off();
    }
    public function listenToCd($cdTitle){
        print "Get ready for an audiopile experience...\n";
        $this->lights->on();
        $this->amp->on();
        $this->amp->setVolume(5);
        $this->amp->setCd($this->cd);
        $this->amp->setStereoSound();
        $this->cd->on();
        $this->cd->play();
    }
    public function endCd(){
        print "Shutting down CD...\n";
        $this->amp->off();
        $this->amp->setCd($this->cd);
        $this->cd->eject();
        $this->cd->off();
    }
    public function listenToRadio($freq){
        print "Tuning in the airwaves...\n";
        $this->tuner->on();
        $this->tuner->setFrequency($freq);
        $this->amp->on();
        $this->amp->setVolume(5);
        $this->amp->setTuner($this->tuner);
    }
    public function endRadio(){
        print "Shutting down the tuner...\n";
        $this->tuner->off();
        $this->amp->off();
    }
}


$amp = new Amplifier("Top-O-Line Amplifier");
$tuner = new Tuner("Top-O-Line AM/FM Tuner", amp);
$dvd = new DvdPlayer("Top-O-Line DVD Player", amp);
$cd = new CdPlayer("Top-O-Line CD Player", amp);
$projector = new Projector("Top-O-Line Projector", dvd);
$lights = new TheaterLights("Theater Ceiling Lights");
$screen = new Screen("Theater Screen");
$popper = new PopcornPopper("Popcorn Popper");

$homeTheater = new HomeTheaterFacade($amp, $tuner, $dvd, $cd, $projector, $screen, $lights, $popper);
$homeTheater->watchMovie("Raiders of the Lost Ark");
$homeTheater->endMovie();