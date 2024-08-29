<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assesment Form Management</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- <link rel="stylesheet" href="code_des/css/code_desc.css"> -->
    <link rel="stylesheet" href="Adminpanel/css/usermanagement.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

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
                       <center> <h3>Assessment Table</h3></center>
                           
      <!--                   <div class="card p-3">
                           <ul class="nav nav-pills nav-justified" style="border:none">
                              <li class="nav-item">
                                <a class="nav-link active datachange" aria-current="page" href="#" data-item="live" >Live</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link datachange" href="#" data-item="past">Past</a>
                              </li>
                            </ul>
                        </div> -->
                    </div>
                    <div class="container mt-5 p-3">
                        <div class="card p-3">
                            <div class="card-body p-3">
                      <table class="table table-hover p-5 table-bordered" id="assessmenttable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Form ID</th>
                                <th>Coder Emp ID</th>
                                <th>Team Name</th>
                                <th>Assigned By</th>
                                <th>File Status</th>
                                <th>Assigned Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="assessmenttablebody" style="overflow: auto;max-height: 500px;">
                            <!-- Table rows will be dynamically inserted here -->
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
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
     <script src="Adminpanel/js/assessmentform.js?<?php echo $randomNumber ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

</body>

</html>