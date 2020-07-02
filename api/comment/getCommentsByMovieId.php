<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/discussion.php');
    error_reporting(0);	
    
    $sql = 'select id, userId, movieId, text, createdDate from discussion where movieId='. $_GET['movieId'] .' order by createdDate desc';

    $array_discussions = array();

	if ($result = mysqli_query($conn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $discussion = new Discussion;
            $discussion->id = $row['id'];
            $discussion->userId = $row['userId'];
            $discussion->movieId = $row['movieId'];
            $discussion->text = $row['text'];
		    $discussion->createdDate = $row['createdDate'];
            array_push($array_discussions, $discussion);
        }

        $success = new Success;
        $success->success = true;
        $success->data = $array_discussions;
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Get Discussions: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>