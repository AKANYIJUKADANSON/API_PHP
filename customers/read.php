<?php

    // Headers must be called first
    header('Access-Control-Allow-Origin:*'); // Allows everything
    header('Content-Type: application/json'); // Will help to send data in backend in json formart
    header('Access-Control-Allow-Method: GET'); // Request method to use will only be GET
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization', 'X-Request-With');


    include('function.php');
    // Checking wic method (posting or getting data ) is used to access or make any action on the server
    $requestMethod = $_SERVER['REQUEST_METHOD'];

    if ($requestMethod == 'GET') {
        // Option to get a single record using an id
        if(isset($_GET['id'])){
            // echo $_GET['id'];
            $getSingleCustomer = getSingleCustomer($_GET);
            echo $getSingleCustomer;

        }else{
            // creating a function to fetch data from the server
            $getCustomerList = getCustomers();
            echo $getCustomerList;
        }
        
    } else {
        $data = [
            'status'=> '405',
            'message'=> 'Method not allowed'
        ];
        header("HTTP/1.0 405 Method not allowed");
        return json_encode($data);
    }
    
?>