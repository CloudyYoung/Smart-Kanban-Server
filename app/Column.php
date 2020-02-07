<?php


namespace App;

use Flight;
use Throwable;

use \App\Event;

class Column{

    public static $uid = 0;

    public $id = 0;
    public $title = "";
    public $note = "";
    private $event = Array();

    function __construct($id, $title, $note){

        $this->id = $id;
        $this->title = $title;
        $this->note = $note;

        $ret = Flight::sql("SELECT * FROM `event` WHERE `column_id` ='$id'   ", true);
        foreach($ret as $event){
            $this->event[(string)$event->id] = new Event($event->id, $event->title, $event->note);
        }

    }
    
    public function get(){
        $arr = get_object_vars($this);
        $arr['event'] = [];
        foreach($this->event as $event){
            $arr['event'][] = $event->get();
        }
        return $arr;
    }

    public function getEvent($event_id){
        if(array_key_exists($event_id, $this->event)){
            return $this->column[$event_id];
        }else{
            return false;
        }
    }

}