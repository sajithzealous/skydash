<!DOCTYPE html>
<html lang="en">

<head>




<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

  <script src="code_des/js/code_drop.js"></script>
  <!-- cdn link -->
 <!-- cdn link -->
 <link rel="stylesheet" href="code_des/css/code_desc.css">

<!-- Your code_drop.js script -->
<!-- <script src="path/to/your/code_drop.js"></script> -->


  <?php


  // include 'logsession.php';
  include('db/db-con.php');
  // include 'login_sessions/teamleader_session.php';
  include 'login_sessions/admin_session.php';
  ?>


  <?php
  include  'include_file/link.php';
  ?>

  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-modal-backdrop@1.0.1/css/bootstrap-modal-backdrop.min.css"> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- custom js-->
<!--  
  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>  -->
</head>

<body>

       <style>
    .custom-scroll {
        overflow-x: auto;
        overflow-y: auto;
        max-height: 700px; /* Set a max height if needed */
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

      <div class="main-panel">
        <div class="content-wrapper">
      
        <div class="row"  style="float:right;padding-right:25px;">
           
           <button type="button" class="  btn btn-primary mr-2 clk_2 "  data-toggle="modal" data-target="#upload_model"> Upload</button>  
          
        </div>
          <div class="row"  style="float:right;padding-right:40px;">
    
         
          <button type="button" class="  btn btn-primary mr-2 clk_2 "  data-toggle="modal" data-target="#codedesc_model"> Create</button>  
          </div>
          <!-- <div class="d-flex"><div class="form-check"> <label class="form-check-label"> <input type="checkbox" class=" row-checkbox  form-check-input fileCheck"  data-index="' + row.index_id + '"><i class="input-helper"></i></label> </div> <span class="mt-2"></span> </div> -->
          <!-- <input type="checkbox" id="select-all-checkbox"> Select All -->
          <!-- <input type="text" id="search_index_id" placeholder="Search Index ID"> -->
          <div class="row"  style="float:right;padding-right:40px;">
        
        <button id="delete-selected" class="btn btn-danger" >Delete </button>
        </div>
        <div class="row"  style="float:right;padding-right:40px;">
          <div id="total-count-label"  class="count_label mr-2 clk_2">Total :0</div>
          </div>
          <div class="row"  style="float:right;padding-right:40px;">
          <div id="selected-count-label"  class="select_count mr-2 clk_2">selected : 0 </div>
          </div>
        
    
        
       
      <!-- main-panel ends -->
      <!-- <input type="text" id="search_index_id" placeholder="Search Index ID">
                       <button id="delete-selected">Delete Selected Rows</button> -->
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12 custom-scroll" style="position: fixed; bottom: 0; width: 85%; top: 20%;  ">

                           

                            <div class="">

                           
                         
                            <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                            <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css"> -->
                            <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
                            <!-- Include DataTables individual column filtering plugin -->
                            <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/plug-ins/1.10.25/api/fnFilterClear.js"></script>
                            
                           <!-- Include Select2 CSS and JS from CDN -->
                            <!-- Select2 CSS -->
                            <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />


                            <!-- Select2 JS -->
                           <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


                           <div class="form-check form-check-flat">
                            <label class="form-check-label">
                           
                        
                           
                            </label>
												   </div>
                            <table id="codedescription_table" class="display table">
    
                              <thead >
                                  <tr class="headerrow">
                                      <th class="sorting">Index id</th>
                                      <th class="sorting">Code</th>
                                      <th class="sorting">Effective date</th>
                                      <th class="sorting">Short desc</th>
                                      <th class="sorting">Long desc</th>
                                      <th class="sorting">Classification</th>
                                      <th class="sorting">Select All    <input class="checkbox checkbox-lg" id="select-all-checkbox" type="checkbox"></th>
                                  </tr>
                              
                              </thead>
                             
                              <tfoot>
                                      <tr class="footerrow">
                                          <th></th>
                                          <th></th>
                                          <th></th>
                                          <th></th>
                                          <th></th>
                                          <th></th>
                                          <th></th>
                                      </tr>
                                  </tfoot>

                          
                          </table>

                
            </div>
            </div>

            </div>
            </div>
        </div>
        </div>
      

        <center>  <div class="modal fade bd-example-modal-lg-edit show" id="upload_model" data-backdrop="static" tabindex="-1" role="dialog" style="margin-top:-200px;width:40%;margin-left:600px;">
               <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
<!--    <h3 ><strong style="padding-left: 300px;">File Upload </strong></h3> -->
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                      </button>

                     </div>
                    <div class="modal-body">
                    <div class="row mt-3">
                    <div class="col-lg-2">
                    </div>
                  
                      <div class="col-lg-8">
                      <img src="xl-download.gif" alt="GIF Image" width="50px" id="csvsampledbtn" height="70px" class="iconimg" >
              <div class="card-body">
                <div class="row" id="proBanner">
              <div class="grid-margin">
                <div class="card bg-gradient-primary border-0">
                  <div class="card-body py-3 px-4 d-flex align-items-center justify-content-between flex-wrap">
                    <p class="mb-0 text-white font-weight-medium"> upload CSV file mandatory! Fill the data Carefully!! </p>
                  </div>
                </div>
              </div>
            </div>
            <div id="message"></div>
          <div class="row">
              <div class=" grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <!-- <h4 class="card-title">New User Create</h4> -->
                    <form id="csvUploadForm" enctype="multipart/form-data">
                    <input type="file" name="csvFile" id="csvFile" accept=".csv" required>
                  
                  </div>
                </div>
              </div>
          </div>
         <button type="button" class="btn btn-success mr-2" name="submit" id="uploadCsvBtn"  style="float:left  !important;">Submit</button>
         <input type="button" class="btn btn-warning" value="Cancel" id="refreshBtn"  style="float:left  !important;"/>
         </form>
            </div>
            </div>
   

      </div>
      <div class="col-lg-2">
      </div>
      </div>
      <div class="modal-footer">  
      </div>
    </div>
  </div>
</div>  </center>

<center><div class="modal fade bd-example-modal-lg-edit show" id="codedesc_model" data-backdrop="static" tabindex="-1" role="dialog" style="margin-top:-100px;width:50%;margin-left:500px;">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">  
            <div class="modal-header">
                 <h3 ><strong style="padding-left: 200px;">Add Code Description </strong></h3>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
            <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body" style="padding:0px 0px ">
      <div class="row mt-3">
      <div class="col-lg-2">
      </div>
        <div class="col-lg-8">
          <!-- <div class="card"> -->
              <div class="card-body">
              <!-- <hr> -->
              <form method="post" id="codedesFrom">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg " id="icd_code" title="please enter a ICD 10 Code"  name="icd_code" placeholder="ICD 10 CODE" required>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg " id="desc" name="desc" title="please enter a description" placeholder="DESCRIPTION" required>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg " id="clinical_grp"  name="clinical_grp" placeholder="CLINICAL GROUP"  title="please enter a clinical group" required>
                </div>
                
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="clinical_des" name="clinical_des" placeholder="CLINICAL GROUP DESCRIPTION" title="please enter a clinical group description" required>
                </div>
                <div class="form-group">
                  <select class="form-control form-control-lg" id="diagnosis_type" name="diagnosis_type"    title="please select a diagnosis type" required>
                  <option value="">DIAGNOSIS TYPE</option>
                    <option >Primary</option>
                    <option>Other</option>                 
                  </select>
                </div>
              
                <button type="submit"  class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SUBMIT </button>
               
              </form>
            </div>
            </div>
              </div>
                  <div class="col-lg-2">
                  </div>
                  </div>
                  <div class="modal-footer">  
                  </div>
              </div>
            </div>
          </div>
        </div>
        </div>
      </div>
    </div>
  </label>
</div>  </center>
</div>
</div>

           
<!--   
<script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script> -->
<!--   <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script> -->
</body>

</html>

