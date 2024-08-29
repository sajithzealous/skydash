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
    $query = "SELECT * FROM `Codesegement` WHERE `Entry_Id` = ?";
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
        // Create an associative array for each row
        $rowData = [
          'Id' => $row['Id'],
          'MItems' => $row['M-Items'],
          'Icd' => $row['ICD-code'],
          'Description' => $row['Description'],
          'Effective_Date' => $row['Effective_Date'],
          'Eo' => $row['Eo'],
          'Rating' => $row['Rating'],
          // 'coding_comments' => $row['coding_comments']
        ];

        // Append the row data to the $data array
        $data[] = $rowData;
        // echo $coding_comments=$rowData['coding_comments'];

      }
    }


    // Close the statement and connection
    $stmt->close();


    // coding_comments

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

    // Example query to fetch user data
    $query = "SELECT * FROM `oasis` WHERE `Entry_Id` = ?";
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
        // Create an associative array for each row
        $rowData = [
          'Id' => $row['Id'],
          'M_item' => $row['M_item'],
          'Agency_response' => $row['Agency_response'],
          'Coder_response' => $row['Coder_response'],
          'Coder_rationali' => $row['Coder_rationali'],
          // 'oasis_comments' => $row['oasis_comments'],
        ];

        // Append the row data to the $data1 array
        $data1[] = $rowData;
      }
    }


    // Close the statement and connection
    $stmt->close();

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
    $query = "SELECT * FROM `Pocsegement` WHERE `Entry_Id` = ?";
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

        // Create an associative array for each row
        $rowData = [
          'Id' => $row['Id'],
          'Poc_item' => $row['Poc_item'],
          'Coder_response' => $row['Coder_response'],
          // 'poc_comments' => $row['poc_comments'],
        ];

        // Append the row data to the $data2 array
        $data2[] = $rowData;
      }
    }


    // Close the statement and connection
    $stmt->close();

    // poc_comments

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

// QC preview

// QC CodeSegement

if ($userId) {
  try {
    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // Example query to fetch user data
    $qc_query = "SELECT * FROM `Codesegementqc` WHERE `Entry_Id` = ?";
    $qc_stmt = $conn->prepare($qc_query);

    // Bind parameters and execute query
    $qc_stmt->bind_param('i', $userId);
    $qc_stmt->execute();
    $qc_result = $qc_stmt->get_result();

    // Fetch user data
    $qc_data = [];

    if ($qc_result->num_rows > 0) {
      while ($qc_row = $qc_result->fetch_assoc()) {
        // Perform empty check validations for specific fields

        // Create an associative array for each qc_row
        $qc_rowData = [
          'Id' => $qc_row['Id'],
          'MItems' => $qc_row['M-Items'],
          'Icd' => $qc_row['ICD-code'],
          'Description' => $qc_row['Description'],
          'Effective_Date' => $qc_row['Effective_Date'],
          'Eo' => $qc_row['Eo'],
          'Rating' => $qc_row['Rating'],
          'Reason' => $qc_row['Reason'],
          'Errortype' => $qc_row['Errortype'],
          'Qcrationaile' => $qc_row['Qcrationaile'],
          // 'coding_comments' => $row['coding_comments']
        ];

        // Append the row qc_data to the $qc_data array
        $qc_data[] = $qc_rowData;
        // echo $data;

      }
    }


    // Close the statement and connection
    $qc_stmt->close();

    // coding_comments

    // Example query to fetch user data
    $query = "SELECT `coding_comments` FROM `Codesegementqc` WHERE `Entry_Id` = '$userId' AND `coding_comments` IS NOT NULL AND `coding_comments` != ''  LIMIT 1";
    $result = mysqli_query($conn, $query);

    // Initialize an empty string to hold the comments
    $qc_coding_comments = "";

    // Check if the query was successful
    if ($result) {
      // Fetch each row
      while ($row1 = mysqli_fetch_assoc($result)) {
        // Append the coding_comments to the string
        $qc_coding_comments .= $row1['coding_comments'] . "<br>"; // Add a line break after each comment
      }
    } else {
      echo "Error executing query: " . mysqli_error($conn);
    }

    $conn->close();
  } catch (Exception $e) {
    echo "Error: " . $e->getMessage();
  }
}

//QC OasisSegement

if ($userId) {
  try {
    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // Example query to fetch user data
    $qc_query = "SELECT * FROM `oasisqc` WHERE `Entry_Id` = ?";
    $qc_stmt = $conn->prepare($qc_query);

    // Bind parameters and execute query
    $qc_stmt->bind_param('i', $userId);
    $qc_stmt->execute();
    $qc_result = $qc_stmt->get_result();

    // Fetch user data
    $qc_data1 = [];

    if ($qc_result->num_rows > 0) {
      while ($qc_row = $qc_result->fetch_assoc()) {
        // Perform empty check validations for each field

        // Create an associative array for each row
        $qc_rowData = [
          'Id' => $qc_row['Id'],
          'M_item' => $qc_row['M_item'],
          'Agency_response' => $qc_row['Agency_response'],
          'Coder_response' => $qc_row['Coder_response'],
          'Coder_rationali' => $qc_row['Coder_rationali'],
          'Error_reason' => $qc_row['Error_reason'],
          'Error_type' => $qc_row['Error_type'],
          'Qc_rationali' => $qc_row['Qc_rationali'],
          'oasis_comments' => $qc_row['oasis_comments'],
        ];

        // Append the row data to the $qc_data1 array
        $qc_data1[] = $qc_rowData;
      }
    }


    // Close the statement and connection
    $qc_stmt->close();

    // oasis_comments

    // Example query to fetch user data
    $query = "SELECT `oasis_comments` FROM `oasisqc` WHERE `Entry_Id` = '$userId' AND `oasis_comments` IS NOT NULL AND `oasis_comments` != ''  LIMIT 1";
    $result = mysqli_query($conn, $query);

    // Initialize an empty string to hold the comments
    $qc_oasis_comments = "";

    // Check if the query was successful
    if ($result) {
      // Fetch each row
      while ($row1 = mysqli_fetch_assoc($result)) {
        // Append the oasis_comments to the string
        $qc_oasis_comments .= $row1['oasis_comments'] . "<br>"; // Add a line break after each comment
      }
    } else {
      echo "Error executing query: " . mysqli_error($conn);
    }


    $conn->close();
  } catch (Exception $e) {
    echo "Error: " . $e->getMessage();
  }
}

// QC PocSegement

if ($userId) {
  try {
    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // Example query to fetch user data
    $qc_query = "SELECT * FROM `Pocsegementqc` WHERE `Entry_Id` = ?";
    $qc_stmt = $conn->prepare($qc_query);

    // Bind parameters and execute query
    $qc_stmt->bind_param('i', $userId);
    $qc_stmt->execute();
    $qc_result = $qc_stmt->get_result();

    // Fetch user data
    $qc_data2 = [];
    if ($qc_result->num_rows > 0) {
      while ($qc_row = $qc_result->fetch_assoc()) {

        // Create an associative array for each qc_row
        $qc_rowData = [
          'Id' => $qc_row['Id'],
          'Poc_item' => $qc_row['Poc_item'],
          'Coder_response' => $qc_row['Coder_response'],
          'Error_reason' => $qc_row['Error_reason'],
          'Error_type' => $qc_row['Error_type'],
          'Qc_rationali' => $qc_row['Qc_rationali'],
          'poc_comments' => $qc_row['poc_comments'],
        ];

        // Append the row data to the $qc_data2 array
        $qc_data2[] = $qc_rowData;
      }
    }


    // Close the statement and connection
    $qc_stmt->close();

    // poc_comments

    // Example query to fetch user data
    $query = "SELECT `poc_comments` FROM `Pocsegementqc` WHERE `Entry_Id` = '$userId' AND `poc_comments` IS NOT NULL AND `poc_comments` != ''  LIMIT 1";
    $result = mysqli_query($conn, $query);

    // Initialize an empty string to hold the comments
    $qc_poc_comments = "";

    // Check if the query was successful
    if ($result) {
      // Fetch each row
      while ($row1 = mysqli_fetch_assoc($result)) {
        // Append the poc_comments to the string
        $qc_poc_comments .= $row1['poc_comments'] . "<br>"; // Add a line break after each comment
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
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <title>Your Title</title>
  <style>
    .styled-table th,
    .styled-table td {
      text-align: left;
    }
  </style>
</head>

<body>

  <div class="container-fluid">
    <div class="row">
      <!-- Left Column (CODER PREVIEW TABLE)-->
      <div class="col-12 col-lg-6">
        <div class="container mt-5 mb-5">
          <div class="card">
            <div class="card-header text-center">
              CODER PREVIEW
            </div>

            <!-- Personal Details Table -->
            <div class="table-responsive">
              <table class="styled-table fixed-header-width table">
                <thead style="color: whitesmoke; background: #4C4CAC;">
                  <tr>
                    <th>Patient_Name</th>
                    <th>MRN</th>
                    <th>Agency</th>
                    <th>Insurance Type</th>
                    <th>Date of Assessment</th>
                    <th>Assessment Type</th>
                    <th>Coder</th>
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
                    <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo "$coder" ?></td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Coding Details Table -->
            <div class="table-responsive">
              <h5> Coding Segement</h5>
              <table class="styled-table fixed-header-width table">
                <thead style="color: whitesmoke; background: #4C4CAC;">
                  <tr>
                    <th>MItems</th>
                    <th>ICD</th>
                    <th>Description</th>
                    <th>Effective_Date</th>
                    <th>E/O</th>
                    <th>Rating</th>
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

                      </tr>
                    <?php } ?>
                  </tbody>
                <?php } else { ?>
                  <tbody>
                    <tr>
                      <td colspan="4" style="border: 1px solid black; white-space: pre-wrap;">No data available</td>
                    </tr>
                  </tbody>
                <?php } ?>
              </table>
            </div>

            <!-- Coding Comments Table -->
            <div class="table-responsive">
              <table class="table mx-auto">
                <thead style="color: whitesmoke; background: #4C4CAC;">
                  <tr>
                    <th scope="col">Coding Commments </th>

                  </tr>
                </thead>
                <tbody>

                  <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $coding_comments; ?></td>

                </tbody>
              </table>
            </div>

            <!-- Oasis Details Table -->
            <div class="table-responsive">
              <h5> Oasis Segement</h5>
              <table class="styled-table fixed-header-width table">
                <thead style="color: whitesmoke; background: #4C4CAC;">
                  <tr>
                    <th>MItems</th>
                    <th>Agency Response</th>
                    <th>Coder Response</th>
                    <th>Coder Rationali</th>
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
                      </tr>
                    <?php } ?>
                  </tbody>


                <?php } else { ?>
                  <tbody>
                    <tr>
                      <td colspan="4" style="border: 1px solid black; white-space: pre-wrap;">No data available</td>
                    </tr>
                  </tbody>
                <?php } ?>
              </table>
            </div>

            <!-- Oasis Comments Table -->
            <div class="table-responsive">
              <table class="table mx-auto">
                <thead style="color: whitesmoke; background: #4C4CAC;">
                  <tr>
                    <th scope="col">Oasis Commments </th>

                  </tr>
                </thead>
                <tbody>

                  <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $oasis_comments; ?></td>

                </tbody>
              </table>
            </div>

            <!-- POC Details Table -->
            <div class="table-responsive">
              <h5> POC Segement</h5>
              <table class="styled-table fixed-header-width table">
                <thead style="color: whitesmoke; background: #4C4CAC;">
                  <tr>
                    <th>POC-ITEM</th>
                    <th>Coder Response</th>
                  </tr>
                </thead>
                <?php if (!empty($data2)) { ?>
                  <tbody>
                    <?php foreach ($data2 as $row) { ?>
                      <tr>
                        <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $row['Poc_item']; ?></td>
                        <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $row['Coder_response']; ?></td>
                      </tr>
                    <?php } ?>
                  </tbody>


                <?php } else { ?>
                  <tbody>
                    <tr>
                      <td colspan="4" style="border: 1px solid black; white-space: pre-wrap;">No data available</td>
                    </tr>
                  </tbody>
                <?php } ?>
              </table>
            </div>

            <!-- POC Comments Table -->
            <div class="table-responsive">
              <table class="table mx-auto">
                <thead style="color: whitesmoke; background: #4C4CAC;">
                  <tr>
                    <th scope="col">POC Commments </th>

                  </tr>
                </thead>
                <tbody>

                  <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $poc_comments; ?></td>

                </tbody>
              </table>
            </div>

            <!-- Other Tables ... -->
          </div>
        </div>
      </div>

      <!-- Right Column ( QC PREVIEW TABLE) -->
      <div class="col-12 col-lg-6">
        <div class="container mt-5 mb-5">
          <div class="card">
            <div class="card-header text-center">
              QC PREVIEW
            </div>
            <!-- QC Personal Details Table -->
            <div class="table-responsive">
              <table class="styled-table fixed-header-width table">
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

            <!-- QC Coding Details Table -->
            <div class="table-responsive">
              <h5>QC Codnig Segement</h5>
              <table class="styled-table fixed-header-width table">
                <thead style="color: whitesmoke; background: #4C4CAC;">
                  <tr>
                    <th>MItems</th>
                    <th>ICD</th>
                    <th>Description</th>
                    <th>Effective Date</th>
                    <th>E/O</th>
                    <th>Rating</th>
                    <th>Error Reason</th>
                    <th>Error Type</th>
                    <th>Qc Rationali</th>
                  </tr>
                </thead>

                <?php if (!empty($qc_data)) { ?>
                  <tbody>
                    <?php foreach ($qc_data  as $qc_row) { ?>
                      <tr>

                        <?php
                        $defaultMItem = [
                          "M1021A", "M1023B", "M1023C", "M1023D", "M1023E", "M1023F", "M1023G", "M1023H", "M1023I",  "M1023J",  "M1023K",  "M1023L",  "M1023M", "M1023N", "M1023O", "M1023P", "M1023Q", "M1023R", "M1023S", "M1023T", "M1023U", "M1023V", "M1023W", "M1023X", "M1023Y",
                        ];
                        ?>

                        <?php if (in_array($qc_row['MItems'], $defaultMItem)) { ?>

                          <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $qc_row['MItems']; ?></td>
                        <?php } else {  ?>
                          <td style="border: 1px solid black; white-space: pre-wrap;"></td>

                        <?php } ?>

                        <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $qc_row['Icd']; ?></td>
                        <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $qc_row['Description']; ?></td>
                        <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $qc_row['Effective_Date']; ?></td>
                        <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $qc_row['Eo']; ?></td>
                        <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $qc_row['Rating']; ?></td>
                        <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $qc_row['Reason']; ?></td>
                        <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $qc_row['Errortype']; ?></td>
                        <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $qc_row['Qcrationaile']; ?></td>

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
            </div>

            <!-- QC Coding Comments Table -->
            <div class="table-responsive">
              <table class="table mx-auto">
                <thead style="color: whitesmoke; background: #4C4CAC;">
                  <tr>
                    <th scope="col">QC Coding Commments </th>

                  </tr>
                </thead>
                <tbody>

                  <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $qc_coding_comments; ?></td>

                </tbody>
              </table>
            </div>

            <!--QC Oasis Details Table -->
            <div class="table-responsive">
              <h5>QC Oasis Segement</h5>
              <table class="styled-table fixed-header-width table">
                <thead style="color: whitesmoke; background: #4C4CAC;">
                  <tr>
                    <th>MItems</th>
                    <th>Agency Response</th>
                    <th>Coder Response</th>
                    <th>Coder Rationali</th>
                    <th>Error Reason</th>
                    <th>Error Type</th>
                    <th>Qc Rationali</th>
                  </tr>
                </thead>
                <?php if (!empty($qc_data1)) { ?>
                  <tbody>
                    <?php foreach ($qc_data1 as $qc_row) { ?>
                      <tr>
                        <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $qc_row['M_item']; ?></td>
                        <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $qc_row['Agency_response']; ?></td>
                        <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $qc_row['Coder_response']; ?></td>
                        <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $qc_row['Coder_rationali']; ?></td>
                        <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $qc_row['Error_reason']; ?></td>
                        <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $qc_row['Error_type']; ?></td>
                        <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $qc_row['Qc_rationali']; ?></td>
                      </tr>
                    <?php } ?>
                  </tbody>


                <?php } else { ?>
                  <tbody>
                    <tr>
                      <td colspan="7" style="border: 1px solid black; white-space: pre-wrap;">No data available</td>
                    </tr>
                  </tbody>
                <?php } ?>
              </table>
            </div>

            <!-- QC Oasis Comments Table -->
            <div class="table-responsive">
              <table class="table mx-auto">
                <thead style="color: whitesmoke; background: #4C4CAC;">
                  <tr>
                    <th scope="col">QC Oasis Commments </th>

                  </tr>
                </thead>
                <tbody>

                  <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $qc_oasis_comments; ?></td>

                </tbody>
              </table>
            </div>

            <!--QC POC Details Table -->
            <div class="table-responsive">
              <h5>QC POC Segement</h5>
              <table class="styled-table fixed-header-width table">
                <thead style="color: whitesmoke; background: #4C4CAC;">
                  <tr>
                    <th>POC-ITEM</th>
                    <th>Coder Response</th>
                    <th>Error Reason</th>
                    <th>Error Type</th>
                    <th>Qc Rationali</th>
                  </tr>
                </thead>
                <?php if (!empty($qc_data2)) { ?>
                  <tbody>
                    <?php foreach ($qc_data2 as $qc_row) { ?>
                      <tr>
                        <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $qc_row['Poc_item']; ?></td>
                        <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $qc_row['Coder_response']; ?></td>
                        <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $qc_row['Error_reason']; ?></td>
                        <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $qc_row['Error_type']; ?></td>
                        <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $qc_row['Qc_rationali']; ?></td>
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
            </div>

            <!-- QC POC Comments Table -->
            <div class="table-responsive">
              <table class="table mx-auto">
                <thead style="color: whitesmoke; background: #4C4CAC;">
                  <tr>
                    <th scope="col">Qc Poc Commments </th>

                  </tr>
                </thead>
                <tbody>

                  <td style="border: 1px solid black; white-space: pre-wrap;"><?php echo $qc_poc_comments ?></td>

                </tbody>
              </table>
            </div>

            <!-- Other Tables ... -->
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <?php
  include 'include_file/pulg.php';
  ?>
  <script src="QA/js/double_preview.js"></script>

</body>

</html>