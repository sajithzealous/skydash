<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agency Management</title>
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
                                    <img class="card-img-top" src="gifs/agency.gif" alt="Card image cap">
                                    <div class="card-body">
                                        <h3 class="card-title card-image-heading">Active Agency</h3>
                                        <p class="card-text" id="activeagency"></p>
                                    </div>

                                </div>
                                <div class="card cardfer">
                                   <img class="card-img-top" src="gifs/inactiveagency.gif" alt="Image Description" style="height:240px;">
                                     <div class="card-body">
                                        <h3 class="card-title card-image-heading">Inactive Agency</h3>
                                        <p class="card-text" id="inactiveagency"></p>
                                    </div>

                                </div>
                                <div class="card cardfer">
                                   <img class="card-img-top" src="gifs/totalagency.gif" alt="Card image cap">

                                    <div class="card-body">
                                        <h3 class="card-title card-image-heading">Total Agency</h3>
                                        <p class="card-text" id="totalagecny"></p>
                                    </div>

                                </div>
                            </div>
                       

                    </div>
 

                    <div class="conatiner m-5">

                        <div class="card p-4">
                            <h3>Agency Table 
                        <!--                                
                                <button type="button" class="btn btn-primary mr-2 clk_2" data-toggle="modal"
                                    data-target="#upload_model" style="float:right"> Upload</button> -->
                                <button type="button" class="btn btn-info mr-2 clk_2" data-toggle="modal"
                                    data-target="#agencyLink" style="float:right"> Create</button>
        
                        </h3>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12 custom-scroll table-responsive p-5"
                                style="width:100%">

                                <table id="Agency_table" class="display table">
                                    <thead>
                                        <tr class="headerrow">
                                            <th class="sorting">S.no</th>
                                            <th class="sorting">Agency Name</th>
                                            <th class="sorting">Agency Id</th>
                                            <th class="sorting">Agency Role</th>
                                            <th class="sorting">Agency Status</th>
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

    <div class="modal fade" id="agencyLink" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true" data-backdrop="static">
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
                                <label for="textInput">Not Need Login</label>
                                <input type="checkbox" class="form" id="selectcheckbox" name="selectcheckbox"
                                    placeholder="">
     
                            </div>
                            <div class="form-group" >
                                <label for="textInput">Agency Name</label>
                                <input type="text" class="form-control" id="textInputUser" name="textInputUser"
                                    placeholder="Enter User Name">
                                <label for="textInput" id="agencypassword">Agency Password</label>
                                <input type="password" class="form-control" id="textInputpassword" name="textInput"
                                    placeholder="Enter User Password">
                            </div>
                            <div class="form-group">
                                <label for="textInput">Agency Id</label>
                                <input type="text" class="form-control" id="textInputempid" name="textInputempid"
                                    placeholder="Enter User Id">
                                <label for="textInput">Agency Role</label>
                                <select class="form-control" id="selectInputuserrole" name="selectInputuserrole">
                                    <option value="">None</option>
                                    <option value="client">Client</option>
                                     <option value="agency">Agency</option>
                                </select>
                            </div>
                            <div class="form-group">
                                 <label for="textInput">Client Id</label>

                                 <select class="form-control" id="selectInputclientid" name="selectInputclientid" style='display: none;'>
                                    <option value=''>Select</option>


                                    <?php
                                        include('db/db-con.php'); 

                                        $selectquery = "SELECT `client_id` FROM `Agent` WHERE `agency_status`='active'";
                                        $selectexectue = $conn->query($selectquery);
                                        
                                        if ($selectexectue->num_rows > 0) { 
                                            while ($selectdata = $selectexectue->fetch_assoc()) { 
                                                $userclientid = $selectdata['client_id'];
                                                
                                                echo "<option value='$userclientid'>$userclientid</option>"; 
                                            }
                                        }
                                    ?>

                                </select>
                                
                            </div>
                            <div class="form-group">
                                <label for="textInput">Agency Status</label>
                                <select class="form-control" id="selectInputStatus" name="selectInputStatus">
                                    <option value="Active">Active</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="newagencysave">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- new user file upload -->
 <!--    <div class="modal fade" id="upload_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true" data-backdrop="static">
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
                             <header></header>
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
    </div> -->




    <!-- Modal Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script src="Adminpanel/js/agencymanagement.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


    <script>
        function toggleClientIdField() {
            var roleSelect = document.getElementById("selectInputuserrole");
            var clientIdField = document.getElementById("selectInputclientid");

            if (roleSelect.value === "agency") {
                clientIdField.style.display = "block";
            } else {
                clientIdField.style.display = "none";
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("selectInputuserrole").addEventListener("change", toggleClientIdField);
        });
    </script>



<script>
    function toggleFields() {
        var checkbox = document.getElementById("selectcheckbox");
        var agencypassword = document.getElementById("agencypassword");
         var textInputpassword = document.getElementById("textInputpassword");
        // var passwordField = document.getElementById("textInputpassword");

        if (checkbox.checked) {
            agencypassword.style.display = "none";
             textInputpassword.style.display = "none";
         
        } else {
            agencypassword.style.display = "block";
            textInputpassword.style.display = "block";

        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        var checkbox = document.getElementById("selectcheckbox");
        checkbox.addEventListener("change", toggleFields);

        // Initialize fields based on checkbox state
        toggleFields();
    });
</script>

</body>

</html>