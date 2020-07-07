<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/comment.php');
    error_reporting(0);	
    
    $sql = 'select * from comment where reviewId='. $_GET['reviewId'] .' order by createdDate desc';
    $array_comments = array();

    try{
        if ($result = mysqli_query($conn, $sql)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $comments = new Comment;
                $comments->id = $row['id'];
                $comments->userId = $row['userId'];
                $comments->reviewId = $row['reviewId'];
                $comments->description = $row['description'];
                $comments->parentId = $row['parentId'];
                $comments->createdDate = $row['createdDate'];
                $comments->modifiedDate = $row['modifiedDate'];
                $comments->active = $row['active'];
                array_push($array_comments, $comments);
            }

            $success = new Success;
            $success->success = true;
            $success->data = $array_comments;
            echo json_encode($success);
        } 
        else {
            $error = new CustomError;
            $error->code = 400;
            $error->description = "Get Comments: ". mysqli_error($conn);
            $error->success = false;
            echo json_encode($error);
        }
        mysqli_close($conn);
    }
    catch(Exception $e){
        $error = new CustomError;
        $error->code = 500;
        $error->description = "Get Comments: ". $e->getMessage();
        $error->success = false;
        echo json_encode($error);
    }
?>