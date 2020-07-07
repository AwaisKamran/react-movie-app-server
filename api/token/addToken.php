<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    error_reporting(0);	
    
    $data = json_decode(file_get_contents("php://input"), true)['data'];
    $tokenValue = $data['tokenValue'];
    $type = $data['type'];

    $sql = "INSERT INTO tokens (tokenValue, type) VALUES ('$tokenValue', '$type')";
        
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
            $error->description = "Add Token: ". mysqli_error($conn);
            $error->success = false;
            echo json_encode($error);
        }
        mysqli_close($conn);
    }
    catch(Exception $e){
        $error = new CustomError;
        $error->code = 500;
        $error->description = "Add Token: ". $e->getMessage();
        $error->success = false;
        echo json_encode($error);
    }
?>