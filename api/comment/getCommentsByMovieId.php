<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/comment.php');
    error_reporting(0);	
    
    $sql = 'select id, userId, movieId, description, createdDate, modifiedDate from comment where movieId='. $_GET['movieId'] .' order by createdDate desc';

    $array_comments = array();

	if ($result = mysqli_query($conn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $comments = new Comment;
            $comments->id = $row['id'];
            $comments->userId = $row['userId'];
            $comments->movieId = $row['movieId'];
            $comments->description = $row['description'];
            $comments->createdDate = $row['createdDate'];
		    $comments->modifiedDate = $row['modifiedDate'];
            array_push($array_comments, $comments);
        }

        $success = new Success;
        $success->success = true;
        $success->data = $array_comments;
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Get Comments: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>