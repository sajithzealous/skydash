<header>

  <div class="container">
    <div class="row">
      
    </div>
  </div>
</header>

<section class="mt-4">
  <div class="container">
    <form class="card fw-card">
      <div class="card-header">
        <nav class="nav  nav-fill">
          <a class="nav-link tab-pills text-bold">1st 30 Days Billing Period</a>
          <a class="nav-link tab-pills">2nd 30 Days Billing Period</a>
         <!--  <a class="nav-link tab-pills" href="#">Company Details</a>
          <a class="nav-link tab-pills" href="#">Finish</a> -->
        </nav>
      </div>

      <!-- =================================================FIRST 30 DAYS BILLING CODE======================================================== -->

      <div class="card-body ">
        <div class="tab d-none">

         <div class="row">
          <div class="mb-3 col-md-4">
            <label for="name" class="form-label">ICD-Code</label>
            <input type="text" class="form-control" name="icdone" id="icdone" placeholder=" Enter ICD-Code">
          </div>
           <div class="mb-3 col-md-8">
            <label for="name" class="form-label">Description</label>
            <input type="text" class="form-control" name="name" id="desone" placeholder="" disabled>
          </div>

          </div>
          <div class="row">
          <div class="mb-3 col-md-4">
            <label for="email" class="form-label">AdmissionSource & Timing</label>
            <select class="form-control" id="adtone">
               <option value="Community Early">Community Early</option>
               <option value="Institutional Early">Institutional Early</option>
               <option value="Community Late">Community Late</option>
                <option value="Institutional Late">Institutional Late</option>
             </select>
          </div>
             <div class="mb-3 col-md-4">
            <label for="email" class="form-label">ClinicalGroup </label>
            <input type="email" class="form-control" name=" " id="cglone" placeholder=" Enter ClinicalGroup" disabled>
          </div>

          <div class="mb-3 col-md-4">
            <label for="email" class="form-label">Level</label>
            <select class="form-control" id="levelone">
               <option value="Low">Low</option>
               <option value="Medium">Medium</option>
               <option value="High">High</option>
             </select>
          </div>
        </div>

          <div class="row">
           
           <div class="mb-3 col-md-6">
            <label for="email" class="form-label"> Comorbidity Adjustment</label>
             <select class="form-control" id="caone">
               <option value="0">0</option>
               <option value="1">1</option>
               <option value="2">2</option>
             </select>
          </div>
            <div class="mb-3 col-md-6">
            <label for="password" class="form-label">LUPA Level</label>
            <input type="number" class="form-control" name=" " id="lupaone" placeholder="Enter LUPA ">
          </div>
          </div>
          <div class="row">
        
           <div class="mb-3 col-md-6">
            <label for="password" class="form-label">HIPPS Code</label>
            <input type="text" class="form-control" name=" " id="hippsone" placeholder=" Enter HIPPS ">
          </div>
          <div class="mb-3 col-md-6">
            <label for="password" class="form-label">OASIS Revenue</label>
            <input type="text" class="form-control" name=" " id="revenueone" placeholder=" Enter OASIS ">
          </div>
          </div>
          </div>
     

<!-- =================================================SECOND 30 DAYS BILLING CODE======================================================== -->
        <div class="tab d-none">
        <div class="row">
          <div class="mb-3 col-md-4">
            <label for="name" class="form-label">ICD-Code</label>
            <input type="text" class="form-control" name="name" id="icdtwo" placeholder=" Enter ICD-Code">
          </div>
           <div class="mb-3 col-md-8">
            <label for="name" class="form-label">Description</label>
            <input type="text" class="form-control" name="name" id="destwo" value="" placeholder="  "  disabled>
          </div>

          </div>
          <div class="row">
          <div class="mb-3 col-md-4">
            <label for="email" class="form-label">AdmissionSource & Timing</label>
            <select class="form-control" id="adttwo">
               <option value="Community Early">Community Early</option>
               <option value="Institutional Early">Institutional Early</option>
               <option value="Community Late">Community Late</option>
                <option value="Institutional Late">Institutional Late</option>
             </select>
          </div>
             <div class="mb-3 col-md-4">
            <label for="email" class="form-label">ClinicalGroup</label>
            <input type="email" class="form-control" name=" " id="cgltwo" placeholder=" Enter ClinicalGroup" disabled>
          </div>


          <div class="mb-3 col-md-4">
            <label for="email" class="form-label">Level</label>
            <select class="form-control" id="leveltwo">
               <option value="Low">Low</option>
               <option value="Medium">Medium</option>
               <option value="High">High</option>
             </select>
          </div>
        </div>

          <div class="row">
           
           <div class="mb-3 col-md-6">
            <label for="email" class="form-label" > Comorbidity Adjustment</label>
             <select class="form-control" id="catwo">
               <option value="0">0</option>
               <option value="1">1</option>
               <option value="2">2</option>
             </select>
          </div>
            <div class="mb-3 col-md-6">
            <label for="password" class="form-label">LUPA Level</label>
            <input type="number" class="form-control" name=" " id="lupatwo" placeholder="Enter LUPA ">
          </div>
          </div>
          <div class="row">
        
           <div class="mb-3 col-md-6">
            <label for="password" class="form-label">HIPPS Code</label>
            <input type="text" class="form-control" name=" " id="hippstwo" placeholder=" Enter HIPPS ">
          </div>
          <div class="mb-3 col-md-6">
            <label for="password" class="form-label">OASIS Revenue</label>
            <input type="text" class="form-control" name=" " id="revenuetwo" placeholder=" Enter OASIS ">
          </div>
          </div>
           
        </div>

     <!--    <div class="tab d-none">
          <div class="mb-3">
            <label for="company_name" class="form-label">Company Name</label>
            <input type="text" class="form-control" name="company_name" id="company_name" placeholder="Please enter company name">
          </div>
          <div class="mb-3">
            <label for="company_address" class="form-label">Company Address</label>
            <textarea class="form-control" name="company_address" id="company_address" placeholder="Please enter company address"></textarea>
          </div>
        </div>

        <div class="tab d-none">
          <p>All Set! Please submit to continue. Thank you</p>
        </div> -->

      </div>
      <div class="card-footer text-end">
       <div class="d-flex float-right">
  <button type="button" id="back_button" class="btn btn-info" onclick="back()">Back</button>
  <button type="button" id="next_button" class="btn btn-primary ml-2 ms-auto" onclick="next()">Next</button>
  <button type="button" id="billingsave" class="btn btn-primary ml-2 ms-auto" style="display:none;" onclick="save()">Save</button>
</div>

      </div>
    </form>
  </div>


  <style>
    .fw-card{
      background-color:#f6f8f9;
    }
.active{
  background-color: #5bb8e6;
  color: white;
}

  </style>
</section>

<script>
  var current = 0;
var tabs = $(".tab");
var tabs_pill = $(".tab-pills");

loadFormData(current);

function loadFormData(n) {
  $(tabs_pill[n]).addClass("active");
  $(tabs[n]).removeClass("d-none");
  
  // Disable "Back" button on the first tab
  $("#back_button").attr("disabled", n == 0 ? true : false);
  
  if (n == tabs.length - 1) {
    // On the last tab, hide the "Next" button and show the "Save" button
    $("#next_button").hide();
    $("#billingsave").show();
  } else {
    // On other tabs, show the "Next" button and hide the "Save" button
    $("#next_button")
      .attr("type", "button")
      .text("Next")
      .attr("onclick", "next()")
      .show();
    $("#billingsave").hide();
  }
}





function next() {
  $(tabs[current]).addClass("d-none");
  $(tabs_pill[current]).removeClass("active");

  current++;
  loadFormData(current);
}

function back() {
  $(tabs[current]).addClass("d-none");
  $(tabs_pill[current]).removeClass("active");

  current--;
  loadFormData(current);
}

  
</script>

 

</script>
 