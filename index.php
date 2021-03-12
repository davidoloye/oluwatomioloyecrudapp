
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
        <div class="wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header">
                            <h2 class="pull-left">Employees Details</h2>
                            <a href="create.php" class="btn btn-success pull-right">Add New Employee</a>
                        </div>

                        <?php
                            // include my database file
                            require_once "dbh.php";
                            
                            // Attempt select query execution
                            $sql = "SELECT * FROM workers";
                            if($result = $conn->query($sql)){
                                if($result->num_rows > 0){
                                    echo "<table class='table table-bordered table-striped'>";
                                        echo "<thead>";
                                            echo "<tr>";
                                                echo "<th>Serial No</th>";
                                                echo "<th>Name</th>";
                                                echo "<th>Address</th>";
                                                echo "<th>Salary</th>";
                                                echo "<th>Request</th>";
                                            echo "</tr>";
                                        echo "</thead>";
                                        echo "<tbody>";
                                            while($row = $result->fetch_array()){
                                                echo "<tr>";
                                                    echo "<td>" . $row['id'] . "</td>";
                                                    echo "<td>" . $row['name'] . "</td>";
                                                    echo "<td>" . $row['address'] . "</td>";
                                                    echo "<td>" . $row['salary'] . "</td>";
                                                    echo "<td>";
                                                        echo "<a href='read.php?id=". $row['id'] ."' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                                        echo "<a href='update.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                                        echo "<a href='delete.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                                    echo "</td>";
                                                echo "</tr>";
                                            }
                                        echo "</tbody>";                            
                                    echo "</table>";
                                    // free result
                                        $result->free();
                                } else {
                                echo "<p><em>no input was recorded</em></p>";
                                        }
                                    }
                            else {
                                echo "errors were recorded".$conn->error;
                                }
                            
                            $conn->close();
                        ?>
                    </div>
                </div>
            </div>
        </div>
</body>
</html>