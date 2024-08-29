<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Qc Scoring</title>
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

<!--                     <div class="container">
                        <div class="card-deck">
                            <div class="card cardfer">
               
                                <div class="card-body">
                                    <h3 class="card-title card-image-heading">Active Scoring</h3>
                                    <p class="card-text activehppscode"></p>
                                </div>

                            </div>
                            <div class="card cardfer">
                             
                                <div class="card-body">
                                    <h3 class="card-title card-image-heading">Inactive Scoring</h3>
                                    <p class="card-text inactivehppscode"></p>
                                </div>

                            </div>
                            <div class="card cardfer">
                               

                                <div class="card-body">
                                    <h3 class="card-title card-image-heading">Total HppsCode</h3>
                                    <p class="card-text totalhppscode"></p>
                                </div>

                            </div>
                        </div>


                    </div> -->


                    <div class="conatiner m-5">

                        <div class="card p-4">
                            <h3>Qc Scoring Table

                                <!--<button type="button" class="btn btn-primary mr-2 clk_2" data-toggle="modal" data-target="#upload_model" style="float:right"> Upload</button>-->
                                <button type="button" class="btn btn-info mr-2 clk_2" data-toggle="modal" data-target="#qcscoringLink" style="float:right"> Create</button> 
                                <!-- <button id="delete-selected" class="btn btn-danger">Delete</button> -->
                            </h3>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12 custom-scroll table-responsive p-5" style="width:100%">

                                <table id="qcscoring_table" class="display table">
                                    <thead>
                                        <tr class="headerrow">
                                            <th class="sorting">S.no</th>
                                            <th class="sorting">Id</th>
                                            <th class="sorting">Mitem</th>
                                            <th class="sorting">Score</th>
                                            <th class="sorting">Segement</th>
                                            <th class="sorting">Version</th>
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


    <!-- new qc scoring -->

    <div class="modal fade" id="qcscoringLink" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLongTitle">New Qc Scoring</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class=" mt-1">
                        <div id="userForm">
                            <div class="form-group">
                                <label for="textInput">Mitem</label>
                                <input type="text" class="form-control" id="textInputMitem" name="textInputMitem"
                                    placeholder="Enter Mitem">
                            </div>
                            <div class="form-group">
                                <label for="textInput">Score</label>
                                <input type="text" class="form-control" id="textInputScore" name="textInputScore"
                                    placeholder="Enter Score">
                            </div>
                            <div class="form-group">
                                <label for="textInput">Segement</label>
                                <select class="form-control" id="selectinputsegement">
                                    <option value="">Select</option>
                                     <option value="Code">Code</option>
                                      <option value="Oasis">Oasis</option>
                                       <option value="Poc">Poc</option>
                                </select>

                            </div>
                            <div class="form-group">
                                <label for="textInput">Version</label>
                              <select class="form-control" id="selectinputversion">
                                    <option value="">Select</option>
                                     <option value="v1">V1</option>
                                      <option value="v2">V2</option>
                                </select>
                  
                            </div>
                            <div class="form-group">
                                <label for="textInput">Status</label>
                                <select class="form-control" id="selectInputqcscoringStatus" name="selectInputqcscoringStatus">
                                    <option value="active">Active</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="newqcscoringsave">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


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

    <script src="Adminpanel/js/qcscoring.js?<?php echo $randomNumber ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
</body>

</html>