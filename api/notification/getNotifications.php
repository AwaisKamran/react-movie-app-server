<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/notification.php');
    error_reporting(0);	
    
    $sql = 'select * from notification where active=1 order by createdDate desc';
    $array_notification = array();

    try{
        if ($result = mysqli_query($conn, $sql)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $notification = new Notification;
                $notification->$notificationId = $row['notificationId'];
                $notification->$type = $row['type'];
                $notification->$description = $row['description'];
                $notification->$createdDate = $row['createdDate'];
                $notification->$modifiedDate = $row['modifiedDate'];
                $notification->$active = $row['active'];
                array_push($array_notification, $notification);
            }

            $success = new Success;
            $success->success = true;
            $success->data = $array_notification;
            echo json_encode($success);
        } 
        else {
            $error = new CustomError;
            $error->code = 400;
            $error->description = "Get Active Notifications : ". mysqli_error($conn);
            $error->success = false;
            echo json_encode($error);
        }
        mysqli_close($conn);
    }
    catch(Exception $e){
        $error = new CustomError;
        $error->code = 500;
        $error->description = "Get Active Notifications: ". $e->getMessage();
        $error->success = false;
        echo json_encode($error);
    }
?>