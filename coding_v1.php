<?php
 include('db/db-con.php');
 header('Cache-Control: no-cache');
 
$randomNumber = rand(1000, 9999);

// $randomString = (string) $randomNumber;

include 'login_sessions/user_session.php';
session_start();
$Id = '';
$role = $_SESSION['role'];
$emp_id = $_SESSION['empid'];
$Id = $_COOKIE['Id'];


 
// $agency = $_SESSION['agent'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    
    <!-- //displaydataininput// -->

    <?php
    include('Assign/display_data.php');
    ?>
    
    <?php
    include 'include_file/link.php';
    ?>

    <?php
     include('db/db-con.php');

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

.resizable-textarea {
  resize: both; /* Enables vertical and horizontal resizing */
  overflow: auto; /* Adds a scrollbar when content overflows */
  min-height: 100px; /* Minimum height of the textarea */
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

        .datetimepicker-input {
            width: 10%;
            /* Modify the width as needed */
        }
    </style>

    <?php
    $conn->close();
    ?>


</head>

<style>
    ul {
        position: relative;
        display: flex;
        gap: 25px;
    }

    ul li {
        position: relative;
        list-style: none;
        width: 60px;
        height: 60px;
        background: #e0e0e0;
        border-radius: 60px;
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
        /* box-shadow: 20px 20px 51px #a4a4a4,
             -20px -20px 51px #ffffff; */
        transition: 0.5s;
    }

    ul li:hover {
        width: 180px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0);
    }

    ul li::before {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: 60px;
        background: linear-gradient(45deg, var(--i), var(--j));
        opacity: 0;
        transition: 0.5s;
    }

    ul li:hover::before {
        opacity: 1;
    }

    ul li::after {
        content: "";
        position: absolute;
        top: 10px;
        width: 100%;
        height: 100%;
        border-radius: 60px;
        background: linear-gradient(45deg, var(--i), var(--j));
        transition: 0.5s;
        filter: blur(15px);
        z-index: -1;
        opacity: 0;
    }

    ul li:hover::after {
        opacity: 0.5;
    }

    ul li .icon {
        color: #777;
        font-size: 1.75em;
        transition: 0.5s;
        transition-delay: 0.25s;
    }

    ul li:hover .icon {
        transform: scale(0);
        color: #fff;
        transition-delay: 0s;
    }

    ul li span {
        position: absolute;
    }

    ul li .title {
        color: #fff;
        font-size: 1.1em;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        transform: scale(0);
        transition: 0.5s;
        transition-delay: 0s;
    }

    ul li:hover .title {
        transform: scale(1);
        transition-delay: 0.25s;
    }

    /* Save Button */
    .save_button {
        padding: 12px 32px;
        border-radius: 10px;
        border: 3px black solid;
        box-shadow: 2px 2px 1px;
        font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
        font-weight: 700;
        font-size: 17px;
        background-color: #01aaba68;
        overflow: hidden;
        position: relative;
        z-index: 10;
    }

    .save_button::after {
        content: "";
        position: absolute;
        background-color: #199fab;
        width: 0px;
        height: 0px;
        border-radius: 50%;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        transition: all .3s ease-in;
        z-index: -1;
    }

    .save_button:hover::after {
        transform-origin: center;
        transition: all .3s ease-in;
        width: 200px;
        height: 200px;
    }


    /* Add more button */
    .add {
        --main-focus: #2d8cf0;
        --font-color: #dedede;
        --bg-color-sub: #222;
        --bg-color: #4B49AC;
        --main-color: #dedede;
        position: relative;
        width: 150px;
        height: 40px;
        cursor: pointer;
        display: flex;
        align-items: center;
        border: 2px solid var(--main-color);
        box-shadow: 4px 4px var(--main-color);
        background-color: var(--bg-color);
        border-radius: 10px;
        overflow: hidden;
    }

    #4B49AC .add,
    .button__icon,
    .button__text {
        transition: all 0.3s;
    }

    .add .button__text {
        transform: translateX(25px);
        color: var(--font-color);
        font-weight: 600;
    }

    .add .button__icon {
        position: absolute;
        transform: translateX(109px);
        height: 100%;
        width: 39px;
        background-color: #7977cf;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .add .svg {
        width: 20px;
        stroke: var(--main-color);
    }

    .add:hover {
        background: var(--bg-color);
    }

    .add:hover .button__text {
        color: transparent;
    }

    .add:hover .button__icon {
        width: 148px;
        transform: translateX(0);
    }

    .add:active {
        transform: translate(3px, 3px);
        box-shadow: 0px 0px var(--main-color);
    }

    .option {
        margin-top: 61px;
        box-shadow: inset 20px 20px 60px #bebebe,
            inset -20px -20px 60px #ffffff;
    }


/*    .newstyle{

        background-color: #007bff; /* Change background color */
        color: #fff; /* Change text color */


    }*/


</style>



<style >/* The switch - the box around the slider */
/* The switch - the box around the slider */
.switch {
  font-size: 17px;
  position: relative;
  display: inline-block;
  width: 1.2em;
  height: 2.4em;
}

/* Hide default HTML checkbox */
.switch .chk {
  opacity: 1;
  width: 12px;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color:red;
  transition: .15s;
  border-radius:5px;
}

.slider:before {
  position: absolute;
  content: "";
  height: .6em;
  width: 2.4em;
  border-radius: 3px;
  left: -0.6em;
  top: 0.2em;
  background-color:white;
  box-shadow: 0 8px 4px rgba(0,0,0,0.3);
  transition: .5s;
}

.slider:before, .slider:after {
  content: "";
  display: block;
}

.slider:after {
  background: linear-gradient(transparent 50%, rgba(255, 255, 255, 0.15) 0) 0 50% / 50% 100%,
        repeating-linear-gradient(90deg,rgb(255, 255, 255) 0,rgb(255, 255, 255),rgb(255, 255, 255) 20%,rgb(255, 255, 255) 20%,rgb(255, 255, 255) 40%) 0 50% / 50% 100%,
        radial-gradient(circle at 50% 50%,rgb(255, 255, 255) 25%, transparent 26%);
  background-repeat: no-repeat;
  border: 0.25em solid transparent;
  border-left: 0.4em solid #ffffff;
  border-right: 0 solid transparent;
  transition: border-left-color 0.1s 0.3s ease-out, transform 0.3s ease-out;
  transform: translateX(-22.5%) rotate(90deg);
  transform-origin: 25% 50%;
  position: relative;
  top: 0.5em;
  left: 0.55em;
  width: 2em;
  height: 1em;
  box-sizing: border-box;
}

.chk:checked + .slider {
  background-color: limegreen;
}

.chk:focus + .slider {
  box-shadow: 0 0 1px limegreen;
}

.chk:checked + .slider:before {
  transform: translateY(2.3em);
}

.chk:checked + .slider:after {
  transform: rotateZ(90deg) rotateY(180deg) translateY(0.45em) translateX(-1.4em);
}

   #completed{

        display: none;
    }
</style>

 

<body>











    <div class="container-scroller">
        <?php
        include 'include_file/profile.php';
        ?>
        <div class="container-fluid page-body-wrapper">



            <?php
            // include 'include_file/sidebar.php'; // Use a relative path to include the file
            ?>

            <div class="content-wrapper ">

                <!-- <nav class="navbar navbar-expand-lg "> -->


                <div class="container-fluid justify-content-center bg-white fixed-top option">
                    <div class="row mt-3">

                        <div class="col-md-12 text-center">
                            <!-- <ul class="d-inline-block mr-3" onclick="window.open('<?php echo $urls; ?>', '_blank')">
                                <li style="--i:#56CCF2;--j:#2F80ED;">
                                    <span class="icon">📃</span>
                                    <span class="title">Patient Chart </span>
                                </li>
                            </ul> -->
                             <!--<ul class="d-inline-block mr-3" id="Patientchart">
                                <li style="--i:#56CCF2;--j:#2F80ED;">
                                    <span class="icon">📁</span> 
                                    <span class="icon"> <img src="Patient-Chart.png" style="height: 35px;"></span>

                                </li>
                            </ul> -->
                            <ul class="d-inline-block mr-3" onclick="openMultipleURLs()">
                                    <li style="--i:#56CCF2;--j:#2F80ED;">
                                        <!-- <span class="icon">📁</span> -->
                                        <span class="icon"> <img src="Patient-Chart.png" style="height: 35px;"></span>
                                        <span class="title">Patient Chart </span>
                                    </li>
                            </ul>


        


                           
                         <ul class="d-inline-block mr-3 break_btn" id="break" value="<?php echo $Id; ?>">
                                <li style="--i:#56CCF2;--j:#2F80ED;">
                                    <span class="icon">⏰</span>
                                    <span class="title">Break</span>
                                </li>
                            </ul>
                             <ul class="d-inline-block mr-3  " id="clk-wip" value=" ">
                                <li style="--i:#56CCF2;--j:#2F80ED;">
                                   <span class="icon"> </span> 
                                    <span class="icon"><img src="hold.png" /> </span>
                                    <span class="title">Pause</span>
                                </li>
                            </ul>  
                        <ul class="d-inline-block mr-3 completed " id="completed" value="<?php echo $Id; ?>">
                                <li id="cmd" style="--i:#56CCF2;--j:#2F80ED;">
                                     <!-- <span class="icon">✅</span>  -->
                                    <span class="icon"> <img src="completed.png"   style="height: 35px;"></span>
                                    <span class="title">Chart for QA</span>
                                </li>
                            </ul> 
                            <ul class="d-inline-block mr-3 preview" id="preview" value="<?php echo $Id; ?>">
                                <li style="--i:#56CCF2;--j:#2F80ED;">
                                    <span class="icon"> <img src="preview-file.png" style="height: 35px;"></span>
                                    <span class="title">Preview</span>
                                </li>
                            </ul>
                            <ul class="d-inline-block mr-3 Pending_btn" id="pending" title="Pending" data-toggle="modal" data-target="#exampleModal" value="<?php echo $Id; ?>">
                                <li style="--i:#56CCF2;--j:#2F80ED;">
                                    <span class="icon">🛑</span>
                                    <span class="title">Pending</span>
                                </li>
                            </ul>
                            <ul class="d-inline-block mr-3" data-toggle="modal" data-target="#exampleModalCenter">
                                <li style="--i:#56CCF2;--j:#2F80ED;">
                                    <span class="icon">📝</span>
                                    <span class="title">Notes</span>
                                </li>
                            </ul>
                            <ul class="d-inline-block mr-3 hhrgpreview" id="hhrgpreview" value="<?php echo $Id; ?>">   
                                <li style="--i:#56CCF2;--j:#2F80ED;">
                                    <span class="icon"> <img src="gifs/preview.png" style="height: 35px;"></span>
                                    <span class="title">HHRG Preview</span>
                                </li>
                            </ul>
                          <ul class="d-inline-block mr-3 QCcompleted " id="QCcompleted" value="<?php echo $Id; ?>">
                                <li id="qccmd" style="--i:#56CCF2;--j:#2F80ED;">
                                     <span class="icon">✅</span> 
                                    <!-- <span class="icon"> <img src="completed.png"   style="height: 35px;"></span> -->
                                    <span class="title">Submit</span>
                                </li>
                            </ul> 

                        
                                         <div class="float-right">
                                             <h3>Working Hours</h3>
                                            <p id="timerDisplay">00:00:00</p>
                                            </div>  
                                                                    </div>

                                                                </div>
                                                            </div>


                                                             </nav>  

                                            <style>
                                                #timerDisplay {
                                                    font-size: 24px;
                                                    font-weight: bold;
                                                    text-align: center;
                                                    padding: 5px;
                                                    background-color: white;
                                                    border: 2px solid #ccc;
                                                    border-radius: 10px;
                                                    width: 150px;
                                                    margin: 0 auto;
                                                }
                                            </style>  


                <br>
                 <br>
                  <br>

                <!-- Your other body elements go here -->



                <div class="row mt-5" id="profiles">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">

                
                            <h4 class="card-title d-inline m-3">Medical Profiles
                                <!-- <button type="button" class="btn btn-success btn_save ml-auto m-3" style="float: right;">Save</button> -->

                                <!-- The JavaScript file responsible for Upadte medical profiles is named 'Assign/Js/comments.js'.  -->
                                <button class="save_button btn_save ml-auto m-3" type="button" id="medical_profile_update" style="float: right;">
                                    <span>Save</span>
                                </button>
                               <input type="text" name="medicalid" id="medicalid" value="<?php echo $Id ?>" class="form-control name_list input-lg" hidden/>
                            </h4>
         
                            <div class="card-body">



                                <br>


 
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Patient Name</label>
                                            <div class="col-sm-9">
                                                <span id="lc" style="color:red"></span>
                                                <input type="text" class="form-control" id="Patientname" name="Patientname" placeholder="Patient Name" value="<?php echo $patientName ?>"   />
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
                                                <input class="form-control" placeholder="Insurance Type" id="InsuranceType" name="Insurance Type" value="<?php echo  $insuranceType ?>"   />
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
                                                <input type="text" class="form-control" id="mrn" name="mrn" placeholder="Mrn" value="<?php echo  $mrn ?>"   />
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
                                                <input class="form-control" placeholder="Agency" id="agency" name="agency" value="<?php echo  $gency ?>"   />
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
                                                <input type="text" class="form-control" id="assdate" name="assdate" placeholder="Assessment Date" value="<?php echo  $assessmentDate ?>"   />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">
                                                <center>Date Of Birth</center>
                                            </label>
                                            <div class="col-sm-9">
                                                <span id="lc" style="color:red"></span>
                                                <input type="text" class="form-control datepickersz" id="datepicker" name="dob" value="<?php echo  $dob ?>"  />
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
                                                <input class="form-control" placeholder="Assessment Type" id="asstype" name="asstype" value="<?php echo  $assessmentType ?>"   />
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
                                 <option value="">Select</option>

                                <option value="male" <?php echo ($gender == 'male') ? 'selected' : ''; ?>>Male</option>
                                <option value="female" <?php echo ($gender == 'female') ? 'selected' : ''; ?>>Female</option>
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
                        /* z-index: 300; */
                    }

                    .csd {
                        position: sticky;
                        top: 0;

                        color: white;
                        /* z-index: 500; */
                    }
 
         </style>

                            <!-- Ryi -->
                             <div class="row" id="">
                                <?php
                                    // Get the value of $Id from the cookie
                                    $Id = $_COOKIE['Id']; // Assuming the cookie name is 'Id'

                                    // Include the file
                                    include "ryi.php";
                                ?>  
                            </div>

                              <div class="row" id="sixty">
                    
                    <div class="col-12 grid-margin stretch-card">

                        <div class="card">
                            <!-- <p class=" my-2" style="color:#3fa93f;margin-left:90%;font-size:15px;  -webkit-text-stroke-width: medium; " hidden>Code Segement Saved </p> -->
                            <div class="card-head csd"><br>

                         <center>

                                   <h4 class="card-title d-inline m-5">Segment</h4>    <div class="ml-5  " style="margin-top: -29px; margin-right: -144px;">

                                       <label class="switch">
                                     <input type="checkbox" class="chk  ">
                                     <span class="slider" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" id="toggleButton5" title="Expand-Code"  ></span>
                                   </label> </div>  </center>
                                </button>
                                <!-- <button type="button" id="btn_save" class="btn btn-success btn_save m-3" style="float: right;">Save</button> -->
                            </div>
                            <div class="collapse" id="myCollapsible5">


                                <div class="card-body">
                                    <div class="container-fluid codesegement" style="background: white;">

  <?php include('form_wizard.php')?>

                                        <br>
                                        <div class="form-group text-center codePart">
 
                                            </form>
                                        </div>

                                    </div>

                                </div>
                                <div class="card-footer d-flex" style="background: white; border-radius: 10px;">

                               
                                    <!-- Save Button -->
                                    

                                </div>
                            </div>


                        </div>
                    </div>
                </div>

                <br>
                <br>


































             
                <div class="row" id="code_segment">
                    
                    <div class="col-12 grid-margin stretch-card">

                        <div class="card">
                            <p class="saved-codesegement my-2" style="color:#3fa93f;margin-left:90%;font-size:15px;  -webkit-text-stroke-width: medium; " hidden>Code Segement Saved </p>
                            <div class="card-head csd"><br>

                         <center>

                                   <h4 class="card-title d-inline m-5">Code Segment </h4>    <div class="ml-5  " style="margin-top: -29px; margin-right: -144px;">

                                       <label class="switch">
                                     <input type="checkbox" class="chk  ">
                                     <span class="slider" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" id="toggleButton" title="Expand-Code"  ></span>
                                   </label> </div>  </center>
                                </button>
                                <!-- <button type="button" id="btn_save" class="btn btn-success btn_save m-3" style="float: right;">Save</button> -->
                            </div>
                            <div class="collapse" id="myCollapsible">


                                <div class="card-body">
                                    <div class="container-fluid codesegement" style="background: white;">



                                        <br>
                                        <div class="form-group text-center codePart">

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

                                                     /* CSS */
                                                    .input-active {
                                                        border: 2px solid blue; /* Change the border color to blue */
                                                        border-radius: 5px; /* Add some border radius for rounded corners */
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
                                                            <th>Coder <br><br><input type="checkbox" class="coderselectall" id="coderselectall"></th>
                                                            <th>Agency<br><br><input type="checkbox" class="agencyselectall" id="agencyselectall"></th>
                                                            <th>Primary Agency <br><br></th>
                                                            <th>Action</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>


                                                        <!-- <tr> -->
                                                        <!-- <td><span>1</span></td> -->
                                                        <td hidden style="width:50px"><input type="text" name="EntryId" id="entryId" value="<?php echo $Id ?>" class="form-control name_list input-lg" /></td>
                                                        <!-- <td><input type="text" name="mitems" id="mitems" value="M1021" class="form-control name_list input-lg" /></td>
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
                                                        </td> -->
                                                        <!-- <td><input type="text" name="alert" id="alert" value="" class="form-control total_amount input-lg" /></td> -->
                                                        <!-- </tr> -->

                                                    </tbody>
                                                </table>
                                                <br>


                                            </form>
                                        </div>

                                    </div>

                                </div>
                                <div class="card-footer d-flex" style="background: white; border-radius: 10px;">

                                    <button type="button" class="button add" name="add" id="add">
                                        <span class="button__text">Add More</span>
                                        <span class="button__icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" stroke-width="2" stroke-linejoin="round" stroke-linecap="round" stroke="currentColor" height="24" fill="none" class="svg">
                                                <line y2="19" y1="5" x2="12" x1="12"></line>
                                                <line y2="12" y1="12" x2="19" x1="5"></line>
                                            </svg>
                                        </span>
                                    </button>

                                    <!-- Save Button -->
                                    <button class="save_button btn_save ml-auto m-3" id="btn_save" type="button"   style="float: right;">
                                        <span>Save</span>
                                    </button>

                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="row" id="oasis_segment">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">   <p class="saved-oasissegement my-2" style="color:#3fa93f;margin-left:90%;font-size:15px;  -webkit-text-stroke-width: medium; " hidden>OASIS Segement Saved AND HHRG Segement Saved </p>
                            <div class="card-head csd"><br>
                             
                               <center>  
                                    <h4 class="card-title d-inline m-5">OASIS Segment  </h4>   <div class="ml-5  " style="margin-top: -29px; margin-right: -144px;">

                                       <label class="switch">
                                     <input type="checkbox" class="chk  ">
                                     <span class="slider" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" id="toggleButton2" title="Expand-OASIS"  ></span>
                                   </label> </div></center>
                                 
                            </div>

                            <div class="collapse" id="myCollapsible2">


                                <div class="card-body">


                                    <div class="container-fluid" style="background: white;">
                                        <br>
                                        <!-- <button type="button" id="btn_save_oasis" class="btn btn-success btn_save_oasis .btn-icon-prepend submit ml-2 mb-3" name="submit" value="submit" style="float: right;">Save</button> <br><br> -->
                                        <table class="table table-hover table-no-border mx-auto" id="headers">
                                            <thead class="thead-dark firstable">
                                                <tr>
                                                    <!-- <th>M-Items</th>   -->
                                                    <th style="text-align: center;">Agency Response</th>

                                                    <th style="text-align:  ;">Coder Response</th>

                                                    <th style="text-align:  ;">Coder Rationale</th>
                                                    <th > </th>
                                                    

                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>


                                        <br> 

                                        <div class="row g-3" id="carouselRow">
                                            <input type="hidden" name="EntryIdoasis" id="entryIdoasis" value="<?php echo $Id ?>" class="form-control name_list input-lg entryIdoasis" />

                                          
                                        </div>
                                        <div id="inputContainer"></div>

                                        <div class="mt-4">

                                            <button class="save_button  btn_save_oasis .btn-icon-prepend submit ml-2 mb-3" type="button" id="btn_save_oasis" style="float: right;" name="submit" value="submit">
                                                <span>Save</span>
                                            </button>
                                        </div>




                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                </div>

                <div class="row " id="ggmitem_segment">
                    <div class="col-12 grid-margin ">
                        <div class="card">   <p class="saved-ggmitem my-2" style="color:#3fa93f;margin-left:90%;font-size:15px;  -webkit-text-stroke-width: medium; " hidden>GG-Mitems Saved </p>
                            <div class="card-head csd"><br>
                             
                               <center>  
                                    <h4 class="card-title d-inline m-5">GG-Mitems </h4>   <div class="ml-5  " style="margin-top: -29px; margin-right: -144px;">

                                       <label class="switch">
                                     <input type="checkbox" class="chk  ">
                                     <span class="slider" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" id="toggleButton4" title="Expand-GG-Mitem"  ></span>
                                   </label> </div></center>
                                 
                            </div>

                            <div class="collapse" id="myCollapsible4">


                                <div class="card-body">


                                    <div class="container-fluid" style="background: white;">
                                        <br>
                                
                                        <table class="table table-hover table-no-border mx-auto" id="headers">
                                            <thead class="thead-dark firstable">
                                                <tr>
                                            
                                                    <th style="text-align: center;">Agency Response</th>

                                                    <th style="text-align:  ;">Coder Response</th>

                                                    <th style="text-align:  ;">Coder Rationale</th>
                                                    <th > </th>
                                                    

                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>


                                        <br> 

                                        <div class="row g-3 stretch-card scroller position-relative" id="gg-mitems">
                                            <input type="hidden" name="entryIdggmitem" id="entryIdggmitem" value="<?php echo $Id ?>" class="form-control name_list input-lg entryIdggmitem" />

                                          
                                        </div>
                                        <div id="inputContainer"></div>

                                        <div class="mt-4">

                                            <button class="save_button  btn_save_oasis .btn-icon-prepend submit ml-2 mb-3" type="button" id="btn_save_oasis" style="float: right;" name="submit" value="submit">
                                                <span>Save</span>
                                            </button>
                                        </div>




                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                </div>


                <div class="row" id="poc_segment">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">  
                            <p class="saved-pocsegement my-2" style="color: #3fa93f;margin-left: 91%;font-size: 15px;-webkit-text-stroke-width: medium;" hidden>POC Segement Saved </p>
                            <div class="card-head csd"><br>
                              
                                <center> 
                                    <h4 class="card-title d-inline m-5">POC Segment </h4>   <div class="ml-5  " style="margin-top: -29px; margin-right: -144px;">

                                       <label class="switch">
                                     <input type="checkbox" class="chk">
                                     <span class="slider" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" id="toggleButton3" title="Expand-POC"></span>
                                   </label> </div></center>
                                
                            </div>

                            <div class="collapse" id="myCollapsible3">
                                <div class="card-body">


                                    <div class="container-fluid" style="background: white;">
                                        <br>
                                        <!-- <button type="button" id="btn_save_poc" class="btn btn-success btn_save_poc .btn-icon-prepend submit ml-2 mb-3" name="submit" value="submit" style="float: right;">Save</button><br><br> -->
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
                                            <input hidden type="text" name="wipdata" id="wipdata" value="<?php echo $Id ?>" class="form-control name_list input-lg" />



                                        </div>
                                        <div class="mt-4">
                                            <button class="save_button  btn_save_poc .btn-icon-prepend submit ml-2 mb-3" name="submit" value="submit" style="float: right;" type="button" id="btn_save_poc">
                                                <span>Save</span>
                                            </button>
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

                    </select> <br><br>
                    <h5 class="modal-title" id="commentModalLabel">Pending Comment</h5>
                    <textarea id="commentText" class="form-control mt-2" placeholder="Enter your comment" style="width: 100%; height: 300px;"></textarea>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="submitComment">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!--Notes Modal -->
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
                    <input hidden type="text" name="chart_id" id="chart_id" value="<?php echo $Id ?>" class="form-control name_list input-lg" />

                    <textarea id="commentTextnotes" class="form-control mt-2" placeholder="Enter your comment" style="width: 100%; height: 300px;"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" id="notes" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <?php
    include 'comments.php';
    ?>


    <!-- <script>
        
        $(document).ready(function(){
        $("#notification").on("click",function(){
            $(".notifications").css("display", "none");
            alert("Notification Hidden");
        });
    });
    </script> -->

 
    <?php
    include 'include_file/pulg.php';
    ?>
<?php
 $randomNumber=rand(0000,9999);

?>
    <script src="js/template.js"></script>
     <script src="ggmitem/js/ggmitem.js?<?php echo $randomNumber ?>"></script>
     <script src="Ryi_v2/js/ryi_v3.js?<?php echo $randomNumber ?>"></script>
     <!-- <script src="Ryi/js/ryi_new.js"></script> -->

    <!-- SCRIPT -->
    <script src="Assign/js/insertcodesegement_v3.js?<?php echo $randomNumber ?>"></script>
      <script src="Assign/js/form_wizard.js?<?php echo $randomNumber ?>"></script>
    <script src="Assign/js/codedescription.js"></script>
    <!-- <script src="Assign/js/oasissegement.js"></script> -->
    <script src="Assign/js/oasis.js"></script>
    <script src="Assign/js/wip_manuel.js"></script>
    <script src="Assign/js/completed.js"></script>
    <script src="Assign/js/break.js"></script>
    <script src="Assign/js/pending.js"></script>
    <script src="Assign/js/poc.js"></script>
    <script src="Assign/js/pendingreason.js"></script>
    <script src="PendingWip/js/pendingwip.js"></script>
    <script src="Assign/js/notes_to_agency.js"></script>
    <script src="Assign/js/preview.js"></script>
    <script src="Assign/js/qc_coding_complete.js"></script>
    <script src="Assign/js/penddisplaydata.js"></script>
    <script src="Assign/js/wipdisplaydata.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.4/xlsx.full.min.js"></script>

</body>

</html>
<!--     <script>
        window.onbeforeunload = function() {

          $('#btn_save').click();
          $('#btn_save_oasis').click();
          $('#btn_save_poc').click();

    return "Are You Sure To Reload";


        }
    </script> -->

<!-- <script>
    // Function to execute when the page is refreshed automatically
    function executeOnAutomaticRefresh() {
        // Your actions to be performed on automatic refresh
        $('#btn_save').click();
        $('#btn_save_oasis').click();
        $('#btn_save_poc').click();
        $('#saveComments').click();
    }

    // Event listener for beforeunload event
    window.addEventListener('beforeunload', function(event) {
        // Check if the page is being refreshed automatically
        if (performance.navigation.type === 1) {
            // Page is refreshed automatically
            executeOnAutomaticRefresh();
        }
    });
</script> -->

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

     const codeSegmentForm = (e) => {
        e.preventDefault()
        console.log(e)
      }

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




 

    //============================================= ONLY drag THE VALUES=====================================

     
  

    //============================================= values drag and swping =====================================
</script>




<script>
    $(function() {
        $('tr').each(function(index) {
            $(this).find('.sortable-ul').attr('id', 'sortable-' + index).sortable();
        });
    });
</script>

<!-- //Notes to modal -->

<script>
    $(document).ready(function() {
        // Open the modal when the button is clicked
        $('#Notesmodal').on('click', function(e) {
            e.preventDefault();
            $('.ModalLabel').modal('show');
        });

    });
</script>

<!-- datepicker -->
<script>
    $(function() {
        var today = new Date();
        $("#datepicker").datepicker({
            maxDate: today,
            dateFormat: 'mm/dd/yy', // Date format: month/day/year
            changeMonth: true, // Show month dropdown
            changeYear: true, // Show year dropdown
            yearRange: "-100:+0" // Allow selection from 100 years ago to the current year
        });
        $(".datepickersz").on("keyup", function() {
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
    });
</script>
<!-- inprogress data load time -->
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
<script>
    // Function to be executed after a delay
    function loadPendingDataDelayed() {
        setTimeout(function() {
            // Load the script dynamically after a delay of 2000 milliseconds (2 seconds)
            var script = document.createElement('script');
            script.src = 'Assign/js/penddisplaydata.js';
            document.body.appendChild(script);
        }, 2000); // Change this value to set the desired delay in milliseconds
    }

    // Attach loadPendingDataDelayed function to window.onload event
    window.onload = loadPendingDataDelayed;
</script>


 <script>
    // Function to be executed after a delay
    function loadPendingDataDelayed() {
        setTimeout(function() {
            // Load the script dynamically after a delay of 2000 milliseconds (2 seconds)
            var script = document.createElement('script');
            script.src = 'Assign/js/wipdisplaydata.js';
            document.body.appendChild(script);
        }, 2000); // Change this value to set the desired delay in milliseconds
    }

    // Attach loadPendingDataDelayed function to window.onload event
    window.onload = loadPendingDataDelayed;
</script>



<!-- data toggle in three segement -->
<script>
    document.getElementById('toggleButton').addEventListener('click', function() {
        var element = document.getElementById('myCollapsible');
        if (element.style.display === 'none' || element.style.display === '') {
            element.style.display = 'block'; // Show the element
        } else {
            element.style.display = 'none'; // Hide the element
        }
    });
  document.getElementById('btn_save').addEventListener('click', function() {
    var element = document.getElementById('myCollapsible');
    element.style.display = 'none';
 
    $(".chk").prop('checked', false);
 
});
</script>
<script>
    document.getElementById('toggleButton2').addEventListener('click', function() {
        var element = document.getElementById('myCollapsible2');
        if (element.style.display === 'none' || element.style.display === '') {
            element.style.display = 'block'; // Show the element
        } else {
            element.style.display = 'none'; // Hide the element
        }
    });
    document.getElementById('btn_save_oasis').addEventListener('click', function() {
    var element = document.getElementById('myCollapsible2');
    element.style.display = 'none';
 
    $(".chk").prop('checked', false);
 
});
</script>




<script>
  document.getElementById('toggleButton3').addEventListener('click', function() {

     var element = document.getElementById('myCollapsible3');
    if (element.style.display === 'none' || element.style.display === '') {
        element.style.display = 'block'; // Show the element
    } else {
        element.style.display = 'none'; // Hide the element
    }
  });
  document.getElementById('btn_save_poc').addEventListener('click', function() {
    var element = document.getElementById('myCollapsible3');
    element.style.display = 'none';
 
    $(".chk").prop('checked', false);
 
  });

 

</script>


<script>
    document.getElementById('toggleButton4').addEventListener('click', function() {
        var element = document.getElementById('myCollapsible4');
        if (element.style.display === 'none' || element.style.display === '') {
            element.style.display = 'block'; // Show the element
        } else {
            element.style.display = 'none'; // Hide the element
        }
    });
    document.getElementById('btn_save_oasis').addEventListener('click', function() {
    var element = document.getElementById('myCollapsible4');
    element.style.display = 'none';
 
    $(".chk").prop('checked', false);
 
   });
</script>


<script>
    document.getElementById('toggleButton5').addEventListener('click', function() {
        var element = document.getElementById('myCollapsible5');
        if (element.style.display === 'none' || element.style.display === '') {
            element.style.display = 'block'; // Show the element
        } else {
            element.style.display = 'none'; // Hide the element
        }
    });
  document.getElementById('btn_save').addEventListener('click', function() {
    var element = document.getElementById('myCollapsible');
    element.style.display = 'none';
 
    $(".chk").prop('checked', false);
 
});
</script>






























<?php setcookie('Id', '', time() - 3600, '/'); ?>

 <script>
    function openMultipleURLs() {
        var urlStr = `<?php echo $urls; ?>`;

        console.log("URL String:", urlStr); // Debugging line

        // Split the string into an array of URLs
        var urlArray = urlStr.split(', ');

        // Loop through each URL and apply the modifications
        var modifiedUrlArray = urlArray.map(function(url) {
            // Check if URLs are separated by digits followed by 'www'
            var modifiedUrl = url.replace(/(\d)(www)/g, '$1 $2');

            // If the modification didn't occur, try splitting by 'https://' and 'http://'
            if (modifiedUrl === url) {
                modifiedUrl = url.replace(/(https:\/\/|http:\/\/)/g, ' $1');
            }

            return modifiedUrl;
        });

        // Join the modified URLs into a single string
        var modifiedUrlStr = modifiedUrlArray.join(' ');

        // Split the modified string into an array of individual URLs
        var urls = modifiedUrlStr.trim().split(' ');

        console.log("URLs after split:", urls); // Debugging line
        if (urls == '') {
            alert("The patient's chart is not available.");
        }
        // Loop through each URL and open in a new tab
        urls.forEach(url => {
            if (url !== '') {
                window.open(url, '_blank');
            }
        });
    }
</script>




<!-- 
<script>
    // Get the textarea
    const textarea = document.getElementById('textarea');
    alert(textarea)

    // Add event listener for the textarea
    textarea.addEventListener('keydown', (event) => {
        let cursorPos = textarea.selectionStart;
        let lines = textarea.value.split('\n');
        let currentLine = textarea.value.substr(0, cursorPos).split('\n').length - 1;
 // Check which arrow key is pressed
        switch (event.keyCode) {
            case 37: // Left arrow
                if (cursorPos > 0) {
                    textarea.setSelectionRange(cursorPos - 1, cursorPos - 1);
                    alert('left arrow');
                }
                break;
            case 39: // Right arrow
                if (cursorPos < textarea.value.length) {
                    textarea.setSelectionRange(cursorPos + 1, cursorPos + 1);
                }
                break;
            case 38: // Up arrow
                if (currentLine > 0) {
                    let newPos = textarea.value.lastIndexOf('\n', cursorPos - 2);
                    textarea.setSelectionRange(newPos + 1, newPos + 1);
                }
                break;
            case 40: // Down arrow
                if (currentLine < lines.length - 1) {
                    let newPos = textarea.value.indexOf('\n', cursorPos);
                    if (newPos === -1) {
                        newPos = textarea.value.length;
                    }
                    textarea.setSelectionRange(newPos + 1, newPos + 1);
                }
                break;
            default:
                break;
        }
    });
</script> -->
