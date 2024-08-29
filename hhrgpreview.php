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

<body style="background-color: #E6E6E6; user-select: none;">
    <input type="text" name="hhrgview" id="hhrgview" value="<?php echo $Id ?>" class="form-control name_list input-lg"
        hidden />
         <!-- <button class="btn btn-primary"onclick="convert_pdf()">Download</button> -->
    <div class="container-fluid mt-4">
        <div class="row d-flex justify-content-center">

            <div class="col-12 col-lg-12">
                <div class="container mt-5 mb-5">

                    <div class="card p-4" id="pdfcontainer">
                        <div class="card-header text-center mb-2">
                            HHRG PREVIEW

                        </div>

                        <!-- personal details -->

                        <div class="table-responsive mt-3">
                            <table class="styled-table fixed-header-width table">
                                <thead style="color: whitesmoke; background: #4C4CAC;">
                                    <tr>

                                        <th scope="col">Patient_MRN</th>
                                        <th scope="col">Patient_Name</th>
                                        <th scope="col">Assessment Type</th>
                                        <th scope="col">Date of Assessment</th>
                                        <th scope="col">Insurance Type</th>
                                        <th scope="col">Agency</th>
                                        <th scope="col">Team</th>
                                        <th scope="col">Coder</th>

                                    </tr>
                                </thead>

                                <tbody>

                                    <tr>
                                        <td style="border: 1px solid black; white-space: pre-wrap;" id="subject_id">
                                        </td>
                                        <td style="border: 1px solid black; white-space: pre-wrap;" id="subject_name">
                                        </td>
                                        <td style="border: 1px solid black; white-space: pre-wrap;" id="assesment_type">
                                        </td>
                                        <td style="border: 1px solid black; white-space: pre-wrap;" id="assesment_date">
                                        </td>
                                        <td style="border: 1px solid black; white-space: pre-wrap;" id="insurance_type">
                                        </td>
                                        <td style="border: 1px solid black; white-space: pre-wrap;" id="agency"></td>
                                        <td style="border: 1px solid black; white-space: pre-wrap;word-break: auto;word-spacing: normal;overflow: auto; ;overflow-x: auto;max-width: 100px;width: 80%;"
                                            id="team"></td>
                                        <td style="border: 1px solid black; white-space: pre-wrap;word-break: auto;word-spacing: normal;overflow: auto;;overflow-x: auto;max-width: 100px;width: 80%;"
                                            id="coder"></td>



                                    </tr>

                                </tbody>

                            </table>
                        </div>

                        <!-- code segement -->
                        <br><br>

                        <div class="table-responsive mt-3">
                            <h4 class="font-weight-bold">HHRG VALUE</h4>
                            <!-- Table structure -->
                            <table class="table table-bordered" id="myTable ">
                                <!-- Table headers... -->
                                <thead class="bg-primary">
                                    <tr class="text-white">
                                        <th style="border: 1px solid black;">Finanical Summary
                                        </th>
                                        <th style="border: 1px solid black;">PDGM Value</th>
                                        <th style="border: 1px solid black;">PDGM First 30 Days
                                        </th>

                                    </tr>
                                </thead>
                                <!-- Table body -->
                                <tbody id="tableBody" class="content">

                                    <tr class="tablebodydataone">
                                        <td style="border: 1px solid black;">Prior-Audit-Amount</td>
                                        <td id="precodevaluemultiplyview" style="border: 1px solid black;"></td>
                                        <td id="precodevalueview" style="border: 1px solid black;"></td>

                                    </tr>
                                    <tr class="tablebodydatatwo">
                                        <td style="border: 1px solid black;">Post-Audit-Amount</td>
                                        <td id="postcodevaluemultiplyview" style="border: 1px solid black;"></td>
                                        <td id="postcodevalueview" style="border: 1px solid black;"></td>

                                    </tr>
                                    <tr class="tablebodydatathree">
                                        <td style="border: 1px solid black;">Additional Amount</td>
                                        <td id="additionalvaluemultiplyview" style="border: 1px solid black;"></td>
                                        <td id="additionvalueview" style="border: 1px solid black;"></td>

                                    </tr>

                                </tbody>
                            </table>



                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


<script src="Assign/js/hhrgpreview.js"></script>
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

</html>