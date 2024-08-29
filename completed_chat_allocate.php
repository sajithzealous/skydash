<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="shortcut icon" href="include_file/ELogo.png" > 
  <?php



  // include 'logsession.php';
  include('db/db-con.php');
  // include 'login_sessions/teamleader_session.php';
  include 'login_sessions/user_session.php';
  ?>
  <!-- Filter -->
  <link rel="stylesheet" href="./css/filter/filter.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->



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

          <?php if ($role === 'TeamLeader') { ?>
            <!-- Filtter start -->
            <div class="card mb-3">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-2">

                    <?php
                    // include 'filter/Status_filter.php';
                    ?>
                  </div>
                  <div class="col-md-2">

                    <?php
                    include 'filter/qc_coder_filters.php';
                    ?>

                  </div>
                  <div class="col-md-2">
<!-- 
                    <button type="button" class="btn btn-primary ml-2 mt-1" id="search">
                      Search</button> -->
                    <button type="button" class="btn btn-primary ml-2 " id="QC_Assign">
                      Assign</button>
                  </div>

                </div>
              </div>
            </div>
            <!-- Filtter close-->
          <?php } ?>
          <!-- Assign Files Table -->
 
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
                      <div class="col-12 d-flex justify-content-center align-items-center">
                        <div id="loading" style="display: none;">
                          <img src="loading.gif" alt="Loading..." />
                        </div>
                      </div>
                    </div>
                    <?php if ($role === 'TeamLeader') { ?>
                      <div class="d-grid gap-2 d-md-flex justify-content-md-end mr-5">
                        <p class="mb-0">Selected Count: : <span id="checkedFilesCount"></span></p>
                      </div>
                    <?php } ?>
                    <!-- <div class="row justify-content-end">
                      <div class="col-6">
                      <marquee class="html-marquee" direction="left" behavior="scroll" scrollamount="12">
                        <p>Aldrin</p>
                      </marquee>
                      </div>

                    </div> -->


                    <div class="row">
                      <div class="col-auto">
                        <p class="card-title">Assign Files</p>
                      </div>
                    </div>



                    <div class="row">
                      <div class="col-12">
                        <div class="table-responsive">
                          <table id="assign_qc_table_data" class="display expandable-table" style="width:100%">
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
          

          <!-- Completed Files Table -->

        <!--   <?php if ($role === 'user') { ?>

            <div class="card mb-3">
              <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-auto">
                          <p class="card-title">Completed Files</p>
                        </div>
                      </div>



                      <div class="row">
                        <div class="col-12">
                          <div class="table-responsive">
                            <table id="Completed_table_data" class="display expandable-table" style="width:100%">
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
            
            </div>

          <?php } ?>   -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->


    <!-- Edit modal -->
    <div class="modal fade bd-example-modal-md-edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="myModal" aria-hidden="true">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Mrn</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" id="edit_form">
              <div class="row">
                <div class="form-group col" hidden>
                  <label for="user-id" class="col-form-label">Id</label>
                  <input type="text" class="form-control" id="Id">
                </div>
                <div class="form-group col">
                  <label for="Patient_Name" class="col-form-label">Patient Name</label>
                  <input type="text" class="form-control" name="Patient_Name" id="Patient_Name" readonly>
                </div>

                <div class="form-group col">
                  <label for="lastname" class="col-form-label">Mrn</label>
                  <input type="text" class="form-control" id="Mrn">
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="close">Close</button>
                <button type="submit" id="update" class="btn btn-primary">Update</button>
              </div>
          </div>
        </div>
      </div>
    </div>

    <?php
    include 'include_file/pulg.php';
    ?>

     <?php  $rand=rand(0000,9999) ?>
    <script src="Assign/js/qc_assigntable.js?<?php echo $rand ?>"></script>
    <!-- <script src="table/js/table.js"></script>
    <script src="Assign/js/pending_table.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/luxon@2.0.0/build/global/luxon.min.js"></script>
</body>

</html>