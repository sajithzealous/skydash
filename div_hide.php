<?php
 include('db/db-con.php');

// Assuming $agency is set in the session
$agency = $_SESSION['agent'];

// Use prepared statement to prevent SQL injection
$sql = "SELECT * FROM codepage WHERE (`profile`='none' OR `code_segment`='none' OR `oasis_segment`='none') AND `agency` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $agency);
$stmt->execute();
$result = $stmt->get_result();

// Initialize display values
$displayProfiles = 'block';
$displayCodeSegment = 'block';
$displayOasisSegment = 'block';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Check the value from the database
        $profile = $row['profile'];
        $codeSegment = $row['code_segment'];
        $oasisSegment = $row['oasis_segment'];

        // Set display values based on the column values
        if ($profile == 'none') {
            $displayProfiles = 'none';
        }
        if ($codeSegment == 'none') {
            $displayCodeSegment = 'none';
        }
        if ($oasisSegment == 'none') {
            $displayOasisSegment = 'none';
        }
    }
}

// Output the styles
?>
<style>
    #profiles {
        display: <?php echo $displayProfiles; ?>;
    }

    #code_segment {
        display: <?php echo $displayCodeSegment; ?>;
    }

    #oasis_segment {
        display: <?php echo $displayOasisSegment; ?>;
    }
</style>

<?php
$stmt->close();
$conn->close();
?>
