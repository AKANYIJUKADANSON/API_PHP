<?php

    // This function will prevent the errors from being displayed
    //error_reporting(0);

    // Headers must be called first
    header('Access-Control-Allow-Origin:*'); // Allows everything
    header('Content-Type: application/json'); // Will help to send data in backend in json formart
    header('Access-Control-Allow-Method: DELETE'); // Request method to use will only be DELETE
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization', 'X-Request-With');


    include('function.php');
    $requestMethod = $_SERVER['REQUEST_METHOD'];

    if ($requestMethod == 'DELETE') {
        // Else we have the raw data and the ID option $_GET
        $deleteRecord = deleteRecord($_GET);
        echo $deleteRecord;

    } else {
        $data = [
            'status'=> '405',
            'message'=> 'Method not allowed'
        ];
        header("HTTP/1.0 405 Method not allowed");
        return json_encode($data);
    }
    
?>