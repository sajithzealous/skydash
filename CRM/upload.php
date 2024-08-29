<!DOCTYPE html>
<html lang="en">

<head>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.4/xlsx.full.min.js"></script>



  <?php

   include 'logsession.php';

 include('../db/db-con.php');


  
   
  ?>


  <?php
  include  'include_file/link.php';
  ?>



</head>

<body>


  <style>
    .custom-icon-class {
      font-size: 16px;

    }
  </style>
  <div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->

    <?php
    include 'include_file/profile.php';
    ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">



      <?php
      include 'include_file/sidebar.php'; // Use a relative path to include the file
      ?>


 
      <!-- 
   /srv/www/htdocs/skydash/include/sidebar.php
  --> <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">


            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
              <h4 class="card-title">Import File <a href="dataformat/dataformat.xlsx " download><h5 style="float:right"><img src="images/xls.png" class="float-right text-overlay" title="Download formate" style="width: 7%; "> </h5></a></h4> 
      

                  </p>
                  <form class="forms-sample" id="myForm" enctype="multipart/form-data">
 
                    <div class="form-group">
                      <label>File upload</label>

                      <div class="input-group col-xs-12">


                        <input class="form-control" type="file" id="formFile" accept=".csv">

                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary float-right clk"  type="button" style="background-color: #4B49AC;">Upload</button>
                        </span>
                      </div>
                    </div>
 
                  </form>

                  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>


                  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">




                  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>





                  <script src="upload/js/form.js" type="text/javascript"></script>
                  <script src="upload/js/insert.js" type="text/javascript"></script>
                </div>
              </div>
    
          </div>
        
 

 
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModalLabel">Empty Data Details</h5>
                <div id="success-message" class="alert alert-success alert-right" style="display: none;"></div>
                <div id="error-message" class="alert alert-danger alert-right" style="display: none;"></div>
                <button class="btn" id="export-click"><i class="fas fa-download alert-rig"></i></button>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <br>
            </div>
            <div class="modal-body" style="max-height: 500px; overflow-x: auto;">
                <!-- Content goes here -->
            </div>
        </div>
    </div>
</div>



     
          

        </div>

 
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title"></h4>



 

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label"><span>
                            Agency Name </label></span>

                        <div class="col-sm-9">
                          <span id="ag" style="color:red"></span>
                          <input type="text" class="form-control" id="agency" name="agency" placeholder="Agency Name" />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label"><span>
                            <center>Patient Name</center></label></span>
                        <div class="col-sm-9">
                          <span id="pt" style="color:red"></span>
                          <input class="form-control" placeholder="Patient Name" id="patient" name="patient" />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
             <!--        <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Task</label>
                        <div class="col-sm-9">
                          <span id="tk" style="color:red"></span>
                          <input type="text" class="form-control" id="task" name="task" placeholder="Task" />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label"><span>
                            <center>Mrn</center></label></span>
                        <div class="col-sm-9">
                          <span id="mr" style="color:red"></span>
                          <input type="text" class="form-control" id="mrn" name="mrn" placeholder="Mrn" />
                        </div>
                      </div>
                    </div> -->
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Assessment Date</label>
                        <div class="col-sm-9">
                          <span id="ad" style="color:red"></span>
                          <input type="date" class="form-control" id="asse_date" name="asse_date" />
                        </div>
                      </div>
                    </div>
                   </label>
                       <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label"><span>
                            <center>Assessment Type</center></label></span>
                        <div class="col-sm-9">
                          <span id="at" style="color:red"></span>
                          <input type="text" class="form-control" id="asse_type" name="asse_type" placeholder="Assessment Type" />
                        </div>
                      </div>
                    </div>
                 </div>

                
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Insurance Type</label>
                        <div class="col-sm-9">
                          <span id="it" style="color:red"></span>
                          <input type="text" class="form-control" id="insu_type" name="insu_type" placeholder="Insurance Type" />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label"><span>
                            <center>Status</center></label></span>

                        <div class="col-sm-9">
                          <span id="st" style="color:red"></span>
                          <select id="status" value="NEW" class="form-control">
                         
                            
                              <option class="status" name="status" id="status"> NEW</option>

 
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Priority</label>
                        <div class="col-sm-9">
                          <span id="pt" style="color:red"></span>
                          <input type="text" class="form-control" id="priority" name="Priority" placeholder="User Name" />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label"><span>
                            <center>Url</center></label></span>
                        <div class="col-sm-9">
                          <span id="Url" style="color:red"></span>
                          <input type="text" class="form-control" id="url" name="url" placeholder="Url" />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Mrn</label>
                        <div class="col-sm-9">
                          <span id="mr" style="color:red"></span>
                          <input type="text" class="form-control" id="mrn" name="mrn" placeholder="Mrn" />
                        </div>
                      </div>
                    </div>
                        <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label"><span>
                            <center>PhoneNumber</center></label></span>
                        <div class="col-sm-9">
                          <span id="ph" style="color:red"></span>
                          <input type="number" class="form-control" id="phone" name="asse_type" placeholder="PhoneNumber" />
                        </div>
                      </div>
                    </div>
                  </div>
                     <div class="col-md-6">

                    <button type="submit" class="btn btn-primary mr-2 clk_2" style="background-color: #4B49AC;">Submit</button>
                      <button class="btn btn-light" id="cancel">Cancel</button>

                  </div>
                  </div>

               
                </label>
                </div>
              </div>
            </div>
          </label>
        </div>
      </div>
    </div>
  </label>
</div>
</div>
</div>
</label>
           
     
    <!-- container-scroller -->
    <!-- plugins:js -->
    <?php
    include 'include_file/pulg.php';
    ?>

</body>

</html>

<style>
  .alert-right {
    position: fixed;
    right:140px; /* Position it to the right side */
    margin: 10px; /* Add margin to create some spacing from the edge */
     
}

.alert-rig{

  position: fixed;
    right:150px; /* Position it to the right side */
    padding:10px;
   font-size: 30px;


}



</style>