<?php

class View{

    private $table = null;

    public function __construct($table){
    	/*{{{*/
        $this->table = $table;
    	/*}}}*/
    }

    public function render(){
    	/*{{{*/
        foreach($this->table as $rowIndex => $row){
            echo "| ";
            foreach($row as  $columnIndex => $column){
                // echo $column->getStatus() . " | ";
                echo $column->getSimbol() . " | ";
            }
            echo "\n";
        }
    	/*}}}*/
    }
}

?>

