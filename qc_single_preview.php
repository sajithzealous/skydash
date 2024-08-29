<?php


include 'logsession.php';
session_start();
 include('db/db-con.php');

$userId = $_COOKIE['Id'];
$emp_id = $_SESSION['empid'];


if ($userId) {
    try {

        // Example query to fetch user data
        $query = "SELECT * FROM `Main_Data` WHERE `Id`='$userId'";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch user data
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $Id = $row['Id'];
            $Notes_to_agency    = $row['Notes_to_agency'];
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- jsPDF library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.js" integrity="sha512-Bw9Zj8x4giJb3OmlMiMaGbNrFr0ERD2f9jL3en5FmcTXLhkI+fKyXVeyGyxKMIl1RfgcCBDprJJt4JvlglEb3A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
  <title>QC VIEW</title>
  <style>
    .styled-table th,
    .styled-table td {
      text-align: left;
    }

    .red-row {
      background-color: #ff7373;
      /* Customize as needed */
    }

    .yellow-row {
      background-color: #ffff76;
      /* Customize as needed */
    }

    .green-row {
      background-color: #7cff7c;
      /* Customize as needed */
    }

    .shadow {
      background: #e0e0e0;
      box-shadow: -25px 25px 75px #b3b3b3,
        25px -25px 75px #ffffff;
    }
  </style>
</head>

<body style="background-color: #E6E6E6; user-select:;">

<!-- tton class="btn btn-primary"onclick="convert_pdf('<?php echo $patientName; ?>_<?php echo $mrn; ?>')">Download</button> -->
<button class="bg-primary text-white   mt-5 float-right"onclick="convert_pdf('QC_File')">Download</button>
  <div class="container-fluid mt-4" id="pdfcontainer">
    <div class="row d-flex justify-content-center">
      <!-- <div class="card shadow"> -->
        <!-- Right Column ( QC PREVIEW TABLE) -->
        <div class="col-12 col-lg-12">
          <div class="container-fluid mt-5 mb-5">
            <div class="card p-4">
              <div class="card-header text-center mb-2">
                QC PREVIEW
              </div>
              <!-- QC Personal Details Table -->
              <div class="table-responsive">
                <table class="table table-hover  Response" id="main-table">
                  <thead style="color: whitesmoke; background: #4C4CAC;">
                    <tr>
                      <th>Patient_Name</th>
                      <th>MRN</th>
                      <th>Agency</th>
                      <th>Insurance Type</th>
                      <th>Date of Assessment</th>
                      <th>Assessment Type</th>
                      <th>QC Coder</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>

              <!-- QC Coding Details Table -->
              <div class="table-responsive mt-3" style="font-size: 14px;">
                <h5>QC Coding Segement</h5> 
                <table class="table table-hover  Response" id="Codnig-table">
                  <thead class=""style="background: #4C4CAC;">
                    <tr class="text-white" style="border: 1px solid black;">
            
                      <th style="border: 1px solid black; white-space: pre-wrap;word-wrap: break-word;">MItems</th>
                      <th style="border: 1px solid black; white-space: pre-wrap;word-wrap: break-word;">ICD</th>
                      <th style="border: 1px solid black; white-space: pre-wrap;word-wrap: break-word;">Description</th>
                      <th style="border: 1px solid black; white-space: pre-wrap;word-wrap: break-word;">Effective Date</th>
                      <th style="border: 1px solid black; white-space: pre-wrap;word-wrap: break-word;">E/O</th>
                      <th style="border: 1px solid black; white-space: pre-wrap;word-wrap: break-word;"> Rating</th>
                      <th style="border: 1px solid black; white-space: pre-wrap;word-wrap: break-word;">Error Reason</th>
                      <th style="border: 1px solid black; white-space: pre-wrap;word-wrap: break-word;">Error Type</th>
                      <th style="border: 1px solid black; white-space: pre-wrap;word-wrap: break-word;">Qc Rationali</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                  <tbody id="Codnig-nodata-table">
                    <tr>
                      <td colspan="9" class="text-center text-danger" style="border: 1px solid black; white-space: pre-wrap;">No data available</td>
                    </tr>
                  </tbody>

                </table>
              </div>

              <!-- QC Coding Comments Table -->
              <div class="table-responsive">
                <table class="table mx-auto" id="Codnig-cmd">
                  <thead style="color: whitesmoke; background: #4C4CAC;">
                    <tr>
                      <th scope="col">Coder Commments </th>
                      <th scope="col">QC Commments </th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                  <tbody id="Codnig-no-comments">
                    <tr>
                      <td class="text-center text-danger" style="border: 1px solid black; white-space: pre-wrap;">No comments available</td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <!--QC Oasis Details Table -->
              <div class="table-responsive" style="font-size: 14px;">
                <h5>QC Oasis Segement</h5>
                <table class="styled-table table table-hover" id="oasisqc-table"  > 
                 <thead class=""style="background: #4C4CAC;">
                    <tr class="text-white" style="border: 1px solid black; text-align: center;">
                      <th style="border: 1px solid black; white-space: pre-wrap;word-wrap: break-word;">MItems</th>
                      <th style="border: 1px solid black; white-space: pre-wrap;word-wrap: break-word;">Agency Response</th>
                      <th style="border: 1px solid black; white-space: pre-wrap;word-wrap: break-word;">Coder Response</th>
                      <th style="border: 1px solid black; white-space: pre-wrap;word-wrap: break-word;text-transform: uppercase;">Qc Response</th>
                      <th style="border: 1px solid black; white-space: pre-wrap;word-wrap: break-word;">Coder Rationali</th>
                      <th style="border: 1px solid black; white-space: pre-wrap;word-wrap: break-word;">Error Reason</th>
                      <th style="border: 1px solid black; white-space: pre-wrap;word-wrap: break-word;">Error Type</th>
                      <th style="border: 1px solid black; white-space: pre-wrap;word-wrap: break-word;">Qc Rationali</th>
                    </tr>
                  </thead>
                  <tbody style="text-align: center;">
                    <tr>
                    </tr>
                  </tbody>
                  <tbody id="oasis-nodata-table">
                    <tr>
                      <td colspan="7" class="text-center text-danger" style="border: 1px solid black; white-space: pre-wrap;">No data available</td>
                    </tr>
                  </tbody>
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
                <th>QCAgency_Response</th>
                <th>Qc-Response</th>
                <th>QC-Rationali</th>
                <th>Error-Type</th>
                <th>Error</th>
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
                      <th scope="col">Coder Commments </th>
                      <th scope="col">QC Commments </th>

                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                  <tbody id="oasis-no-comments">
                    <tr>
                      <td class="text-center text-danger" style="border: 1px solid black; white-space: pre-wrap;">No comments available</td>
                    </tr>
                  </tbody>
                </table>
              </div>

 
 
              <!--QC POC Details Table -->
              <div class="table-responsive" style="font-size: 14px;">
                <h5>QC POC Segement</h5>
                <table class="styled-table table table-hover" id="poc-table">
                  <thead style="color: whitesmoke; background: #4C4CAC;">
                    <tr>
                      <th style="border: 1px solid black; white-space: pre-wrap;word-wrap: break-word;">Poc-Item</th>
                      <th style="border: 1px solid black; white-space: pre-wrap;word-wrap: break-word;">Coder Response</th>
                       
                      <th style="border: 1px solid black; white-space: pre-wrap;word-wrap: break-word;">QC Response</th>
                      <th style="border: 1px solid black; white-space: pre-wrap;word-wrap: break-word;">Error Reason</th>
                      <th style="border: 1px solid black; white-space: pre-wrap;word-wrap: break-word;">Error Type</th>
                      <th style="border: 1px solid black; white-space: pre-wrap;word-wrap: break-word;">Qc Rationali</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                  <tbody id="poc-nodata-table">
                    <tr>
                      <td colspan="5" class="text-center text-danger" style="border: 1px solid black; white-space: pre-wrap;">No data available</td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <!-- QC POC Comments Table -->
              <div class="table-responsive">
                <table class="table mx-auto" id="poc-cmd">
                  <thead style="color: whitesmoke; background: #4C4CAC;">
                    <tr>
                      <th scope="col">Coder Commments </th>
                      <th scope="col">QC Commments </th>

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


                        <div class="table-responsive mt-3">
                           
                                <table class="table mx-auto">
                                    <thead style="color: whitesmoke; background: #4C4CAC;">
                                        <tr>
                                            <th scope="col"> Notes To Agency</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $Notes_to_agency ?></td>

                                    </tbody>
                                </table>
                            
                        </div>


            </div>
          </div>
        </div>
      <!-- </div> -->

    </div>
  </div>
<script>
 
 function convert_pdf(filename) {
  var element = document.getElementById("pdfcontainer");
   
 


var options = {
    margin: [0.5, 0.5, 0.5, 0.5], //[top, left, bottom, right]
    filename: filename + ".pdf",
    image: { type: "jpeg", quality: 0.72 }, // Reduce image quality
    pagebreak: { avoid: "tr", mode: "css", before: "#nextpage1"},
    html2canvas: { scale: 2, useCORS: true, dpi:72, letterRendering: true }, // Reduce scale and DPI
    jsPDF: { unit: "in", format: "a2", orientation: "portrait" },
}

 

        // Generate PDF
        html2pdf()
            .from(element)
            .set(options)
            .save();
    }
</script>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <?php
  include 'include_file/pulg.php';
  ?>





<?php  $randomNumber = rand(1000, 9999);  ?>

 
 
 

  <script src="QA/js/qc_singlepreview.js?<?php echo $randomNumber ?>"></script>
   <script src="ggmitem/js/qc_ggitem_previwe.js?<?php echo $randomNumber ?>"></script>

</body>

</html>