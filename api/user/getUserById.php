<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/user.php');
    error_reporting(0);

    $sql = "select * from user where id=". $_GET['userId'];
    $result = mysqli_query($conn, $sql);
   
    try{
        if (mysqli_num_rows($result) > 0) {       
            while ($row = mysqli_fetch_assoc($result)) {
                $user = new User;
                $user->id = $row['id'];
                $user->firstName = $row['firstName'];
                $user->lastName = $row['lastName'];
                $user->displayName = $row['displayName'];
                $user->email = $row['email'];
                $user->password = $row['password'];
                $user->flagged = $row['flagged'];
                $user->flaggedReason = $row['flaggedReason'];
                $user->type = $row['type'];
                $user->active = $row['active'];
                $user->createdDate = $row['createdDate'];
                $user->modifiedDate = $row['modifiedDate'];
            }

            $success = new Success;
            $success->success = true;
            $success->data = $user;
            echo json_encode($success);
        } 
        else {
            $error = new CustomError;
            $error->code = 400;
            $error->description = "Get user: ". mysqli_error($conn);
            $error->success = false;
            echo json_encode($error);
        }

        mysqli_close($conn);
    }
    catch(Exception $e){
        $error = new CustomError;
        $error->code = 500;
        $error->description = "Get user: ". $e->getMessage();
        $error->success = false;
        echo json_encode($error);
    }
?>