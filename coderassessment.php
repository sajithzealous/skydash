
<?php
  
   date_default_timezone_set('America/New_York');


include('db/db-con.php');
include  'include_file/link.php';


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sth = $conn->prepare("SELECT Team,team_emp_id FROM coders GROUP BY Team,team_emp_id;
 ");
    $sth->execute();
    $team = $sth->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

  
  ?>  





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assesment Form Coder Details</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- <link rel="stylesheet" href="code_des/css/code_desc.css"> -->
    <link rel="stylesheet" href="Adminpanel/css/usermanagement.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
        /* Styling the table for fixed headers and scrollable tbody */
       

        #assessmentformcoder_table thead th {
            position: relative ;
            top: 0;
            z-index: 2;
        }

        /* Scrollable tbody */
        .table-container {
            max-height: 500px; /* Set the desired height for the scrollable area */
            overflow-y: auto;
            overflow-x: hidden;
        }

    </style>

<body>
    <div class="container-scroller">
        <!-- Navbar -->
        <?php include 'include_file/profile.php'; ?>

        <div class="container-fluid page-body-wrapper">
            <!-- Sidebar -->
            <?php include 'include_file/sidebar.php'; ?>

            <div class="main-panel">
                <div class="content-wrapper">



                    <div class="conatiner m-5">

                        <div class="card p-4">
                            <h3>Assesment Form Coder Table
                                <a href="assessmentform.php"><button type="button" class="btn btn-info mr-2" style="float:right"> Back</button></a>

                               
                            </h3>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12 p-5 table-container" style="width:100%">

                                <table id="assessmentformcoder_table" class="display table" >
                                    <thead>
                                        <tr class="headerrow">
                                            <th class="sorting">Id</th>
                                            <th class="sorting">Form Id</th>
                                            <th class="sorting">Coder</th>
                                            <th class="sorting">Team</th>
                                            <th class="sorting">Assigned By</th>
                                            <th class="sorting">Assigned Date</th>
                                            <th class="sorting">Status</th>
                                            <th class="sorting">Action</th>
                                            <th class="sorting">Operations</th>
                                         </tr>
                                    </thead>
                                    <tbody class="">
                                        

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>






    <style>
        .form-group .labelook {

            font-size: 15px;
            font-weight: 500px;
            font-style: bold;
        }
    </style>
    <?php

    $randomNumber = rand(1000, 9999);
    ?>

  


    <!-- Modal Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="Adminpanel/js/assessmentform.js?<?php echo $randomNumber ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
</body>

</html>