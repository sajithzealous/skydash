<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="./css/filter/filter.css">
  <link rel="shortcut icon" href="include_file/ELogo.png" > 
  <?php

  // include 'logsession.php';
  include('db/db-con.php');
  // include 'login_sessions/teamleader_session.php';
  include 'login_sessions/user_session.php';
  ?>
 
  </style>
</head>

<body>

  <div class="container-scroller">

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
                    include 'filter/TeamWise_Coder.php';
                    ?>

                  </div>
                  <div class="col-md-2">
                  <!-- 
                    <button type="button" class="btn btn-primary ml-2 mt-1" id="search">
                      Search</button> -->
                    <button type="button" class="btn btn-primary ml-5 " id="Approved_assign">
                      Assign</button>
                  </div>

                </div>
              </div>
            </div>
            <!-- Filtter close-->
          <?php } ?>
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
                    <div class="row">
                      <div class="col-auto">
                        <p class="card-title">Approved Files</p>
                      </div>
                    </div>



                  <div class="row">
                        <div class="col-12">
                          <div class="table-responsive">
                            <!-- <input type="text" id="customSearchBox" placeholder="Search..."> -->
                            <table id="Approved_table" class="display expandable-table" style="width:100%">
                              <thead>
                                <tr class="table">
                                  <!-- Table headers go here -->
                                </tr>
                              </thead>
                              <tbody class="table">
                                <!-- Table data goes here -->
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
   <?php  $rand=rand(0000,9999) ?>
    <script src="Assign/js/Approved_table_v2.js?<?php echo $rand ?>"></script>

     <script src="https://cdn.jsdelivr.net/npm/luxon@2.0.0/build/global/luxon.min.js"></script>
</body>

</html>