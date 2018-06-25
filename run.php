<?php
require ("vendor/autoload.php");

$line = (int)readline('Type the number of sandwiches and tap enter: ');

try 
{
    $obj = new \SandwichSchedule\SandwichSchedule();
    $obj->setQtyOrders($line);
    $obj->calculate();
    
    echo $obj->output();
} catch (Exception $e) {
    echo 'Error found : ' . $e->getMessage() . chr(10);
}