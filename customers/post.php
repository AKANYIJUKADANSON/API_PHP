<?php

    // This function will prevent the errors from being displayed
    error_reporting(0);

    // Headers must be called first
    header('Access-Control-Allow-Origin:*'); // Allows everything
    header('Access-Control-Allow-Method: POST'); // Request method to use will only be POST
    header('Content-Type: application/json'); // Will help to send data in backend in json formart
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization', 'X-Request-With');


    include('function.php');
    $requestMethod = $_SERVER['REQUEST_METHOD'];

    if ($requestMethod == 'POST') {
        // if one is storing raw data (one in form of json) using other methods like ajax, notepad, 
        // other than forms then we use

        $inputData = json_decode(file_get_contents("php://input"), true);
        // If the raw method is empty/ not used then form was used en we have to 
        // use the form option to store data
        if(empty($inputData)){
            // check for data from the Form wc is sent using the post
            $userDetails = sendPostedData($_POST);
        }else{
            // Else we have the raw data
            $userDetails = sendPostedData($inputData);
        }

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