     <?php

      include 'logsession.php';
      include('../db/db-con.php');
     
      session_start();
      $role = $_SESSION['role'];
      $user = $_SESSION['username'];
      $emp_id = $_SESSION['empid'];

      // // Database connection details
      // $servername = "localhost";
      // $username = "zhcadmin";
      // $password = "d0m!n$24";
      // $dbname = "HCLI";

      // // Create connection
      // $conn = new mysqli($servername, $username, $password, $dbname);

      // // Check database connection
      // if ($conn->connect_error) {
      //   die("Connection failed: " . $conn->connect_error);
      // }
      // Initialize counts
      $countQcCompleted = 0;
      $countNew = 0;

      // Query for QC COMPLETED count
      $sqlQcCompleted = "SELECT COUNT(*) as QcCompletedCount FROM `Main_Data` WHERE `status` = 'QC COMPLETED' AND `alloted_to_coder`='$user'AND `coder_emp_id`='$emp_id'";
      $runqueryQcCompleted = mysqli_query($conn, $sqlQcCompleted);

      if ($runqueryQcCompleted) {
        $resultQcCompleted = mysqli_fetch_assoc($runqueryQcCompleted);
        $countQcCompleted = $resultQcCompleted['QcCompletedCount'];
      } else {
        echo "Error: " . mysqli_error($conn);
      }

      // Query for New count
      $sqlNew = "SELECT COUNT(*) as NewCount FROM `Main_Data` WHERE `status` IN ('ASSIGNED TO CODER', 'REASSIGNED TO CODER') AND `alloted_to_coder`='$user' AND `coder_emp_id`='$emp_id'";
      $runqueryNew = mysqli_query($conn, $sqlNew);

      if ($runqueryNew) {
        $resultNew = mysqli_fetch_assoc($runqueryNew);
        $countNew = $resultNew['NewCount'];
      } else {
        echo "Error: " . mysqli_error($conn);
      }

      // Query for COMPLETED count
      if($role=='user')
      {
           $sqlNew = "SELECT COUNT(*) as Qc_New FROM `Main_Data` WHERE `status` IN ('ALLOTED TO QC') AND `alloted_to_coder`='$user' AND `coder_emp_id`='$emp_id'";
           $runqueryNew = mysqli_query($conn, $sqlNew);
      }

      else if($role=='QA'){

         $sqlNew = "SELECT COUNT(*) as Qc_New FROM `Main_Data` WHERE `status` IN ('ALLOTED TO QC')";
          $runqueryNew = mysqli_query($conn, $sqlNew);
  
          
      }
            else if($role=='QaTl'){

         $sqlNew = "SELECT COUNT(*) as Qc_New FROM `Main_Data` WHERE `status` IN ('ALLOTED TO QC') AND  `qc_team_emp_id`='$emp_id'";
          $runqueryNew = mysqli_query($conn, $sqlNew);
  
          
      }
    
    

      if ($runqueryNew) {
        $resultNew = mysqli_fetch_assoc($runqueryNew);
        $Qc_New = $resultNew['Qc_New'];
      } else {
        echo "Error: " . mysqli_error($conn);
      }

      // Query for QC countApproved count
      $sqlQcCompleted = "SELECT COUNT(*) as countApproved FROM `Main_Data` WHERE `status` = 'APPROVED' AND `alloted_to_coder`='$user' AND `coder_emp_id`='$emp_id'";
      $runqueryApproved = mysqli_query($conn, $sqlQcCompleted);

      if ($runqueryApproved) {
        $resultApproved = mysqli_fetch_assoc($runqueryApproved);
        $countApproved = $resultApproved['countApproved'];
      } else {
        echo "Error: " . mysqli_error($conn);
      }

      // Calculating the total count
      // $totalCount = $countQcCompleted + $countNew;
      // Use $countQcCompleted and $countNew as needed in your HTML or further logic 

      ?>

    <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">

     <nav class="sidebar sidebar-offcanvas" id="sidebar">

       <ul class="nav">

    <?php if ($role == 'tm') { ?>

          <li class="nav-item">
             <a class="nav-link" href="index.php">
               <i class="icon-layout menu-icon"></i>
               <span class="menu-title">DashBoard</span>
             </a>
           </li>  
 <?php } ?>
         <?php if ($role == 'Admin') { ?>

          <li class="nav-item">
             <a class="nav-link" href="index.php">
               <i class="icon-layout menu-icon"></i>
               <span class="menu-title">DashBoard</span>
             </a>
           </li>  
  <!--           <li class="nav-item">
    <a class="nav-link" data-toggle="collapse" href="#form-elements-main" aria-expanded="false" aria-controls="form-elements-main">
        <i class="icon-columns menu-icon"></i>
        <span class="menu-title">Main Menu</span>
        <i class="menu-arrow"></i>
    </a>
    <div class="collapse" id="form-elements-main">
        <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" href="index.php">DashBoard</a></li>
        </ul>
    </div>
</li> -->

  
           <li class="nav-item">
             <a class="nav-link" href="home1.php">
               <i class="icon-grid menu-icon"></i>
               <span class="menu-title">Assign</span>
             </a>
           </li>

            <li class="nav-item">
             <a class="nav-link" href="Adminconsole.php">
               <i class="icon-layout menu-icon"></i>
               <span class="menu-title">Admin Console</span>
             </a>
           </li>
       
         <?php } ?>
         <?php if ($role == 'agency') { ?>
           <li class="nav-item">
             <a class="nav-link" href="agent_dash.php">
               <i class="icon-grid-2 menu-icon"></i>
               <span class="menu-title">Dashboard</span>
             </a>
           </li>
<!--            <li class="nav-item">
             <a class="nav-link" href="home1.php">
               <i class="icon-grid menu-icon"></i>
               <span class="menu-title">Main Menu</span>
             </a>
           </li> -->

      <li class="nav-item">
             <a class="nav-link" href="reports_agencywise.php">
               <i class="mdi mdi-view-grid menu-icon"></i>
               <span class="menu-title">Reports</span>
             </a>
           </li>

         <?php } ?>


          <?php if ($role == 'superadmin') { ?>
           <li class="nav-item">
             <a class="nav-link" href="index.php">
               <i class="icon-layout menu-icon"></i>
               <span class="menu-title">Main-DashBoard</span>
             </a>
           </li>
           <li class="nav-item">
             <a class="nav-link" href="home1.php">
               <i class="icon-grid menu-icon"></i>
               <span class="menu-title">Main Menu</span>
             </a>
           </li>
            <li class="nav-item">
             <a class="nav-link" href="form.php">
               <i class="icon-paper menu-icon"></i>
               <span class="menu-title">FileUpload</span>
             </a>
           </li>
            <li class="nav-item">
             <a class="nav-link" href="coder_main.php">
               <i class="icon-grid-2 menu-icon"></i>
               <span class="menu-title">coder-Dashboard</span>
             </a>
           </li>
            <li class="nav-item">
             <a class="nav-link" href="team_main.php">
               <i class="icon-grid-2 menu-icon"></i>
               <span class="menu-title">Team-Dashboard</span>
             </a>
           </li>

            <li class="nav-item">
             <a class="nav-link" href="Adminconsole.php">
               <i class="icon-layout menu-icon"></i>
               <span class="menu-title">Admin Console</span>
             </a>
           </li>
           <li class="nav-item">
             <a class="nav-link" href="assign_table.php">
               <i class="icon-columns menu-icon"></i>
               <span class="menu-title">Assigned Table
                 <?php if ($role == 'user' || $role == 'superadmin') { ?>
                   <label class="badge badge-info" title="New"><?php echo $countNew ?></label>
                 <?php } ?>
               </span>
             </a>
           </li>

            <li class="nav-item">
             <a class="nav-link" href="completed_chat_allocate.php">
               <i class="mdi mdi-view-week menu-icon"></i>
               <span class="menu-title">Alloted to QC
                 <?php if ($role == 'user' || $role == 'superadmin') { ?>
                   <label class="badge badge-info" title="New"><?php echo $Qc_New ?></label>
                 <?php } ?>
               </span>
             </a>
           </li>
            <li class="nav-item">
             <a class="nav-link" href="qc_completed_table.php">
               <i class="mdi mdi-chart-bar menu-icon"></i>
               <span class="menu-title">QC Completed-files
                 <label class="badge badge-info text-end" title="QC Completed"><?php echo $countQcCompleted ?></label>
               </span>
             </a>
           </li>

           <li class="nav-item">
               <a class="nav-link" href="Approved_table.php">
                 <i class="mdi mdi-basket-fill menu-icon"></i>
                 <span class="menu-title">Approved-files
                 <?php if ($role == 'user' || $role == 'superadmin') { ?>
                   <label class="badge badge-info text-end" title="Approved"><?php echo $countApproved ?></label>
                   <?php } ?>
                 </span>
               </a>
             </li>
              <li class="nav-item">
             <a class="nav-link" href="Qa_table.php">
               <i class="mdi mdi-bitbucket menu-icon"></i>
               <span class="menu-title">QA Bucket <label class="badge badge-info" title="QC Completed"><?php echo $Qc_New ?></label></span>
             </a>
           </li>
           <li class="nav-item">
             <a class="nav-link" href="Qa_work_files.php">
               <i class="mdi mdi-vk-box menu-icon"></i>
               <span class="menu-title">QA Work Files</span>
             </a>
           </li>
           <li class="nav-item">
             <a class="nav-link" href="qc_c.php">
               <i class="mdi mdi-beer menu-icon"></i>
               <span class="menu-title">Completed-files</span>
             </a>
           </li>

         <?php } ?>




   <?php if ($role == 'ceo') { ?>
           <li class="nav-item">
             <a class="nav-link" href="index.php">
               <i class="icon-layout menu-icon"></i>
               <span class="menu-title">Main-DashBoard</span>
             </a>
           </li>
           <li class="nav-item">
    <a class="nav-link" data-toggle="collapse" href="#form-elements-reports" aria-expanded="false" aria-controls="form-elements-reports">
        <i class="icon-columns menu-icon"></i>
        <span class="menu-title">Reports</span> 
        <i class="menu-arrow"></i>
    </a>
     <div class="collapse" id="form-elements-reports">
        <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" href="coderperformance.php">Team Performance</a></li>
            <li class="nav-item"><a class="nav-link" href="efficiency.php">Efficency Report</a></li>
        </ul>
    </div>
     <div class="collapse" id="form-elements-reports">
        <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" href="agency_report.php">Agency Reports</a></li>
        </ul>
    </div>
    <div class="collapse" id="form-elements-reports">
        <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" href="reporting_viwe.php">Production Reports</a></li>
        </ul>
    </div>
     <div class="collapse" id="form-elements-reports">
        <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" href="qualityreport.php">Quality Reports</a></li>
        </ul>
    </div>
     <div class="collapse" id="form-elements-reports">
        <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" href="feedback.php">QCFeedback Reports</a></li>
        </ul>
    </div>
    <div class="collapse" id="form-elements-reports">
        <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" href="logreport.php">Work Log</a></li>
        </ul>
    </div>  
     <div class="collapse" id="form-elements-reports">
        <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" href="logindetails.php">Login Details</a></li>
        </ul>
    </div>
</li>
 <li class="nav-item">
             <a class="nav-link" href="agencyinvoice.php">
               <i class="mdi mdi-basket-fill menu-icon"></i>
               <span class="menu-title">Agency Invoice</span>
             </a>
           </li>
            <li class="nav-item">
             <a class="nav-link" href="Adminconsole.php">
               <i class="icon-bar-graph menu-icon"></i>
               <span class="menu-title">Admin Console</span>
             </a>
           </li>
 
      
              




 <?php } ?>





 

           <?php if ($role == 'client') { ?>
           <li class="nav-item">
             <a class="nav-link" href="main_dash.php">
               <i class="icon-grid-2 menu-icon"></i>
               <span class="menu-title">DashBoard</span>
             </a>
           </li> 

            <li class="nav-item">
             <a class="nav-link" href="report.php">
               <i class="mdi mdi-view-grid menu-icon"></i>
               <span class="menu-title">Reports</span>
             </a>
           </li> 
           
    <!--        <li class="nav-item">
             <a class="nav-link" href="main_menu.php">
               <i class="icon-grid menu-icon"></i>
               <span class="menu-title">File Status</span>
             </a>
           </li> -->
           <li class="nav-item">
             <a class="nav-link" href="fileupload.php">
               <i class="icon-file menu-icon"></i>
               <span class="menu-title">File Upload</span>
             </a>
           </li>

         <?php } ?>
           
         <!--   <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <i class="icon-layout menu-icon"></i>
              <span class="menu-title">UI Elements</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">Buttons</a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/dropdowns.html">Dropdowns</a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/typography.html">Typography</a></li>
              </ul>
            </div>
            </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
              <i class="icon-columns menu-icon"></i>
              <span class="menu-title">Form elements</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="form-elements">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"><a class="nav-link" href="pages/forms/basic_elements.html">Basic Elements</a></li>
              </ul>
            </div>
          </li> -->
         <!--    <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
              <i class="icon-bar-graph menu-icon"></i>
              <span class="menu-title">Charts</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="charts">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="pages/charts/chartjs.html">ChartJs</a></li>
              </ul>
            </div>
          </li> -->
         <!--        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
              <i class="icon-grid-2 menu-icon"></i>
              <span class="menu-title">Tables</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="tables">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="pages/tables/basic-table.html">Basic table</a></li>
              </ul>
            </div>
          </li> -->
         <!--       <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
              <i class="icon-contract menu-icon"></i>
              <span class="menu-title">Icons</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="icons">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="pages/icons/mdi.html">Mdi icons</a></li>
              </ul>
            </div>
          </li> -->
         <!--   <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
              <i class="icon-head menu-icon"></i>
              <span class="menu-title">User Pages</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="pages/samples/login.html"> Login </a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/samples/register.html"> Register </a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#error" aria-expanded="false" aria-controls="error">
              <i class="icon-ban menu-icon"></i>
              <span class="menu-title">Error pages</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="error">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="pages/samples/error-404.html"> 404 </a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/samples/error-500.html"> 500 </a></li>
              </ul>
            </div>
          </li> -->



         <?php if ($role == 'Admin'  || $role == 'agency') { ?>
           <li class="nav-item">
             <a class="nav-link" href="form.php">
               <i class="icon-paper menu-icon"></i>
               <span class="menu-title">FileUpload</span>
             </a>
           </li>


         <?php } ?>


         <?php if ($role == 'user') { ?>

         <li class="nav-item">
             <a class="nav-link" href="coder_main.php">
               <i class="icon-grid-2 menu-icon"></i>
               <span class="menu-title">Dashboard</span>
             </a>
           </li> 
         <?php } ?>
         <?php if ($role == 'TeamLeader') { ?>

           <li class="nav-item">
             <a class="nav-link" href="team_main.php">
               <i class="icon-grid-2 menu-icon"></i>
               <span class="menu-title">Dashboard</span>
             </a>
           </li>



         <?php } ?>

          <?php if ($role == 'TeamLeader'||$role == 'Admin' ||$role == 'tm') { ?>

   <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#form-elements-reports" aria-expanded="false" aria-controls="form-elements-reports">
                <i class="icon-columns menu-icon"></i>
                <span class="menu-title">Reports</span> 
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="form-elements-reports">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="coderperformance.php">Team Performance</a></li>
                    <li class="nav-item"><a class="nav-link" href="efficiency.php">Efficency Report</a></li>
                    <li class="nav-item"><a class="nav-link" href="agency_report.php">Agency Reports</a></li>
                    <li class="nav-item"><a class="nav-link" href="reporting_viwe.php">Production Reports</a></li>
                    <li class="nav-item"><a class="nav-link" href="qualityreport.php">Quality Reports</a></li>
                    <li class="nav-item"><a class="nav-link" href="sixtydaysreport.php">HHRG Worksheet Reports</a></li>
                    <li class="nav-item"><a class="nav-link" href="feedback.php">QCFeedback Reports</a></li>
                    <li class="nav-item"><a class="nav-link" href="logreport.php">Work Log</a></li>
                    <li class="nav-item"><a class="nav-link" href="logindetails.php">Login Details</a></li>
                    <li class="nav-item"><a class="nav-link" href="logindetails_v2.php">Total Login Details</a></li>
                </ul>
            </div>
        </li>

    <style>
        .nav-item { margin-bottom: 10px; }
        .collapse { display: none; }
    </style>
           <script>
        $(document).ready(function() {
            $('.nav-link[data-toggle="collapse"]').on('click', function(e) {
                e.preventDefault();
                var target = $(this).attr('href');
                
                if ($(target).is(':visible')) {
                    $(target).slideUp();
                } else {
                    $('.collapse').slideUp(); // Hide all open collapse sections
                    $(target).slideDown();    // Show the clicked one
                }
            });
        });
    </script>
          <li class="nav-item">
             <a class="nav-link" href="autologouttable.php">
               <i class="mdi mdi-chart-bar menu-icon"></i>
               <span class="menu-title">User Status</span>
             </a>
           </li>

         <?php } ?>

        


         <?php if ($role == 'user'  || $role == 'TeamLeader') { ?>
           <li class="nav-item">
             <a class="nav-link" href="assign_table.php">
               <i class="mdi mdi-vk-box  menu-icon"></i>
               <span class="menu-title">Assigned Table
                 <?php if ($role == 'user') { ?>
                   <label class="badge badge-info" title="New"><?php echo $countNew ?></label>
                 <?php } ?>
               </span>
             </a>
           </li>
         <?php } ?>

         <?php if ($role == 'user' || $role == 'TeamLeader') { ?>
           <li class="nav-item">
             <a class="nav-link" href="completed_chat_allocate.php">
               <i class="mdi mdi-view-week menu-icon"></i>
               <span class="menu-title">Alloted to QC
                 <?php if ($role == 'user') { ?>
                   <label class="badge badge-info" title="New"><?php echo $Qc_New ?></label>
                 <?php } ?>
               </span>
             </a>
           </li>
         <?php } ?>
         <?php if ($role == 'user') { ?>
           <li class="nav-item">
             <a class="nav-link" href="qc_completed_table.php">
               <i class="mdi mdi-chart-bar menu-icon"></i>
               <span class="menu-title">QC Completed
                 <label class="badge badge-info text-end" title="QC Completed"><?php echo $countQcCompleted ?></label>
               </span>
             </a>
           </li>

           <li class="nav-item">
             <a class="nav-link" href="assessmenttablecoder.php">
               <i class="mdi mdi-view-week menu-icon"></i>
               <span class="menu-title">Assessment
               </span>
             </a>
           </li>
         <?php } ?>
         <?php if ($role == 'user'  || $role == 'TeamLeader' ) { ?>
             <li class="nav-item">
               <a class="nav-link" href="Approved_table.php">
                 <i class="mdi mdi-basket-fill menu-icon"></i>
                 <span class="menu-title">Approved
                 <?php if ($role == 'user') { ?>
                   <label class="badge badge-info text-end" title="Approved"><?php echo $countApproved ?></label>
                   <?php } ?>
                 </span>
               </a>
             </li>
           <?php } ?>



          <?php if ($role == 'TeamLeader' ) { ?>

            
          <li class="nav-item">
             <a class="nav-link" href="qc_c.php">
               <i class="mdi mdi-beer menu-icon"></i>
               <span class="menu-title">Qc Completed</span>
             </a>
           </li>

           <?php } ?>

         <?php if ($role == 'QA') { ?>

            <li class="nav-item">
             <a class="nav-link" href="qc_main.php">
               <i class="mdi mdi-apps menu-icon"></i>
               <span class="menu-title">Qc Dashboard <label class="badge badge-info"  ></label></span>
             </a>
           </li>
           <li class="nav-item">
             <a class="nav-link" href="Qa_table.php">
               <i class="mdi mdi-bitbucket menu-icon"></i>
               <span class="menu-title">QA Bucket <label class="badge badge-info" title="QC Completed"><?php echo $Qc_New ?></label></span>
             </a>
           </li>
           <li class="nav-item">
             <a class="nav-link" href="Qa_work_files.php">
               <i class="mdi mdi-vk-box menu-icon"></i>
               <span class="menu-title">QA Work Files</span>
             </a>
           </li>
           <li class="nav-item">
             <a class="nav-link" href="qc_c.php">
               <i class="mdi mdi-beer menu-icon"></i>
               <span class="menu-title">Completed</span>
             </a>
           </li>
            <li class="nav-item">
               <a class="nav-link" href="Approved_table.php">
                 <i class="mdi mdi-basket-fill menu-icon"></i>
                 <span class="menu-title">Approved
                  
                 </span>
               </a>
             </li>

         <?php } ?>


                  <?php if ($role == 'QaTl') { ?>

            <li class="nav-item">
             <a class="nav-link" href="Qcteam_main.php">
               <i class="mdi mdi-apps menu-icon"></i>
               <span class="menu-title">Dashboard <label class="badge badge-info"  ></label></span>
             </a>
           </li>
           <li class="nav-item">
             <a class="nav-link" href="Qa_table.php">
               <i class="mdi mdi-bitbucket menu-icon"></i>
               <span class="menu-title">Assign Table <label class="badge badge-info" title="QC Completed"><?php echo $Qc_New ?></label></span>
             </a>
           </li>
            <li class="nav-item">
             <a class="nav-link" href="autologouttable.php">
               <i class="mdi mdi-chart-bar menu-icon"></i>
               <span class="menu-title">User Management</span>
             </a>
           </li>
            <li class="nav-item">
               <a class="nav-link" href="Approved_table.php">
                 <i class="mdi mdi-basket-fill menu-icon"></i>
                 <span class="menu-title">Approved
                  
                 </span>
               </a>
            </li>
         <?php } ?>
            <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#games" aria-expanded="false" aria-controls="form-elements-reports">
                <i class="icon-columns menu-icon"></i>
                <span class="menu-title">Games</span> 
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="games">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="knows.php">Hangman</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Memory Card</a></li>
                </ul>
            </div>
        </li>

       </ul>
     </nav>