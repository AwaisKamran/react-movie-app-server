<?php
    include('../../cors.php');    
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    error_reporting(0);	
    
    $data = json_decode(file_get_contents("php://input"), true)['data'];
    $id = $data['id'];;
    $title = $data['title'];;
    $overview = $data['overview'];;
    $tagline = $data['tagline'];;
    $voteAverage = $data['voteAverage'];;
    $backdrop = $data['backdrop'];;
    $poster = $data['poster'];;
    $popularity = $data['popularity'];;
    $adult = $data['adult'];;
    $budget = $data['budget'];;
    $imdbId = $data['imdbId'];;
    $type = $data['type'];;

    $sql = "INSERT INTO movie (id, title, overview, tagline, voteAverage, backdrop, poster, popularity, adult, budget, imdbId, type)"+
    " VALUES ('$id', '$title', '$overview', '$tagline', '$voteAverage', '$backdrop', '$poster', '$popularity', '$adult', '$budget', '$imdbId', '$type')";
    	
	if (mysqli_query($conn, $sql)) {
        $success = new Success;
        $success->success = true;
        $success->data = mysqli_insert_id($conn); 
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Add Film: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>