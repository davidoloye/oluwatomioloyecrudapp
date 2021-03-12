<?php
// Include config file
require_once "dbh.php";
 
// firstly declaring and initializing my variables
$name = $address = $salary = "";
$nameerror = $addresserror = $salaryerror = "";
 
// evauating the data whe the button is clicked
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // testing the name entry
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $nameerror = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $nameerror = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    // testing the address entry
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $addresserror = "Please enter an address.";     
    } else{
        $address = $input_address;
    }
    
    // testing the salary entry
    $input_salary = trim($_POST["salary"]);
    if(empty($input_salary)){
        $salaryerror = "Please enter the salary amount.";     
    } elseif(!ctype_digit($input_salary)){
        $salaryerror = "Please enter a positive integer value.";
    } else{
        $salary = $input_salary;
    }

    // verifying the input errors before sending to the database
    if(empty($nameerror) && empty($addresserror) && empty($salaryerror)){
        // Prepare an insert statement
        $sql = "INSERT INTO workers (name, address, salary) VALUES ('$name','$address','$salary')";
 
        if($confirm = $conn->prepare($sql)){

            // declaring the parameters
            $option1 = $name;
            $option2 = $address;
            $option3 = $salary;

            // Binding the variables to the prepared statement as parameters
            $confirm->bind_param("sss", $option1, $option2, $option3);
            
            
            
            // Attempt to execute the prepared statement
            if($confirm->execute()){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Closing my confirm statement
        $stmt->close();
    }
    
    // closing my connection
    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Create Record</h2>
                    </div>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($nameerror)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $nameerror;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($addresserror)) ? 'has-error' : ''; ?>">
                            <label>Address</label>
                            <textarea name="address" class="form-control"><?php echo $address; ?></textarea>
                            <span class="help-block"><?php echo $addresserror;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($salaryerror)) ? 'has-error' : ''; ?>">
                            <label>Salary</label>
                            <input type="text" name="salary" class="form-control" value="<?php echo $salary; ?>">
                            <span class="help-block"><?php echo $salaryerror;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>