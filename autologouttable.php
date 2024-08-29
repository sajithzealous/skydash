<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> User Management</title>
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

 <?php include'usercountindex.php'?> 

<!--                     <div class="container">
                            <div class="card-deck">
                                <div class="card cardfer">
                                    <img class="card-img-top" src="gifs/agency.gif" alt="Card image cap">
                                    <div class="card-body">
                                        <h3 class="card-title card-image-heading">Login User</h3>
                                        <p class="card-text" id="Lo"></p>
                                    </div>

                                </div>
                                <div class="card cardfer">
                                   <img class="card-img-top" src="gifs/inactiveagency.gif" alt="Image Description" style="height:240px;">
                                     <div class="card-body">
                                        <h3 class="card-title card-image-heading">Logout User</h3>
                                        <p class="card-text" id="inactiveagency"></p>
                                    </div>

                                </div>
                            </div>
                       

                    </div> -->
 

                    <div class="conatiner m-5">


                        <div class="card p-4">
                            <h3>User Table          
                        </h3>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12 custom-scroll table-responsive p-5"
                                style="width:100%">

                                <table id="autologout" class="display table">
                                    <thead>
                                        <tr class="headerrow">
                                            <th class="">S.no</th>
                                            <th class="">User Name</th>
                                            <th class="">User Id</th>
                                            <th class="">User Role</th>
                                            <th class="">User Status</th>
<!--                                             <th class="">Date</th>
                                            <th class="">Login Time</th>
                                            <th class="">Logout Time</th> -->
                                            <th class="">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



   

<?php $random =rand(10000,9999); ?>


    <!-- Modal Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script src="Adminpanel/js/autologout.js?<?php echo $random?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


</body>

</html>