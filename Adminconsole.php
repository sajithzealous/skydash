<!DOCTYPE html>
<html lang="en">
    <head> 

        <?php 
 
    include('db/db-con.php');
  include  'include_file/link.php';


  ?>
<?php
    session_start();
    $user = $_SESSION['role'];
    $agent = $_SESSION['agent'];
   
    ?>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> <?php $rand =rand(0000,9999)?>
        <link rel="stylesheet" href="Adminpanel/css/checkbox.css">
        <link rel="stylesheet" href="Adminpanel/css/panel.css?
                    <?php echo $rand ?>">
    </head>
    <body>
        <div class="container-scroller"> <?php
    include 'include_file/profile.php';
    ?> <div class="container-fluid page-body-wrapper"> <?php
      include 'include_file/sidebar.php'; // Use a relative path to include the file
      ?> <div class="main-panel">
                    <div class="content-wrapper">
                        <div class="card" style="background-color: #001940;">
                            <div class="card-body">
                                <section>
                                    <div class="rt-container">
                                        <div class="col-rt-12">
                                            <div class="wrapper">
                                                <div class="wrap">
                                                    <h4 class="Start">Admin Panel</h3>
                                                    <br>
                                                    <br>
                                                    <div class="btn-big blue">
                                                        <a href="agencymanagement.php">
                                                            <i class="fa fa-building fa-4x" ></i>
                                                             <!-- <img class="fa" src="gifs/book.gif">  -->
                                                            <h2 class="label bottom">Agencymanagement</h2>
                                                        </a>
                                                    </div>
                                                    <!-- 

                                                 <div class="btn-big orange"><i class="fa fa-user fa-2x"></i><h2
                                                    class="label bottom"data-toggle="modal"
                                                                data-target="#userLink">New User</h2></div> -->
                                                    <div class="btn-small violet">
                                                        <a href="usermanagement.php">
                                                            <i class="fa fa-user fa-4x"></i>
                                                            <h2 class="label bottom">Usermanagement</h2>
                                                        </a>
                                                    </div>
                                                    <div class="btn-big orange">
                                                        <a href="autologouttable.php">
                                                            <i class="fa fa-sign-out fa-4x"></i>
                                                            <h2 class="label bottom" data-toggle="modal" data-target="#userLink">Forcelogout</h2>
                                                        </a>
                                                    </div>
                                                    <div class="btn-big purple">
                                                        <a href="codedescrptionnew.php">
                                                            <i class="fa fa-book fa-4x" aria-hidden="true"></i>
                                                            <h2 class="label bottom">Codedescription</h2>
                                                        </a>
                                                    </div>
                                                    <div class="btn-big orange">
                                                        <a href="assesmenttype.php">
                                                           <i class="fa fa-file-text fa-4x" aria-hidden="true"></i>
                                                            <h2 class="label bottom">Assessmenttype</h2>
                                                        </a>
                                                    </div>
                                                    <div class="btn-small blue-light" id="">
                                                       
                                                       <a href="Pendingreason.php">
                                                        <i class="fa fa-comment fa-4x" aria-hidden="true"></i>
                                                        <h2 class="label bottom">Pendingreason</h2></a>
                                                    </div>
                                                    <div class="btn-small" id="">
                                                      
                                                    </div>
                                                    <div class="btn-big green">
                                                        <a href="cpsccode.php">
                                                       <i class="fa fa-copyright fa-4x" aria-hidden="true"></i>
                                                        <h2 class="label bottom">Cpsccode</h2></a>
                                                    </div>

                                                    <div class="btn-small violet">
                                                        <a href="hhrgcodevalue.php">
                                                        <i class="fa fa-header fa-4x" aria-hidden="true"></i>
                                                        <h2 class="label bottom" >Hhrgvalue</h2></a>
                                                    </div>
                                                    <div class="btn-small bluethree">
                                                        <a href="Comorbiditygrphigh.php">
                                                          <i class="fa fa-expand fa-4x" aria-hidden="true"></i>
                                            
                                                        <h2 class="label bottom">Comorbidityhigh</h2></a>
                                                    </div>
                                                    <div class="btn-small purple">
                                                         <a href="Comorbiditygrplow.php">
                                                        <i class="fa fa-compress fa-4x" aria-hidden="true"></i>
                                                        <h2 class="label bottom">Comorbiditylow</h2></a>
                                                    </div>
                                                     <div class="btn-big photo">
                                                          <a href="Maintainence.php">
                                                            <img src="https://healthrevpartners.com/wp-content/uploads/2022/06/OASIS-E-blog.jpg"
                                                            class="img-delay-1" />
                                                        <h2 class="label bottom">Oasisitems</h2></a>
                                                       
                                                    </div>
                                                    <div class="btn-small red">
                                                        <a href="Maintainence.php">
                                                            <i class="fa-brands fa-get-pocket fa-4x" style="color: #ffffff; margin-top:25px;"></i>
                                                        <h2 class="label bottom">Pocitems</h2></a>
                                                    </div>
                                                    <br>
                                                   
                                                   <div class="btn-big blue-light">
                                                       <a href="Pdgmoasis.php">
                                                         <i class="fa fa-p fa-4x" aria-hidden="true" style="color: #ffffff;"></i>
                                                        <h2 class="label bottom">Pdgmoasisvalue</h2></a>
                                                      
                                                    </div>
                                                  <div class="btn-small green " id="hppscode">
                                                    <a href="hppscodemanagement.php">
                                                         <i class="fa fa-header fa-4x" aria-hidden="true"></i></a>
                                                        <h2 class="label bottom">Hppscode</h2>
                                                    </div>
                                                <div class="btn-big violet">
                                                        <a href="Qc_scoringmanagement.php">
                                                          <i class="fa  fa-q fa-4x" aria-hidden="true"></i>
                                                            <h2 class="label bottom">Qc Scoring System</h2>
                                                        </a>
                                                    </div>

                                                <div class="btn-small bluethree">
                                                        <a href="assessmentform.php">
                                                          <i class="fa-solid fa-a fa-4x" aria-hidden="true" style="color: #ffffff;margin-top:25px;"></i>
                                                            <h2 class="label bottom">Assessment Form</h2>
                                                        </a>
                                                    </div>
                                                        <!-- <div class="btn-big blue">
                                                        <a href="">
                                                          
                                                            <h2 class="label bottom" data-toggle="modal" data-target="#userLink">Force Logout</h2>
                                                        </a>
                                                    </div>
                                                    <div class="btn-small purple " id="newoasis">
                                                       
                                                        <h2 class="label bottom">New Oasis Items</h2>
                                                    </div> 
                                                    <div class="btn-small blue-light " id="newoasis">
                                                        <h2 class="label bottom">New Oasis Items</h2>
                                                    </div> -->
                        
                        


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <style>
            .custom-scroll {
                overflow-x: auto;
                overflow-y: auto;
                max-height: 600px;
                /* Set a max height if needed */
            }
        </style>
        </div> <?php
        include 'include_file/pulg.php';
        ?>
        <!-- Add scripts for Bootstrap and other dependencies here -->
        <script src="https://cdn.lordicon.com/lordicon.js"></script>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <!-- Include jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Bootstrap JavaScript -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    </body>
</html>