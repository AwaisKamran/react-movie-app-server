<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/genre.php');
    error_reporting(0);	
    
    $sql = 'select * from genre order by createdDate desc';
    $array_genre = array();

    try{
        if ($result = mysqli_query($conn, $sql)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $genre = new Genre;
                $genre->id = $row['id'];
                $genre->name = $row['name'];
                $genre->createdDate = $row['createdDate'];
                $genre->modifiedDate = $row['modifiedDate'];
                array_push($array_genre, $genre);
            }

            $success = new Success;
            $success->success = true;
            $success->data = $array_genre;
            echo json_encode($success);
        } 
        else {
            $error = new CustomError;
            $error->code = 400;
            $error->description = "Get Genre List: ". mysqli_error($conn);
            $error->success = false;
            echo json_encode($error);
        }

        mysqli_close($conn);
    }
    catch(Exception $e){
        $error = new CustomError;
        $error->code = 500;
        $error->description = "Get Genre List: ". $e->getMessage();
        $error->success = false;
        echo json_encode($error);
    }
?>