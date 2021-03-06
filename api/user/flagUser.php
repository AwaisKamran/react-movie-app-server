<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    error_reporting(0);	
    
    $data = json_decode(file_get_contents("php://input"), true)['data'];
    $flagged = $data['value'];
    $flaggedReason = $data['description'];
    $userId = $data['id'];

    $sql = "Update user set flagged='$flagged', flaggedReason='$flaggedReason', modifiedDate=GETDATE() where id='$userId'";
        
    try{
        if (mysqli_query($conn, $sql)) {
            $success = new Success;
            $success->success = true;
            echo json_encode($success);
        } 
        else {
            $error = new CustomError;
            $error->code = 400;
            $error->description = "User Activation Flagged Status: ". mysqli_error($conn);
            $error->success = false;
            echo json_encode($error);
        }
        mysqli_close($conn);
    }
    catch(Exception $e){
        $error = new CustomError;
        $error->code = 500;
        $error->description = "User Activation Flagged Status: ". $e->getMessage();
        $error->success = false;
        echo json_encode($error);
    }
?>