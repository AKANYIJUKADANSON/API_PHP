<?php

    require '../inc/dbconn.php';
    
    function getCustomers(){
        
        global $conn;

        $getCustomer = "SELECT*FROM customers";
        $postCustomer_run = mysqli_query($conn, $getCustomer);

        if($postCustomer_run){

            // checking if any record exists
            if (mysqli_num_rows($postCustomer_run) > 0) {
                $result = mysqli_fetch_all($postCustomer_run, MYSQLI_ASSOC);

                $data = [
                    'status'=> '200',
                    'message'=> 'Data fetched successfully',
                    'data'=> $result
                ];
                header("HTTP/1.0 200 Data fetched successfully");
                return json_encode($data);
                
            }else {
                $data = [
                    'status'=> '404',
                    'message'=> 'No customer found'
                ];
                header("HTTP/1.0 404 No customer found");
                return json_encode($data);
            }

        }else {
            $data = [
                'status'=> '500',
                'message'=> 'Internal Server Error'
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }

    }


    # Get the single customer
    function getSingleCustomer($posteddata){
        
        global $conn;

        $customerId = mysqli_real_escape_string($conn, $posteddata['id']);

        if($customerId == null){
            return error422("Enter the customer ID");
        }

        $singleCustomer = "SELECT*FROM customers WHERE id = '$customerId' LIMIT 1";
        $singleCustomer_run = mysqli_query($conn, $singleCustomer);

        if($singleCustomer_run){

            // checking if any record exists
            if (mysqli_num_rows($singleCustomer_run) == 1) {
                $result = mysqli_fetch_assoc($singleCustomer_run);

                $data = [
                    'status'=> '201',
                    'message'=> 'Customer fetched successfully',
                    'data'=> $result
                ];
                header("HTTP/1.0 201 Customer fetched successfully");
                return json_encode($data);
                
            }else {
                $data = [
                    'status'=> '404',
                    'message'=> 'No customer found'
                ];
                header("HTTP/1.0 404 No customer found");
                return json_encode($data);
            }

        }else {
            $data = [
                'status'=> '500',
                'message'=> 'Internal Server Error'
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }

    }

    /** The parameter in the function below is the data that is passed to it from the post file
     * That is after a user has enterd data using the Postman
     * $userDetailsSent is same as $_POST and then to get what a use 
     * has put then we fill it with ['index string']
    */
    function sendPostedData($userDetailsSent){
        global $conn;

        $name = mysqli_escape_string($conn, $userDetailsSent['name']);
        $email = mysqli_escape_string($conn, $userDetailsSent['email']);
        $phone = mysqli_escape_string($conn, $userDetailsSent['phone']);

        // check if the user has put any data
        if(empty(trim($name))){
            // return an error if the field is not filled
            return error422("Name field required");
        }elseif (empty(trim($email))) {
            // return an error may be from a function
            return error422("Email field required");
        }elseif (empty(trim($phone))) {
            return error422("Phone field required");
        }else{
            // If all fields are created en filled then store the data
            $postCustomer = "INSERT INTO customers(name, email, phone) VALUES('$name', '$email', '$phone')";
            $postCustomer_run = mysqli_query($conn, $postCustomer);

            if($postCustomer_run){        
                    $data = [
                        'status'=> '201',
                        'message'=> 'Customer created successfully'
                    ];
                    header("HTTP/1.0 201 Created");
                    return json_encode($data);
            }else {
                $data = [
                    'status'=> '500',
                    'message'=> 'Internal Server Error'
                ];
                header("HTTP/1.0 500 Internal Server Error");
                return json_encode($data);
            }
        }
    }


    // This $message param is what is passed from the sendPostedData() fun
    function error422($message){
        $data = [
            'status'=> '422',
            'message'=> $message
        ];
        header("HTTP/1.0 422 Invalid input");
        return json_encode($data);
        exit();
    }


    function updateCustomer($inputDetailsToUpdate, $customerUniqueParams){

            global $conn;
    
            if(!isset($customerUniqueParams['id'])){
                return error422("Id not Specified in URL");
    
                // Also check if there is no record
            }elseif($customerUniqueParams['id'] == null){
                return error422("Enter customer Id");
            }

            $id = mysqli_real_escape_string($conn, $customerUniqueParams['id']);
            $updateName = mysqli_real_escape_string($conn, $inputDetailsToUpdate['name']);
            $updateEmail = mysqli_real_escape_string($conn, $inputDetailsToUpdate['email']);
            $updatePhone = mysqli_real_escape_string($conn,$inputDetailsToUpdate['phone']);
            
            // check if the user has put any data
            if(empty(trim($updateName))){
                // return an error if the field is not filled
                return error422("Name field required");
            }elseif (empty(trim($updateEmail))) {
                // return an error may be from a function
                return error422("Email field required");
            }elseif (empty(trim($updatePhone))) {
                return error422("Phone field required");
            }else{
                // If all fields are created en filled then store the data
                $updateCustomer = "UPDATE customers SET name = '$updateName', 
                email= '$updateEmail' , phone = '$updatePhone' WHERE id='$id' LIMIT 1 ";

                $updateCustomer_run = mysqli_query($conn, $updateCustomer);
    
                if($updateCustomer_run){        
                        $data = [
                            'status'=> '200',
                            'message'=> 'Customer updated successfully'
                        ];
                        header("HTTP/1.0 200 Updated");
                        return json_encode($data);
                }else {
                    $data = [
                        'status'=> '500',
                        'message'=> 'Internal Server Error'
                    ];
                    header("HTTP/1.0 500 Internal Server Error");
                    return json_encode($data);
                }
            }
        }



        function deleteRecord($selectedRecord){

        global $conn;
    
            if(!isset($selectedRecord['id'])){
                return error422("Id not Specified in URL");
    
                // Also check if there is no record
            }elseif($selectedRecord['id'] == null){
                return error422("Enter customer Id");
            }

            $id = mysqli_real_escape_string($conn, $selectedRecord['id']);
            
                // If all fields are created en filled then store the data
                $deleteCustomer = "DELETE from customers WHERE id='$id' LIMIT 1 ";

                $deleteCustomer_run = mysqli_query($conn, $deleteCustomer);
    
                if($deleteCustomer_run){        
                        $data = [
                            'status'=> '200',
                            'message'=> 'Customer Deleted successfully'
                        ];
                        header("HTTP/1.0 200 Deleted");
                        return json_encode($data);
                }else {
                    $data = [
                        'status'=> '500',
                        'message'=> 'Internal Server Error'
                    ];
                    header("HTTP/1.0 500 Internal Server Error");
                    return json_encode($data);
                }
            

        }
