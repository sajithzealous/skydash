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
  <script src="code_des/js/code_des.js"></script>
  <!-- cdn link -->
  <link rel="stylesheet" href="code_des/css/code_desc.css">

  <!-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/fixedheader/3.1.9/js/dataTables.fixedHeader.min.js"></script> -->


  <?php

   include 'logsession.php';

  include('db/db-con.php');
  ?>


  <?php
  include  'include_file/link.php';
  ?>
<!-- 
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-modal-backdrop@1.0.1/css/bootstrap-modal-backdrop.min.css"> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- custom js-->
 
  <script src="https://code.jquery.com/jquery-3.7.0.js"></script> 
</head>

<body>



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
           
           <button type="button" class="btn btn-primary btn-round px-4  stock-editbtn1 "  data-toggle="modal" data-target="#upload_model"> Upload</button>  
          
        </div>
          <div class="row"  style="float:right;padding-right:50px;">
    
         
          <button type="button" class="btn btn-primary btn-round px-4  stock-editbtn1 "  data-toggle="modal" data-target="#codedesc_model"> Create</button>  
          </div>
          <!-- <div class="d-flex"><div class="form-check"> <label class="form-check-label"> <input type="checkbox" class=" row-checkbox  form-check-input fileCheck"  data-index="' + row.index_id + '"><i class="input-helper"></i></label> </div> <span class="mt-2"></span> </div> -->
          <!-- <input type="checkbox" id="select-all-checkbox"> Select All -->
          <!-- <input type="text" id="search_index_id" placeholder="Search Index ID"> -->
          <div class="row"  style="float:right;padding-right:50px;">
          <button id="delete-selected" class="btn btn-danger" >Delete </button>
          </div>
      <!-- main-panel ends -->
      <!-- <input type="text" id="search_index_id" placeholder="Search Index ID">
                       <button id="delete-selected">Delete Selected Rows</button> -->
                          <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top:60px;">
                            <div class="">

                            <table id="codedescription_table" class="display">
                                <thead>
                                    <tr class="headerrow">  
                                                                          
                                        <th>Index id </th>
                                        <th>Code </th>
                                        <th>Effective date  </th>
                                        <th>Short desc </th>
                                        <th>Long desc</th>
                                        <th>Classification </th>
                                        <th>Delete  </th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <!-- <table id="codedescription_table" class="display">
                    <thead>
                        <tr>
                            <th>Index ID </th>
                            <th>Code</th>
                            <th>Effective Date</th>
                            <th>Short Description</th>
                            <th>Long Description </th>
                            <th>Classification </th>
                        </tr>
                        <tr>
                        <th><input type="text" id="search_index_id">
                          </th>
                          <th>
                          <input type="text" id="search_code">
                          </th>
                          <th>
                          <input type="text" id="search_effective_date">
                          </th>
                          <th>
                          <input type="text" id="search_short_desc">
                          </th>
                          <th>
                          <input type="text" id="search_logn_desc">
                          </th>
                          <th>
                          <input type="text" id="search_classification">
                          </th>
                        </tr>
                    </thead>
                   
                </table> -->
                    
                  <!-- <table id="codedescription_table" class="display">
                      <thead class="headerrow">
                          <tr class>
                              <th>Index ID</th>
                              <th>Code</th>
                              <th>Effective Date</th>
                              <th>Short Description</th>
                              <th>Long Description</th>
                              <th>Classification</th>
                          </tr>
                          
                          
                      </thead>
                      <tbody></tbody>
                  </table> -->
            </div>
            </div>

            </div>
            </div>
        </div>
        </div>
      

          <div class="modal fade  bg-theme1" id="upload_model" data-backdrop="static" tabindex="-1" role="dialog" style="margin-top:-200px;width:40%;margin-left:600px;">
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
        
              <div class="card-body">
                <div class="row" id="proBanner">
              <div class="col-md-12 grid-margin">
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
         <button type="button" class="btn btn-success mr-2" name="submit" id="uploadCsvBtn" >Submit</button>
         <input type="button" class="btn btn-warning" value="Cancel" id="refreshBtn" />
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

<div class="modal fade  bg-theme1" id="codedesc_model" data-backdrop="static" tabindex="-1" role="dialog"  style="margin-top:-100px;width:50%;margin-left:500px;">
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
</div>
</div>
</div>
</label>
           
  
<script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
</body>

</html>

