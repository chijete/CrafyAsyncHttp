<?php

require 'class.php';

$init_time = time(); // reference

// new CrafyAsyncHttp({ABSOLUTE_PATH_TO_FOLDER_FOR_TEMP_FILES})
$classInstance = new CrafyAsyncHttp(__DIR__ . '/temp_files');
$result = $classInstance->makeAsyncCurl(
  'http://localhost/proyectos/CrafyAsyncHttp/test.php', // = CURLOPT_URL
  [
    "CURLOPT_POST" => true,
    "CURLOPT_POSTFIELDS" => json_encode([
      'hello' => 'world'
    ]),
    "CURLOPT_HTTPHEADER" => [
      "Content-Type: application/json"
    ],
    "CURLOPT_MAXREDIRS" => 10
  ] // = curl_setopt
);

var_dump($result); // true or false

$end_time = time(); // reference

echo '<br>';
echo $end_time - $init_time; // (reference) Prints 0

?>