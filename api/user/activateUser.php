<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    error_reporting(0);	
    
    $data = json_decode(file_get_contents("php://input"), true)['data'];
    $active = $data['value'];
    $userId = $data['id'];

    $sql = "Update user set active='$active', modifiedDate=GETDATE() where id='$userId'";
        
    try{
        if (mysqli_query($conn, $sql)) {
            $success = new Success;
            $success->success = true;
            echo json_encode($success);
        } 
        else {
            $error = new CustomError;
            $error->code = 400;
            $error->description = "Modify User Activation Status: ". mysqli_error($conn);
            $error->success = false;
            echo json_encode($error);
        }
        mysqli_close($conn);
    }
    catch(Exception $e){
        $error = new CustomError;
        $error->code = 500;
        $error->description = "Modify User Activation Status: ". $e->getMessage();
        $error->success = false;
        echo json_encode($error);
    }
?>