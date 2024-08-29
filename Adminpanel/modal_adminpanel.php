<!-- New Agency Bootstrap Modal -->
  <div class="modal fade" id="newagencyLink" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLongTitle">Add
            New Agency</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="container mt-1">
            <form>
              <div class="form-group">
                <label for="textInput">Agency Name</label>
                <input type="text" class="form-control" id="textInputagencyname" name="textInputAgency"
                  placeholder="Enter Agency Name">
              </div>
                <div class="form-group">
                <label for="textInput">Client Name</label>
                <input type="text" class="form-control" id="textInputclientname" name="textInputClient"
                  placeholder="Enter Client Name">
              </div>
            <div class="form-group">
                <label for="textInput">Client Id</label>
                <input type="text" class="form-control" id="textInputclientid" name="textInputClientid"
                  placeholder="Enter Client Id">
              </div>

              <div class="form-group">
                <label for="selectInput">Status</label>
                <select class="form-control" id="selectInputAgency" name="selectInputAgency">
                  <option value="active">Active</option>
                  <!--<option value="option2">Option 2</option>
                                        <option value="option3">Option 3</option> -->
                </select>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="newagencydata">Save
              changes</button>
          </div>
        </div>
      </div>
    </div>
  </div>

      <!-- New User Modal -->
  <div class="modal fade" id="userLink" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLongTitle">New
            User</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="container mt-1">
            <form  id="userForm">
              <div class="form-group">
                <label for="textInput">User Name</label>
                <input type="text" class="form-control" id="textInputUser" name="textInputUser"
                  placeholder="Enter User Name">
                <label for="textInput">User Password</label>
                <input type="password" class="form-control" id="textInputpassword" name="textInput"
                  placeholder="Enter User Password">
              </div>

              <div class="form-group">
                <label for="textInput">Emp Id</label>
                <input type="text" class="form-control" id="textInputempid" name="textInputempid"
                  placeholder="Enter User Id">
                <label for="textInput">User Role</label>
                <select class="form-control" id="selectInputuserrole" name="selectInputuserrole">
                  <!-- <option value="Admin">Admin</option> -->
                  <option value="">None</option>
                  <option value="TeamManager">Team Manager</option>
                  <option value="TeamLeader">Team Leader</option>
                  <option value="user">Coder</option>
                  <option value="QA">QA Coder</option>
                  <option value="clinet">Client</option>
                  <option value="mis">Mis</option>
                  <option value="OperationalManager">Operational Manager</option>

                </select>
              </div>
              <div class="form-group">
                <label for="textInput">Organization</label>
                <input type="text" class="form-control" id="textInputOrganization" name="textInputOrganization"
                  placeholder="Enter Organization Name">
                <label for="textInput">User Status</label>
                <select class="form-control" id="selectInputStatus" name="selectInputStatus">
                  <option value="Active">Active</option>
                  <!--<option value="option2">Option 2</option>
                                        <option value="option3">Option 3</option> -->
                </select>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="newusersave">Save
              changes</button>
          </div>
        </div>
      </div>
    </div>
  </div>
















<!-- New Oasis  -->

<div class="modal fade" id="Oasisjson" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: solid;border-block-color: orange;">
                 <div class="form-row">
               
                                    <div class="container">
                                       <h4 class="modal-title" id="exampleModalLongTitle">New Agency Oasis</h4><br>
                            <div class="card-deck">
                                <div class="card cardfer">
                                    <img class="card-img-top" src="gifs/agency.gif" alt="Card image cap">
                                    <div class="card-body">
                                        <h3 class="card-title card-image-heading">Total Items</h3>
                                        <p class="card-text" id="Total-Items"></p>
                                        <!-- <input type="text" class="form-control" placeholder="Agency Name" id="Agencynameoasis"> -->
                                    </div>

                                </div>
                                <div class="card cardfer">
                                   <img class="card-img-top" src="gifs/inactiveagency.gif" alt="Image Description">
                                     <div class="card-body">
                                        <h3 class="card-title card-image-heading">Selected Items</h3>
                                        <p class="card-text" id="Selected-Items"></p>
                                        <!-- <input type="text" class="form-control" placeholder="Agency Id" id="Agencyidoasis"> -->
                                    </div>

                                </div>
                              <div class="card cardfer">
                                    <img class="card-img-top" src="gifs/agency.gif" alt="Card image cap">
                                    <div class="card-body">
                                        <h3 class="card-title card-image-heading">Agency Name</h3>
                                        <p class="card-text" id="Agency-name"></p>
                                        <!-- <input type="text" class="form-control" placeholder="Agency Name" id="Agencynameoasis"> -->
                                    </div>

                                </div>
                                  <div class="card cardfer">
                                    <img class="card-img-top" src="gifs/agency.gif" alt="Card image cap">
                                    <div class="card-body">
                                        <h3 class="card-title card-image-heading">Agency Id</h3>
                                        <p class="card-text" id="Agency-id"></p>
                                        <!-- <input type="text" class="form-control" placeholder="Agency Name" id="Agencynameoasis"> -->
                                    </div>

                                </div>
                            </div>
                       

                    </div>

               
    
      


      

    </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body custom-scroll" id="modaloasisjsonbody">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">

                            <table id="qa_oasis_table_data" class="display expandable-table "style="width:100%">

                                <thead>
                                    <tr>
                                        <!-- Table header content -->
                                    </tr>
                                </thead>
                                <tbody id="qa_oasis_table_body" >
                                    <!-- Checkbox items will be appended here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

  <!-- New Agency Json for Poc -->

  <div class="modal fade" id="Pocjson" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLongTitle">New
            Agency Poc</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modalpocjsonbody">





        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary">Save
            changes</button>
        </div>
      </div>
    </div>
  </div>

    <!-- New Qc Code Error Type Modal -->
  <div class="modal fade" id="qccodeerror" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLongTitle">New
            Qc Code Error</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="container mt-1">
            <form>
              <div class="form-group">
                <label for="textInput">Add New</label>
                <input type="text" class="form-control" id="textInputcode" name="textInputcode"
                  placeholder="Enter Data">
              </div>
              <div class="form-group">
                <label for="textInput">Status</label>
                <select class="form-control" id="selecterrorcodestatus" name="selecterrorcodestatus">
                  <option value="active">Active</option>
                  <!--<option value="option2">Option 2</option>
                                        <option value="option3">Option 3</option> -->
                </select>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="qccodeerrortype">Save
              changes</button>
          </div>
        </div>
      </div>
    </div>
  </div>
      <!-- New Qc Oasis Error Type Modal -->
  <div class="modal fade" id="qcoasiserror" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLongTitle">New
            Qc Oasis Error</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="container mt-1">
            <form>
              <div class="form-group">
                <label for="textInput">Add New</label>
                <input type="text" class="form-control" id="textInputoasis" name="textInputoasis"
                  placeholder="Enter Data">
              </div>
              <div class="form-group">
                <label for="textInput">Status</label>
                <select class="form-control" id="selecterroroasisstatus" name="selecterroroasisstatus">
                  <option value="active">Active</option>
                  <!--<option value="option2">Option 2</option>
                                        <option value="option3">Option 3</option> -->
                </select>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary"  id="qcoasiserrortype">Save
              changes</button>
          </div>
        </div>
      </div>
    </div>
  </div>
        <!-- New Qc Poc Error Type Modal -->
  <div class="modal fade" id="qcpocerror" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLongTitle">New
            Qc Poc Error</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="container mt-1">
            <form>
              <div class="form-group">
                <label for="textInput">Add New</label>
                <input type="text" class="form-control" id="textInputpoc" name="textInputpoc"
                  placeholder="Enter Data">
              </div>
              <div class="form-group">
                <label for="textInput">Status</label>
                <select class="form-control" id="selecterrorpocstatus" name="selecterrorpocstatus">
                  <option value="Active">Active</option>
                  <!--<option value="option2">Option 2</option>
                                        <option value="option3">Option 3</option> -->
                </select>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="qcpocerrortype">Save
              changes</button>
          </div>
        </div>
      </div>
    </div>
  </div>




 <!-- New Qc Pending Reason Modal -->
  <div class="modal fade" id="pendingreason" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLongTitle">Pending Reason</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="container mt-1">
            <form>
              <div class="form-group">
                <label for="textInput">Add New</label>
                <input type="text" class="form-control" id="textInputpending" name="textInputpending"
                  placeholder="Enter Data">
              </div>
              <div class="form-group">
                <label for="textInput">Status</label>
                <select class="form-control" id="selecterrorpendingstatus" name="selecterrorpendingstatus">
                  <option value="Active">Active</option>
                  <!--<option value="option2">Option 2</option>
                                        <option value="option3">Option 3</option> -->
                </select>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="pendingreasontype">Save
              changes</button>
          </div>
        </div>
      </div>
    </div>
  </div>


   <!-- New Comorbidity High Modal -->
  <div class="modal fade uploadclass" id="comorbidityhigh" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLongTitle">Comorbidity High</h4>
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
          </div>
        </div>
      </div>
    </div>
  </div>






<!-- <script>
const form = document.querySelector(".formdata"),
fileInput = document.querySelector(".file-input"),
progressArea = document.querySelector(".progress-area"),
uploadedArea = document.querySelector(".uploaded-area");

// form click event
form.addEventListener("click", () =>{
  fileInput.click();
});

fileInput.onchange = ({target})=>{
  let file = target.files[0]; //getting file [0] this means if user has selected multiple files then get first one only
  if(file){
    let fileName = file.name; //getting file name
    if(fileName.length >= 12){ //if file name length is greater than 12 then split it and add ...
      let splitName = fileName.split('.');
      fileName = splitName[0].substring(0, 13) + "... ." + splitName[1];
    }
    uploadFile(fileName); //calling uploadFile with passing file name as an argument
  }
}

// file upload function
function uploadFile(name){
  let xhr = new XMLHttpRequest(); //creating new xhr object (AJAX)
  xhr.open("POST", "php/upload.php"); //sending post request to the specified URL
  xhr.upload.addEventListener("progress", ({loaded, total}) =>{ //file uploading progress event
    let fileLoaded = Math.floor((loaded / total) * 100);  //getting percentage of loaded file size
    let fileTotal = Math.floor(total / 1000); //gettting total file size in KB from bytes
    let fileSize;
    // if file size is less than 1024 then add only KB else convert this KB into MB
    (fileTotal < 1024) ? fileSize = fileTotal + " KB" : fileSize = (loaded / (1024*1024)).toFixed(2) + " MB";
    let progressHTML = `<li class="row">
                          <i class="fas fa-file-alt"></i>
                          <div class="content">
                            <div class="details">
                              <span class="name">${name} • Uploading</span>
                              <span class="percent">${fileLoaded}%</span>
                            </div>
                            <div class="progress-bar">
                              <div class="progress" style="width: ${fileLoaded}%"></div>
                            </div>
                          </div>
                        </li>`;
    uploadedArea.innerHTML = ""; //uncomment this line if you don't want to show upload history
    uploadedArea.classList.add("onprogress");
    progressArea.innerHTML = progressHTML;
    if(loaded == total){
      progressArea.innerHTML = "";
      let uploadedHTML = `<li class="row">
                            <div class="content upload">
                              <i class="fas fa-file-alt"></i>
                              <div class="details">
                                <span class="name">${name} • Uploaded</span>
                                <span class="size">${fileSize}</span>
                              </div>
                            </div>
                            <i class="fas fa-check"></i>
                          </li>`;
      uploadedArea.classList.remove("onprogress");
      uploadedArea.innerHTML = uploadedHTML; //uncomment this line if you don't want to show upload history
      uploadedArea.insertAdjacentHTML("afterbegin", uploadedHTML); //remove this line if you don't want to show upload history
    }
  });
  let data = new FormData(form); //FormData is an object to easily send form data
  xhr.send(data); //sending form data
}

  </script> -->