<?php
session_start();

 include('db/db-con.php');
// Check if the 'Id' parameter is set in the cookie
if (isset($_COOKIE['Id'])) {
  // Get the user ID from the cookie
  $userId = $_COOKIE['Id'];

  // Create a normal SQL query. Be cautious, as this approach is prone to SQL injection.
  $select_query = "SELECT `status`,`patient_name`,`mrn` FROM `Main_Data` WHERE `Id` = '$userId'";
  $result = $conn->query($select_query);

  if ($result) {
      if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          $status = $row['status'];
          $patient_name = $row['patient_name'];
          $mrn = $row['mrn'];
      } else {
          // No records found for the given ID
          echo "No records found for the given ID";
      }
  } else {
      // Error in SQL query
      echo "Error executing SQL query";
  }
} else {
  // 'Id' parameter is not set in the cookie
  echo "No 'Id' parameter found in the cookie";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="path/to/bootstrap.css"> <!-- Include Bootstrap CSS if you're using Bootstrap -->
    <!-- Include other CSS files if needed -->
    <script src="path/to/html2pdf.bundle.min.js"></script> 
  <title>Final View</title>
  
 
  </style>  
</head>
<body >
<!-- <body style="background-color: #E6E6E6; user-select: none;"> -->
 <style type="text/css">
   /* Basic styling for buttons */
button {
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.3s ease;
}

/* Styling for Approved button */
.continue-application {
    background-color: #28a745;
    color: white;
    border: none;
    margin-right: 10px;
}

/* Hover effect for Approved button */
.continue-application:hover {
    background-color: #218838;
}

/* Styling for Download PDF button */
.btn-primary {
    background-color: #007bff;
    color: white;
    border: none;
}

/* Hover effect for Download PDF button */
.btn-primary:hover {
    background-color: #0056b3;
}

 </style>
 <?php
 
    if ($status !== 'APPROVED') :
    ?>
     <div class="container-fluid justify-content-center bg-white fixed-top option">
    <div class="row mt-3">
        <div class="col-md-12 text-center mb-3">
            <button class="continue-application" id="Approved">
                Approved
            </button>  

            
        </div>
    </div>
</div>

    <?php endif; ?>

  <div class="container-fluid mt-5"  >
    <div class="row d-flex justify-content-center">
    
 
      <div class="col-12 col-lg-12">
  <button class="btn btn-primary float-right my-4" onclick="downloadPDF()">
                Download PDF
            </button>
        <div class="container mt-5 mb-5">
          

          <!-- pdf download length start -->
           <div class="downloadPDF" id="perviewpdfcontainer">  
          <div class="card p-4">
            <div class="card-header text-center mb-2" >
              FINAL PREVIEW 
            </div>
   
 
            <!-- QC Personal Details Table -->
         <div class="table-responsive">
    <table class="styled-table fixed-header-width table" id="main-table">
        <thead style="color: whitesmoke; background: #4C4CAC;">
            <tr>
                <th>Patient Name</th>
                <th>MRN</th>
                <th>Agency</th>
                <th>Insurance Type</th>
                <th>Date of Assessment</th>
                <th>Assessment Type</th>
                <th>Coder</th>
            </tr>
        </thead>
        <tbody>
            <!-- Table body content goes here -->
        </tbody>
    </table>
</div>


            <!-- QC Coding Details Table -->
   <div class="table-responsive">
    <h5>Coding Segment</h5>
    <table class="table table-striped table-hover" id="Codnig-table">
        <thead style="color: whitesmoke; background: #4C4CAC;">
            <tr>
                <th>MItems</th>
                <th>ICD</th>
                <th>Description</th>
                <th>Effective Date</th>
                <th>E/O</th>
                <th>Rating</th>
            </tr>
        </thead>
        <tbody>
            <!-- Table body content goes here -->
        </tbody>
        <tbody id="Codnig-nodata-table">
            <tr>
                <td colspan="6" class="text-center text-danger" style="border: 1px solid black; white-space: pre-wrap;">No data available</td>
            </tr>
        </tbody>
    </table>
</div>


            <!-- QC Coding Comments Table -->
  <div class="table-responsive">
    <table class="table mx-auto" id="Codnig-cmd">
        <thead style="color: whitesmoke; background: #4C4CAC;">
            <tr>
                <th scope="col">Coding Comments</th>
            </tr>
        </thead>
        <tbody>
            <!-- Table body content goes here -->
        </tbody>
        <tbody id="Codnig-no-comments">
            <tr>
                <td class="text-center text-danger" style="border: 1px solid black; white-space: pre-wrap;">No comments available</td>
            </tr>
        </tbody>
    </table>
</div>
<style>
#oasisqc-table,
#oasisqc-table th,
#oasisqc-table td {
    border: 1px solid black;
}
</style>

            <!--QC Oasis Details Table -->
 <div class="table-responsive">
    <h5>Oasis Segment</h5>
    <table class="styled-table fixed-header-width table table-bordered table-striped table-hover" id="oasisqc-table">
        <thead style="color: whitesmoke; background: #4C4CAC;">
            <tr>
                <th>MItems</th>
                <th>Agency Response</th>
                <th>Coder Response</th>
                <th>Coder Rational</th>
            </tr>
        </thead>
        <tbody id="oasisqc-table-body"></tbody>
        <tbody id="oasis-nodata-table"></tbody>
    </table>
</div>
<div class="gg" id="gg-items">     
    <h4 >GG-Mitem</h4>
    <table class="table  table-bordered table-hover table-striped   Response" id="dataTable">
        <thead style="color: whitesmoke; background: #4C4CAC;">
            <tr class="text-white" id="tdh">
                <th>M-Items</th>
                <th>Agency_Response</th>
                <th>Coder_Response</th>
                <th>Coder_Rationali</th>
            
            </tr>
        </thead>
        <tbody id="dataTableBody">
            <!-- Table rows will be dynamically added here -->
        </tbody>
    </table>
</div>
<style>
.table-bordered {
    border: 1px solid #dee2e6;
}

.table-bordered th,
.table-bordered td {
    border: 1px solid black;
}  
 
</style>


            <!-- QC Oasis Comments Table -->

       <div class="table-responsive">
    <table class="table mx-auto" id="oasisqc-cmd">
        <thead style="color: whitesmoke; background: #4C4CAC;">
            <tr>
                <th scope="col">Oasis Comments </th>
            </tr>
        </thead>
        <tbody>
            <!-- Table body content goes here -->
        </tbody>
        <tbody id="oasis-no-comments">
            <tr>
                <td class="text-center text-danger" style="border: 1px solid black; white-space: pre-wrap;">No comments available</td>
            </tr>
        </tbody>
    </table>
</div>


   <!--QC POC Details Table -->
      <div class="table-responsive">
    <h5>POC Segment</h5>
    <table class="styled-table fixed-header-width table" id="poc-table">
        <thead style="color: whitesmoke; background: #4C4CAC;">
            <tr>
                <th>POC-ITEM</th>
                <th>Coder Response</th>
            </tr>
        </thead>
        <tbody>
            <!-- Table body content goes here -->
        </tbody>
        <tbody id="poc-nodata-table">
            <tr>
                <td colspan="2" class="text-center text-danger" style="border: 1px solid black; white-space: pre-wrap;">No data available</td>
            </tr>
        </tbody>
    </table>
</div>


            <!-- QC POC Comments Table -->
            <div class="table-responsive">
              <table class="table mx-auto" id="poc-cmd">
                <thead style="color: whitesmoke; background: #4C4CAC;">
                  <tr>
                    <th scope="col">Poc Commments </th>

                  </tr>
                </thead>
                <tbody>

                </tbody>
                <tbody id="poc-no-comments">
                  <tr>
                    <td class="text-center text-danger" style="border: 1px solid black; white-space: pre-wrap;">No comments available</td>
                  </tr>
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
      <!-- </div> -->

    </div>
  </div>
</div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.js" integrity="sha512-Bw9Zj8x4giJb3OmlMiMaGbNrFr0ERD2f9jL3en5FmcTXLhkI+fKyXVeyGyxKMIl1RfgcCBDprJJt4JvlglEb3A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
  <?php
  include 'include_file/pulg.php';
  ?>
  <script src="Assign/js/final_preview.js"></script>
  <script src="Assign/js/Approved_file.js"></script>
  <script src="ggmitem/js/final_previwe-ggitem.js"></script>


<script>
   
function downloadPDF() {
    var element = document.getElementById('perviewpdfcontainer');
    if (!element) {
        console.error("Element with ID 'perviewpdfcontainer' not found.");
        return;
    }

 var options = {
    margin: [10, 10, 20, 10],
    filename: '<?php echo $patient_name . " " . $mrn; ?>.pdf', // Concatenate patient name and MRN for filename
    image: { type: 'jpeg', quality: 1 }, // Increase quality to 1 (highest quality)
    html2canvas: { scale: 2, logging: true },
    jsPDF: { unit: 'mm', format: 'a3', orientation: 'portrait' },
    // pagebreak: { mode: ['avoid-all'] }
};


   
  

    html2pdf()
        .from(element)
        .set(options)
        .save()
        .catch(function (error) {
            console.error("Error generating PDF:", error);
        });
}




</script>


</body>

</html>