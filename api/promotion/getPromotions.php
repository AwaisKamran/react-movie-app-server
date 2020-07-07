<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/promotion.php');
    error_reporting(0);	
    
    $sql = 'select * from promotion where active=1 order by createdDate desc';
    $array_promotions = array();

    try{
        if ($result = mysqli_query($conn, $sql)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $promotion = new Promotion;
                $promotion->$promotionId = $row['promotionId'];
                $promotion->$type = $row['type'];
                $promotion->$description = $row['description'];
                $promotion->$createdDate = $row['createdDate'];
                $promotion->$endDate = $row['endDate'];
                $promotion->$modifiedDate = $row['modifiedDate'];
                $promotion->$active = $row['active'];
                array_push($array_promotions, $promotion);
            }

            $success = new Success;
            $success->success = true;
            $success->data = $array_promotions;
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