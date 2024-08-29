
<?php
  
   date_default_timezone_set('America/New_York');


include('db/db-con.php');
include  'include_file/link.php';


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

  
  ?>  





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assesment Form Management</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- <link rel="stylesheet" href="code_des/css/code_desc.css"> -->
    <link rel="stylesheet" href="Adminpanel/css/usermanagement.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container-scroller">
        <!-- Navbar -->
        <?php include 'include_file/profile.php'; ?>

        <div class="container-fluid page-body-wrapper">
            <!-- Sidebar -->
            <?php include 'include_file/sidebar.php'; ?>

            <div class="main-panel">
                <div class="content-wrapper">



                    <div class="conatiner m-5">

                        <div class="card p-4">
                            <h3>Assesment Form Table
                                <a href="assessmentformdesign.php"><button type="button" class="btn btn-info mr-2 clk_2" style="float:right"> Create</button></a>
                                <a href="coderassessment.php"><button type="button" class="btn btn-secondary mr-2 clk_2" style="float:right">Assesment Details</button></a>
                                <a href="manualevaluation.php"><button type="button" class="btn mr-2" style="float:right;color: white;background-color: rgb(103, 58, 183)" >Manual Evaluation </button></a>
                               
                            </h3>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12 custom-scroll table-responsive p-5" style="width:100%">

                                <table id="assessmentform_table" class="display table" >
                                    <thead>
                                        <tr class="headerrow">
                                            <th class="sorting">S.no</th>
                                            <th class="sorting">Title</th>
                                            <th class="sorting">Date</th>
                                            <th class="sorting">Status</th>
                                            <th class="sorting">Status Button</th>
                                            <th class="sorting">Published</th>
                                            <th class="sorting">Published Button</th>
                                            <th class="sorting">Edit</th>
                                            <th class="sorting">Timestamp</th>
                                        </tr>
                                    </thead>
                                    <tbody class="" style="overflow: auto;min-height: 500px;">
                                        

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>






<style>
    /* Container for the checkbox list */
    #coderContainer5 {
        max-height: 200px;
        overflow-y: auto;
        border: 1px solid #ccc;
        padding: 10px;
        width:400px;
    }

    /* Individual checkbox label styling */
    #coderCheckboxList5 label {
        display: block;
        margin-bottom: 5px;
        justify-content: center;
        align-items: center;
    }

    /* 'Select All' checkbox styling */
    #selectAllCoders5 {
      
        width:50px;
        height:30px;
         justify-content: center;
        align-items: center;
    }

    /* Default checkbox style */
    .coderCheckbox5 {


        background-color: #f0f0f0;
        border-radius: 5px;
        cursor: pointer;
        width:50px;
        height:30px;
        justify-content: center;
        align-items: center;
    }

    /* Styling for checked checkboxes */
    .coderCheckbox5 input[type="checkbox"]:checked + label {
        background-color: #007bff; /* Blue background when checked */
        color: white;
        font-weight: bold;
    }

    /* Styling for unchecked checkboxes */
    .coderCheckbox5 input[type="checkbox"] + label {
        background-color: #f0f0f0; /* Light gray background when unchecked */
        color: black;
        font-weight: normal;
    }

  /*  #text{

        font-size:50px;
    }*/
</style>

    <?php

    $randomNumber = rand(1000, 9999);
    ?>

    <div class="modal fade" id="publishedModal" tabindex="-1" role="dialog" aria-labelledby="publishedModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="publishedModalLabel">Publish Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                           <label class="col-sm-4 col-form-label bold">Select Team</label> 
                            <div class="col-sm-10">
                            
                                  <select class="form-control teamdata" name="team" id="team_select5" style="color:black;font-weight: 6000;">
                                            <option value="">All-Team</option>
                                             
                                            <?php foreach ($team as $teams) { ?>
                                                <option value="<?= $teams['Team'] . ' - ' . $teams['team_emp_id'] ?>"><?= $teams['Team'] . ' - ' . $teams['team_emp_id'] ?></option>
                                            <?php } ?>
                                        </select>  
                            </div>
                        </div>
                    </div>
             <!--        <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Select Coder</label> 
                            <div class="col-sm-10">

                                 <select class="form-control coderdata" id="coder_name5" name="coder" style="color:black;font-weight: 6000;" multiple>
                                    <option value="">Coder-Name </option>
                                </select>
                       </div>
                        </div>
                    </div> -->


                    <div id="coderContainer5" style="max-height: 200px; overflow-y: auto;">
                              <label>
                                <input type="checkbox" id="selectAllCoders5" class=""> Select All
                              </label>
                              <div id="coderCheckboxList5"></div>
                            </div>



        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary savedataasses">Saves changes</button>
      </div>
    </div>
  </div>
</div>







    <!-- Modal Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="Adminpanel/js/assessmentform.js?<?php echo $randomNumber ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
</body>

</html>