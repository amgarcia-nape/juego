<?php

class Ceil{

    private $status = null;

    public function __construct($status){
        $this->setStatus($status);
    }

    public function setStatus($status){
        $this->status = (int)$status;
    }

    public function getStatus(){
    	/*{{{*/
        return $this->status;
    	/*}}}*/
    }

}
