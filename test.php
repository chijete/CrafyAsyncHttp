<?php

// Example online resource

sleep(5);
$datos = file_get_contents("php://input");
file_put_contents('test.txt', $datos);

?>