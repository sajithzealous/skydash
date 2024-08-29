 <?php
    include 'include_file/link.php';

 include('../db/db-con.php');


    $query = "SELECT `Coders`,`coder_emp_id` FROM `coders` WHERE `all_view`='Yes'";
    // Execute the query
    $result = $conn->query($query);

    $data = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row; // Assuming 'Coders' is the column name
        }
    }
    
    // Return data as JSON
    header('Content-Type: application/json');
    echo json_encode($data);
    
    // Close the database connection
    $conn->close();
    ?>
    
    