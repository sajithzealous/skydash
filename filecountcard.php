          



          <div class="row">
            <div class="col-md-6 grid-margin transparent">
              <div class="row">
                <div class="col-md-6 mb-4 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card" style="background-color:#e84d4c;">
                    <div class="card-body  demo" id="new_file">
                      <h3 class="mb-4" style="color:white">New Files</h3>
                      <p class="fs-30 mb-1" id="NEW"> </p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card" style="background-color:#4c553b;">
                    <div class="card-body" id="ass_file">
                      <h3 class="mb-4"  style="color:white">Files Assigned</h3>
                      <p class="fs-30 mb-2" id="assing"></p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card" style="background-color:#bc6e2a;">
                    <div class="card-body" id="wip_file">
                      <h3 class="mb-4" style="color:white">Wip</h3>
                      <p class="fs-30 mb-2" id="processing"></p>
                
                    </div>
                  </div>
                </div>
                <div class="col-md-6 stretch-card transparent"
                data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card" style="background-color:#5c49ac;">
                    <div class="card-body" id="cmd_file">
                      <h3 class="mb-4"  style="color:white">Alloted To Qc</h3>
                      <p class="fs-30 mb-2" id="COM"></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 grid-margin transparent">
              <div class="row">
                <div class="col-md-6 mb-4 stretch-card transparent"
                data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card" style="background-color:#dc2f06;">
                    <div class="card-body" id="assign_tem">
                      <h3 class="mb-4"  style="color:white">Assign To Team</h3>
                      <p class="fs-30 mb-2" id="ass_team"></p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent"
                data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card" style="background-color:#f99006;">
                    <div class="card-body" id="Inprogress">
                      <h3 class="mb-4"  style="color:white">On Hold</h3>
                      <p class="fs-30 mb-2"id="inp"></p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent" data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card" style="background-color:#d85898">
                    <div class="card-body" id="Pending">
                      <h3 class="mb-4"  style="color:white">Pending </h3>
                      <p class="fs-30 mb-2" id="pnd"></p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 stretch-card transparent"
                data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card" style="background-color:#bc1a04;">
                    <div class="card-body" id="Qcwip">
                      <h3 class="mb-4"  style="color:white">Qc Wip</h3>
                      <p class="fs-30 mb-2" id="qcwip"></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 grid-margin transparent">
              <div class="row">
                <div class="col-md-6 mb-4 stretch-card transparent"
                data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card"  style="background-color:#6e763b;">
                    <div class="card-body" id="qccmd_file">
                      <h3 class="mb-4"  style="color:white">Qc Completed</h3>
                      <p class="fs-30 mb-2" id="qc_com"></p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent"
                data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card" style="background-color:#f99212">
                    <div class="card-body" id="noqc">
                      <h3 class="mb-4"  style="color:white">No Qc</h3>
                      <p class="fs-30 mb-2"id="qc_no"></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 grid-margin transparent">
              <div class="row">
                <div class="col-md-6 mb-4 stretch-card transparent"
                data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card" style="background-color:#1b3668;">
                    <div class="card-body" id="aprd_file">
                      <h3 class="mb-4"  style="color:white">Files Approved</h3>
                      <p class="fs-30 mb-2" id="app"></p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent"
                data-toggle="modal" data-target=".bd-example-modal-lg-edit">
                  <div class="card" style="background-color:#cd3888">
                    <div class="card-body" id="dirctapp">
                      <h3 class="mb-4"  style="color:white">Direct Approved</h3>
                      <p class="fs-30 mb-2"id="directapp_count"></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>



<div class="modal fade bd-example-modal-lg-edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="myModal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header"><h3  class="sthd"> </h3>
          <!-- <i class="fa-sharp fa-solid fa-cloud-arrow-down fa-lg" id="showdown" title=" Download"style="cursor: pointer;"></i> -->
          <p class="card-title mb-0" id="exampleModalLabel"><span></p></span>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
          <div class="row">
            <div class="col-md-12 grid-margin stretch-card" >
              <div class="card">
                <div class="card-body"  >
                  <div class="table-responsive scroll" >
                    <table class="table table-striped table-hover " >
                      <thead class="thd text-white" id="head2" style="background-color: #088394;">
                        <tr class="thd">
                          <th>AllotedTeam</th> 
                          <th>Agency</th>
                          <th>PatientName</th>
                          <th>Mrn</th>
                          <th >Status</th>
                          <th>Coder</th>
                          <th>InsuranceType</th>
                          <th>AssesmentType</th>
                          <th>AssesmentDate</th>
                          <th>Preview</th>
                        </tr>  
                      </thead>
                      <tbody id="data-table" >
                        
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

<style>
 
    .bd-example-modal-lg-edit .modal-dialog {
    max-width: 80%; /* Adjust the width as needed */
  }

 
  #head2 {
        position: sticky;
        top: 0;
        background-color: white; /* Optional: Change background color as needed */
        z-index: 1500; /* Optional: Ensure the header appears above other elements */
    }

 .scroll {
    overflow-y: auto; /* This allows vertical scrolling if the content overflows the container vertically */
    overflow-x: auto; /* This is invalid CSS syntax; `overflow-x` property expects a value like `auto`, `hidden`, `scroll`, or `visible`, not a specific length like `500px` */
    max-height: 590px; /* This sets the maximum height of the container, beyond which it will start to scroll vertically */
}



        
 
</style>

<?php  $randomNumber = rand(1000, 9999);  ?>
<script src="upload/js/data_show_dash.js?<?php echo $randomNumber ?>"></script>
<script src="upload/js/count.js" type="text/javascript"></script>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.2/xlsx.full.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

 

<script>
 
 <?php include 'datepicker.js'; ?>


</script>