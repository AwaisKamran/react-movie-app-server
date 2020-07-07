<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/review.php');
    error_reporting(0);	
    
    $sql = 'select * from tokens where tokenValue='. $_GET['tokenValue'];
    $array_token = array();

    try{
        if ($result = mysqli_query($conn, $sql)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $token = new Token;
                $token->id = $row['tokenId'];
                $token->userId = $row['tokenValue'];
                $token->type = $row['type'];
                $token->createdDate = $row['createdDate'];
                $token->active = $row['active'];
                array_push($array_token, $review);
            }

            $success = new Success;
            $success->success = true;
            $success->data = $array_token;
            echo json_encode($success);
        } 
        else {
            $error = new CustomError;
            $error->code = 400;
            $error->description = "Get Token By Value: ". mysqli_error($conn);
            $error->success = false;
            echo json_encode($error);
        }

        mysqli_close($conn);
    }
    catch(Exception $e){
        $error = new CustomError;
        $error->code = 500;
        $error->description = "Get Token By Value: ". $e->getMessage();
        $error->success = false;
        echo json_encode($error);
    }
?>