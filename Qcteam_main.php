<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  include 'login_sessions/qa_session.php';
   date_default_timezone_set('America/New_York');
  include('db/db-con.php');
  include  'include_file/link.php';
  ?>  
<!-- Include moment.js from CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<!-- custom js-->




<!-- custom js-->
<!-- custom css-->
 <!-- custom css-->
<!-- chart js-->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- chart js-->
 

</head>
<body>

  <div class="container-scroller">
        <?php
        include 'include_file/profile.php';
        ?>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_settings-panel.html -->
        <?php
        include 'include_file/sidebar.php'; // Use a relative path to include the file
        ?>
 
        <?php
           include 'style.php';
        ?>
 
 
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
 
            

            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                
                </div>
                <div class="col-12 col-xl-4">
                 <div class="justify-content-end d-flex">
                  
                   <!--  <input id="datepicker2" class="custom-daterangepicker">
                    <span> </span> -->

 
                <input id="ecommerce-dashboard-daterangepicker" class="custom-daterangepicker" ><span> </span>   

                   
              

                 </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
              <div class="col-md-6 grid-margin transparent">
              <div class="row">
                <div class="col-md-6 mb-4 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card card-tale " >
                    <div class="card-body" id="assign_to_qc" value="">
                      <h4> New</h4><br>
                      <p class="fs-30 mb-1" id="alloted_qc"> 0</p>
                      <p> </p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card" style="background-color:#648FA5;">
                    <div class="card-body " id="assign_coder">
                      <h4 style="color:white"> Assingned To QcCoder </h4><br>
                      <p class="fs-30 mb-1" id="assigned_qccoder" style="color:white"> 0</p>
                      <p> </p>
                    </div>
                  </div>
                </div>

              </div>
              <div class="row">
                <div class="col-md-6 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card  "style="background-color:#844957;">
                    <div class="card-body" id="dir_completed">
                       <h4 style="color:white">Direct Completed</h4><br>
                      <p class="fs-30 mb-1" id="direct_completed" style="color:white">0 </p>
                      <p> </p>
                    </div>
                  </div>
                </div>
                 <div class="col-md-6 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card  " style="background-color:#64A571;">
                    <div class="card-body" id="approve">
                  
                      <h4 style="color:white">Approved Files</h4><br>
                      <p class="fs-30 mb-1" id="approvedfile" style="color:white">0 </p>
                      <p> </p>
                    </div>
                  </div>
                </div>
              </div>

            </div>

  
            <div class="col-md-6 grid-margin transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
              <div class="row">
                <div class="col-md-6 mb-4 stretch-card transparent">
                  <div class="card   " style="background-color:#AB6C4A;">
                    <div class="card-body" id="wipqc">
                      <h4 style="color:white">QC WIP</h4><br>
                      <p class="fs-30 mb-1" id="qc_wip" style="color:white">0 </p>
                      <p> </p>
                    </div>
                  </div>
                </div>

                  <div class="col-md-6 mb-4 stretch-card transparent">
                  <div class="card   " style="background-color:#8664A5;">
                    <div class="card-body" id="qc_complete">
                      <h4 style="color:white">QC Completed</h4><br>
                      <p class="fs-30 mb-1" id="qc_com" style="color:white">0 </p>
                      <p> </p>
                    </div>
                  </div>
                </div>
            
            

              </div>
              
            </div>

          </div>
               <div class="row">
               <div class="col-md-12">
                <input id="datepicker1" class="custom-daterangepicker float-right">&nbsp;&nbsp;&nbsp;
              
                
                </div> 
                

              </div>  
              <br>
              
          
         
 
            <div class="col-md-12 ">
              <div class="card ">
                <div class="">
                  <div id="" class="  " data-ride="">
                    <div class="">
                      <div class="">
                        <div class="row">
                       
                              </div>  
                              </div>
                               <div class="col-md-12 mt-3">
                                <div class="card">
                               <div class="card-body">

                                 <p class="card-title mb-0 text-primary text-uppercase">Team Performance</p><br><br>
                                    <p class="card-title mb-0"> </p> 
                                    <div class="table-responsive custom-scroll1">

                                                
                                        <table class="table table-striped table-border table-hover">
                                        <thead id="headers1" class="bg-light">
                                            <tr>
                                            <center></center>
                                            <th class="pl-0  pb-2 border-bottom"style="text-align: center;">QC-Team</th>
                                            <th class="border-bottom pb-2">QC-Coder</th>
                                          
                                            <th class="border-bottom pb-2">Total</th>
                                            <th class="border-bottom pb-2">Assing File</th>
                                            <th class="border-bottom pb-2">QC WIP</th>
                                            <th class="border-bottom pb-2">QC-COMPLETED</th>
                                          
                                        
                          
                                            <th class="border-bottom pb-2">APPROVED</th>
                                            </tr>
                                        </thead>
                                        <tbody id="show_data">
                                        
                                        </tbody>
                                        </table>
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
        </div>
      </div>
    </div>   
  </div>
<!-- ------------------------------------------------------------- Model Design----------------------------------------------- -->
<style>
    

#head {
    position: sticky;
    top: 0;
    background-color: white;
    z-index: 1600; /* Adjust z-index as needed */
}

.scroll {
    max-height: 590px;
    overflow-y: auto;
}

 
</style>
  <!-- Edit modal -->
  <div class="container-fluid">
    
 
  <div class="modal fade bd-example-modal-lg-edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="myModal" aria-hidden="true" >
    <div class="modal-dialog modal-xl">
      <div class="modal-content mr-5" style="width: 120%;">
        <div class="modal-header">
          <p class="card-title mb-0" id="exampleModalLabel"><span></p></span>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card " >
              <div class="card">
                <div class="card-body">
                  <div class="table-responsive scroll">
    <table class="table table-striped table-hover">
        <thead class="thded text-white" >
            <tr class="thd text-primary bg-secondary"id="head">
                <!-- Your table headers here -->
            </tr>
        </thead>
        <tbody id="data-table">
            <!-- Table rows will be populated dynamically -->
        </tbody>
    </table>
</div>

                </div>
              </div>
            </div>
          </div>


      </div>
    </div>
  </div>  
 </div>

<?php  $randomNumber = rand(1000, 9999);  ?>
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <script src="qcteam_dash/js/Qcteam_dash.js? <?php echo $randomNumber ?>"></script>  
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

 

<script>
 
 <?php include 'datepicker.js'; ?>


</script>

</body>

</html>

