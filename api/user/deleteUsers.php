<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    error_reporting(0);	
    
    $data = json_decode(file_get_contents("php://input"), true)['data'];
    $list = $data['list'];

    $sql = "delete from user where id in ('$list')";
        
    try{
        if (mysqli_query($conn, $sql)) {
            $success = new Success;
            $success->success = true;
            echo json_encode($success);
        } 
        else {
            $error = new CustomError;
            $error->code = 400;
            $error->description = "Delete Users: ". mysqli_error($conn);
            $error->success = false;
            echo json_encode($error);
        }
        mysqli_close($conn);
    }
    catch(Exception $e){
        $error = new CustomError;
        $error->code = 500;
        $error->description = "Delete Users: ". $e->getMessage();
        $error->success = false;
        echo json_encode($error);
    }
?>