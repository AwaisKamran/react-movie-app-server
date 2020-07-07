<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/user.php');
    error_reporting(0);

    $sql = "select * from user";
    $array_users = array();
    $result = mysqli_query($conn, $sql);
   
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
            array_push($array_users, $user);
        }

        $success = new Success;
        $success->success = true;
        $success->data = $array_users;
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Get users: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>