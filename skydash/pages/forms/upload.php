<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['formFile'])) {
        $file = $_FILES['formFile'];

        // Check if the file is a CSV file
        $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        if (strtolower($file_extension) !== 'csv') {
            echo "Error: Please upload a CSV file.";
            exit;
        }

        // Process and insert data from the CSV file
        if (($handle = fopen($file['tmp_name'], 'r')) !== false) {
            fgetcsv($handle);
            while (($data = fgetcsv($handle)) !== false) {
                // Assuming the CSV file has two columns: 'column1' and 'column2'
                $first_name = $conn->real_escape_string($data[1]);
                $last_name = $conn->real_escape_string($data[2]);
                $email = $conn->real_escape_string($data[3]);
                $age = $conn->real_escape_string($data[4]);

                // Insert data into the database
                $sql = "INSERT INTO `data` (`first_name`, `last_name`, `email`, `age`) VALUES ('$first_name', '$last_name', '$email', '$age')";

                if ($conn->query($sql) === TRUE) {
                    // Data inserted successfully
                } else {
                    // Error handling
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
            fclose($handle);
        }

        // Close the database connection
        $conn->close();

        echo "Data from CSV file inserted successfully.";
    } else {
        echo "No file uploaded.";
    }
} else {
    echo "Invalid request method.";
}
?>
