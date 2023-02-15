<?php

    // This function will prevent the errors from being displayed
    //error_reporting(0);

    // Headers must be called first
    header('Access-Control-Allow-Origin:*'); // Allows everything
    header('Content-Type: application/json'); // Will help to send data in backend in json formart
    header('Access-Control-Allow-Method: PUT'); // Request method to use will only be PUT
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization', 'X-Request-With');


    include('function.php');
    $requestMethod = $_SERVER['REQUEST_METHOD'];

    if ($requestMethod == 'PUT') {
        // if one is storing raw data (one in form of json) using other methods like ajax, notepad, 
        // other than forms then we use

        $inputData = json_decode(file_get_contents("php://input"), true);

        // Else we have the raw data and the ID option $_GET
        $userDetails = updateCustomer($inputData, $_GET);
        echo $userDetails;

    } else {
        $data = [
            'status'=> '405',
            'message'=> 'Method not allowed'
        ];
        header("HTTP/1.0 405 Method not allowed");
        return json_encode($data);
    }
    
?>