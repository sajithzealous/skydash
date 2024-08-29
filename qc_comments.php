<?php
// Start session and error reporting
session_start();


// Check if the user session exists
$user = $_SESSION['username'] ?? null;

// Database connection details
 include('db/db-con.php');

// Function to fetch coding_comments based on Entry_Id and table name
function coding_comments($conn, $tableName, $entryId) {
    $query = "SELECT `coding_comments` FROM `$tableName` WHERE `Entry_Id` = '$entryId' AND `coding_comments` IS NOT NULL AND `coding_comments` != '' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        return $row['coding_comments'];
    } else {
        // Log error or handle as per your application logic
        // echo "Error executing query for $tableName: " . mysqli_error($conn);
    }
    return "";
}
// Function to fetch oasis_comments based on Entry_Id and table name
function oasis_comments($conn, $tableName, $entryId) {
  $query = "SELECT `oasis_comments` FROM `$tableName` WHERE `Entry_Id` = '$entryId' AND `oasis_comments` IS NOT NULL AND `oasis_comments` != '' LIMIT 1";
  $result = mysqli_query($conn, $query);

  if ($result && $row = mysqli_fetch_assoc($result)) {
      return $row['oasis_comments'];
  } else {
      // Log error or handle as per your application logic
     // echo "Error executing query for $tableName: " . mysqli_error($conn);
  }
  return "";
}
// Function to fetch first comment based on Entry_Id and table name
function Pocsegement_comments($conn, $tableName, $entryId) {
  $query = "SELECT `poc_comments` FROM `$tableName` WHERE `Entry_Id` = '$entryId' AND `poc_comments` IS NOT NULL AND `poc_comments` != '' LIMIT 1";
  $result = mysqli_query($conn, $query);

  if ($result && $row = mysqli_fetch_assoc($result)) {
      return $row['poc_comments'];
  } else {
      // Log error or handle as per your application logic
      //echo "Error executing query for $tableName: " . mysqli_error($conn);
  }
  return "";
}

$userId = $_COOKIE['Id'] ?? '';

// Fetch comments for each segment
$coding_comments = coding_comments($conn, 'Codesegement', $userId);
$oasis_comments = oasis_comments($conn, 'oasis', $userId);
$poc_comments = Pocsegement_comments($conn, 'Pocsegement', $userId);
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <title>Document</title>

</head>
<style>
  .cmd_button {
    padding: 12.5px 30px;
    border: 0;
    border-radius: 100px;
    background-color: #2ba8fb;
    color: #ffffff;
    font-weight: Bold;
    transition: all 0.5s;
    -webkit-transition: all 0.5s;
  }

  .cmd_button:hover {
    background-color: #6fc5ff;
    box-shadow: 0 0 20px #6fc5ff50;
    transform: scale(1.1);
  }

  .cmd_button:active {
    background-color: #3d94cf;
    transition: all 0.25s;
    -webkit-transition: all 0.25s;
    box-shadow: none;
    transform: scale(0.98);
  }

  @media (max-width: 575.98px) { .container-fluid{font-size: 2px} }

 @media (max-width: 767.98px) { ..container-fluid{font-size: 2px} }

 
@media (max-width: 991.98px) { ..container-fluid{font-size: 2px} }
 
@media (max-width: 1199.98px) { ..container-fluid{font-size: 2px} }

 
@media (max-width: 1399.98px) { ..container-fluid{font-size: 2px} } 

</style>

<body>

   <div class="container-fluid">
  <div class="row">
    <div class="col-lg-8 col-md-10 col-sm-12 mx-auto">

      <div class="theme-setting-wrapper mt-4">
        <div id="settings-trigger">
          <i class="far fa-comment-alt"></i>
        </div>

        <div id="theme-settings" class="settings-panel">
          <i class="settings-close ti-close"></i>
          <p class="settings-heading font-weight-bold" style="font-family: 'Roboto Slab', sans-serif; font-size: 18px; font-weight: bold; color: #333;background-color: lightgrey;">QC Comments
              </p><br>
          <br><button class="btn btn-primary cmd_button" id="qc_cmd" style="float: right;">Save</button>
          
          <br>
          <br>

         <!--  <div class="form-group">
            <label for="qc_codesegment_cmd" class="ml-1" style="font-family: 'Playfair Display', sans-serif; font-size: 18px; font-weight: bold; color: #333;">Code Segments</label>
            <br>
            <textarea class="form-control shadow p-3 mb-2 bg-white rounded ml-3 mt-2" id="qc_codesegment_cmd" rows="3" placeholder="Enter your comment here..." style="width: 100%; max-width: 270px; height: 150px;"><?php echo $coding_comments?></textarea>
          </div><br> -->


             <div class="form-group" style="margin-top: -20px;">
              <label for="qc_codesegment_cmd" class="ml-1" style="font-family: 'Playfair Display', sans-serif; font-size: 18px;color: #333;">Code Segments</label>
              <br>
              <textarea class="form-control shadow   bg-white rounded  scrollable-textarea" id="qc_codesegment_cmd" rows="3"
                placeholder="Enter your comment here..." style="width: 100%; height:150px;"><?php echo $coding_comments?></textarea>
            </div><br>

          <div class="form-group" style="margin-top: -40px;">
            <label for="qc_oasissegment_cmd" class="ml-1" style="font-family: 'Playfair Display', sans-serif; font-size: 18px; color: #333;">Oasis Segments</label>
            <br>
            <textarea class="form-control shadow bg-white rounded   scrollable-textarea" id="qc_oasissegment_cmd" rows="3" placeholder="Enter your comment here..." style="width: 100%; height:150px;"><?php echo $oasis_comments?></textarea>
          </div><br>

          <div class="form-group" style="margin-top: -49px;">
            <label for="qc_poc_cmd" class="ml-1" style="font-family: 'Playfair Display', sans-serif; font-size: 18px;color: #333;">POC</label>
            <br>
            <textarea class="form-control shadow  bg-white rounded   scrollable-textarea" id="qc_poc_cmd" rows="3" placeholder="Enter your comment here... "style="width: 100%; height:150px;"><?php echo $poc_comments?></textarea>
          </div>
 
           <!--   <div class="form-group text-center">
              <button class="btn btn-primary cmd_button qc_cmd" id="qc_cmd">Save</button>
            </div> -->

        </div>
      </div>
    </div>
  </div>
</div>

</body>
<script src="QA/js/qc_comments.js"></script>


</html>

 <!--  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-8 col-md-10 col-sm-12 mx-auto">
        <div class="theme-setting-wrapper mt-4">
          <div id="settings-trigger"><i class="far fa-comment-alt"></i></div>
          <div id="theme-settings" class="settings-panel">
            <i class="settings-close ti-close"></i>
            <p class="settings-heading font-weight-bold" style="font-family: 'Roboto Slab', sans-serif; font-size: 18px; font-weight: bold; color: #333;">Comments</p>
            <br>
            <div class="form-group">
              <label for="codesegment_cmd" class="ml-1">Code Segments</label>
              <br>
              <textarea class="form-control shadow p-3 mb-2 bg-white rounded ml-3 mt-2 scrollable-textarea" id="codesegment_cmd" rows="3"
                placeholder="Enter your comment here..." style="width: 94%;"></textarea>
            </div><br>

            <div class="form-group">
              <label for="oasissegment_cmd" class="ml-1">Oasis Segments</label>
              <br>
              <textarea class="form-control shadow p-3 mb-2 bg-white rounded ml-3 mt-2 scrollable-textarea" id="oasissegment_cmd" rows="3"
                placeholder="Enter your comment here..." style="width: 94%;"></textarea>
            </div><br>

            <div class="form-group">
              <label for="poc_cmd" class="ml-1">POC</label>
              <br>
              <textarea class="form-control shadow p-3 mb-2 bg-white rounded ml-3 mt-2 scrollable-textarea" id="poc_cmd" rows="3"
                placeholder="Enter your comment here..." style="width: 94%;"></textarea>
            </div>
            <div class="form-group text-center">
              <button class="btn btn-primary cmd_button" id="saveComments">Save</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> -->