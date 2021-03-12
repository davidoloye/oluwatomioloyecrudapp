<?php
// adding the database file
require_once "dbh.php";
 
// Declaring and initializing my variables
$name = $address = $salary = "";
$nameerror = $addresserror = $salaryerror = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // testing my name entry
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $nameerror = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $nameerror = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    // testing my address entry
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $addresserror = "Please enter an address.";     
    } else{
        $address = $input_address;
    }
    
    // testing my salary entry
    $input_salary = trim($_POST["salary"]);
    if(empty($input_salary)){
        $salaryerror = "Please enter the salary amount.";     
    } elseif(!ctype_digit($input_salary)){
        $salaryerror = "Please enter a positive integer value.";
    } else{
        $salary = $input_salary;
    }
    
    // Checking the total error log before sending to the database
    if(empty($nameerror) && empty($addresserror) && empty($salaryerror)){
        // Prepare an update statement
        $sql = "UPDATE workers SET name=?, address=?, salary=? WHERE id=?";
 
        if($confirm = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $confirm->bind_param("sssi", $option1, $option2, $option3, $option4);
            
            // Set parameters
            $option1 = $name;
            $option2 = $address;
            $option3 = $salary;
            $option4 = $id;
            
            // Attempt to execute the prepared statement
            if($confirm->execute()){
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // closing my confirm statement
        $confirm->close();
    }
    
    // closing my connection
    $conn->close();
} else{
    // Check existence of id parameter before processing further
        if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
            // Get URL parameter
            $id =  trim($_GET["id"]);
            
            // Prepare a select statement
            $sql = "SELECT * FROM workers WHERE id = ?";
            if($confirm = $conn->prepare($sql)){

                // declaring my binding parameter
                $validationid = $id;


                // Bind variables to the prepared statement as parameters
                $confirm->bind_param("i", $validationid);
                
            
                
                // trying to execute the already binded parameter
                if($confirm->execute()){
                    $result = $confirm->get_result();
                    
                    if($result->num_rows == 1){
                        /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                        $row = $result->fetch_array(MYSQLI_ASSOC);
                        
                        // Retrieve individual field value
                        $name = $row["name"];
                        $address = $row["address"];
                        $salary = $row["salary"];
                    } else {
                        // URL doesn't contain valid id. Redirect to error page
                        header("location: error.php");
                        exit();
                            }
                    
                } else  {
                    echo "Oops! Something went wrong. Please try again later.";
                        }
            }
            // closing my statement
            $confirm->close();
            // closing my connection
            $conn->close();
        }  else{
            // URL doesn't contain id parameter. Redirect to error page
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
                        <h2>Update workers Data</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
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
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Exit</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>