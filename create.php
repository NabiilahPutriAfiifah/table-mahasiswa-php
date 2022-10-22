<?php
//Include config file
require_once "config.php";

//Tentukan variabel dan inisialisasi dengan nilai kosong
$name = $nim = $tugas = $uts = $uas = "";
$name_err = $nim_err = $tugas_err = $uts_err = $uas_err = "";

//memproses data formulir saat formulir dikirimkan
if($_SERVER["REQUEST_METHOD"] == "POST"){
    //validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else {
        $name = $input_name;
    }

    //Validate nim
    $input_nim = trim($_POST["nim"]);
    if(empty($input_nim)) {
        $nim_err = "Please enterr the nim amount.";
    } elseif(!ctype_digit($input_nim)) {
        $nim_err = "Please enter a positive integer value.";
    } else {
        $nim = $input_nim;
    }

    //Validate tugas
    $input_tugas = trim($_POST["tugas"]);
    if(empty($input_tugas)) {
        $tugas_err = "Please enterr the tugas amount.";
    } elseif(!ctype_digit($input_tugas)) {
        $tugas_err = "Please enter a positive integer value.";
    } else {
        $tugas = $input_tugas;
    }

    //validate uts
    $input_uts = trim($_POST["uts"]);
    if(empty($input_uts)) {
        $uts_err = "Please enterr the uts amount.";
    } elseif(!ctype_digit($input_uts)) {
        $uts_err = "Please enter a positive integer value.";
    } else {
        $uts = $input_uts;
    }

     //validate uas
     $input_uas = trim($_POST["uas"]);
     if(empty($input_uas)) {
         $uas_err = "Please enterr the uas amount.";
     } elseif(!ctype_digit($input_uas)) {
         $uas_err = "Please enter a positive integer value.";
     } else {
         $uas = $input_uas;
     }

    //check input errors before inserting in database
    if(empty($name_err) && empty($nim_err) && empty($tugas_err) && empty($uts_err) && empty($uas_err)) {
        //prepare an insert statement
        $sql = "INSERT INTO mahasiswa (name, nim, tugas, uts, uas) VALUES (?, ?, ?, ?, ?)";

    if($stmt = mysqli_prepare($link, $sql)) {
        //Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sssss", $param_name, $param_nim, $param_tugas, $param_uts, $param_uas);

        //set parameters
        $param_name = $name;
        $param_nim = $nim;
        $param_tugas = $tugas;
        $param_uts = $uts;
        $param_uas = $uas;

        //attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)) {
            //Records created succesfully. Redirect to landing page
            header("location: index.php");
            exit();
        } else {
            echo "Something went wrong. Please try again later.";
        }
    }

    //Close statement
    mysqli_stmt_close($stmt);

    }

    //close connection
    mysqli_close($link);

    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
    .wrapper {
        width: 500px;
        margin: 0 auto;
    }
    </style>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Tambah mahasiswa</h2>
                    </div>
                    <p>Silahkan isi form di bawah ini kemudian submit untuk menambahkan data mahasiswa ke dalam
                        database.
                    </p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Nama</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($nim_err)) ? 'has-error' : ''; ?>">
                            <label>NIM</label>
                            <input type="text" name="nim" class="form-control" value="<?php echo $nim; ?>">
                            <span class="help-block"><?php echo $nim_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($tugas_err)) ? 'has-error' : ''; ?>">
                            <label>Tugas</label>
                            <input type="text" name="tugas" class="form-control" value="<?php echo $tugas; ?>">
                            <span class="help-block"><?php echo $tugas_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($uts_err)) ? 'has-error': ''; ?>">
                            <label>UTS</label>
                            <input type="text" name="uts" class="form-control" value="<?php echo $uts; ?>">
                            <span class="help-block"><?php echo $uts_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($uas_err)) ? 'has-error': ''; ?>">
                            <label>UAS</label>
                            <input type="text" name="uas" class="form-control" value="<?php echo $uas; ?>">
                            <span class="help-block"><?php echo $uas_err; ?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
</body>

</html>