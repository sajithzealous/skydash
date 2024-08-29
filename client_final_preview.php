<?php
session_start();

 include('db/db-con.php');
// Check if the 'Id' parameter is set in the cookie
if (isset($_COOKIE['Id'])) {
  // Get the user ID from the cookie
  $userId = $_COOKIE['Id'];

  // Create a normal SQL query. Be cautious, as this approach is prone to SQL injection.
 $select_query = "SELECT `status`, `assesment_type` FROM `Main_Data` WHERE `Id` = '$userId'";
$result = $conn->query($select_query);

if ($result) {
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $status = $row['status'];
        // Echo the value of $assesment_type
       $assesment_type = $row['assesment_type'];
    } else {
        // No records found for the given ID
        echo "No records found for the given ID";
    }


  } else {
      // Error in SQL query
      echo "Error executing SQL query";
  }
} else {
  // 'Id' parameter is not set in the cookie
  echo "No 'Id' parameter found in the cookie";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <title>Final View</title>
  <style>
    .styled-table th,
    .styled-table td {
      text-align: left;
    }

    .red-row {
      background-color: #ff7373;
      /* Customize as needed */
    }

    .yellow-row {
      background-color: #ffff76;
      /* Customize as needed */
    }

    .green-row {
      background-color: #7cff7c;
      /* Customize as needed */
    }

    .shadow {
      background: #e0e0e0;
      box-shadow: -25px 25px 75px #b3b3b3,
        25px -25px 75px #ffffff;
    }

    /* approved button card */
    .continue-application {
      --color: #fff;
      --background: #404660;
      --background-hover: #3A4059;
      --background-left: #2B3044;
      --folder: #F3E9CB;
      --folder-inner: #BEB393;
      --paper: #FFFFFF;
      --paper-lines: #BBC1E1;
      --paper-behind: #E1E6F9;
      --pencil-cap: #fff;
      --pencil-top: #275EFE;
      --pencil-middle: #fff;
      --pencil-bottom: #5C86FF;
      --shadow: rgba(13, 15, 25, .2);
      border: none;
      outline: none;
      cursor: pointer;
      position: relative;
      border-radius: 5px;
      font-size: 14px;
      font-weight: 500;
      line-height: 19px;
      -webkit-tap-highlight-color: transparent;
      padding: 17px 29px 17px 69px;
      transition: background 0.3s;
      color: var(--color);
      background: var(--bg, var(--background));
    }

    .continue-application>div {
      top: 0;
      left: 0;
      bottom: 0;
      width: 53px;
      position: absolute;
      overflow: hidden;
      border-radius: 5px 0 0 5px;
      background: var(--background-left);
    }

    .continue-application>div .folder {
      width: 23px;
      height: 27px;
      position: absolute;
      left: 15px;
      top: 13px;
    }

    .continue-application>div .folder .top {
      left: 0;
      top: 0;
      z-index: 2;
      position: absolute;
      transform: translateX(var(--fx, 0));
      transition: transform 0.4s ease var(--fd, 0.3s);
    }

    .continue-application>div .folder .top svg {
      width: 24px;
      height: 27px;
      display: block;
      fill: var(--folder);
      transform-origin: 0 50%;
      transition: transform 0.3s ease var(--fds, 0.45s);
      transform: perspective(120px) rotateY(var(--fr, 0deg));
    }

    .continue-application>div .folder:before,
    .continue-application>div .folder:after,
    .continue-application>div .folder .paper {
      content: "";
      position: absolute;
      left: var(--l, 0);
      top: var(--t, 0);
      width: var(--w, 100%);
      height: var(--h, 100%);
      border-radius: 1px;
      background: var(--b, var(--folder-inner));
    }

    .continue-application>div .folder:before {
      box-shadow: 0 1.5px 3px var(--shadow), 0 2.5px 5px var(--shadow), 0 3.5px 7px var(--shadow);
      transform: translateX(var(--fx, 0));
      transition: transform 0.4s ease var(--fd, 0.3s);
    }

    .continue-application>div .folder:after,
    .continue-application>div .folder .paper {
      --l: 1px;
      --t: 1px;
      --w: 21px;
      --h: 25px;
      --b: var(--paper-behind);
    }

    .continue-application>div .folder:after {
      transform: translate(var(--pbx, 0), var(--pby, 0));
      transition: transform 0.4s ease var(--pbd, 0s);
    }

    .continue-application>div .folder .paper {
      z-index: 1;
      --b: var(--paper);
    }

    .continue-application>div .folder .paper:before,
    .continue-application>div .folder .paper:after {
      content: "";
      width: var(--wp, 14px);
      height: 2px;
      border-radius: 1px;
      transform: scaleY(0.5);
      left: 3px;
      top: var(--tp, 3px);
      position: absolute;
      background: var(--paper-lines);
      box-shadow: 0 12px 0 0 var(--paper-lines), 0 24px 0 0 var(--paper-lines);
    }

    .continue-application>div .folder .paper:after {
      --tp: 6px;
      --wp: 10px;
    }

    .continue-application>div .pencil {
      height: 2px;
      width: 3px;
      border-radius: 1px 1px 0 0;
      top: 8px;
      left: 105%;
      position: absolute;
      z-index: 3;
      transform-origin: 50% 19px;
      background: var(--pencil-cap);
      transform: translateX(var(--pex, 0)) rotate(35deg);
      transition: transform 0.4s ease var(--pbd, 0s);
    }

    .continue-application>div .pencil:before,
    .continue-application>div .pencil:after {
      content: "";
      position: absolute;
      display: block;
      background: var(--b, linear-gradient(var(--pencil-top) 55%, var(--pencil-middle) 55.1%, var(--pencil-middle) 60%, var(--pencil-bottom) 60.1%));
      width: var(--w, 5px);
      height: var(--h, 20px);
      border-radius: var(--br, 2px 2px 0 0);
      top: var(--t, 2px);
      left: var(--l, -1px);
    }

    .continue-application>div .pencil:before {
      -webkit-clip-path: polygon(0 5%, 5px 5%, 5px 17px, 50% 20px, 0 17px);
      clip-path: polygon(0 5%, 5px 5%, 5px 17px, 50% 20px, 0 17px);
    }

    .continue-application>div .pencil:after {
      --b: none;
      --w: 3px;
      --h: 6px;
      --br: 0 2px 1px 0;
      --t: 3px;
      --l: 3px;
      border-top: 1px solid var(--pencil-top);
      border-right: 1px solid var(--pencil-top);
    }

    .continue-application:before,
    .continue-application:after {
      content: "";
      position: absolute;
      width: 10px;
      height: 2px;
      border-radius: 1px;
      background: var(--color);
      transform-origin: 9px 1px;
      transform: translateX(var(--cx, 0)) scale(0.5) rotate(var(--r, -45deg));
      top: 26px;
      right: 16px;
      transition: transform 0.3s;
    }

    .continue-application:after {
      --r: 45deg;
    }

    .continue-application:hover {
      --cx: 2px;
      --bg: var(--background-hover);
      --fx: -40px;
      --fr: -60deg;
      --fd: .15s;
      --fds: 0s;
      --pbx: 3px;
      --pby: -3px;
      --pbd: .15s;
      --pex: -24px;
    }
  </style>
</head>
<body>
<!-- <body style="background-color: #E6E6E6; user-select: none;"> -->

<!--   <?php if ($status !== 'APPROVED') : ?>
    <div class="container-fluid justify-content-center bg-white fixed-top option">
      <div class="row mt-3">
        <div class="col-md-12 text-center mb-3">
          <button class="continue-application" id="Approved">
            <div>
              <div class="pencil"></div>
              <div class="folder">
                <div class="top">
                  <svg viewBox="0 0 24 27">
                    <path d="M1,0 L23,0 C23.5522847,-1.01453063e-16 24,0.44771525 24,1 L24,8.17157288 C24,8.70200585 23.7892863,9.21071368 23.4142136,9.58578644 L20.5857864,12.4142136 C20.2107137,12.7892863 20,13.2979941 20,13.8284271 L20,26 C20,26.5522847 19.5522847,27 19,27 L1,27 C0.44771525,27 6.76353751e-17,26.5522847 0,26 L0,1 C-6.76353751e-17,0.44771525 0.44771525,1.01453063e-16 1,0 Z"></path>
                  </svg>
                </div>
                <div class="paper"></div>
              </div>
            </div>
            Approved
          </button>
        </div>
      </div>
    </div>
  <?php endif; ?> -->

  <div class="container-fluid mt-5">
    <div class="row d-flex justify-content-center">
      <!-- <div class="card shadow"> -->
      <!-- Right Column ( QC PREVIEW TABLE) -->
      <div class="col-12 col-lg-12">
        <div class="container mt-5 mb-5">
          <div class="card p-4">
            <div class="card-header text-center mb-2">
              FINAL PREVIEW 
            </div>
            <!-- QC Personal Details Table -->
            <div class="table-responsive">
              <table class="styled-table fixed-header-width table" id="main-table">
                <thead style="color: whitesmoke; background: #4C4CAC;">
                  <tr>
                    <th>Patient_Name</th>
                    <th>MRN</th>
                    <th>Agency</th>
                    <th>Insurance Type</th>
                    <th>Date of Assessment</th>
                    <th>Assessment Type</th>
                    <th>Coder</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>

            <!-- QC Coding Details Table -->
            <div class="table-responsive">
              <h5>Coding Segment</h5>
              <table class="styled-table fixed-header-width table" id="Codnig-table">
                <thead style="color: whitesmoke; background: #4C4CAC;">
                  <tr>
                    <th>MItems</th>
                    <th>ICD</th>
                    <th>Description</th>
                    <th>Effective Date</th>
                    <th>E/O</th>
                    <th>Rating</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
                <tbody id="Codnig-nodata-table">
                  <tr>
                    <td colspan="9" class="text-center text-danger" style="border: 1px solid black; white-space: pre-wrap;">No data available</td>
                  </tr>
                </tbody>

              </table>
            </div>

            <!-- QC Coding Comments Table -->
            <div class="table-responsive">
              <table class="table mx-auto" id="Codnig-cmd">
                <thead style="color: whitesmoke; background: #4C4CAC;">
                  <tr>
                    <th scope="col">Coding Commments </th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
                <tbody id="Codnig-no-comments">
                  <tr>
                    <td class="text-center text-danger" style="border: 1px solid black; white-space: pre-wrap;">No comments available</td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!--QC Oasis Details Table -->
            <div class="table-responsive">
              <h5>Oasis Segment</h5>
              <table class="styled-table fixed-header-width table table-bordered" id="oasisqc-table">
                <thead style="color: whitesmoke; background: #4C4CAC;">
                  <tr>
                    <th>MItems</th>
                    <th>Agency Response</th>
                    <th>Coder Response</th>
                    <th>Coder Rationali</th>
                  </tr>
                </thead>
                <tbody id="oasisqc-table-body">
                  <tr>
                  </tr>
                </tbody>
                <tbody id="oasis-nodata-table">
                  <tr>
                    <td colspan="7" class="text-center text-danger" style="border: 1px solid black; white-space: pre-wrap;"> </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- QC Oasis Comments Table -->
            <div class="table-responsive">
              <table class="table mx-auto" id="oasisqc-cmd">
                <thead style="color: whitesmoke; background: #4C4CAC;">
                  <tr>
                    <th scope="col">Oasis Commments </th>

                  </tr>
                </thead>
                <tbody>
                </tbody>
                <tbody id="oasis-no-comments">
                  <tr>
                    <td class="text-center text-danger" style="border: 1px solid black; white-space: pre-wrap;">No comments available</td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!--QC POC Details Table -->

    <?php if ($assessment_type != 'Soc'): ?>
<!--     <div class="table-responsive">
        <h5>POC Segment</h5>
        <table class="styled-table fixed-header-width table" id="poc-table">
   
            <thead style="color: whitesmoke; background: #4C4CAC;">
                <tr>
                    <th>POC-ITEM</th>
                    <th>Coder Response</th>
                </tr>
            </thead>
       
            <tbody></tbody>
      
            <tbody id="poc-nodata-table">
                <tr>
                    <td colspan="5" class="text-center text-danger" style="border: 1px solid black; white-space: pre-wrap;">No data available</td>
                </tr>
            </tbody>
        </table>
    </div> -->
    <?php endif; ?>

    <!-- QC POC Comments Table -->
<!--     <div class="table-responsive">
        <table class="table mx-auto" id="poc-cmd">
          
            <thead style="color: whitesmoke; background: #4C4CAC;">
                <tr>
                    <th scope="col">Poc Commments</th>
                </tr>
            </thead>
           
            <tbody></tbody>
             
            <tbody id="poc-no-comments">
                <tr>
                    <td class="text-center text-danger" style="border: 1px solid black; white-space: pre-wrap;">No comments available</td>
                </tr>
            </tbody>
        </table>
    </div>
 -->


          

          </div>
        </div>
      </div>
      <!-- </div> -->

    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <?php
  include 'include_file/pulg.php';
  ?>
  <script src="Assign/js/final_preview.js"></script>
  <script src="Assign/js/Approved_file.js"></script>

</body>

</html>