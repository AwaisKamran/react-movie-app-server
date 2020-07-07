<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/movies.php');
    error_reporting(0);	
    
    $sql = 'select * from movie where id='. $_GET['movieId'];

    $array_films = array();

	if ($result = mysqli_query($conn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $film = new Movies;
            $film->$id = $row['id'];
            $film->$title = $row['title'];
            $film->$overview = $row['overview'];
            $film->$tagline = $row['tagline'];
            $film->$voteAverage = $row['voteAverage'];
            $film->$backdrop = $row['backdrop'];
            $film->$poster = $row['poster'];
            $film->$popularity = $row['popularity'];
            $film->$adult = $row['adult'];
            $film->$budget = $row['budget'];
            $film->$imdbId = $row['imdbId'];
            $film->$type = $row['type'];
            $film->$createdDate = $row['createdDate'];
            $film->$modifiedDate = $row['modifiedDate'];
            array_push($array_films, $film);
        }

        $success = new Success;
        $success->success = true;
        $success->data = $array_films;
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Get Movie By Movie Id: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>