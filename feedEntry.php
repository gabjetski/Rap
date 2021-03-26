<?php
class feedEntry{
    public $title;
    public $path;
    public $length;
    public $tag1;
    public $tag2;
    public $tag3;
    public $tag4;
    public $tag5;
    public $description;
    public $user_id;
    public $bpm;
    public $key_id;
    public $type;
    public $monet;

    function feedEntry ($title, $path, $length, $tag1, $tag2, $tag3, $tag4, $tag5, $description, $user_id, $bpm, $key_id, $type, $monet){
        $this->title = $title;
        $this->path = $path;
        $this->length = $length;
        $this->tag1 = $tag1;
        $this->tag2 = $tag2;
        $this->tag3 = $tag3;
        $this->tag4 = $tag4;
        $this->tag5 = $tag5;
        $this->description = $description;
        $this->user_id = $user_id;
        $this->bpm = $bpm;
        $this->key_id = $key_id;
        $this->type = $type;
        $this->monet = $monet;
    }

    function add(){

    }
}


