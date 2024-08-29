<!DOCTYPE html>
<html lang="en">

<head>

  <?php

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
                <div class="col-md-1"></div>
                <div class="col-md-2">

                  <?php
                  include 'filter/Status_filter.php';
                  ?>
                </div>

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
                  include 'filter/coder_filter.php';
                  ?>

                </div>
                <div class="col-md-2">


                  <?php
                  include 'filter/team_filter.php';
                  ?>



                </div>
                <!-- <div class="col-md-1">

                  <button type="button" class="btn btn-primary ml-2 " id="searchButton">
                    Submit</button>
                </div> -->

              </div>
            </div>
          </div>
          <!-- Filtter close-->

          <div class="row">
            <!-- --2 row-- -->
          </div>
          <div class="row">
            <!-- --3 row-- -->
          </div>
          <div class="row">
            <!-- --4 row-- -->
          </div>
          <!-- Table Start-->
          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">Table</p>
                  <div class="row">
                    <div class="col-12">
                      <div class="table-responsive">
                        <table id="table_data" class="display expandable-table" style="width:100%">
                          <thead>
                            <tr class="table text-center">
                              <th>Team</th>
                              <th>Agency</th>
                              <th>Location</th>
                              <th>Patient Name</th>
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

                            </tr>
                          </thead>
                          <tbody class="table text-center">
                            <!-- Data will be inserted here -->
                          </tbody>
                        </table>
                        <!-- No data found message (initially hidden) -->
                        <div id="no-data-message" style="display: none;" class="text-center">No data found...☹</div>
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

  <!-- End custom js for this page-->
</body>

</html>