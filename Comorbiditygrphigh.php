<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comorbidity Group High</title>
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
                                    <!-- <img class="card-img-top" src="gifs/agency.gif" alt="Card image cap"> -->
                                    <div class="card-body">
                                        <h3 class="card-title card-image-heading">Active Comorbidity High</h3>
                                        <p class="card-text" id="activecgh"></p>
                                    </div>

                                </div>
                                <div class="card cardfer">
                                   <!-- <img class="card-img-top" src="gifs/inactiveagency.gif" alt="Image Description" style="height:240px;"> -->
                                     <div class="card-body">
                                        <h3 class="card-title card-image-heading">Inactive Comorbidity High</h3>
                                        <p class="card-text" id="inactivecgh"></p>
                                    </div>

                                </div>
                                <div class="card cardfer">
                                   <!-- <img class="card-img-top" src="gifs/totalagency.gif" alt="Card image cap"> -->

                                    <div class="card-body">
                                        <h3 class="card-title card-image-heading">Total Comorbidity High</h3>
                                        <p class="card-text" id="totalcgh"></p>
                                    </div>

                                </div>
                            </div>
                       

                    </div>
 

                    <div class="conatiner m-5">

                        <div class="card p-4">
                            <h3>Comorbidity High Table 
                        <!--                                
                                <button type="button" class="btn btn-primary mr-2 clk_2" data-toggle="modal"
                                    data-target="#upload_model" style="float:right"> Upload</button> -->
                                <button type="button" class="btn btn-info mr-2 clk_2" data-toggle="modal"
                                    data-target="#cghLink" style="float:right"> Create</button>
        
                        </h3>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12 custom-scroll table-responsive p-5"
                                style="width:100%">

                                <table id="cghtable" class="display table">
                                    <thead>
                                        <tr class="headerrow">
                                            <th class="sorting">S.no</th>
                                            <th class="sorting">Id</th>
                                            <th class="sorting">Group One</th>
                                            <th class="sorting">Group Two</th>
                                            <th class="sorting">Year</th>
                                            <th class="sorting">Status</th>
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

    <div class="modal fade" id="cghLink" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLongTitle">New Comorbidity High</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class=" mt-1">
                        <div id="userForm">
                            <div class="form-group">
                                <label for="textInput">Group one</label>
                                <input type="text" class="form-control" id="textInputGroupone" name="textInputGroupone"
                                    placeholder="Enter Group One">
                                <label for="textInput">Group Two</label>
                                <input type="text" class="form-control" id="textInputGrouptwo" name="textInputGrouptwo"
                                    placeholder="Enter Group Two">
                            </div>
                            <div class="form-group">
                                <label for="textInput">Year</label>
                                <input type="text" class="form-control" id="textInputYear" name="textInputYear"
                                    placeholder="Enter Year">
                            </div>
                            <div class="form-group">
                                <label for="textInput">Comorbidity High Status</label>
                                <select class="form-control" id="selectInputCghStatus" name="selectInputCghStatus">
                                    <option value="active">Active</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="newcghsave">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


<?php  $rand =rand(0000,9999) ?>
    <script src="Adminpanel/js/comorbidityhigh.js?<?php echo $rand ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


</body>

</html>