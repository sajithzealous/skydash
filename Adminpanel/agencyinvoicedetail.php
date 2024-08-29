<?php
// Enable error reporting for debugging purposes
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection file
include('../db/db-con.php');

// Check if the action is insertdata
if (isset($_GET['action']) && $_GET['action'] == 'insertdata') {
    // Check if JSON data is received
    if (isset($_POST['jsonData'])) {
        // Retrieve the JSON data sent via POST
        $jsonData = $_POST['jsonData'];
        $clientid = $_POST['Clientuid'];

        // Check if data already exists based on agency ID
        $query_check = "SELECT * FROM `agencydetail` WHERE `agency_id` = '$clientid'";
        $result_check = $conn->query($query_check);

        if ($result_check) {
            // Use mysqli_num_rows() to check the number of rows returned
            if ($result_check->num_rows > 0) {
                // Data exists, update it
                $query = "UPDATE `agencydetail` SET `agency_detail` = '$jsonData', `status` = 'active' WHERE `agency_id` = '$clientid'";
            } else {
                // Data doesn't exist, insert it
                $query = "INSERT INTO `agencydetail`(`agency_id`, `agency_detail`, `status`) VALUES ('$clientid', '$jsonData', 'active')";
            }

            try {
                // Execute the query
                if ($conn->query($query)) {
                    $response = ['success' => true, 'message' => 'Data inserted/updated successfully.'];
                    echo json_encode($response);
                } else {
                    $response = ['error' => true, 'message' => 'Error inserting/updating data'];
                    echo json_encode($response);
                }
            } catch (PDOException $e) {
                // Handle database errors
                echo "Error: " . $e->getMessage();
            }
        } else {
            // Handle query execution error
            echo "Error executing the query: " . $conn->error;
        }
    } else {
        echo "Error: No JSON data received.";
    }
}
// Check if the action is showdata
if (isset($_GET['action']) && $_GET['action'] == 'showdata') {
    try {
        // Select all active status data from the agencydetail table
        $query = "SELECT * FROM `agencydetail` WHERE `status` = 'active'";
        $result = $conn->query($query);

        if ($result) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode($data);
        } else {
            echo json_encode(['error' => true, 'message' => 'Error retrieving data']);
        }
    } catch (PDOException $e) {
        // Handle database errors
        echo json_encode(['error' => true, 'message' => 'Database error: ' . $e->getMessage()]);
    }
}
if(isset($_GET['action']) && $_GET['action'] == 'generateInvoice')
{
    $dateTime = date('Y-m-d H:i:s');
    $invoice_no = $_POST['invoice_no'];
    $invoice_date = $_POST['invoice_date'];
    $agancy_id = $_POST['agancy_id'];
    $products = $_POST['products'];
    $payment_plan = $_POST['payment_plan'];
    $qty = $_POST['qty'];
    $amount = $_POST['amount'];
    $row_total_amount = $_POST['final_amount'];

    $total_amount = 0;
    $data = []; 
    foreach ($products as $key => $product) {
        // Create a new array for each iteration and assign values to keys
        $data[] = [
            'product' => $product,
            'payment_plan' => $payment_plan[$key],
            'qty' => $qty[$key],
            'amount' => $amount[$key],
            'row_total_amount' => $row_total_amount[$key]
        ];
    
        // Calculate total amount by adding row_total_amount for each iteration
        $total_amount += $row_total_amount[$key];
    }
    
    $productData = json_encode($data);

    mysqli_query($conn, "INSERT INTO `invoice_data`(`agent_id`, `invoice_no`, `invoice_date`, `product_data`, `status`, `created_by`, `update_time`, `timestamp`, `total_amount`, `tax_amount`, `final_amount`) VALUES ('$agancy_id','$invoice_no','$invoice_date','$productData','Active','1','$dateTime','$dateTime', '$total_amount', '0', '$total_amount')");
    $inserted_id = mysqli_insert_id($conn);

    $res['status'] = 'Ok';
    $res['invoice'] = $inserted_id;
    // print_r($products);

    echo json_encode($res);
}
?>
