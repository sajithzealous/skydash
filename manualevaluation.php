
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
    <title>Manual Evaluation</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- <link rel="stylesheet" href="code_des/css/code_desc.css"> -->
    <link rel="stylesheet" href="Adminpanel/css/usermanagement.css">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
        /* Styling the table for fixed headers and scrollable tbody */
       

        #assessmentformcoder_table thead th {
            position: relative ;
            top: 0;
            z-index: 2;
        }

        /* Scrollable tbody */
        .table-container {
            max-height: 500px; /* Set the desired height for the scrollable area */
            overflow-y: auto;
            overflow-x: hidden;
        }

    </style>

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
                            <h3>Manual Evaluation Table
                                <a href="assessmentform.php"><button type="button" class="btn btn-info mr-2" style="float:right"> Back</button></a>

                               
                            </h3>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12 p-5 table-container" style="width:100%">

                                <table id="assessmentformmanual_table" class="display table" >
                                    <thead>
                                        <tr class="headerrow">
                                            <th class="sorting">Id</th>
                                            <th class="sorting">Form Id</th>
                                            <th class="sorting">Assessment Title</th>
                                            <th class="sorting">Coder</th>
                                            <th class="sorting">System Mark</th>
                                            <th class="sorting">Date</th>
                                            <th class="sorting">Status</th>
                                            <th class="sorting">Action</th>
                                         </tr>
                                    </thead>
                                    <tbody class="">
                                        

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
        .form-group .labelook {

            font-size: 15px;
            font-weight: 500px;
            font-style: bold;
        }
    </style>
    <?php $randomNumber = rand(1000, 9999); ?>

  
<div class="modal fade" id="evaluationModal" tabindex="-1" aria-labelledby="evaluationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="evaluationModalLabel">Evaluation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
        <!-- This is where your dynamic content goes -->
        <div id="answerscoder">
          <!-- Your dynamically generated form groups -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveChangesButton">Save changes</button>
      </div>
    </div>
  </div>
</div>





    <!-- Modal Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="Adminpanel/js/assessmentform.js?<?php echo $randomNumber ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
</body>

</html>