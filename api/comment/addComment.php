<?php
    include('../../cors.php');    
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    error_reporting(0);	
    
    $data = json_decode(file_get_contents("php://input"), true)['data'];
    $description = $data['description'];
    $userId = $data['userId'];
    $reviewId = $data['reviewId'];
    $parentId = $data['parentId'];

    $sql = "INSERT INTO comments (userId, reviewId, description, parentId) VALUES ('$userId', '$reviewId', '$description', '$parentId')";
        
    try{
        if (mysqli_query($conn, $sql)) {
            $success = new Success;
            $success->success = true;
            $success->data = mysqli_insert_id($conn); 
            echo json_encode($success);
        } 
        else {
            $error = new CustomError;
            $error->description = "Add Comments: ". mysqli_error($conn);
            $error->success = false;
            echo json_encode($error);
        }       
        mysqli_close($conn);
    }
    catch(Exception $e){
        $error = new CustomError;
        $error->description = "Add Comments: ". $e->getMessage();
        $error->success = false;
        echo json_encode($error);
    }
?>