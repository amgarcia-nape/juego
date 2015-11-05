<?php

require_once('Controller.class.php');
require_once('Ceil.class.php');
require_once('View.class.php');

echo "Set num rows: ";
$rows = fgets(STDIN);
echo "Set num columns: ";
$columns = fgets(STDIN);

echo exec("clear");

$con = new Controller($rows, $columns);
$con->init();

echo "\nEnter to run...";
fgets(STDIN);

$continue = 0;
while ( $continue == 0 ){
    echo exec("clear");
    $con->run();
    $con->paint();
    echo "Press 0 or enter for new iteration, 1 to abort: ";
    $continue = fgets(STDIN);
}


?>
