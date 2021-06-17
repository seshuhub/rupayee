<?php
// Include config file
require_once "config-pdo-format.php";
 
// Define variables and initialize with empty values
$date = $opentiming = $closetiming = $lottery_number"";
$date_err = $opentiming_err = $closetiming_err = $lottery_number"";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate date
    $input_date = trim($_POST["date"]);
    if(empty($input_date)){
        $date_err = "Please enter a date.";
    } elseif(!filter_var($input_date, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $date_err = "Please enter a valid date.";
    } else{
        $date = $input_date;
    }
    
    // Validate opentiming
    $input_opentiming = trim($_POST["opentiming"]);
    if(empty($input_opentiming)){
        $opentiming_err = "Please enter an opentiming.";     
    } else{
        $opentiming = $input_opentiming;
    }
    

   // Validate closetiming
    $input_closetiming = trim($_POST["closetiming"]);
    if(empty($input_closetiming)){
        $closetiming_err = "Please enter an closetiming.";     
    } else{
        $closetiming = $input_closetiming;
    }



    // Validate lottery_number
    $input_lottery_number = trim($_POST["lottery_number"]);
    if(empty($input_lottery_number)){
        $lottery_number_err = "Please enter the lottery_number amount.";     
    } elseif(!ctype_digit($input_lottery_number)){
        $lottery_number_err = "Please enter a positive integer value.";
    } else{
        $lottery_number = $input_lottery_number;
    }
    
    // Check input errors before inserting in database
    if(empty($date_err) && empty($opentiming_err) && empty($closetiming_err) &&empty($lottery_number)){
        // Prepare an insert statement
        $sql = "INSERT INTO employees (date, opentiming, closetiming, lottery_number) VALUES (:date, :opentiming, :closetiming, :lottery_number)";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
	$stmt->bindParam(":date", $param_date);
	$stmt->bindParam(":opentiming", $param_opentiming);
	$stmt->bindParam(":closetiming", $param_closetiming);
	$stmt->bindParam(":lottery_number", $param_lottery_number);
            
            // Set parameters
            $param_date = $date;
            $param_opentiming = $opentiming;
            $param_closetiming = $closetiming;
            $param_lottery_number = $lottery_number;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
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
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
                    <h2 class="mt-5">Create Record</h2>

                    <p>Please fill this form and submit to add record to the database.</p>

                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

	<div class="form-group">
                            <label>Date</label>
<input type="text" name="date" class="form-control <?php echo (!empty($date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $date; ?>">
                            <span class="invalid-feedback"><?php echo $date_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>Open Timing</label>
<input type="text" name="opentiming" class="form-control <?php echo (!empty($opentiming_err)) ? 'is-invalid' : ''; ?>"><?php echo $opentiming; ?>">
                            <span class="invalid-feedback"><?php echo $address_err;?></span>
                        </div>



                        <div class="form-group">
                            <label>Close Timing </label>
<input type="text" name="closetiming" class="form-control <?php echo (!empty($closetiming_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $closetiming; ?>">
                            <span class="invalid-feedback"><?php echo $closetiming_err;?></span>
                        </div>


                        <div class="form-group">
                            <label>lottery_number </label>
<input type="text" name="lottery_number" class="form-control <?php echo (!empty($lottery_number_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $lottery_number; ?>">
                            <span class="invalid-feedback"><?php echo $lottery_number_err;?></span>
                        </div>


                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index-pdo-format.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>

                </div>
            </div>        
        </div>
    </div>
</body>
</html>