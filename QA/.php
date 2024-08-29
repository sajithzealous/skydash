<?php
include 'db-con.php';


include 'login_sessions/user_session.php';
session_start();
$role = $_SESSION['role'];
$Id = $_GET['Id'];





$agency = $_SESSION['agent'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-cx1GvwI1/PzdBYP1e6/J2H2w95aP+1e0+KlgQCT4Dn2zU5CUIaGq6u1NI7/P3xUkONnH1aDMQ/9cO2Cki5yWeA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- //displaydataininput// -->

    <?php
    include('Assign/display_data.php');
    ?>

    <?php
    include('db/db-con.php');

    ?>
    <?php
    include 'include_file/link.php';
    ?>

    <?php
    $servername = "192.168.200.59";
    $username   = "zeal";
    $password   = "4321";
    $dbname     = "HCLI";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }



    $sql = "SELECT * FROM codepage WHERE (`profile`='none' OR `code_segment`='none' OR `oasis_segment`='none' OR `poc_segment`='none') AND `assesment_type`='$assessmentType'";
    $result = $conn->query($sql);

    // Initialize display values
    $displayProfiles = 'block';
    $displayCodeSegment = 'block';
    $displayOasisSegment = 'block';
    $displayPocSegment = 'block';

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Check the value from the database
            $profile = $row['profile'];
            $codeSegment = $row['code_segment'];
            $oasisSegment = $row['oasis_segment'];
            $pocSegment = $row['poc_segment'];

            // Set display values based on the column values
            if ($profile == 'none') {
                $displayProfiles = 'none';
            }
            if ($codeSegment == 'none') {
                $displayCodeSegment = 'none';
            }
            if ($oasisSegment == 'none') {
                $displayOasisSegment = 'none';
            }
            if ($pocSegment == 'none') {
                $displayPocSegment = 'none';
            }
        }
    }

    ?>
    <style>
        #profiles {
            display: <?php echo $displayProfiles; ?>;
        }

        #code_segment {
            display: <?php echo $displayCodeSegment; ?>;
        }

        #oasis_segment {
            display: <?php echo $displayOasisSegment; ?>;
        }

        #poc_segment {
            display: <?php echo $displayPocSegment; ?>;
        }


        /* CSS to highlight empty fields */
        .empty-field {
            border: 1px solid red;
            /* Set a red border for empty fields */
        }

        /* CSS to highlight duplicate ICD IDs */
        .duplicate {
            background-color: #ffe6e6;
            /* Set a background color for fields with duplicate ICD IDs */
        }
    </style>
    <style>
        .custom-icon-class {
            font-size: 16px;
        }


        .table.table-no-border,
        .table.table-no-border>thead>tr>th,
        .table.table-no-border>tbody>tr>td,
        .table.table-no-border>tbody>tr>th,
        .table.table-no-border>tfoot>tr>td,
        .table.table-no-border>tfoot>tr>th,
        .table.table-no-border>thead>tr>td {
            border: none;
        }

        td label {
            display: flex;
            align-items: center;
        }

        td input[type="checkbox"] {
            margin-right: 5px;
        }

        /* Adjust text color to make it less prominent */


        .codesegement {
            overflow-x: auto;
            overflow-y: auto;
            max-height: 700px;
        }

        .scroller {
            overflow-x: auto;
            overflow-y: auto;
            max-height: 700px;
        }


        .Pocsegement {

            overflow-x: auto;
            overflow-y: auto;
            max-height: 500px;



        }
    </style>

    <?php
    $conn->close();
    ?>


</head>

<body>

    <div class="container-scroller">
        <?php
        include 'include_file/profile.php';
        ?>
        <div class="container-fluid page-body-wrapper">



            <?php
            // include 'include_file/sidebar.php'; // Use a relative path to include the file
            ?>

            <div class="content-wrapper mt-4">

                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-REHJTs1r2L/CfA6Rr+Oq83aIZlOFh9SBE1Q3L10VEMhNETIbb8F+8rVdUuBaa6S" crossorigin="anonymous">

                <nav class="navbar navbar-expand-lg navbar-white bg-white" style="border-radius:43px;">

                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ml-auto mt-3">
                         
                            <li class="nav-item">
                                <button class="btn btn-primary mr-4" onclick="window.open('<?php echo $url; ?>', '_blank')" title="Open a new tab for chart">
                                    <i class="fas fa-chart-line"></i> Patient Chart
                                </button>
                            </li>

                            <li class="nav-item">
                                <button class="btn btn-warning mr-4 break_btn" title="Break" id="break" value="<?php echo $Id; ?>">
                                    <i class="fas fa-bell"></i> Break
                                </button>
                            </li>
                               <li class="nav-item">
                                <button class="btn btn-danger mr-4 Pendwip_btn pendpoc_btn" id="Pendwip" title="Pendwip" value="<?php echo $Id; ?>">
                                    <!-- <i class="fas fa-exclamation-circle"></i>--> On Hold
                                </button>
                            </li>
                            <li class="nav-item">
                                <!-- <a href="assign_table.php?Id=<?php echo $Id; ?>" id="completedBtn"> -->
                                <button type="button" class="btn btn-info btn-fw mr-4 mb-3 completed" id="completed" value="<?php echo $Id; ?>">
                                    <i class="fas fa-check-circle"></i> Completed
                                </button> 
                            </li>
                            <li class="nav-item">
                                <button class="btn btn-secondary mr-4 Pending_btn" id="pending" title="Pending" data-toggle="modal" data-target="#exampleModal" value="<?php echo $Id; ?>">
                                    <i class="fas fa-exclamation-circle"></i> Pending
                                </button>
                            </li>
                             <li class="nav-item">
                                <button type="button" class="btn" data-toggle="modal" data-target="#exampleModalCenter" value="<?php echo $Id; ?>" style="background-color: #F58718;"><i class='fas fa-comment-alt'></i> Notes
                                 
                                 </button>
                                    <!-- <i class="fas fa-exclamation-circle"></i>-->
                                </button>
                            </li>
                        </ul>
                    </div>


                </nav>
                <br>


                <!-- Your existing code goes here -->

                <!-- Your other body elements go here -->



                <div class="row" id="profiles">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">


                            <h4 class="card-title d-inline m-3">Medical Profiles<button type="button" class="btn btn-success btn_save ml-auto m-3" style="float: right;">Save</button></h4>


                            <div class="card-body">



                                <br>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Patient Name</label>
                                            <div class="col-sm-9">
                                                <span id="lc" style="color:red"></span>
                                                <input type="text" class="form-control" id="Patientname" name="Patientname" placeholder="Patient Name" readonly value="<?php echo $patientName ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">
                                                <center>Insurance Type</center>
                                            </label>
                                            <div class="col-sm-9">
                                                <span id="pt" style="color:red"></span>
                                                <input class="form-control" placeholder="Insurance Type" id="number" name="number" readonly value="<?php echo  $insuranceType ?>" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">MRN</label>
                                            <div class="col-sm-9">
                                                <span id="lc" style="color:red"></span>
                                                <input type="text" class="form-control" id="mrn" name="mrn" placeholder="Mrn" readonly value="<?php echo  $mrn ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">
                                                <center>Agency</center>
                                            </label>
                                            <div class="col-sm-9">
                                                <span id="pt" style="color:red"></span>
                                                <input class="form-control" placeholder="Agency" id="agency" name="agency" readonly value="<?php echo  $agency ?>" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Assessment Date</label>
                                            <div class="col-sm-9">
                                                <span id="lc" style="color:red"></span>
                                                <input type="text" class="form-control" id="assdate" name="assdate" placeholder="Assessment Date" readonly value="<?php echo  $assessmentDate ?>" />
                                            </div>
                                        </div>
                                    </div>
                                 
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label"><center>Date Of Birth</center></label>
                                            <div class="col-sm-9">
                                                <span id="lc" style="color:red"></span>
                                                <input type="text" class="datepicker form-control " id="dob" name="dob" placeholder="MM/DD/YYYY" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                       <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">
                                               Assessment Type
                                            </label>
                                            <div class="col-sm-9">
                                                <span id="pt" style="color:red"></span>
                                                <input class="form-control" placeholder="Assessment Type" id="asstype" name="asstype" readonly value="<?php echo  $assessmentType ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">
                                                <center>Gender</center>
                                            </label>
                                            <div class="col-sm-9">
                                                <span id="pt" style="color:red"></span>
                                                <select class="form-control" id="gender" name="gender">
                                                    <option value="none ">None</option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                    <option value="other">Other</option>
                                                </select>
                                            </div>


                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <style>
                    .thead-dark {
                        position: sticky;
                        top: 0;
                        background-color: #343a40;
                        /* Adjust the background color as needed */
                        color: white;
                        /* Adjust the text color as needed */
                        z-index: 300;
                    }

                    .csd {
                        position: sticky;
                        top: 0;

                        color: white;
                        z-index: 500;
                    }
                </style>
                <div class="row" id="code_segment">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-head csd"><br>

                                <h4 class="card-title d-inline m-5">CODE Segment </h4>
                                <button type="button" id="btn_save" class="btn btn-success btn_save m-3" style="float: right;">Save</button>
                            </div>


                            <div class="card-body">
                                <div class="container-fluid codesegement" style="background: white;">



                                    <br>
                                    <div class="form-group text-center codePart">
                                        <form name="" id="add_name">

                                            <style>
                                                .ui- datepicker-calendar {
                                                    position: absolute;
                                                    /* top: calc(100% + 10px); */
                                                    /* Adjust this value as needed */
                                                    left: 50%;
                                                    transform: translateX(-50%);
                                                    z-index: 999;
                                                    background-color: white;
                                                    border: 1px solid #ccc;
                                                    padding: 10px;
                                                    /* display: block; */
                                                    overflow: visible;
                                                }
                                            </style>

                                            <table class="table table-hover table-no-border mx-auto haeders_2 sortable-ul" id="dynamic_field">
                                                <thead class="thead-dark firstable">
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>M-Items</th>
                                                        <th>ICD-10-code </th>
                                                        <th>Description</th>
                                                        <th>Effective Date</th>
                                                        <th>E/O</th>
                                                        <th>Rating</th>

                                                    </tr>
                                                </thead>
                                                <tbody>


                                                    <tr>
                                                        <td><span>1</span></td>
                                                        <td hidden><input type="text" name="EntryId" id="entryId" value="<?php echo $Id ?>" class="form-control name_list input-lg" /></td>
                                                        <td><input type="text" name="mitems" id="mitems" value="M1021" class="form-control name_list input-lg" readonly /></td>
                                                        <td><input name="icd" id="icd" class="form-control name_email input-lg " autocomplete="off"></td>
                                                        <td><input type="text" name="description" id="description" value="" class="form-control total_amount input-lg description" readonly />
                                                        </td>
                                                        <td><input type="text" name="effectivedate" id="effectivedate" value="" autocomplete="off" class=" datepicker form-control total_amount input-lg " /></td>
                                                        <td>
                                                            <select name="eo" class="form-control total_amount input-lg" id="eo">
                                                                <option value="None">None</option>
                                                                <option value="E">E</option>
                                                                <option value="O">O</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="rating" class="form-control total_amount input-lg" id="rating">
                                                                <option value="None">None</option>
                                                                <option value="0">0</option>
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>

                                                            </select>
                                                        </td>
                                                        <!-- <td><input type="text" name="alert" id="alert" value="" class="form-control total_amount input-lg" /></td> -->
                                                    </tr>

                                                </tbody>
                                            </table>
                                            <br>


                                        </form>
                                    </div>

                                </div>

                            </div>
                            <div class="card-footer" style="background: white;border-radius: 10px;">

                                <button type="button" name="add" id="add" class="btn btn-primary btn-sm add">Add
                                    More</button>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="row" id="oasis_segment">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">


                            <div class="card-body">


                                <div class="container-fluid" style="background: white;">
                                    <br>
                                    <h4 class="card-title d-inline">OASIS Segment </h4><br> <button type="button" id="btn_save_oasis" class="btn btn-success btn_save_oasis .btn-icon-prepend submit ml-2 mb-3" name="submit" value="submit" style="float: right;">Save</button> <br><br>
                                    <table class="table table-hover table-no-border mx-auto" id="headers">
                                        <thead class="thead-dark firstable">
                                            <tr>
                                                <!-- <th>M-Items</th>   -->
                                                <th style="text-align: center;">Agency Response</th>

                                                <th style="text-align: center;">Coder Response</th>

                                                <th style="text-align: center;">Coder Rationali</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>


                                    <br>

                                    <div class="row g-3" id="carouselRow">
                                        <input type="hidden" name="EntryIdoasis" id="entryIdoasis" value="<?php echo $Id ?>" class="form-control name_list input-lg entryIdoasis" />
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="row" id="poc_segment">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">


                            <div class="card-body">


                                <div class="container-fluid" style="background: white;">
                                    <br>
                                    <h4 class="card-title d-inline">POC Segment </h4><br> <button type="button" id="btn_save_poc" class="btn btn-success btn_save_poc .btn-icon-prepend submit ml-2 mb-3" name="submit" value="submit" style="float: right;">Save</button><br><br>
                                    <table class="table table-hover table-no-border mx-auto" id="headers">
                                        <thead class="thead-dark firstable">
                                            <tr>

                                                <th style="text-align: center;">Coder Response</th>


                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>


                                    <br>

                                    <div class="row g-3" id="pocsegementRow">
                                        <input hidden type="text" name="poc" id="poc" value="<?php echo $Id ?>" class="form-control name_list input-lg" />
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    </div>

    </div>
    </div>

    </div>


    <!-- Pending Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="commentModalLabel">File Pending State</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                </div>
                <div class="modal-body" id="modal-body">
                    <h5 class="modal-title" id="commentModalLabel">Pending Reason</h5><br>
                    <select id="commentType" class="form-control">
                        <div id="result">
                            <option value="">Select</option>
                        </div>
                      
                    </select>   <br><br>
                    <h5 class="modal-title" id="commentModalLabel">Pending Comment</h5>
                    <textarea id="commentText" class="form-control mt-2" placeholder="Enter your comment" style="width: 100%; height: 300px;"></textarea>
                 
                    
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                    <button type="button" class="btn btn-primary" id="submitComment">Submit</button>
                </div>
            </div>
        </div>
    </div>

        <!--Notes Modal -->
   <!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Notes to agency</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h5 class="modal-title" id="commentModalLabel">Notes</h5>
                    <textarea id="commentTextnotes" class="form-control mt-2" placeholder="Enter your comment" style="width: 100%; height: 300px;"></textarea>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
    <?php
    include 'comments.php';
    ?>

    <?php
    include 'include_file/pulg.php';
    ?>

    <script src="js/template.js"></script>
    <!-- SCRIPT -->
    <script src="Assign/js/insertcodesegement.js"></script>
    <script src="Assign/js/codedescription.js"></script>
    <!-- <script src="Assign/js/oasissegement.js"></script> -->
    <script src="Assign/js/oasis.js"></script>
    <script src="Assign/js/completed.js"></script>
    <script src="Assign/js/break.js"></script>
    <script src="Assign/js/pending.js"></script>
    <script src="Assign/js/poc.js"></script>
    <script src="Assign/js/pendingreason.js"></script>
    <script src="PendingWip/js/pendingwip.js"></script>
    <script>
        // Function to be executed after a delay
        function loadPendingDataDelayed() {
            setTimeout(function() {
                // Load the script dynamically after a delay of 2000 milliseconds (2 seconds)
                var script = document.createElement('script');
                script.src = 'PendingWip/js/oasispedingdata.js';
                document.body.appendChild(script);
            }, 2000); // Change this value to set the desired delay in milliseconds
        }

        // Attach loadPendingDataDelayed function to window.onload event
        window.onload = loadPendingDataDelayed;
    </script>

    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.4/xlsx.full.min.js"></script>
    <!-- <link href="select2-4.1.0-rc.0/select2-4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->

    <!-- <script src="js/select2.js"></script>  
<script src="select2-4.1.0-rc.0/select2-4.1.0-rc.0/dist/js/select2.js"></script> -->


    <!--  <script src="vendors/select2/select2.min.js"></script>
        <script src="js/select2.js"></script> -->


</body>

</html>



 <script>
$(function () {
        // Get today's date
        var today = new Date();
        // alert(today);

        // Set datepicker with maxDate as today
        $(".datepickers").datepicker({
          maxDate: today,
          dateFormat: "mm/dd/yy", // Set the desired date format
          onSelect: function (dateText) {
           $(this).val(dateText); // Remove slashes when selecting the date
          },
        });

        // Automatically insert slashes while typing
        $(".datepickersz").on("keyup", function () {
          var val = $(this).val().replace(/\D/g, "");
          if (val.length > 2) {
            $(this).val(
              val.slice(0, 2) + "/" + val.slice(2, 4) + "/" + val.slice(4, 8)
            );
          } else if (val.length > 0) {
            $(this).val(
              val.slice(0, 2) + (val.length > 2 ? "/" + val.slice(2, 4) : "")
            );
          }
        });
      })
</script>


<script>
    //=============================================  ONLY drag THE VALUES =====================================   
    document.ondragstart = function(event) {
        event.dataTransfer.setData("fromId", event.target.id);
    };

    document.ondrag = function(event) {

    };

    /* Events fired on the drop target */
    document.ondragover = function(event) {
        event.preventDefault();
    };




    // function drop(ev, target) {
    //  ev.preventDefault();
    //     const fromId = ev.dataTransfer.getData("fromId")
    //     const toId = target.id
    //     const targetInput = document.getElementById(toId)
    //     console.log(toId)

    //     const fromValue = document.getElementById(fromId)
    //     targetInput.value = fromValue.value

    //     fromValue.value = ""
    //     targetInput.dispatchEvent(new Event('change', { 'bubbles': true }));
    //     fromValue.dispatchEvent(new Event('change', { 'bubbles': true }));
    // }

    //============================================= ONLY drag THE VALUES=====================================

    //============================================= values drag and swping =====================================
    function drop(ev, target) {
        ev.preventDefault();
        const fromId = ev.dataTransfer.getData("fromId")
        const toId = target.id
        const targetInput = document.getElementById(toId)
        const ext = targetInput.value
        console.log(toId)

        const fromValue = document.getElementById(fromId)
        targetInput.value = fromValue.value

        fromValue.value = ext
        targetInput.dispatchEvent(new Event('change', {
            'bubbles': true
        }));
        fromValue.dispatchEvent(new Event('change', {
            'bubbles': true
        }));
    }

    //============================================= values drag and swping =====================================
</script>





<script>
    $(function() {
        $('tr').each(function(index) {
            $(this).find('.sortable-ul').attr('id', 'sortable-' + index).sortable();
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Open the modal when the button is clicked
        $('#Notesmodal').on('click', function(e) {
            e.preventDefault();
            $('.ModalLabel').modal('show');
        });

    });

</script>

<script src="no_back.js"></script>