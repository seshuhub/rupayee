<?php
// Include config file
require_once "config-pdo-format.php";
 
// Define variables and initialize with empty values
$date = $opentiming = $closetiming = $lottery_number="";
$date_err = $opentiming_err = $closetiming_err = $lottery_number_err="";
 
// Processing form data when form is submitted
if(isset($_POST["Id"]) && !empty($_POST["Id"])){
    // Get hIdden input value
    $Id = $_POST["Id"];
    
    // ValIdate date
    $input_date = trim($_POST["date"]);
    if(empty($input_date)){
        $date_err = "Please enter a date.";
    } elseif(!filter_var($input_date, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $date_err = "Please enter a valid date.";
    } else{
        $date = $input_date;
    }
    
    // ValIdate opentiming
    $input_opentiming = trim($_POST["opentiming"]);
    if(empty($input_opentiming)){
        $opentiming_err = "Please enter an opentiming.";     
    } else{
        $opentiming = $input_opentiming;
    }
    
	    // ValIdate Close Timing
    $input_closetiming= trim($_POST["closetiming"]);
    if(empty($input_closetiming)){
        $closetiming_err = "Please enter an closetiming.";     
    } else{
        $closetiming = $input_closetiming;
    }


    // ValIdate Lottery_Number
    $input_lottery_number = trim($_POST["lottery_number"]);
    if(empty($input_lottery_number)){
        $lottery_number_err = "Please enter the lottery_number";     
    } elseif(!ctype_digit($input_lottery_number)){
        $lottery_number_err = "Please enter a positive integer value.";
    } else{
        $lottery_number = $input_lottery_number;
    }
    
    // Check input errors before inserting in database
    if(empty($date_err) && empty($opentiming_err) && empty($closetiming_err) && empty($lottery_number_err)){
        // Prepare an update statement
        $sql = "UPDATE datepick SET date=:date, opentiming=:opentiming, closetiming=:closetiming, lottery_number=:lottery_number WHERE Id=:Id";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":date", $param_date);
            $stmt->bindParam(":opentiming", $param_opentiming);
            $stmt->bindParam(":closetiming", $param_closetiming);
            $stmt->bindParam(":lottery_number", $param_lottery_number);
            $stmt->bindParam(":Id", $param_Id);
            
            // Set parameters
            $param_date = $date;
            $param_opentiming = $opentiming;
            $param_closetiming = $closetiming;
            $param_lottery_number = $lottery_number;
            $param_Id = $Id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records updated successfully. Redirect to landing page
                header("location: index-pdo-format.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        unset($stmt);
    }
    
    // Close connection
    unset($pdo);
} else{
    // Check existence of Id parameter before processing further
    if(isset($_GET["Id"]) && !empty(trim($_GET["Id"]))){
        // Get URL parameter
        $Id =  trim($_GET["Id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM datepick WHERE Id = :Id";
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":Id", $param_Id);
            
            // Set parameters
            $param_Id = $Id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                    // Retrieve indivIdual field value
                    
                    $date = $row["date"];
                    $opentiming = $row["opentiming"];
                    $closetiming = $row["closetiming"];
                    $lottery_number= $row["lottery_number"];
                } else{
                    // URL doesn't contain valId Id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        unset($stmt);
        
        // Close connection
        unset($pdo);
    }  else{
        // URL doesn't contain Id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
 
 
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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
                    <h2 class="mt-5">Update Record</h2>

                    <p>Please edit the input values and submit to update the records.</p>

<form action="<?php echo htmlspecialchars(basedate($_SERVER['REQUEST_URI'])); ?>" method="post">

                        <div class="form-group">
                            <label>date</label>
                           <input type="text" date="date" class="form-control <?php echo (!empty($date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $date; ?>">
                            <span class="invalid-feedback"><?php echo $date_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>opentiming</label>
<input type="text" date="opentiming" class="form-control <?php echo (!empty($opentiming_err)) ? 'is-invalid' : ''; ?>"value="<?php echo $opentiming; ?>">
                            <span class="invalid-feedback"><?php echo $opentiming_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>closetiming</label>
<input type="text" date="closetiming" class="form-control <?php echo (!empty($closetiming_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $closetiming; ?>">
                            <span class="invalid-feedback"><?php echo $closetiming_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>lottery_number</label>
<input type="text" date="lottery_number" class="form-control <?php echo (!empty($lottery_number_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $lottery_number; ?>">
                            <span class="invalid-feedback"><?php echo $lottery_number_err;?></span>
                        </div>

                        <input type="hidden" date="Id" value="<?php echo $Id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index-pdo-format.php" class="btn btn-secondary ml-2">Cancel</a>


                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>