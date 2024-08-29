<?php

// require('fpdf/fpdf.php');
include 'logsession.php';
session_start();
 include('db/db-con.php');

$userId = $_COOKIE['Id'];
$emp_id = $_SESSION['empid'];
// echo $userId;
// Initialize variables
$Id = '';
$patientName = "";
$phoneNumber = "";
$mrn = "";
$agency = "";
$assessmentDate = "";
$assessmentType = "";
$url = "";
$coder = "";

// Mian Data 

if ($userId) {
    try {
        // Create a connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

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
            $patientName = $row['patient_name'];
            $phoneNumber = $row['phone_number'];
            $mrn = $row['mrn'];
            $agency = $row['agency'];
            $assessmentDate = $row['assesment_date'];
            $assessmentType = $row['assesment_type'];
            $insuranceType = $row['insurance_type'];
            $url = $row['url'];
            $coder = $row['alloted_to_coder'];
            $Coder_emp_id    = $row['coder_emp_id'];
            $Notes_to_agency    = $row['Notes_to_agency'];
        }


        // Close the statement and connection
        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

// CodeSegement

if ($userId) {
    try {
        // Create a connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }



        // Example query to fetch user data
        $query = "SELECT `coding_comments` FROM `Codesegement` WHERE `Entry_Id` = '$userId' AND `coding_comments` IS NOT NULL AND `coding_comments` != ''  LIMIT 1";
        $result = mysqli_query($conn, $query);

        // Initialize an empty string to hold the comments
        $coding_comments = "";

        // Check if the query was successful
        if ($result) {
            // Fetch each row
            while ($row = mysqli_fetch_assoc($result)) {
                // Append the coding_comments to the string
                $coding_comments .= $row['coding_comments'] . "<br>"; // Add a line break after each comment
            }
        } else {
            echo "Error executing query: " . mysqli_error($conn);
        }


        $conn->close();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
// OasisSegement

if ($userId) {
    try {
        // Create a connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }



        // oasis_comments

        // Example query to fetch user data
        $query = "SELECT `oasis_comments` FROM `oasis` WHERE `Entry_Id` = '$userId' AND `oasis_comments` IS NOT NULL AND `oasis_comments` != ''  LIMIT 1";
        $result = mysqli_query($conn, $query);

        // Initialize an empty string to hold the comments
        $oasis_comments = "";

        // Check if the query was successful
        if ($result) {
            // Fetch each row
            while ($row = mysqli_fetch_assoc($result)) {
                // Append the oasis_comments to the string
                $oasis_comments .= $row['oasis_comments'] . "<br>"; // Add a line break after each comment
            }
        } else {
            echo "Error executing query: " . mysqli_error($conn);
        }

        $conn->close();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

// PocSegement

if ($userId) {
    try {
        // Create a connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }


        // Example query to fetch user data
        $query = "SELECT `poc_comments` FROM `Pocsegement` WHERE `Entry_Id` = '$userId' AND `poc_comments` IS NOT NULL AND `poc_comments` != ''  LIMIT 1";
        $result = mysqli_query($conn, $query);

        // Initialize an empty string to hold the comments
        $poc_comments = "";

        // Check if the query was successful
        if ($result) {
            // Fetch each row
            while ($row = mysqli_fetch_assoc($result)) {
                // Append the poc_comments to the string
                $poc_comments .= $row['poc_comments'] . "<br>"; // Add a line break after each comment
            }
        } else {
            echo "Error executing query: " . mysqli_error($conn);
        }

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
    <!-- html2canvas library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- jsPDF library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.js" integrity="sha512-Bw9Zj8x4giJb3OmlMiMaGbNrFr0ERD2f9jL3en5FmcTXLhkI+fKyXVeyGyxKMIl1RfgcCBDprJJt4JvlglEb3A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <title>CODER VIEW</title>


    <?php
    include('include_file/link.php');
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
} */

   .content {
            width: 100%;
            white-space: nowrap;
            overflow: hidden;
        }
</style>

<body style="background-color: #E6E6E6; user-select:  ;">

    <div class="container-fluid mt-4">
        <div class="row d-flex justify-content-center">
            <button class="btn btn-primary"onclick="convert_pdf('<?php echo $patientName; ?>_<?php echo $mrn; ?>')">Download</button>
            <div class="col-12 col-lg-12">
                <div class="container mt-5 mb-5">

                    <div class="card p-4" id="pdfcontainer">
                        <div class="card-header text-center mb-2">
                            CODER PREVIEW

                        </div>

                        <!-- personal details -->

                        <div class="table-responsive mt-3">
                            <table class="styled-table fixed-header-width table">
                                <thead style="color: whitesmoke; background: #4C4CAC;">
                                    <tr>
                                        <th scope="col">Patient_Name</th>
                                        <th scope="col">Patient_MRN</th>
                                        <th scope="col">Agency</th>
                                        <th scope="col">Insurance Type</th>
                                        <th scope="col">Date of Assessment</th>
                                        <th scope="col">Assessment Type</th>
                                        <th scope="col">Coder</th>
                                        
                                    </tr>
                                </thead>

                                <tbody>

                                    <tr>
                                        <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo "$patientName" ?></td>
                                        <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo "$mrn" ?></td>
                                        <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo "$agency" ?></td>
                                        <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo "$insuranceType" ?></td>
                                        <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo "$assessmentDate" ?></td>
                                        <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo "$assessmentType" ?></td>
                                        <td style="border: 1px solid black; white-space: pre-wrap;word-break: auto;word-spacing: normal;overflow: auto;overflow-x: auto; max-width: 100px;width: 80%;"><?php echo "$coder" ?>&nbsp(<?php echo  $Coder_emp_id ?>)</td>
                                         

                                    </tr>

                                </tbody>

                            </table>
                        </div>

                        <!-- code segement -->

                        <div class="table-responsive mt-3">
                            <h4 class="font-weight-bold">Code Segment</h4>
                            <!-- Table structure -->
                            <table class="table table-striped table-hover Response" id="myTable ">
                                <!-- Table headers... -->
                                <thead class="bg-primary">
                                    <tr class="text-white">
                                        <!-- <th>ID</th> -->
                                        <th style="border: 1px solid black; white-space: pre-wrap;">M-Items</th>
                                        <th style="border: 1px solid black; white-space: pre-wrap;">ICD-code</th>
                                        <th style="border: 1px solid black; white-space: pre-wrap;"> Description</th>
                                        <th style="border: 1px solid black; white-space: pre-wrap;">Effective Date</th>
                                        <th style="border: 1px solid black; white-space: pre-wrap;">EO</th>
                                        <th style="border: 1px solid black; white-space: pre-wrap;">Rating</th>
                                    </tr>
                                </thead>
                                <!-- Table body -->
                                <tbody id="tableBody" class="content">
                                    <?php if (!empty($data)) : ?>
                                        <?php foreach ($data as $row) : ?>
                                            <tr>

                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>

                                        <tr>
                                            <td colspan="7" style="border: 1px solid black; white-space: pre-wrap;">No data available </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                            <!-- JavaScript to load data using AJAX -->
                            <script>
                                $(document).ready(function() {
                                    // Function to load data using AJAX
                                    function loadData() {
                                        $.ajax({
                                            url: "codesegment_data.php?action=Codesegement",
                                            method: 'GET',
                                            dataType: 'json',
                                            success: function(response) {
                                                // Clear existing table rows
                                                $('#tableBody').empty();

                                                if ('error' in response) {
                                                    console.error('Error loading data:', response.error);
                                                    // Display an error message to the user if needed
                                                } else {
                                                    // Populate table with new data
                                                    if (response.data && response.data.length > 0) {
                                                        response.data.forEach(function(row) {


                                                            const defaultMItem = [
                                                                "M1021A", "M1023B", "M1023C", "M1023D", "M1023E", "M1023F", "M1023G", "M1023H", "M1023I", "M1023J", "M1023K", "M1023L", "M1023M", "M1023N", "M1023O", "M1023P", "M1023Q", "M1023R", "M1023S", "M1023T", "M1023U", "M1023V", "M1023W", "M1023X", "M1023Y",
                                                            ];

                                                            $('#tableBody').append(`<tr> ${defaultMItem.includes(row["M-Items"]) ? `<td style="border: 1px solid black; white-space: pre-wrap;">${row['M-Items']}</td>` : '`<td style="border: 1px solid black; white-space: pre-wrap;"> </td>`'}
    

                                           
                                        <td style="border: 1px solid black; white-space: pre-wrap;text-transform: uppercase;">${row['ICD-code']}</td>
                                        <td style="border: 1px solid black; white-space: pre-wrap;">${row.Description}</td>
                                        <td style="border: 1px solid black; white-space: pre-wrap;">${row.Effective_Date}</td>
                                        <td style="border: 1px solid black; white-space: pre-wrap;">${row.Eo}</td>
                                        <td style="border: 1px solid black; white-space: pre-wrap;">${row['ICD-code'].startsWith('Z') ? '' : row.Rating}</td>
                                    </tr>
                                `);
                                                               // "text-transform: uppercase - if need to codesegment

                                                        });
                                                    } else {
                                                        // Display a message if no data is available
                                                        $('#tableBody').append('<tr><td colspan="7">No data available</td></tr>');
                                                    }
                                                }
                                            },
                                            error: function(error) {
                                                console.error('Error loading data:', error);
                                            }
                                        });
                                    }

                                    // Initial load of data when the document is ready
                                    loadData();
                                });
                            </script>
                        </div>

                        <!-- code segement  comment-->

                        <div class="table-responsive mt-3">

                            <table class="table mx-auto">
                                <thead style="color: whitesmoke; background: #4C4CAC;">
                                    <tr>
                                        <th scope="col">Coding Commments </th>

                                    </tr>
                                </thead>
                              <tbody >
    <td style="border: 1px solid black; white-space: pre-wrap; word-break: auto; word-spacing: normal; overflow-x: auto; max-width: 200px;"><?php echo $coding_comments; ?></td>
</tbody>

                            </table>

                        </div>
                         <!-- <div class="pagebreak"></div> -->


                        <!-- oasis segement -->

                        <div class="table-responsive mt-3">

                            <h4 class="font-weight-bold"> OASIS Segment</h4>
                            <table class="table table-striped table-hover Response" id="myTable">
                                <!-- Table headers... -->
                                <thead class="bg-primary">
                                    <tr class="text-white">
                                        <!-- <th>ID</th> -->
                                        <th>M-Items</th>
                                        <th>Agency_response</th>
                                        <th>Coder_response</th>
                                        <th>Coder_rationali </th>
                                    </tr>
                                </thead>
                                <!-- Table body -->
                                <tbody id="oasis" class="content">
                                    <?php if (!empty($data)) : ?>
                                        <?php foreach ($data as $row) : ?>
                                            <tr>
                                                <!-- Table cells... -->
                                                <!-- Add your PHP code here to populate the cells with data from $row -->
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <!-- Display a message if no data is available -->
                                        <tr>
                                            <td colspan="4" style="border: 1px solid black; white-space: pre-wrap; word-wrap: break-word;word-spacing: normal;">No data available</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
<br>


                            <script>
                                $(document).ready(function() {
                                    // Function to load data using AJAX
                                    function loadData() {
                                        $.ajax({
                                            url: "codesegment_data.php?action=oasis",
                                            method: 'GET',
                                            dataType: 'json',
                                            success: function(response) {
                                                // Clear existing table rows
                                                $('#oasis').empty();

                                                if ('error' in response) {
                                                    console.error('Error loading data:', response.error);
                                                    // Display an error message to the user if needed
                                                } else {
                                                    // Populate table with new data
                                                    if (response.data && response.data.length > 0) {
                                                        response.data.forEach(function(row) {
                                                            // Append a new row for each record
                                                            $('#oasis').append(`
                                    <tr>
                                     
                                        <td style="border: 1px solid black; white-space: pre-wrap;">${row['M_item']}</td>
                                        <td style="border: 1px solid black; white-space: pre-wrap;">${row['Agency_response']}</td>
                                        <td style="border: 1px solid black; white-space: pre-wrap;">${row['Coder_response']}</td>
                                        <td style="border: 1px solid black; white-space: pre-wrap;">${row['Coder_rationali']}</td>
                                        
                                    </tr>
                                `);
                                                        });
                                                    } else {
                                                        // Display a message if no data is available
                                                        $('#oasis').append('<tr><td colspan="7">No data available</td></tr>');
                                                    }
                                                }
                                            },
                                            error: function(error) {
                                                console.error('Error loading data:', error);
                                            }
                                        });
                                    }

                                    // Initial load of data when the document is ready
                                    loadData();
                                });
                            </script>
 
  
                        <div class="gg" id="gg-items">
                            
                       
                            <h4 class="font-weight-bold">GG-Mitem</h4>
                            <table class="table table-striped table-hover Response table-borderd " id="dataTable">
                                <!-- Table headers... -->
                                <thead class="bg-primary">
                                    <tr class="text-white">
                                        <!-- <th>ID</th> -->
                                        <th>M-Items</th>
                                        <!-- <th>M-Items-Type</th> -->
                                        <th>Agency_response</th>
                                        <th>Coder_response</th>
                                        <th>Coder_rationali </th>
                                    </tr>
                                </thead>
                                  <tbody>

                                </tbody>
                                 </table>

                          </div>

 

 

 
<script>
$(document).ready(function() {
    // Function to load data using AJAX
    function loadData() {
        $.ajax({
            url: "ggmitem/ggmitemshowdata.php?action=oasis_new",
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log("gg",response);

                var tableBody = $('#dataTable tbody');

                  if (response.length === 0) {
                    // If response is empty, display "No data available" message
                    var noDataRow = $('<tr></tr>');
                    noDataRow.append('<td colspan="4" style="text-align: center;">No data available</td>');

                    tableBody.append(noDataRow);
                    $("#gg-items").hide();

                } else {

                response.forEach(function(rowData) {
                    var agencyData = JSON.parse(rowData.agencydata);
                    var mitem = agencyData.mitem;
                    var mitem_type = agencyData.mitem_type;

                    var coderData = JSON.parse(rowData.coderdata);
                    var coderRationali = rowData.Coder_rationali;

                    var row = $('<tr></tr>');
                    row.append(`<td style="border: 1px solid black; white-space: pre-wrap;">${mitem}</td>`);
                    // row.append(`<td>${mitem_type}</td>`);
                    row.append(`<td style="border: 1px solid black; white-space: pre-wrap;">${getTagsWithGroup(agencyData.fields)}</td>`);
                    row.append(`<td style="border: 1px solid black; white-space: pre-wrap;color-red;">${getTagsWithGroup(coderData.fields)}</td>`);
                    row.append(`<td style="border: 1px solid black; white-space: pre-wrap;">${coderRationali}</td>`);

                    tableBody.append(row);
                });
            }

        },
            error: function(error) {
                console.error('Error loading data:', error);
            }
        });
    }
 


function getTagsWithGroup(fields) {
    var tagsWithGroup = "";
    fields.forEach(function(field) {
        var groupName = field.group;
        field.tags.forEach(function(tag) {
            // Check if the tag has a value
            if (tag.value) {
                // Display each tag within a box
                tagsWithGroup += `<div style="border: 1px solid black; padding: 5px; margin-bottom: 5px;">${groupName}: ${tag.name}: <strong>${tag.value}</strong></div>`;
            }
        });
    });
    return tagsWithGroup;
}

 // Initial load of data when the document is ready
    loadData();
});


</script>


 </div>














                        <!-- oasis segement comments-->

                        <div class="table-responsive mt-3">
                            <div class="card">
                                <table class="table mx-auto">
                                    <thead style="color: whitesmoke; background: #4C4CAC;">
                                        <tr>
                                            <th scope="col">Oasis-Commments</th>

                                        </tr>
                                    </thead>
                                    <tbody class="content">

                                        <td style="border: 1px solid black; white-space: pre-wrap;word-break: auto; word-wrap: break-word;"><?php echo $oasis_comments ?></td>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                         <!-- <div class="pagebreak"></div> -->

                        <!-- poc segement-->

                        <div class="table-responsive mt-3">
                            <h4 class="font-weight-bold"> POC Segment</h4>
                            <table class="table table-striped table-hover Response" id="myTable">
                                <!-- Table headers... -->
                                <thead class="bg-primary">
                                    <tr class="text-white">
                                        <!-- <th>ID</th> -->
                                        <th>Poc_item</th>
                                        <th>Coder_response</th>

                                    </tr>
                                </thead>
                                <!-- Table body -->
                                <tbody id="poc" class="content">
                                    <?php if (!empty($data)) : ?>
                                        <?php foreach ($data as $row) : ?>
                                            <tr>
                                                <!-- Table cells... -->
                                                <!-- Add your PHP code here to populate the cells with data from $row -->
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <!-- Display a message if no data is available -->
                                        <tr>
                                            <td colspan="4">No data available</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>



                            <script>
                                $(document).ready(function() {
                                    // Function to load data using AJAX
                                    function loadData() {
                                        $.ajax({
                                            url: "codesegment_data.php?action=Pocsegement",
                                            method: 'GET',
                                            dataType: 'json',
                                            success: function(response) {
                                                // Clear existing table rows
                                                $('#poc').empty();

                                                if ('error' in response) {
                                                    console.error('Error loading data:', response.error);
                                                    // Display an error message to the user if needed
                                                } else {
                                                    // Populate table with new data
                                                    if (response.data && response.data.length > 0) {
                                                        response.data.forEach(function(row) {
                                                            // Append a new row for each record
                                                            $('#poc').append(`
                                    <tr>
                                     
                                        <td style="border: 1px solid black; white-space: pre-wrap; ">${row['Poc_item']}</td>
                                        <td style="border: 1px solid black; white-space: pre-wrap;">${row['Coder_response']}</td>
                                        
                                    </tr>
                                `);
                                                        });
                                                    } else {
                                                        // Display a message if no data is available
                                                        $('#poc').append('<tr><td colspan="7">No data available</td></tr>');
                                                    }
                                                }
                                            },
                                            error: function(error) {
                                                console.error('Error loading data:', error);
                                            }
                                        });
                                    }

                                    // Initial load of data when the document is ready
                                    loadData();
                                });
                            </script>
                        </div>

                        <!-- poc segement comments-->

                        <div class="table-responsive mt-3">
                            <div class="card">
                                <table class="table mx-auto">
                                    <thead style="color: whitesmoke; background: #4C4CAC;">
                                        <tr>
                                            <th scope="col"> Poc-Commments</th>

                                        </tr>
                                    </thead>
                                    <tbody class="content">

                                        <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $poc_comments ?></td>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Notes to Agency -->

                        <div class="table-responsive mt-3">
                            <div class="card">
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
            </div>




        </div>

    </div>
</body>

<script src="Assign/js/assign_table.js"></script>
<script src="Assign/js/completed.js"></script>
<?php
include 'include_file/pulg.php';
?>

<!--   <script>
  //JavaScript code for generating PDF 
        function convert_pdf(filename) {
            // Get the HTML element to convert to PDF
            var element = document.getElementById('pdfcontainer');

            // Options for PDF generation
            var options = {
                margin: [10, 10, 20, 10], // [left, top, right, bottom]
                filename: filename+'.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2, logging: true },
                jsPDF: { unit: 'mm', format: 'a3', orientation: 'portrait' },
                 pagebreak: { mode: ['avoid-all', 'css', 'legacy']}
            };

            // Generate PDF
            html2pdf()
                .from(element)
                .set(options)
                .save();
        }

</script>  
 -->

 


<script>
 
 function convert_pdf(filename) {
  var element = document.getElementById("pdfcontainer");
 
  var options = {
    margin: [0, 0, 1, 0], //[top, leaft, bottom, right]
    filename: filename + ".pdf",
    image: { type: "jpeg", quality: 1 },
    pagebreak: { avoid: "tr", mode: "css", before: "#nextpage1" },
    html2canvas: { scale: 5, useCORS: true, dpi: 192, letterRendering: true },
    jsPDF: { unit: "in", format: "a3", orientation: "portrait" },
  };

        // Generate PDF
        html2pdf()
            .from(element)
            .set(options)
            .save();
    }
</script>


 








</html>