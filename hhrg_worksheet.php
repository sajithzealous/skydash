<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- html2canvas library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"
        integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- jsPDF library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.js"
        integrity="sha512-Bw9Zj8x4giJb3OmlMiMaGbNrFr0ERD2f9jL3en5FmcTXLhkI+fKyXVeyGyxKMIl1RfgcCBDprJJt4JvlglEb3A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <title>HHRG VIEW</title>


    <?php
    include('include_file/link.php');

    $Id = $_COOKIE['Id'];


    ?>
</head>

<style>
    .button {
        width: 140px;
        height: 45px;
        border-radius: 30em;
        /*  position: relative;*/
        overflow: hidden;
        color: #fff;
        font-family: Roboto, sans-serif;
        font-weight: 600;
        font-size: 15px;
        line-height: 1;
        cursor: pointer;
        z-index: 1;
        border: 3px solid #fff;
        box-shadow: 6px 6px 12px #c5c5c5, -6px -6px 12px #ffffff;
        transition: 0.6s ease-in;
        background-color: #4c4cac;
    }

    /*   .pagebreak {
    page-break-before: always; /* Insert page break before this element */
    }

    */ .content {
        width: 100%;
        white-space: nowrap;
        overflow: hidden;
    }
</style>

 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #E6E6E6;
            user-select: none;
        }
        .card-header {
            background-color: #e6eefa;
            font-weight: bold;
        }
        .highlight {
            background-color: #0069d9;
            color: white;
            font-weight: bold;
            padding: 0.2rem 0.5rem;
            
        }
  
    </style>
</head>
<body>
    <input type="text" name="hhrgview" id="hhrgvalue" value="<?php echo $Id ?>" class="form-control name_list input-lg" hidden />

    <div class="container-fluid mt-4  ">
        <div class="row d-flex justify-content-center">
            <div class="btn">
 
<button type="button" class="btn btn-sm btn-primary" onclick="convert_pdf('')">Download</button>


</div>
            
            <div class="col-12 col-lg-12">
                <div class="container mt-5 mb-5">
                    <div class="card p-4" id="pdfcontainer">
                        <div class="card-header text-center mb-2">
                            HHRG Work Sheet  
                        </div>

                        <!-- Personal Details -->
                        <div class="table-responsive mt-3">
                            <table class="styled-table fixed-header-width table table-bordered table-striped">
                                <thead style="color: whitesmoke; background: #4C4CAC;">
                                    <tr class="table-success" style="color:black;font-weight: 600;">
                                        <th scope="col" style="font-size: 16px;">Patient_MRN</th>
                                        <th scope="col" style="font-size: 16px;">Patient_Name</th>
                                        <th scope="col" style="font-size: 16px;">Assessment Type</th>
                                        <th scope="col" style="font-size: 16px;">Date of Assessment</th>
                                        <th scope="col" style="font-size: 16px;">Insurance Type</th>
                                        <th scope="col" style="font-size: 16px;">Agency</th>
                                        <th scope="col" style="font-size: 16px;">Team</th>
                                        <th scope="col" style="font-size: 16px;">Coder</th>
                                    </tr>
                                </thead>
                               <tbody id="showdata" style="font-size: 18px;">
   
</tbody>

                            </table>
                        </div>

                        

                        <br>
                  

                    <div class="container mt-5">
                        <div class="row">
                            <!-- First Card -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        OASIS-E Recertification <br>
                                        1st 30-Day Billing Period<br>
                                      <!-- <small>07/04/2024 - 08/02/2024</small>  -->
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">Payment Group Details</h5>
                                        <p><strong>Primary Diagnosis Code:</strong> <span id="code1"></span> <span id="des1"></span></p>
                                        <p><strong>Admission Source & Timing:</strong> <span id="ad1"></span></p>
                                        <p><strong>Clinical Group & Level:</strong> <span id="clg1"></span></p>
                                        <p><strong>Comorbidity Adjustment:</strong> <span id="cma1"></span></p>
                                        <p><strong>LUPA Level:</strong> <span id="lupa1"></span></p>
                                        <p><strong>HIPPS Code:</strong> <span id="hipps1"></span></p>
                                    </div>
                                    <div class="card-footer text-end">
                                        <strong>OASIS Revenue:</strong> <span id="osrev1" class="highlight"> </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Second Card -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        OASIS-E Recertification <br>
                                        2nd 30-Day Billing Period<br>
                                          <!-- <small>08/03/2024 - 09/01/2024</small>  -->
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">Payment Group Details</h5>
                                        <p><strong>Primary Diagnosis Code:</strong> <span id="code2"></span> <span id="des2"></span></p>
                                        <p><strong>Admission Source & Timing:</strong> <span id="ad2"></span></p>
                                        <p><strong>Clinical Group & Level:</strong> <span id="clg2"></span></p>
                                        <p><strong>Comorbidity Adjustment:</strong> <span id="cma2"></span></p>
                                        <p><strong>LUPA Level:</strong> <span id="lupa2"></span></p>
                                        <p><strong>HIPPS Code:</strong> <span id="hipps2"></span></p>
                                    </div>
                                    <div class="card-footer text-end">
                                        <strong>OASIS Revenue:</strong> <span id="osrev2" class="highlight"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Cards can be added here if needed -->

                </div>
            </div>
          
        </div>
    </div>
</body>
</html>


 
<?php
include 'include_file/pulg.php';
?>

<script>
 // JavaScript code for generating PDF 
        function convert_pdf(filename) {
            // Get the HTML element to convert to PDF
            var element = document.getElementById('pdfcontainer');

            // Options for PDF generation
            var options = {
                margin: [10, 10, 20, 10], // [left, top, right, bottom]
                filename: filename+'.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2, logging: true },
                jsPDF: { unit: 'mm', format: 'a2', orientation: 'portrait' },
                // pagebreak: { mode: ['avoid-all', 'css', 'legacy']}
            };

            // Generate PDF
            html2pdf()
                .from(element)
                .set(options)
                .save();
        }

</script>

<script>
    
$(document).ready(function(){

     var id = $("#hhrgvalue").val();
         profile_details(id);
         hhrg_value(id);
    
      
function profile_details(id) {
    $.ajax({
        type: "post",
        url: "Assign/hhrg_worksheet_display.php?action=profile",
        data: {
            id: id,
        },
        success: function (response) {
            // Assuming the response is JSON
            var data = JSON.parse(response);

            var show =data.data;
            
            // Clear the existing table rows
            $('#showdata').empty();

            // Create a new table row with the received data
            var newRow = `
                <tr>
                    <td>${show.mrn}</td>
                    <td>${show.patient_name}</td>
                    <td>${show.assesment_type}</td>
                    <td>${show.assesment_date}</td>
                    <td>${show.insurance_type}</td>
                    <td>${show.agency}</td>
                    <td>${show.team_name}</td>
                    <td>${show.coder_emp_id}</td>
                </tr>
            `;

            // Append the new row to the table body
            $('#showdata').append(newRow);

              var downloadButton = document.querySelector('.btn');
              downloadButton.setAttribute('onclick', `convert_pdf('${show.patient_name}_${show.mrn}')`);
        },
        error: function () {
            console.error("Error occurred while fetching data.");
        },
    });
}

function hhrg_value(id)
{


$.ajax({
        type: "post",
        url: "Assign/hhrg_worksheet_display.php?action=report_data",
        data: {
            id: id,
        },
        success: function (response) {
             console.log("hhrg_re",response);
              var data = JSON.parse(response);

            var show =data.data;

            $("#code1").text(show.first_icd_code);
            $("#des1").text(show.first_desc);
            $("#ad1").text(show.first_admission);
            $("#clg1").text(show.first_clinical_group);
            $("#cma1").text(show.first_comorbidity);
            $("#lupa1").text(show.first_lupa);
            $("#hipps1").text(show.first_hipps);
            $("#osrev1").text('$'+show.first_billing_revenue);

            $("#code2").text(show.second_icd_code);
            $("#des2").text(show.second_desc);
            $("#ad2").text(show.second_admission);
            $("#clg2").text(show.second_clinical_group);
            $("#cma2").text(show.second_comorbidity);
            $("#lupa2").text(show.second_lupa);
            $("#hipps2").text(show.second_hipps);
            $("#osrev2").text('$'+show.second_billing_revenue);
        },
        error: function () {
            console.error("Error occurred while fetching data.");
        },
    });

}



});








</script>

</html>