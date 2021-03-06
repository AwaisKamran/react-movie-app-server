<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/user.php');
    error_reporting(0);

    try{
        $sql = 'select * from wishlist where userId='. $_GET['userId'] .' order by createdDate desc';
        $array_wishlist = array();
        $result = mysqli_query($conn, $sql);
    
        if (mysqli_num_rows($result) > 0) {       
            while ($row = mysqli_fetch_assoc($result)) {
                $wishlist = new Wishlist;
                $wishlist->id = $row['id'];
                $wishlist->userId = $row['userId'];
                $wishlist->movieId = $row['movieId'];
                $wishlist->watched = $row['watched'];
                $wishlist->createdDate = $row['createdDate'];     
                $wishlist->modifiedDate = $row['modifiedDate'];          
                array_push($array_wishlist, $user);
            }
            $success = new Success;
            $success->success = true;
            $success->data = $array_wishlist;
            echo json_encode($success);
        } 
        else {
            $error = new CustomError;
            $error->code = 400;
            $error->description = "Get Wishlist By User Id: ". mysqli_error($conn);
            $error->success = false;
            echo json_encode($error);
        }
        mysqli_close($conn);
    }
    catch(Exception $e){
        $error = new CustomError;
        $error->code = 500;
        $error->description = "Get Wishlist By User Id: ". $e->getMessage();
        $error->success = false;
        echo json_encode($error);
    }
?>