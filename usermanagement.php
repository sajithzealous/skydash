<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- <link rel="stylesheet" href="code_des/css/code_desc.css"> -->
    <link rel="stylesheet" href="Adminpanel/css/usermanagement.css">
</head>

<body>
    <div class="container-scroller">
        <!-- Navbar -->
        <?php include 'include_file/profile.php'; ?>

        <div class="container-fluid page-body-wrapper">
            <!-- Sidebar -->
            <?php include 'include_file/sidebar.php'; ?>

            <div class="main-panel">
                <div class="content-wrapper">

                    <div class="container">
                        <div class="card-deck">
                            <div class="card cardfer">
                                <img class="card-img-top" src="gifs/activeuser1.gif" alt="Card image cap">
                                <div class="card-body">
                                    <h3 class="card-title card-image-heading">Active User</h3>
                                    <p class="card-text active_user_count"></p>
                                </div>

                            </div>
                            <div class="card cardfer">
                                <img class="card-img-top" src="gifs/inactiveuser.gif" alt="Image Description">
                                <div class="card-body">
                                    <h3 class="card-title card-image-heading">Inactive User</h3>
                                    <p class="card-text inactive_user_count"></p>
                                </div>

                            </div>
                            <div class="card cardfer">
                                <img class="card-img-top" src="gifs/totalusers1.gif" alt="Card image cap">

                                <div class="card-body">
                                    <h3 class="card-title card-image-heading">Total User</h3>
                                    <p class="card-text total_user_count"></p>
                                </div>

                            </div>
                        </div>


                    </div>


                    <div class="conatiner m-5">

                        <div class="card p-4">
                            <h3>User Table

                                <button type="button" class="btn btn-primary mr-2 clk_2" data-toggle="modal" data-target="#upload_model" style="float:right"> Upload</button>
                                <button type="button" class="btn btn-info mr-2 clk_2" data-toggle="modal" data-target="#userLink" style="float:right"> Create</button>
                                <!-- <button id="delete-selected" class="btn btn-danger">Delete</button> -->
                            </h3>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12 custom-scroll table-responsive p-5" style="width:100%">

                                <table id="user_table" class="display table">
                                    <thead>
                                        <tr class="headerrow">
                                            <th class="sorting">S.no</th>
                                            <th class="sorting">Employee Name</th>
                                            <th class="sorting">Employee Id</th>
                                            <th class="sorting">Employee Role</th>
                                            <th class="sorting">Employee Status</th>
                                            <th class="sorting">Date Of Creation</th>
                                            <th class="sorting">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- new user form modal -->

    <div class="modal fade" id="userLink" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLongTitle">New User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class=" mt-1">
                        <div id="userForm">
                            <div class="form-group">
                                <label for="textInput">User Name</label>
                                <input type="text" class="form-control" id="textInputUser" name="textInputUser" placeholder="Enter User Name">
                                <label for="textInput">User Password</label>
                                <input type="password" class="form-control" id="textInputpassword" name="textInput" placeholder="Enter User Password">
                            </div>
                            <div class="form-group">
                                <label for="textInput">Emp Id</label>
                                <input type="text" class="form-control" id="textInputempid" name="textInputempid" placeholder="Enter User Id">
                                <label for="textInput">User Role</label>
                                <select class="form-control" id="selectInputuserrole" name="selectInputuserrole">
                                    <option value="">None</option>
                                    <option value="TeamManager">Team Manager</option>
                                    <option value="TeamLeader">Team Leader</option>
                                    <option value="user">Coder</option>
                                    <option value="QA">QA Coder</option>
                                    <!-- <option value="clinet">Client</option> -->
                                    <option value="Admin">Mis</option>
                                    <option value="OperationalManager">Operational Manager</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="textInput">Organization</label>
                                <input type="text" class="form-control" id="textInputOrganization" name="textInputOrganization" placeholder="Enter Organization Name">
                                <label for="textInput">User Status</label>
                                <select class="form-control" id="selectInputStatus" name="selectInputStatus">
                                    <option value="Active">Active</option>
                                </select>
                            </div>
                            <div class="form-group" id="InputTeam">
                                <label for="selectInputTeam">User Team</label>
                                <select class="form-control" id="selectInputTeam" name="selectInputTeam">
                                    <option value=''>Select</option>


                                    <?php
                                    include('db/db-con.php');

                                    $selectquery = "SELECT  DISTINCT `Team` FROM `coders`";
                                    $selectexectue = $conn->query($selectquery);

                                    if ($selectexectue->num_rows > 0) {
                                        while ($selectdata = $selectexectue->fetch_assoc()) {
                                            $userteam = $selectdata['Team'];

                                            echo "<option value='$userteam'>$userteam</option>";
                                        }
                                    }
                                    ?>

                                </select>
                            </div>

                            <div class="form-group" id="InputTeamleader">
                                <label for="selectInputTeam">Team leader</label>
                                <select class="form-control" id="selectInputTeamleader" name="selectInputTeamleader">
                                    <option value=''>Select</option>


                                    <?php
                                    include('db/db-con.php');

                                    $selectquery = "SELECT  DISTINCT `team_leader_name` FROM `coders`";
                                    $selectexectue = $conn->query($selectquery);

                                    if ($selectexectue->num_rows > 0) {
                                        while ($selectdata = $selectexectue->fetch_assoc()) {
                                            $userteam = $selectdata['team_leader_name'];

                                            echo "<option value='$userteam'>$userteam</option>";
                                        }
                                    }
                                    ?>

                                </select>
                            </div>

                            <div class="form-group" id="InputTeamManager">
                                <label for="selectInputTeam">Team Manager</label>
                                <select class="form-control" id="selectInputTeamManager" name="selectInputTeamManager">
                                    <option value=''>Select</option>


                                    <?php
                                    include('db/db-con.php');

                                    $selectquery = "SELECT  DISTINCT `team_manager_name` FROM `coders`";
                                    $selectexectue = $conn->query($selectquery);

                                    if ($selectexectue->num_rows > 0) {
                                        while ($selectdata = $selectexectue->fetch_assoc()) {
                                            $userteam = $selectdata['team_manager_name'];

                                            echo "<option value='$userteam'>$userteam</option>";
                                        }
                                    }
                                    ?>

                                </select>
                            </div>

                            <div class="form-group" id="InputOperationalManager">
                                <label for="selectInputTeam">Operational Manager</label>
                                <select class="form-control" id="selectInputOperationalManager" name="selectInputOperationalManager">
                                    <option value=''>Select</option>


                                    <?php
                                    include('db/db-con.php');

                                    $selectquery = "SELECT  DISTINCT  `operational_manager_name` FROM `coders`";
                                    $selectexectue = $conn->query($selectquery);

                                    if ($selectexectue->num_rows > 0) {
                                        while ($selectdata = $selectexectue->fetch_assoc()) {
                                            $userteam = $selectdata['operational_manager_name'];

                                            echo "<option value='$userteam'>$userteam</option>";
                                        }
                                    }
                                    ?>

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="newusersave">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="modal fade" id="userLink" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLongTitle">New User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="userForm">
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label for="textInputUser" class="labelook">User Name</label>
                                <input type="text" class="form-control" id="textInputUser" name="textInputUser"
                                    placeholder="Enter User Name">
                            </div>
                            <div class="form-group col-md-5">
                                <label for="textInputPassword" class="labelook">User Password</label>
                                <input type="password" class="form-control" id="textInputPassword"
                                    name="textInputPassword" placeholder="Enter User Password">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="textInputEmpId" class="labelook">User Emp Id</label>
                                <input type="text" class="form-control" id="textInputEmpId" name="textInputEmpId"
                                    placeholder="Enter Your  Emp Id">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label for="textInputEmail" class="labelook">User Email</label>
                                <input type="text" class="form-control" id="textInputEmail" name="textInputEmail"
                                    placeholder="Enter Your Email">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="selectInputUserGender" class="labelook">User Gender</label>
                                <select class="form-control" id="selectInputUserGender" name="selectInputUserGender">
                                    <option value="">Choose</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="selectInputUserRole" class="labelook">User Role</label>
                                <select class="form-control" id="selectInputUserRole" name="selectInputUserRole">
                                    <option value="">Choose...</option>
                                    <option value="TeamManager">Team Manager</option>
                                    <option value="TeamLeader">Team Leader</option>
                                    <option value="Coder">Coder</option>
                                    <option value="QACoder">QA Coder</option>
                                    <option value="Client">Client</option>
                                    <option value="MIS">MIS</option>
                                    <option value="OperationalManager">Operational Manager</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="textInputDob">Date Of Birth</label>
                                <input type="text" class="form-control" id="textInputDob" name="textInputDob"
                                    placeholder="Enter Your Dob">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="textInputOrganization">User Organization</label>
                                <input type="text" class="form-control" id="textInputOrganization"
                                    name="textInputOrganization" placeholder="Enter Organization Name">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="textInputCertification">User Certification</label>
                                <input type="text" class="form-control" id="textInputCertification"
                                    name="textInputCertification" placeholder="Enter Certification ">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="textInputJoiningDate">User Joining Date</label>
                                <input type="text" class="form-control" id="textInputJoiningDate"
                                    name="textInputJoiningDate" placeholder="Enter JoiningDate ">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="selectInputStatus">User Status</label>
                                <select class="form-control" id="selectInputStatus" name="selectInputStatus">
                                    <option value="Active">Active</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="selectInputExperience">User Experience</label>
                                <select class="form-control" id="selectInputExperience" name="selectInputExperience">
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="Above 3 years">Above 3 years</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="selectInputTeam">User Team</label>
                                <select class="form-control" id="selectInputTeam" name="selectInputTeam">
                                //PHP Code to Fetch Teams from Database 
                                    <?php
                                    include('db/db-con.php');
                                    $selectquery = "SELECT `team_name` FROM `team`";
                                    $selectexectue = $conn->query($selectquery);
                                    if ($selectexectue->num_rows > 0) {
                                        while ($selectdata = $selectexectue->fetch_assoc()) {
                                            $userteam = $selectdata['team_name'];
                                            echo "<option value='$userteam'>$userteam</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6"></div>
                            <div class="form-group col-md-6"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="newusersavesecond">Save changes</button>
                </div>
            </div>
        </div>
    </div>  -->






    <!-- new user file upload -->
    <div class="modal fade" id="upload_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLongTitle">File Upload Csv</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container mt-1">

                        <div class="wrapper datawrap">
                            <!-- <header></header> -->
                            <form action="#" class="formdata">
                                <input class="file-input" type="file" name="file" hidden>
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p>Browse File to Upload</p>
                            </form>
                            <section class="progress-area"></section>
                            <section class="uploaded-area"></section>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="newusersave">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <style>
        .form-group .labelook {

            font-size: 15px;
            font-weight: 500px;
            font-style: bold;
        }
    </style>
    <?php

    $randomNumber = rand(1000, 9999);
    ?>

    <!-- Modal Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script src="Adminpanel/js/usermanagementdatatable.js?<?php echo $randomNumber ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <!--  <script>
    $(document).ready(function() {
            $('#selectInputUserRole').change(function() {
                var role = $(this).val();

                // Hide all dynamic fields initially
                $('#textInputDob').closest('.form-group').hide();
                $('#textInputOrganization').closest('.form-group').hide();
                $('#textInputCertification').closest('.form-group').hide();
                $('#textInputJoiningDate').closest('.form-group').hide();
                $('#selectInputExperience').closest('.form-group').hide();
                $('#selectInputTeam').closest('.form-group').hide();

                // Show fields based on selected role
                if (role === 'Coder') {
                    $('#selectInputTeam').closest('.form-group').show();
                } else if (role === 'TeamLeader') {
                    $('#selectInputExperience').closest('.form-group').show();
                    $('#selectInputTeam').closest('.form-group').show();
                } else if (role === 'TeamManager') {
                    $('#textInputJoiningDate').closest('.form-group').show();
                    $('#selectInputExperience').closest('.form-group').show();
                    $('#selectInputTeam').closest('.form-group').show();
                } else if (role === 'QACoder') {
                    $('#selectInputTeam').closest('.form-group').show();
                } else if (role === 'OperationalManager') {
                    $('#textInputDob').closest('.form-group').show();
                    $('#textInputOrganization').closest('.form-group').show();
                    $('#textInputCertification').closest('.form-group').show();
                    $('#textInputJoiningDate').closest('.form-group').show();
                }
            });

            // Trigger change event on page load to set the correct initial state
            $('#selectInputUserRole').trigger('change');
        });
</script>  -->
    <script>
        function toggleClientIdField() {
            var roleSelect = document.getElementById("selectInputuserrole");
            var teamManagerField = document.getElementById("InputTeamManager");
            var teamLeaderField = document.getElementById("InputTeamleader");
            var teamField = document.getElementById("InputTeam");
            var operationalManagerField = document.getElementById("InputOperationalManager");

            // Hide all fields initially
            teamManagerField.style.display = "none";
            teamLeaderField.style.display = "none";
            teamField.style.display = "none";
            operationalManagerField.style.display = "none";


            // Show specific fields based on selected role
            if (roleSelect.value === "TeamManager") {
                operationalManagerField.style.display = "block";
            } else if (roleSelect.value === "TeamLeader") {
                teamManagerField.style.display = "block";
                teamField.style.display = "block";
                operationalManagerField.style.display = "block";
            } else if (roleSelect.value === "user") {
                teamLeaderField.style.display = "block";
                teamManagerField.style.display = "block";
                teamField.style.display = "block";
                operationalManagerField.style.display = "block";
            } else if (roleSelect.value === "OperationalManager") {
                teamField.style.display = "block";
            } else if (roleSelect.value === "QA") {
                teamLeaderField.style.display = "block";
                teamManagerField.style.display = "block";
                teamField.style.display = "block";
                operationalManagerField.style.display = "block";
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("selectInputuserrole").addEventListener("change", toggleClientIdField);
        });
    </script>
</body>

</html>