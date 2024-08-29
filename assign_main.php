<!DOCTYPE html>
<html lang="en">

<head>

  <?php


   include 'logsession.php';
  include('db/db-con.php');
  include 'include_file/link.php';
  ?>
  <!-- Filter -->
  <link rel="stylesheet" href="./css/filter/filter.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>

<body>

  <!--  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="filter/filter_list.js" type="text/javascript"></script> -->
  <div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->

    <?php
    include 'include_file/profile.php';
    ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">


      <?php
      include 'include_file/sidebar.php';
      ?>


      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">

                <div class="col-12 col-xl-4">
                  <div class="justify-content-end d-flex">
                    <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                      <!--  <button class="btn btn-sm btn-light bg-white  mr-5  float-right" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                     <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
                    </button> -->

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Filtter start -->
          <div class="card mb-3">
            <div class="card-body">
              <div class="row">
                <div class="col-md-2">

                  <?php
                  include 'team_dash/assign_status_filter.php';
                  ?>
                </div>

                <!-- <div class="col-md-2">

                  <?php
                  //include 'filter/assesment_filter.php';
                  ?>

                </div> -->

                <!-- <div class="col-md-2">

                  <?php
                //  include 'filter/agent_filter.php';
                  ?>

                </div> -->
                <div class="col-md-2">
                  <?php
                  include 'filter/team_filter.php';
                  ?>

                </div>
                <div class="col-md-2">

                  <div class="wrapper">
                    <button class="form-control toggle-next ellipsis font-weight-bolder">Coder</button>
                    <div class="checkboxes" id="status">
                      <div class="inner-wrap coder views_coder">
                        <!-- <div class="coders">
                        <?php
                        // include 'filter/coders.php';
                        ?>
                        </div> -->

                      </div>
                    </div>
                  </div>


                </div>
                <div class="col-md-2">

                  <button type="button" class="btn btn-primary ml-2 mt-1" id="searchButton">
                    Search</button>
<!-- 
                  <button type="button" class="btn btn-primary ml-2 mt-1" id="Assign">
                    Assign</button> -->
                </div>

              </div>
            </div>
            <!-- Filtter close-->
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
            </style>
            <div class="row">
              <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <!-- Loader design -->
                    <div class="row">
                      <div class="col-12 d-flex justify-content-center align-items-center">
                        <div id="loading" style="display: none;">
                          <img src="loading.gif" alt="Loading..." />
                        </div>
                      </div>
                    </div>
                    <!-- <div class="row">
                    <div class="col-12 d-flex justify-content-center align-items-center">
                      <div id="loading" style="display: none;">
                        <img src="restart.gif" alt="Loading..." />
                      </div>
                    </div>
                  </div> -->


                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mr-5">
                    <p class="mb-0">Number of Checked Files: <span id="checkedFilesCount"></span></p>
                    </div>

                    <div class="row">
                      <div class="col-auto">
                        <p class="card-title">Files</p>
                      </div>
                    </div>


                    <div class="row">
                      <div class="col-12">
                        <div class="table-responsive">
                          <table id="table_data" class="display expandable-table" style="width:100%">
                            <thead>
                              <tr class="table text-center">
                                <!-- <th>#</th> -->
                                <th>Id</th>
                                <th>Team</th>
                                <th>Agency</th>
                                <th>Location</th>
                                <th>Patient Name</th>
                                <th>Phone Number</th>
                                <th>Task</th>
                                <th>MRN</th>
                                <th>Assessment Date</th>
                                <th>DSI</th>
                                <th>DSC</th>
                                <th>Assessment Type</th>
                                <th>Insurance Type</th>
                                <th>Status</th>
                                <th>USER</th>
                                <th>Workable</th>
                                <th>Remarks</th>
                                <th>Assigned Date</th>
                                <th>Assigned by Team</th>
                                <th>Assigned by Coder</th>
                                <th>Coder</th>
                                <th>Url</th>

                              </tr>
                            </thead>
                            <tbody class="table text-center">
                            </tbody>
                          </table>
                          <!-- No data found message (initially hidden) -->
                          <!-- <div id="no-data-message" style="display: none;" class="text-center">No data found...☹</div> -->
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
    <script src="team_dash/js/assign_table.js"></script>

</body>

</html>