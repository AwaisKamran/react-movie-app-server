<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/review.php');
    error_reporting(0);	
    
    $sql = 'select * from reviews where userId='. $_GET['userId'] .' order by createdDate desc';
    $array_reviews = array();

    try{
        if ($result = mysqli_query($conn, $sql)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $review = new Review;
                $review->id = $row['id'];
                $review->userId = $row['userId'];
                $review->movieId = $row['movieId'];
                $review->description = $row['description'];
                $review->createdDate = $row['createdDate'];
                $review->modifiedDate = $row['modifiedDate'];
                $review->active = $row['active'];
                array_push($array_reviews, $review);
            }

            $success = new Success;
            $success->success = true;
            $success->data = $array_reviews;
            echo json_encode($success);
        } 
        else {
            $error = new CustomError;
            $error->code = 400;
            $error->description = "Get Reviews By User Id: ". mysqli_error($conn);
            $error->success = false;
            echo json_encode($error);
        }

        mysqli_close($conn);
    }
    catch(Exception $e){
        $error = new CustomError;
        $error->code = 500;
        $error->description = "Get Reviews By User Id: ". $e->getMessage();
        $error->success = false;
        echo json_encode($error);
    }
?>