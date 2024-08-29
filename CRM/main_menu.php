<!DOCTYPE html>
<html lang="en">

<head>

  <?php
  $user = $_SESSION['role'];
  $agent =$_SESSION['agent'];
  include('../db/db-con.php');

  ?>
  <!-- Filter -->
  <link rel="stylesheet" href="./css/filter/filter.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
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
          <!-- Filtter start -->
          <div class="card mb-3">
            <div class="card-body">
              <div class="row">
                <div class="col-md-2">

                  <?php
                  include 'filter/Status_filter.php';
                  ?>
                </div>
                <?php if ($role == 'Admin') { ?>

                  <div class="col-md-2">

                    <?php
                    include 'filter/assesment_filter.php';
                    ?>

                  </div>

                  <div class="col-md-2">

                    <?php
                    include 'filter/agent_filter.php';
                    ?>

                  </div>
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
                <?php } ?>
                <div class="col-md-2">

                  <button type="button" class="btn btn-primary ml-2 mt-1" id="searchButton">
                    Search</button>
                  <?php if ($role == 'Admin') { ?>
                    <button type="button" class="btn btn-primary ml-2 mt-1" id="Assign">
                      Assign</button>
                  <?php } ?>
                </div>

              </div>
            </div>
            <!-- Filtter close-->
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

                    <?php if ($role == 'Admin') { ?>
                      <div class="d-grid gap-2 d-md-flex justify-content-md-end mr-5">
                        <p class="mb-0">Number of Checked Files: <span id="checkedFilesCount"></span></p>
                      </div>
                    <?php } ?>
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
                                <th>#</th>
                                <th>Id</th>
                                <th>Patient Name</th>
                                <th>MRN</th>
                                <th>Phone Number</th>
                                <th>Insurance Type</th>
                                <th>Assessment Date</th>
                                <th>Assessment Type</th>
                                <th>Agency</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Chart</th>

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

    <!-- <?php
          include 'include_file/pulg.php';
          ?> -->
    <script src="table/js/table.js"></script>

</body>

</html>