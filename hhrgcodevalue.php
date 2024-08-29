<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HHRG Value</title>
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
                                        <h3 class="card-title card-image-heading">Active HHRG</h3>
                                        <p class="card-text" id="activehhrg"></p>
                                    </div>

                                </div>
                                <div class="card cardfer">
                                   <!-- <img class="card-img-top" src="gifs/inactiveagency.gif" alt="Image Description" style="height:240px;"> -->
                                     <div class="card-body">
                                        <h3 class="card-title card-image-heading">Inactive HHRG</h3>
                                        <p class="card-text" id="inactivehhrg"></p>
                                    </div>

                                </div>
                                <div class="card cardfer">
                                   <!-- <img class="card-img-top" src="gifs/totalagency.gif" alt="Card image cap"> -->

                                    <div class="card-body">
                                        <h3 class="card-title card-image-heading">Total HHRG</h3>
                                        <p class="card-text" id="totalhhrg"></p>
                                    </div>

                                </div>
                            </div>
                       

                    </div>
 

                    <div class="conatiner m-5">

                        <div class="card p-4">
                            <h3>HHRG Value Table 
                        <!--                                
                                <button type="button" class="btn btn-primary mr-2 clk_2" data-toggle="modal"
                                    data-target="#upload_model" style="float:right"> Upload</button> -->
                                <button type="button" class="btn btn-info mr-2 clk_2" data-toggle="modal"
                                    data-target="#hhrgLink" style="float:right"> Create</button>
        
                        </h3>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12 custom-scroll table-responsive p-5"
                                style="width:100%">

                                <table id="hhrgtable" class="display table">
                                    <thead>
                                        <tr class="headerrow">
                                            <th class="sorting">S.no</th>
                                            <th class="sorting">Id</th>
                                            <th class="sorting">National</th>
                                            <th class="sorting">Labor Portion</th>
                                            <th class="sorting">Non Labor Portion</th>
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

    <div class="modal fade" id="hhrgLink" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLongTitle">New HHRG</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class=" mt-1">
                        <div id="userForm">
                            <div class="form-group">
                                <label for="textInput">National Value</label>
                                <input type="text" class="form-control" id="textInputNational" name="textInputNational"
                                    placeholder="Enter National Value">
                                <label for="textInput">Labor Portion Value</label>
                                <input type="text" class="form-control" id="textInputLabor" name="textInput"
                                    placeholder="Enter Labor Portion Value">
                            </div>
                            <div class="form-group">
                                <label for="textInput">Non Labor Portion Value</label>
                                <input type="text" class="form-control" id="textInputNonLabor" name="textInputNonLabor"
                                    placeholder="Enter Non Labor Portion Value">
                                <label for="textInput">Year</label>
                                <input type="text" class="form-control" id="textInputYear" name="textInputYear"
                                    placeholder="Enter Year">
                            </div>
                            <div class="form-group">
                                <label for="textInput">HHRG Status</label>
                                <select class="form-control" id="selectInputHHRGStatus" name="selectInputHHRGStatus">
                                    <option value="active">Active</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="newhhrgsave">Save changes</button>
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
    <script src="Adminpanel/js/hhrgcode.js?<?php echo $rand ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


</body>

</html>