<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/user.php');
    error_reporting(0);

    $data = json_decode(file_get_contents("php://input"), true)['data'];
    $email = $data['email'];
    $password = $data['password'];

    $sql = "select * from user where email='$email' && password='$password' and active=1";
    $result = mysqli_query($conn, $sql);
   
	if (mysqli_num_rows($result) > 0) {       
        while ($row = mysqli_fetch_assoc($result)) {
            $user = new User;
            $user = new User;
            $user->id = $row['id'];
            $user->name = $row['name'];
            $user->email = $row['email'];
            $user->password = $row['password'];
            $user->flagged = $row['flagged'];
            $user->flaggedReason = $row['flaggedReason'];
            $user->type = $row['type'];
            $user->active = $row['active'];
        }

        $success = new Success;
        $success->success = true;
        $success->data = $user;
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Login user: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>