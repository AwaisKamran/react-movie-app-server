<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/settings.php');
    error_reporting(0);

    $sql = 'select * from settings';
    $array_settings = array();
    $result = mysqli_query($conn, $sql);
   
	if (mysqli_num_rows($result) > 0) {       
        while ($row = mysqli_fetch_assoc($result)) {
            $settings = new Settings;
            $settings->id = $row['id'];
            $settings->userId = $row['key'];
            $settings->movieId = $row['value'];
            $settings->createdDate = $row['createdDate'];     
            $settings->modifiedDate = $row['modifiedDate'];          
            array_push($array_settings, $user);
        }

        $success = new Success;
        $success->success = true;
        $success->data = $array_settings;
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Get Settings: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>