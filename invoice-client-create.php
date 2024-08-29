<!DOCTYPE html>
<html lang="en">

<head>

  <?php
  $user = $_SESSION['role'];
  $agent = $_SESSION['agent'];
  $empid = $_SESSION['empid'];
  include('db/db-con.php');
  include 'login_sessions/admin_session.php';
  ?>
    <link rel="shortcut icon" href="include_file/ELogo.png" > 
  <!-- Filter -->
  <link rel="stylesheet" href="./css/filter/filter.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->

</head>
<style>
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


  .dataTables_wrapper .top {
    display: flex;
    justify-content: space-between;
  }

  /* Adjust the DataTable layout */
  .dataTables_wrapper .bottom {
    display: flex;
    justify-content: space-between;
  }

  /* Age file clour change status */

  .color1 {
    background: lavenderblush;

  }

  .color2 {
    background: yellow;

  }

  .color3 {
    background: green;

  }

  .color4 {
    color: violet;

  }

  .color5 {
    background: none;

  }
</style>

<body>
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
                <h3>Create Client</h3>

                <div class="row">
                    <div class="heading my-3 col-12">
                      <h4>Basic Information</h4>
                    </div>
                    <div class="col-lg-4 col-12 pb-3">
                      <label for="#clientName">Client Name</label>
                      <input type="text" name="" class="form-control" id="clientName">
                    </div>
                    <div class="col-lg-4 col-12 pb-3">
                      <label for="#companyName">Company Name</label>
                      <input type="text" name="" class="form-control" id="companyName">
                    </div>
                    <div class="col-lg-4 col-12 pb-3">
                      <label for="#clientuid">Client UID</label>
                      <input type="text" name="" class="form-control" id="clientuid">
                    </div>
                    <div class="heading my-3 col-12">
                      <h4>Contact Information</h4>
                    </div>
                    <div class="col-lg-6 col-12 pb-3">
                      <label for="#companyAddress">Company Address</label>
                      <input type="text" name="" class="form-control" id="companyAddress">
                    </div>
                    <div class="col-lg-3 col-12 pb-3">
                      <label for="#primaryPhone">Primary Phone</label>
                      <input type="text" name="" class="form-control" id="primaryPhone">
                    </div>
                    <div class="col-lg-3 col-12 pb-3">
                      <label for="#secPhone">Secondary Phone</label>
                      <input type="text" name="" class="form-control" id="secPhone">
                    </div>
                    <div class="col-lg-3 col-12 pb-3">
                      <label for="#companyAddress">Primary Email</label>
                      <input type="text" name="" class="form-control" id="primaryEmail">
                    </div>
                    <div class="col-lg-3 col-12 pb-3">
                      <label for="#primaryPhone">Secondary Email</label>
                      <input type="text" name="" class="form-control" id="secondaryEmail">
                    </div>
                    <div class="col-lg-6 col-12 pb-3">
                      <label for="#secPhone">Company URL</label>
                      <input type="text" name="" class="form-control" id="companyURL">
                    </div>
                    <div class="col-lg-3 col-12 pb-3">
                      <label for="#companyAddress">LinkedIn</label>
                      <input type="text" name="" class="form-control" id="linkedIn">
                    </div>
                    <div class="col-lg-3 col-12 pb-3">
                      <label for="#primaryPhone">Skype</label>
                      <input type="text" name="" class="form-control" id="skype">
                    </div>
                    <div class="col-lg-3 col-12 pb-3">
                      <label for="#secPhone">WhatsApp</label>
                      <input type="text" name="" class="form-control" id="whatsApp">
                    </div>
                    <div class="col-lg-3 col-12 pb-3">
                      <label for="#secPhone">Signal</label>
                      <input type="text" name="" class="form-control" id="signal">
                    </div>
                    <div class="col-lg-3 col-12 pb-3">
                      <label for="#secPhone">Slack</label>
                      <input type="text" name="" class="form-control" id="flack">
                    </div>
                    <div class="col-lg-3 col-12 pb-3">
                      <label for="#secPhone">Teams</label>
                      <input type="text" name="" class="form-control" id="teams">
                    </div>
                    <div class="col-lg-3 col-12 pb-3">
                      <label for="#secPhone">Facebook</label>
                      <input type="text" name="" class="form-control" id="facebook">
                    </div>
                    <div class="col-lg-3 col-12 pb-3">
                      <label for="#secPhone">Twitter</label>
                      <input type="text" name="" class="form-control" id="twitter">
                    </div>
                    <div class="heading my-3 col-12">
                      <h4>Billing Information</h4>
                    </div>
                    <div class="col-lg-8 col-12 pb-3">
                      <label for="#secPhone">Twitter</label>
                      <input type="text" name="" class="form-control" id="twitter">
                    </div>
                </div>
            </div>

          </div>

        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <script src="https://cdn.jsdelivr.net/npm/luxon@2.0.0/build/global/luxon.min.js"></script>

    <!-- <?php
          include 'include_file/pulg.php';
          ?> -->


</body>

</html>