<?php
// Check existence of Id parameter before processing further
if (isset($_GET["Id"]) && !empty(trim($_GET["Id"]))) {
    // Include config file
    require_once "config-pdo-format.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM datepick WHERE Id = :Id";
    
    if ($stmt = $pdo->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":Id", $param_Id);
        
        // Set parameters
        $param_Id = trim($_GET["Id"]);
        
        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            if ($stmt->rowCount() == 1) {
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Retrieve individual field value
                $Id = $row["Id"];
                $date = $row["date"];
                $opentiming = $row["opentiming"];
                $closetiming = $row["closetiming"];
                $lottery_Number = $row["lottery_number"];
            } else {
                // URL doesn't contain valId Id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    unset($stmt);
    
    // Close connection
    unset($pdo);
} else {
    // URL doesn't contain Id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3">View Record</h1>
                    
                    <div class="form-group">
                        <label>ID</label>
                        <p><b><?php echo $row["Id"]; ?></b></p>
                    </div>

                    <div class="form-group">
                        <label>date</label>
                        <p><b><?php echo $row["date"]; ?></b></p>
                    </div>
                    
                    <div class="form-group">
                        <label>opentiming</label>
                        <p><b><?php echo $row["opentiming"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>closetiming</label>
                        <p><b><?php echo $row["closetiming"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>lottery_Number</label>
                        <p><b><?php echo $row["lottery_number"]; ?></b></p>
                    </div>
                    <p><a href="index-pdo-format.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>