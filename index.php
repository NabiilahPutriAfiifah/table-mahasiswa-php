<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <style type="text/css">
    .wrapper {
        width: 650px;
        margin: 0 auto;
    }

    .page-header h2 {
        margin-top: 0;
    }

    table tr td:last-child a {
        margin-right: 15px;
    }
    </style>
    <script type="text/javascript">
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
    </script>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Informasi Mahasiswa</h2>
                        <a href="create.php" class="btn btn-success pull-right">Tambah Baru</a>
                    </div>
                    <?php
                    // Include config file
                    require_once "config.php";

            //         $sql = "SELECT nama, nim, tugas, uts, uas , (tugas+uts+uas)/3 AS nilai_akhir
            //         FROM mahasiswa";
                    
            // $query = mysqli_query($link, $sql);

            // if (!$query) {
            //     die ('SQL Error: ' . mysqli_error($link));
            // }
            // $nilai_akhir=$row["tugas"]+$row["uts"]+$row["uas"];
            // $result=$nilai_akhir/3;
            
                    // Attempt select query execution
                    $sql = "SELECT * FROM mahasiswa";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                          
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>NAMA</th>";
                                        echo "<th>NIM</th>";
                                        echo "<th>TUGAS</th>";
                                        echo "<th>UTS</th>";
                                        echo "<th>UAS</th>";
                                        echo "<th>NILAI AKHIR</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>".$row['name']."</td>";
                                        echo "<td>".$row['nim']."</td>";
                                        echo "<td>".$row['tugas']."</td>";
                                        echo "<td>".$row['uts']."</td>";
                                        echo "<td>".$row['uas']."</td>";
                                        echo "<td>".$row['nilai_akhir'] = ($row["tugas"]+$row["uts"]+$row["uas"])/3 ."</td>";
                                        echo "<td>";
                                            echo "<a href='read.php?id=". $row['id'] ."' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                            echo "<a href='update.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "<a href='delete.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }

                    // Close connection
                    mysqli_close($link);
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>