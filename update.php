<?php

// Include config file 3 
require_once "config.php";

// Define variables and initialize with empty values. 
$name = $nim = $tugas = $uts = $uas = ""; 
$name_err = $nim_err = $tugas_err = $uts_err = $uas_err = "";

// Processing form data when form is submitted 
if(isset($_POST["id"]) && !empty($_POST["id"])){ 
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate name
    $input_name = trim($_POST["name"]); 
    if (empty($input_name)) {
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name."; 
    }else{
        $name = $input_name;
    }

    // Validate nim
    $input_nim = trim($_POST["nim"]);
    if (empty($input_nim)){
        $nim_err = "Please enter the nim amount.";
    } elseif(!ctype_digit($input_nim)){ 
        $nim_err = "Please enter a positive integer value."; 
    }else{
        $nim = $input_nim;
    }

    // Validate tugas
    $input_tugas = trim($_POST["tugas"]);
    if (empty($input_tugas)){
        $tugas_err = "Please enter the tugas amount.";
    } elseif(!ctype_digit($input_tugas)){ 
        $tugas_err = "Please enter a positive integer value."; 
    }else{
        $tugas = $input_tugas;
    }

    // Validate uts
    $input_uts = trim($_POST["uts"]);
    if (empty($input_uts)){
        $uts_err = "Please enter the uts amount.";
    } elseif(!ctype_digit($input_uts)){ 
        $uts_err = "Please enter a positive integer value."; 
    }else{
        $uts = $input_uts;
    }

    // Validate uas
    $input_uas = trim($_POST["uas"]);
    if (empty($input_uas)){
        $uas_err = "Please enter the uas amount.";
    } elseif(!ctype_digit($input_uas)){ 
        $uas_err = "Please enter a positive integer value."; 
    }else{
        $uas = $input_uas;
    }

    // Check input errors before inserting in database
    if (empty($name_err) && empty($nim_err) && empty($tugas_err) && empty($uts_err) && empty($uas_err)){ 
        // Prepare an update statement 
        $sql = "UPDATE mahasiswa SET name=?, nim=?, tugas=?, uts=?, uas=? WHERE id=?";

        if($stmt = mysqli_prepare($link, $sql)){ 
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssi", $param_name, $param_nim, $param_tugas, $param_uts, $param_uas, $param_id);
    
            // Set parameters
            $param_name = $name;
            $param_nim = $nim; 
            $param_tugas = $tugas;
            $param_uts = $uts;
            $param_uas = $uas;                 
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page 
                header("location: index.php");
                exit();
            }else{
                echo "Something went wrong. Please try again later.";
            }
        }
            
        // Close statement
        mysqli_stmt_close($stmt);

    }
            
    // Close connection
    mysqli_close($link); 
}else{        
    // Check existence of id parameter before processing further      
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter   
        $id = trim($_GET["id"]);
    
        // Prepare a select statement 
        $sql = "SELECT * FROM mahasiswa WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){ 
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            // Set parameters
            $param_id = $id;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){ 
                $result = mysqli_stmt_get_result($stmt);

                if(mysqli_num_rows($result) == 1) {
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */ 
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    // Retrieve individual field value 
                    $name = $row["name"];
                    $nim = $row["nim"];
                    $tugas = $row["tugas"];
                    $uts = $row["uts"];
                    $uas = $row["uas"];
                }else{
                // URL doesn't contain valid id. Redirect to error page 
                header("location: error.php"); 
                exit();
                }

            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement 
        mysqli_stmt_close($stmt);

        // Close connection
        mysqli_close($link);
        }else{
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
    .wrapper {
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
                        <h2>Update Record</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($nim_err)) ? 'has-error' : ''; ?>">
                            <label>nim</label>
                            <input type="text" name="nim" class="form-control" value="<?php echo $nim; ?>">
                            <span class="help-block"><?php echo $nim_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($tugas_err)) ? 'has-error' : ''; ?>">
                            <label>tugas</label>
                            <input type="text" name="tugas" class="form-control" value="<?php echo $tugas; ?>">
                            <span class="help-block"><?php echo $tugas_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($uts_err)) ? 'has-error' : ''; ?>">
                            <label>uts</label>
                            <input type="text" name="uts" class="form-control" value="<?php echo $uts; ?>">
                            <span class="help-block"><?php echo $uts_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($uas_err)) ? 'has-error' : ''; ?>">
                            <label>uas</label>
                            <input type="text" name="uas" class="form-control" value="<?php echo $uas; ?>">
                            <span class="help-block"><?php echo $uas_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>