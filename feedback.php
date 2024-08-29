<?php 

session_start();
 
  include('db/db-con.php');
  include  'include_file/link.php';
      $role = $_SESSION['role'];
      $user = $_SESSION['username'];
      $emp_id = $_SESSION['empid'];
      $agency_name = $_SESSION['agency'] 

  
   
  ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> </title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!-- <link rel="stylesheet" href="code_des/css/code_desc.css"> -->
    <link rel="stylesheet" href="./css/filter/filter.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link href='https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css' rel='stylesheet' type='text/css'>
 
<style>
    /* Custom style for Excel button */
.custom-excel-button {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    border-radius: 8px;
}

/* Custom style for CSV button */
.custom-csv-button {
    background-color: #008CBA; /* Blue */
    border: none;
    color: white;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    border-radius: 8px;
}

 

/* Fix table header */
  #head {
        position: sticky;
        top: 0;
        background-color: white; /* Optional: Change background color as needed */
        z-index: 1500; /* Optional: Ensure the header appears above other elements */
    }
     #head1 {
        position: sticky;
        top: 0;
        background-color: white; /* Optional: Change background color as needed */
        z-index: 1500; /* Optional: Ensure the header appears above other elements */
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

 /* checkbox settings 👇 */

.ui-checkbox {
  --primary-color: #1677ff;
  --secondary-color: #fff;
  --primary-hover-color: #4096ff;
  /* checkbox */
  --checkbox-diameter: 20px;
  --checkbox-border-radius: 5px;
  --checkbox-border-color: #d9d9d9;
  --checkbox-border-width: 1px;
  --checkbox-border-style: solid;
  /* checkmark */
  --checkmark-size: 1.2;
}

.ui-checkbox, 
.ui-checkbox *, 
.ui-checkbox *::before, 
.ui-checkbox *::after {
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
}

.ui-checkbox {
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  width: var(--checkbox-diameter);
  height: var(--checkbox-diameter);
  border-radius: var(--checkbox-border-radius);
  background: var(--secondary-color);
  border: var(--checkbox-border-width) var(--checkbox-border-style) var(--checkbox-border-color);
  -webkit-transition: all 0.3s;
  -o-transition: all 0.3s;
  transition: all 0.3s;
  cursor: pointer;
  position: relative;
}

.ui-checkbox::after {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  -webkit-box-shadow: 0 0 0 calc(var(--checkbox-diameter) / 2.5) var(--primary-color);
  box-shadow: 0 0 0 calc(var(--checkbox-diameter) / 2.5) var(--primary-color);
  border-radius: inherit;
  opacity: 0;
  -webkit-transition: all 0.5s cubic-bezier(0.12, 0.4, 0.29, 1.46);
  -o-transition: all 0.5s cubic-bezier(0.12, 0.4, 0.29, 1.46);
  transition: all 0.5s cubic-bezier(0.12, 0.4, 0.29, 1.46);
}

.ui-checkbox::before {
  top: 40%;
  left: 50%;
  content: "";
  position: absolute;
  width: 4px;
  height: 7px;
  border-right: 2px solid var(--secondary-color);
  border-bottom: 2px solid var(--secondary-color);
  -webkit-transform: translate(-50%, -50%) rotate(45deg) scale(0);
  -ms-transform: translate(-50%, -50%) rotate(45deg) scale(0);
  transform: translate(-50%, -50%) rotate(45deg) scale(0);
  opacity: 0;
  -webkit-transition: all 0.1s cubic-bezier(0.71, -0.46, 0.88, 0.6),opacity 0.1s;
  -o-transition: all 0.1s cubic-bezier(0.71, -0.46, 0.88, 0.6),opacity 0.1s;
  transition: all 0.1s cubic-bezier(0.71, -0.46, 0.88, 0.6),opacity 0.1s;
}

/* actions */

.ui-checkbox:hover {
  border-color: var(--primary-color);
}

.ui-checkbox:checked {
  background: var(--primary-color);
  border-color: transparent;
}

.ui-checkbox:checked::before {
  opacity: 1;
  -webkit-transform: translate(-50%, -50%) rotate(45deg) scale(var(--checkmark-size));
  -ms-transform: translate(-50%, -50%) rotate(45deg) scale(var(--checkmark-size));
  transform: translate(-50%, -50%) rotate(45deg) scale(var(--checkmark-size));
  -webkit-transition: all 0.2s cubic-bezier(0.12, 0.4, 0.29, 1.46) 0.1s;
  -o-transition: all 0.2s cubic-bezier(0.12, 0.4, 0.29, 1.46) 0.1s;
  transition: all 0.2s cubic-bezier(0.12, 0.4, 0.29, 1.46) 0.1s;
}

.ui-checkbox:active:not(:checked)::after {
  -webkit-transition: none;
  -o-transition: none;
  -webkit-box-shadow: none;
  box-shadow: none;
  transition: none;
  opacity: 1;
}
 

 

</style>
<style>
  .dropdown {
    position: relative;
    display: inline-block;
  }

  .dropdown-toggle {
    background-color: #f1f1f1;
    padding: 10px;
    cursor: pointer;
    border: 1px solid #ccc;
    border-radius: 4px;
  }
.dropdown-menu {
    z-index: 18000;
}
  .dropdown-menu {
    display: none;
    position: absolute;
    background-color: white;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 200px;
  }

  .dropdown-menu ul {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .dropdown-menu li {
    margin: 5px 0;
  }

  .dropdown-menu input {
    margin-right: 10px;
  }

  .dropdown.open .dropdown-menu {
    display: block;
  }
</style>
</head>



<?php

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sth = $conn->prepare("SELECT Team,team_emp_id FROM coders GROUP BY Team,team_emp_id;
 ");
    $sth->execute();
    $team = $sth->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sth = $conn->prepare("SELECT file_status FROM `filestatus` WHERE `status`='active'");
    $sth->execute();
    $status = $sth->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sth = $conn->prepare("SELECT agency FROM `Main_Data` GROUP BY `agency`");
    $sth->execute();
    $agency = $sth->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}





 ?>

<body>
    <div class="container-scroller">
        <!-- Navbar -->
        <?php include 'include_file/profile.php'; ?>

        <div class="container-fluid page-body-wrapper">
            <!-- Sidebar -->
            <?php include 'include_file/sidebar.php'; ?>

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                      
                    </div>
 

               
   





     
 



<!-- FEED BACK-REPORT -->


 <div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
            <p class="card-title mb-0 text-primary text-uppercase">QAFeedBack-Report</p><br><br>
            <button type="button" class="btn btn-primary btn-sm float-right y-3" id="searchbtn3" style="margin-top: -67px;">Search</button>
            <div class="dropdown float-right y-3" style="margin-top: -67px;margin-right: 97px">
  <div class="dropdown-toggle" style="background-color: #4B49AC; color:white;border-radius:25px;font-size:10px"><b> Custom Column View</div></b>
  <div class="dropdown-menu">
    <ul class="items" s>
 
      <li><input type="checkbox" class="column-toggle ui-checkbox" data-column="1" checked> CoderName </li>
      <li><input type="checkbox" class="column-toggle ui-checkbox" data-column="2" checked> CoderEmpid</li>
      <li><input type="checkbox" class="column-toggle ui-checkbox" data-column="4" checked> Patient_name </li>
      <li><input type="checkbox" class="column-toggle ui-checkbox" data-column="19" checked>Coder-Previwe  </li>
      <li><input type="checkbox" class="column-toggle ui-checkbox" data-column="20" checked>QC-Previwe  </li>
      <li><input type="checkbox" class="column-toggle ui-checkbox" data-column="21" checked>Final-Previwe  </li>
      <li><input type="checkbox" class="column-toggle ui-checkbox" data-column="8" checked> TeamLeader</li>
      <li><input type="checkbox" class="column-toggle ui-checkbox" data-column="9" checked> TeamLeader-Id</li>
      <li><input type="checkbox" class="column-toggle ui-checkbox" data-column="10" checked> Insurance-type</li>
      <li><input type="checkbox" class="column-toggle ui-checkbox" data-column="11" checked> Assesment-date</li>
      <li><input type="checkbox" class="column-toggle ui-checkbox" data-column="11" checked> Assesment-type</li>
    </ul>
  </div>
</div>
            <h4 class="card-title">Filters</h4>
            <form class="form-sample">
                <div class="row">
                <div class="col-md-2">
    <div class="form-group row">
        <label class="col-sm-4 col-form-label">From Date</label>
        <div class="col-sm-8">
            <input type="date" class="form-control" id="from_date3" value="<?php echo date('Y-m-d'); ?>" required>
        </div>
    </div>
</div>
<div class="col-md-2">
    <div class="form-group row">
        <label class="col-sm-4 col-form-label">To Date</label>
        <div class="col-sm-8">
            <input type="date" class="form-control" id="to_date3" value="<?php echo date('Y-m-d'); ?>" required>
        </div>
    </div>
</div>

                    <div class="col-md-2">
                        <div class="form-group row">
                             <!-- <span style="color: red;">*</span> -->
                            <!-- <label class="col-sm-4 col-form-label bold" style="margin-right: -40px;">Team</label> -->
                            <div class="col-sm-10">
                               <!--  <select class="form-control" name="team" id="team_select">
                                    <option value="">Select</option>
                                    <?php foreach ($team as $teams) { ?>
                                        <option value="<?= $teams['Team'] ?>"><?= $teams['Team'] ?></option>
                                    <?php } ?>
                                </select> -->
                                  <select class="form-control" name="team" id="team_select3" style="color:black;font-weight: 6000;">
    <option value="">Select-Team</option>
    <?php foreach ($team as $teams) { ?>
        <option value="<?= $teams['Team'] . ' - ' . $teams['team_emp_id'] ?>"><?= $teams['Team'] . ' - ' . $teams['team_emp_id'] ?></option>
    <?php } ?>
</select>  
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group row">
                            <!-- <label class="col-sm-4 col-form-label">Coder</label> -->
                            <div class="col-sm-10">
                                <select class="form-control" id="coder_name3" name="coder" style="color:black;font-weight: 6000;">
                                    <option value="">Coder-Name </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                            <div class="form-group row">
                                <!-- <label class="col-sm-4 col-form-label">Coder</label> -->
                                <div class="col-sm-10">
                                    <select class="form-control" id="agency" name="agency" style="color:black;font-weight: 6000;">
                                        <option value="">Agency</option>
                                        <?php foreach ($agency as $agencys) { ?>
                                            <option value="<?= $agencys['agency'] ?>"><?= $agencys['agency'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                           <div class="col-md-2">
                        <div class="form-group row">
                            <!-- <label class="col-sm-4 col-form-label">Status</label> -->
                            <div class="col-sm-10">
<select class="form-control" name="team" id="status3" style="color:black;font-weight: 6000;">
    <option value="">Status</option>
   
        <option value="Added">Add</option>
        <option value="Deleted">Delete</option>
        <option value="Modified">Modified</option>
        <option value="Others">Others</option>
    
</select>  
                            </div>
                        </div>
                    </div>
                                   <div class="col-md-2 ml-5">
                        <div class="form-group row">
                            <!-- <label class="col-sm-4 col-form-label">Status</label> -->
                             <!-- <span style="color: red;">*</span> -->
                            <div class="col-sm-10">

<select class="form-control" name="team" id="segment" style="color:black;font-weight: 6000;">
    <option value="">Select-Segment</option>
 <option value="All">All</option>  
         <option value="Codesegementqc">Code-Segment</option>  
        <option value="oasisqc">Oasis-Segment</option>
        <option value="Pocsegementqc">Poc-Segment</option>
   
    
</select>  
                            </div>
                        </div>
                    </div>
     
                </div>
            </form>
        </div>
    </div>
</div>
   

  <img id="download_excel2" src="images/dd.png" title="Download" class="NEW float-right hover:bg-primary-600" style="width: 45px; margin-top: -8px; margin-left: 420px; ">

         <div class="col-lg-12 grid-margin stretch-card">
         <div class="card">
 
        <div class="card-body">

 
   
 

           

           <div class="table-responsive scroll"  >
    <table class="table table-striped table-bordered" id="table_report3">
        <thead style="background: #4b49ac; color: white;"id="head2">
            <tr>
                <th>Sno</th>
                <th>Id</th>
                <th>Coder</th>
                <th>CoderEmpid</th>
                <th>Team</th>
                <th>TeamEmpid</th>
                <th>Patient name</th>
                <th>Mrn</th>
                <th>Status</th>
                <th>Insurance Type</th>
                <th>Assesment Date</th>
                <th>Assesment Type</th>
                <th>Agency</th>
                <th>Qc person</th>
                 <th>Mitem</th>
                <th>Coder Response</th>
                <th>QC Response</th>
                <th>Error Category</th>
                <th>Error Type</th>
                <th>Remark</th>                
                <th>Coded Date</th>
                <th>Alloted To Qc Date</th>
                <th>Audit Date</th>
                <th>Completed Date</th>
                
                 
            </tr>
        </thead>
        <tbody id="table_data3">
            
        </tbody>
    </table>
</div>

        </div>
    </div>
</div>



















 






           
           
          </div>
        </div>




 
<?php  $randomNumber = rand(1000, 9999);  ?>
 
 
 
 
                </div>
            </div>
        </div>
    </div>
 <script>
  document.querySelector('.dropdown-toggle').addEventListener('click', function() {
    this.parentElement.classList.toggle('open');
  });

  window.addEventListener('click', function(event) {
    if (!event.target.matches('.dropdown-toggle')) {
      var dropdowns = document.querySelectorAll('.dropdown');
      dropdowns.forEach(function(dropdown) {
        //dropdown.classList.remove('open');
      });
    }
  });
</script>
    <script src="report_files/js/team_wise_report_v2.js?<?php echo $randomNumber ?>"></script>
     <script src="report_files/js/feedback_report_download.js?<?php echo $randomNumber ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.2/xlsx.full.min.js"></script>
    <!-- Modal Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script> -->
    <!-- <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

 

    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>


</body>



<style>




.headerrow{
    text-align: center !important;
    background-color:#4b49ac !important;color:white;
/*    font-size: 200px;*/

}


    </style>

</html>
