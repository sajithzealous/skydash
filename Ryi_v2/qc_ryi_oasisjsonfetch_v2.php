<?php

session_start(); // Added missing semicolon

include('../db/db-con.php');

$Id = $_POST['Id'];

$data = array(); // Initialize an empty array to store the data

if ($Id) {
    // Define an array of M items
    $mItems = array(
        "M1033 - Risk for Hospitalization",
        "M1800 - Grooming",
        "M1810 - Ability to Dress Upper Body",
        "M1820 - Ability to Dress Lower Body",
        "M1830 - Bathing",
        "M1840 - Toilet transferring",
        "M1850 - Transferring",
        "M1860 - Ambulation/Locomotion"
    );

    // Loop through each M item
    foreach ($mItems as $mItem) {
        // Prepare SQL query for the current M item
        $sqlselectdata = "SELECT * FROM `oasisqc` WHERE `M_item`='$mItem' AND `Entry_id`='$Id'";
        
        // Execute the query
        $result = mysqli_query($conn, $sqlselectdata);
        
        // Check if query executed successfully
        if ($result) {
            // Fetch data from the result set
            while ($row = mysqli_fetch_assoc($result)) {
                // Store Agency response and Coder response
                $agencyResponse = $row['Agency_response'];
                  $coderResponse = $row['Qc_response'];

                // Initialize arrays to store Agency and Coder responses
                $agencyResponses = array();
                $coderResponses = array();

                // If the current M item is "M1033 - Risk for Hospitalization"
                if ($mItem === "M1033 - Risk for Hospitalization") {
                    // Split Agency response by commas and add to array
                    $agencyParts = explode(',', $agencyResponse);
                    $agencyResponses = array_merge($agencyResponses, array_map('trim', $agencyParts));

                    // Split Coder response by commas and add to array
                    $coderParts = explode(',', $coderResponse);
                    $coderResponses = array_merge($coderResponses, array_map('trim', $coderParts));
                } else {
                    // If the current M item is not "M1033 - Risk for Hospitalization",
                    // directly add Agency and Coder responses to their respective arrays
                    $agencyResponses[] = $agencyResponse;
                    $coderResponses[] = $coderResponse;
                }

                // Query to fetch mitem_values from Pdgmoasis table for Agency response
                $sqlselectvalueofdataAgency = "SELECT `mitem_values` FROM `Pdgmoasis` WHERE `mitem_name`='$mItem' AND `mitem_options` IN ('" . implode("','", $agencyResponses) . "') AND `status`='active'";
                
                // Execute the query for Agency response
                $resultAgency = mysqli_query($conn, $sqlselectvalueofdataAgency);

                // Fetch mitem_values for Agency response
                $agencyValues = array();
                while ($rowAgency = mysqli_fetch_assoc($resultAgency)) {
                    $agencyValues[] = $rowAgency['mitem_values'];
                }

                // Query to fetch mitem_values from Pdgmoasis table for Coder response
                $sqlselectvalueofdataCoder = "SELECT `mitem_values` FROM `Pdgmoasis` WHERE `mitem_name`='$mItem' AND `mitem_options` IN ('" . implode("','", $coderResponses) . "') AND `status`='active'";
                
                // Execute the query for Coder response
                $resultCoder = mysqli_query($conn, $sqlselectvalueofdataCoder);

                // Fetch mitem_values for Coder response
                $coderValues = array();
                while ($rowCoder = mysqli_fetch_assoc($resultCoder)) {
                    $coderValues[] = $rowCoder['mitem_values'];
                }

                // Store data in response array
                $data[$mItem] = array(
                    'Agency_response' => $agencyValues,
                    'Coder_response' => $coderValues
                );


                // echo $agencyValues;
                // echo $coderValues;




                // Calculate the sum of values for Agency and Coder responses
                $sumAgency = array_sum($agencyValues);
                $sumCoder = array_sum($coderValues);

                // Store the sums in the response array
                $data[$mItem]['Sum_Agency'] = $sumAgency;
                $data[$mItem]['Sum_Coder'] = $sumCoder;
            }

            // Free the result sets
            mysqli_free_result($result);
            mysqli_free_result($resultAgency);
            mysqli_free_result($resultCoder);
        } else {
            // Handle query execution error
            echo "Error fetching oasis data: " . mysqli_error($conn);
        }
    }
    // Close database connection
    mysqli_close($conn);

    // Send the data as JSON response
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    echo "No ID provided.";
}
?>
