<?php

// require('fpdf/fpdf.php');
include 'logsession.php';
session_start();
 include('db/db-con.php');

$userId = $_COOKIE['Id'];
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
$qccoder = "";

// Main Data 

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
            $qccoder = $row['qc_person'];
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
        $query = "SELECT * FROM `Codesegementqc` WHERE `Entry_Id` = ?";
        $stmt = $conn->prepare($query);

        // Bind parameters and execute query
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch user data
        $data = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Perform empty check validations for specific fields
                if (
                    !empty($row['Id']) &&
                    !empty($row['M-Items']) &&
                    !empty($row['ICD-code']) &&
                    !empty($row['Description']) &&
                    !empty($row['Effective_Date']) &&
                    !empty($row['Eo']) &&
                    !empty($row['Rating']) &&
                    !empty($row['Reason']) &&
                    !empty($row['Errortype']) &&
                    !empty($row['Qcrationaile'])
                    // isset($row['coding_comments'])
                ) {
                    // Create an associative array for each row
                    $rowData = [
                        'Id' => $row['Id'],
                        'MItems' => $row['M-Items'],
                        'Icd' => $row['ICD-code'],
                        'Description' => $row['Description'],
                        'Effective_Date' => $row['Effective_Date'],
                        'Eo' => $row['Eo'],
                        'Rating' => $row['Rating'],
                        'Reason' => $row['Reason'],
                        'Errortype' => $row['Errortype'],
                        'Qcrationaile' => $row['Qcrationaile'],
                        // 'coding_comments' => $row['coding_comments']
                    ];

                    // Append the row data to the $data array
                    $data[] = $rowData;
                    // echo $data;
                }
            }
        }


        // Close the statement and connection
        $stmt->close();

        // coding_comments

        // Example query to fetch user data
        $query = "SELECT `coding_comments` FROM `Codesegementqc` WHERE `Entry_Id` = '$userId' AND `coding_comments` IS NOT NULL AND `coding_comments` != ''  LIMIT 1";
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

        // Example query to fetch user data
        $query = "SELECT * FROM `oasisqc` WHERE `Entry_Id` = ?";
        $stmt = $conn->prepare($query);

        // Bind parameters and execute query
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch user data
        $data1 = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Perform empty check validations for each field
                if (
                    !empty($row['Id']) &&
                    !empty($row['M_item']) &&
                    isset($row['Agency_response']) &&
                    isset($row['Coder_response']) &&
                    isset($row['Coder_rationali']) &&
                    isset($row['Error_reason']) &&
                    isset($row['Error_type']) &&
                    isset($row['Qc_rationali']) &&
                    isset($row['oasis_comments'])
                ) {
                    // Create an associative array for each row
                    $rowData = [
                        'Id' => $row['Id'],
                        'M_item' => $row['M_item'],
                        'Agency_response' => $row['Agency_response'],
                        'Coder_response' => $row['Coder_response'],
                        'Coder_rationali' => $row['Coder_rationali'],
                        'Error_reason' => $row['Error_reason'],
                        'Error_type' => $row['Error_type'],
                        'Qc_rationali' => $row['Qc_rationali'],
                        'oasis_comments' => $row['oasis_comments'],
                    ];

                    // Append the row data to the $data1 array
                    $data1[] = $rowData;
                }
            }
        }


        // Close the statement and connection
        $stmt->close();

        // oasis_comments

        // Example query to fetch user data
        $query = "SELECT `oasis_comments` FROM `oasisqc` WHERE `Entry_Id` = '$userId' AND `oasis_comments` IS NOT NULL AND `oasis_comments` != ''  LIMIT 1";
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
        $query = "SELECT * FROM `Pocsegementqc` WHERE `Entry_Id` = ?";
        $stmt = $conn->prepare($query);

        // Bind parameters and execute query
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch user data
        $data2 = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Perform empty check validations for specific fields
                if (
                    !empty($row['Id']) &&
                    !empty($row['Poc_item']) &&
                    !empty($row['Coder_response']) &&
                    !empty($row['Error_reason']) &&
                    !empty($row['Error_type']) &&
                    !empty($row['Qc_rationali']) &&
                    isset($row['poc_comments']) // Check if 'poc_comments' is set
                ) {
                    // Create an associative array for each row
                    $rowData = [
                        'Id' => $row['Id'],
                        'Poc_item' => $row['Poc_item'],
                        'Coder_response' => $row['Coder_response'],
                        'Error_reason' => $row['Error_reason'],
                        'Error_type' => $row['Error_type'],
                        'Qc_rationali' => $row['Qc_rationali'],
                        'poc_comments' => $row['poc_comments'],
                    ];

                    // Append the row data to the $data2 array
                    $data2[] = $rowData;
                }
            }
        }


        // Close the statement and connection
        $stmt->close();

        // poc_comments

        // Example query to fetch user data
        $query = "SELECT `poc_comments` FROM `Pocsegementqc` WHERE `Entry_Id` = '$userId' AND `poc_comments` IS NOT NULL AND `poc_comments` != ''  LIMIT 1";
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
    <title>Pdf</title>


    <?php
    include('include_file/link.php');
    ?>
</head>

<style>
    /* Custom CSS for right border */
    .right-border {
        border-right: 1px solid;
    }

    .no-bottom-border {
        border-bottom: none;
    }

    .card1 {
        background-color: white;

    }





    @media print {

        html,
        body {
            display: none;
            /* hide whole page */
        }
    }

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
</style>

<body style="background-color: #E6E6E6; user-select: none;">



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-REHJTs1r2L/CfA6Rr+Oq83aIZlOFh9SBE1Q3L10VEMhNETIbb8F+8rVdUuBaa6S" crossorigin="anonymous">
    <div class="">
        <nav class="navbar navbar-expand-lg navbar-white bg-white">

            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- <button class="button">
                    <span class="d-inline-block mr-3"  id="stcoder" value="<?php echo $userId; ?>">Sent to coder</span>
                </button> -->
            </div>


        </nav>



        <div class="container  mt-5" id="pdfcontainer">

            <div class="card">



                <div class="container mt-5 mb-5">

                    <div class="card">
                        <!-- <h4 style="float:right;">CODER:<?php echo "$coder" ?></h4> -->

                        <table class="table mx-auto">
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
                                    <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo "$qccoder" ?></td>

                                </tr>

                            </tbody>

                        </table>

                    </div>
                </div>
                <!-- -->


                <!-- code segement -->
                <div class="container mt-5 mb-5">
                    <h4>QC Code Segement</h4>
                    <div class="card">

                        <table class="table mx-auto">
                            <thead style="color: whitesmoke; background: #4C4CAC;">
                                <tr>
                                    <th scope="col">MItems</th>
                                    <th scope="col">ICD</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Effective Date</th>
                                    <th scope="col">E/O</th>
                                    <th scope="col">Rating</th>
                                    <th scope="col">Error Reason</th>
                                    <th scope="col">Error Type</th>
                                    <th scope="col">Qc Rationali</th>
                                </tr>
                            </thead>

                            <?php if (!empty($data)) { ?>
                                <tbody>
                                    <?php foreach ($data  as $row) { ?>
                                        <tr>

                                            <?php
                                            $defaultMItem = [
                                                "M1021A", "M1023B", "M1023C", "M1023D", "M1023E", "M1023F", "M1023G", "M1023H", "M1023I",  "M1023J",  "M1023K",  "M1023L",  "M1023M", "M1023N", "M1023O", "M1023P", "M1023Q", "M1023R", "M1023S", "M1023T", "M1023U", "M1023V", "M1023W", "M1023X", "M1023Y",
                                            ];
                                            ?>

                                            <?php if (in_array($row['MItems'], $defaultMItem)) { ?>

                                                <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $row['MItems']; ?></td>
                                            <?php } else {  ?>
                                                <td style="border: 1px solid black; white-space: pre-wrap;"></td>

                                            <?php } ?>

                                            <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $row['Icd']; ?></td>
                                            <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $row['Description']; ?></td>
                                            <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $row['Effective_Date']; ?></td>
                                            <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $row['Eo']; ?></td>
                                            <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $row['Rating']; ?></td>
                                            <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $row['Reason']; ?></td>
                                            <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $row['Errortype']; ?></td>
                                            <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $row['Qcrationaile']; ?></td>

                                        </tr>
                                    <?php } ?>
                                </tbody>
                            <?php } else { ?>
                                <tbody>
                                    <tr>
                                        <td colspan="4">No data available</td>
                                    </tr>
                                </tbody>
                            <?php } ?>

                        </table>
                        <div class="container mt-5 mb-5">
                            <h4>QC Coding Commments</h4>
                            <div class="card">
                                <table class="table mx-auto">
                                    <thead style="color: whitesmoke; background: #4C4CAC;">
                                        <tr>
                                            <th scope="col"> </th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $coding_comments ?></td>

                                    </tbody>

                                </table>
                            </div>
                        </div>

                        <!-- oasis -->
                        <div class="container mt-5 mb-5">
                            <h4>QC OASIS Segement</h4>
                            <div class="card">

                                <table class="table mx-auto">
                                    <thead style="color: whitesmoke; background: #4C4CAC;">
                                        <tr>
                                            <th scope="col">MItems</th>
                                            <th scope="col">Agency Response</th>
                                            <th scope="col">Coder Response</th>
                                            <th scope="col">Coder Rationali</th>
                                            <th scope="col">Error Reason</th>
                                            <th scope="col">Error Type</th>
                                            <th scope="col">Qc Rationali</th>
                                        </tr>
                                    </thead>
                                    <?php if (!empty($data1)) { ?>
                                        <tbody>
                                            <?php foreach ($data1 as $row) { ?>
                                                <tr>
                                                    <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $row['M_item']; ?></td>
                                                    <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $row['Agency_response']; ?></td>
                                                    <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $row['Coder_response']; ?></td>
                                                    <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $row['Coder_rationali']; ?></td>
                                                    <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $row['Error_reason']; ?></td>
                                                    <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $row['Error_type']; ?></td>
                                                    <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $row['Qc_rationali']; ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>


                                    <?php } else { ?>
                                        <tbody>
                                            <tr>
                                                <td colspan="4">No data available</td>
                                            </tr>
                                        </tbody>
                                    <?php } ?>
                                </table>

                                <div class="container mt-5 mb-5">
                                    <h4>Qc Oasis-Commments</h4>
                                    <div class="card">
                                        <table class="table mx-auto">
                                            <thead style="color: whitesmoke; background: #4C4CAC;">
                                                <tr>
                                                    <th scope="col"> </th>

                                                </tr>
                                            </thead>
                                            <tbody>

                                                <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $oasis_comments ?></td>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- -->

                        <!-- poc -->
                        <div class="container mt-5 mb-5">
                            <h4>Qc POC Segement</h4>
                            <div class="card">

                                <table class="table mx-auto">
                                    <thead style="color: whitesmoke; background: #4C4CAC;">
                                        <tr>
                                            <th scope="col">POC-ITEM</th>
                                            <th scope="col">Coder Response</th>
                                            <th scope="col">Error Reason</th>
                                            <th scope="col">Error Type</th>
                                            <th scope="col">Qc Rationali</th>
                                        </tr>
                                    </thead>
                                    <?php if (!empty($data2)) { ?>
                                        <tbody>
                                            <?php foreach ($data2 as $row) { ?>
                                                <tr>
                                                    <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $row['Poc_item']; ?></td>
                                                    <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $row['Coder_response']; ?></td>
                                                    <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $row['Error_reason']; ?></td>
                                                    <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $row['Error_type']; ?></td>
                                                    <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $row['Qc_rationali']; ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>


                                    <?php } else { ?>
                                        <tbody>
                                            <tr>
                                                <td colspan="4">No data available</td>
                                            </tr>
                                        </tbody>
                                    <?php } ?>
                                </table>
                                <div class="container mt-5 mb-5">
                                    <h4>Qc Poc Commments</h4>
                                    <div class="card">
                                        <table class="table mx-auto">
                                            <thead style="color: whitesmoke; background: #4C4CAC;">
                                                <tr>
                                                    <th scope="col"> </th>

                                                </tr>
                                            </thead>
                                            <tbody>

                                                <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $poc_comments ?></td>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

                <!-- <script> -->



                <!--  <script src="QA/js/Qa_work_files.js"></script>
                <script src="QA/js/qc_completed.js"></script> -->
                <?php
                include 'include_file/pulg.php';
                ?>
</body>
    
<script>
    window.jsPDF = window.jspdf.jsPDF;

    // Convert HTML content to PDF
    function convert_pdf() {
        var doc = new jsPDF();

        // Source HTMLElement or a string containing HTML.
        var elementHTML = document.querySelector("#pdfcontainer");

        doc.html(elementHTML, {
            callback: function(doc) {
                // Save the PDF
                // doc.save('document-html.pdf');
                console.log(doc.output("blob"))
                window.location.href = URL.createObjectURL(doc.output("blob"))
            },
            margin: [15, 10, 10, 15],
            autoPaging: 'text',
            x: 0,
            y: 0,
            width: 150, //target width in the PDF document
            windowWidth: 675 //window width in CSS pixels
        });
    }
</script>


<script>
    $(document).ready(function() {
        $('#Back').on("click", function() {
            var confirmation = confirm("Are you sure you want to go back to the assign table?");
            if (confirmation) {
                window.location.href = "Qa_work_files.php";

            } else {
                console.log("Action canceled");
            }
        });
    });
</script>

</html>