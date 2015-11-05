<?php

class Controller{

    private $table   = null;
    private $rows    = null;
    private $columns = null;

    public function __construct($rows, $columns){
    	/*{{{*/
        $this->setRows($rows);
        $this->setColumns($columns);

        $table = array();

        for ( $rowIndex=0; $rowIndex<$rows; $rowIndex++){
            $tmp = array();
            for ( $colIndex=0; $colIndex<$columns; $colIndex++){
                $ceil           = new Ceil(0);
                $tmp[$colIndex] = $ceil;
            }
            $table[$rowIndex] = $tmp;
        }

        $this->setTable($table);
    	/*}}}*/
    }

    /*{{{*/
    public function setTable($table){
        /*{{{*/
        $this->table = $table;
        /*}}}*/
    }

    public function setRows($rows){
        /*{{{*/
        $this->rows = $rows;
        /*}}}*/
    }

    private function setColumns($columns){
        /*{{{*/
        $this->columns = $columns;
        /*}}}*/
    }
    /*}}}*/

    /*{{{*/
    private function getRows(){
        /*{{{*/
        return $this->rows;
        /*}}}*/
    }

    public function getColumns(){
        /*{{{*/
        return $this->columns;
        /*}}}*/
    }

    public function getTable(){
        /*{{{*/
        return $this->table;
        /*}}}*/
    }
    /*}}}*/

    private function setCeil($rowIndex, $colIndex, $ceil){
        /*{{{*/
        $table          = $this->getTable();
        $row            = $table[$rowIndex];
        $row[$colIndex] = $ceil;

        $table[$rowIndex] = $row;
        $this->setTable($table);
        /*}}}*/
    }

    private function getCeil($rowIndex, $colIndex){
        /*{{{*/
        $table = $this->getTable();
        $row   = $table[$rowIndex];
        $ceil  = $row[$colIndex];

        return $ceil;
        /*}}}*/
    }

    public function init(){
    	/*{{{*/
        for ($rowIndex=0; $rowIndex<$this->getRows(); $rowIndex++){
            for ($colIndex=0; $colIndex<$this->getColumns(); $colIndex++){
                $ceil = $this->getCeil($rowIndex, $colIndex);
                $rowTmp = $rowIndex + 1;
                $colTmp = $colIndex + 1;
                echo "Set status (1/0) for ceil in position row: $rowTmp, column: $colTmp ($rowTmp, $colTmp): ";
                $status = fgets(STDIN);
                $ceil->setStatus($status);
                $this->setCeil($rowIndex, $colIndex, $ceil);
                echo exec("clear");
                $this->paint();
            }
        }
    	/*}}}*/
    }

    public function run(){
        /*{{{*/
        $newTable = array();

        for ($rowIndex=0; $rowIndex<$this->getRows(); $rowIndex++){
            $tmp = array();
            for ($colIndex=0; $colIndex<$this->getColumns(); $colIndex++){
                $adjacents = $this->getAdjacents($rowIndex, $colIndex);
                $ceil = $this->recalculateCeil($rowIndex, $colIndex, $adjacents);
                $tmp[$colIndex] = $ceil;
            }
            $newTable[$rowIndex] = $tmp;
        }

        $this->setTable($newTable);
        /*}}}*/
    }

    public function recalculateCeil($rowIndex, $colIndex, $adjacents){
        /*{{{*/
        $currentCeil = clone $this->getCeil($rowIndex, $colIndex);

        switch($currentCeil->getStatus()){
        case 0:
            // check born
            $alives = 0;
            foreach ($adjacents as $adjacentKey => $adjacentValue){
                $ceil = $this->getCeil($adjacentValue->row, $adjacentValue->column);
                $alives += ( $ceil->getStatus() == 1 ) ? 1 : 0;
            }
            if ( $alives == 3 ){
                $currentCeil->setStatus(1);
            }
            break;
        case 1:
            // check dead
            $alives = 0;
            foreach ($adjacents as $adjacentKey => $adjacentValue){
                $ceil = $this->getCeil($adjacentValue->row, $adjacentValue->column);
                $alives += ( $ceil->getStatus() == 1 ) ? 1 : 0;
            }
            if ( $alives < 2 || $alives > 3 ){
                $currentCeil->setStatus(0);
            }
            break;
        }

        return $currentCeil;
        /*}}}*/
    }

    public function getAdjacents($rowIndex, $colIndex){
        /*{{{*/
        $adjacents = array();

        $rows    = $this->getRows();
        $columns = $this->getColumns();

        for ($iteration=0;$iteration<8;$iteration++){
            switch($iteration){
            case 0:
                $rowAdjacent = $rowIndex - 1;
                $colAdjacent = $colIndex;
                break;
            case 1:
                $rowAdjacent = $rowIndex - 1;
                $colAdjacent = $colIndex + 1;
                break;
            case 2:
                $rowAdjacent = $rowIndex;
                $colAdjacent = $colIndex + 1;
                break;
            case 3:
                $rowAdjacent = $rowIndex + 1;
                $colAdjacent = $colIndex + 1;
                break;
            case 4:
                $rowAdjacent = $rowIndex + 1;
                $colAdjacent = $colIndex;
                break;
            case 5:
                $rowAdjacent = $rowIndex + 1;
                $colAdjacent = $colIndex -1;
                break;
            case 6:
                $rowAdjacent = $rowIndex;
                $colAdjacent = $colIndex - 1;
                break;
            case 7:
                $rowAdjacent = $rowIndex - 1;
                $colAdjacent = $colIndex - 1;
                break;
            }

            if ( ( $rowAdjacent < 0 ) || ( $colAdjacent < 0 ) || ( $rowAdjacent > ( $rows - 1 ) ) || ( $colAdjacent > ( $columns - 1 ) ) ){
            }else{
                $adjacent         = new StdClass();
                $adjacent->row    = $rowAdjacent;
                $adjacent->column = $colAdjacent;

                $adjacents[$iteration] = $adjacent;
            }
        }

        return $adjacents;
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
