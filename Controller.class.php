<?php

class Controller{

    private $table   = null;

    public function __construct($rows, $columns){
    	/*{{{*/
        $table = array();

        for ( $row=0; $row<$rows; $row++){
            $tmp = array();
            for ( $column=0; $column<$columns; $column++){
                $ceil = new Ceil(0);
                $tmp[$column] = $ceil;
            }
            $table[$row] = $tmp;
        }

        $this->table = $table;
    	/*}}}*/
    }

    public function paint(){
    	/*{{{*/
        $view = new View($this->table);
        $view->render();
    	/*}}}*/
    }

}

?>
