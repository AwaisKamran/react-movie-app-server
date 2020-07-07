<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    error_reporting(0);	
    
    $data = json_decode(file_get_contents("php://input"), true)['data'];
    $firstName = $data['firstName'];
    $lastName = $data['lastName'];
    $displayName = $data['displayName'];
    $email = $data['email'];
    $password = $data['password'];
    $type = $data['type'];

    $sql = "INSERT INTO user (firstName, lastName, displayName, email, password, type) VALUES ('$firstName', '$lastName', '$displayName', '$email', '$password', '$type')";
        
    try{
        if (mysqli_query($conn, $sql)) {
            $success = new Success;
            $success->success = true;
            $success->data = mysqli_insert_id($conn); 
            echo json_encode($success);
        } 
        else {
            $error = new CustomError;
            $error->code = 400;
            $error->description = "Add User: ". mysqli_error($conn);
            $error->success = false;
            echo json_encode($error);
        }
        mysqli_close($conn);
    }
    catch(Exception $e){
        $error = new CustomError;
        $error->code = 500;
        $error->description = "Add User: ". $e->getMessage();
        $error->success = false;
        echo json_encode($error);
    }
?>