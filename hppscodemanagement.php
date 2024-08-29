<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hpps Code Management</title>
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
                                <!-- <img class="card-img-top" src="gifs/activeuser1.gif" alt="Card image cap"> -->
                                <div class="card-body">
                                    <h3 class="card-title card-image-heading">Active HppsCode</h3>
                                    <p class="card-text activehppscode"></p>
                                </div>

                            </div>
                            <div class="card cardfer">
                                <!-- <img class="card-img-top" src="gifs/inactiveuser.gif" alt="Image Description"> -->
                                <div class="card-body">
                                    <h3 class="card-title card-image-heading">Inactive HppsCode</h3>
                                    <p class="card-text inactivehppscode"></p>
                                </div>

                            </div>
                            <div class="card cardfer">
                                <!-- <img class="card-img-top" src="gifs/totalusers1.gif" alt="Card image cap"> -->

                                <div class="card-body">
                                    <h3 class="card-title card-image-heading">Total HppsCode</h3>
                                    <p class="card-text totalhppscode"></p>
                                </div>

                            </div>
                        </div>


                    </div>


                    <div class="conatiner m-5">

                        <div class="card p-4">
                            <h3>Hpps Code Table

<!--                                 <button type="button" class="btn btn-primary mr-2 clk_2" data-toggle="modal" data-target="#upload_model" style="float:right"> Upload</button>
                                <button type="button" class="btn btn-info mr-2 clk_2" data-toggle="modal" data-target="#userLink" style="float:right"> Create</button> -->
                                <!-- <button id="delete-selected" class="btn btn-danger">Delete</button> -->
                            </h3>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12 custom-scroll table-responsive p-5" style="width:100%">

                                <table id="hppscode_table" class="display table">
                                    <thead>
                                        <tr class="headerrow">
                                            <th class="sorting">S.no</th>
                                            <th class="sorting">Id</th>
                                            <th class="sorting">Source</th>
                                            <th class="sorting">Level</th>
                                            <th class="sorting">Comorbidity</th>
                                            <th class="sorting">Hipps_code</th>
                                            <th class="sorting">Weight</th>
                                            <th class="sorting">Threshold</th>
                                            <th class="sorting">Version</th>
                                            <th class="sorting">Year</th>
                                            <th class="sorting">Status</th>
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

    <script src="Adminpanel/js/hppscodemanagementdatatable.js?<?php echo $randomNumber ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
</body>

</html>