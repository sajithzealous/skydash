<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="shortcut icon" href="include_file/ELogo.png" > 

    <?php

    // include 'logsession.php';
    include('db/db-con.php');
    // include 'login_sessions/teamleader_session.php';
    include 'login_sessions/qa_session.php';
    ?>
    <!-- Filter -->
    <link rel="stylesheet" href="./css/filter/filter.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">



    <style>
        .dataTables_wrapper .top {
            display: flex;
            justify-content: space-between;
        }

        /* Adjust the DataTable layout */
        .dataTables_wrapper .bottom {
            display: flex;
            justify-content: space-between;
        }

        .dot-circle {
            display: inline-block;
            width: 12px;
            /* Adjust the size of the dot as needed */
            height: 12px;
            border-radius: 50%;
            background-color: #ff0000;
            /* Adjust the background color as needed */
            margin-right: 8px;
            /* Adjust the margin as needed */
        }

        /* Replace table with your actual table's class or ID */
        /* Increase specificity by using the table class or ID */
        table.dataTable tbody tr.status_completed_row {
            display: none !important;
            /* Add !important to override other styles */
        }
    </style>
</head>

<body>

    <!--  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="filter/filter_list.js" type="text/javascript"></script> -->
    <div class="container-scroller">
        <!-- partial:../../partials/_navbar.html -->

        <?php

        include 'include_file/link.php';
        include 'include_file/profile.php';
        ?>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">


            <?php
            include 'include_file/sidebar.php';
            ?>


            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="card mb-3">
                        <div class="row">
                            <div class="col-md-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <!-- Loader design -->
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-center align-items-center">
                                                <!-- <div id="loading" style="display: none;">
                          <img src="loading.gif" alt="Loading..." />
                        </div> -->
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-auto">
                                                <p class="card-title">QA Work Files</p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table id="qa_work_files" class="display expandable-table" style="width:100%">
                                                        <thead>
                                                            <tr class="table">
                                                            </tr>
                                                        </thead>
                                                        <tbody class="table">
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Table end-->

                    </div>

                </div>
                <!-- main-panel ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <!-- container-scroller -->

        <?php
        include 'include_file/pulg.php';
        ?>
        <script src="https://cdn.jsdelivr.net/npm/luxon@2.0.0/build/global/luxon.min.js"></script>
        <script src="QA/js/Qa_work_files.js"></script>
</body>

</html>