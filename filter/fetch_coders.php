<?php







// THIS FILTER USED TO TEAM WISE REPORTING ADMIN MIS REPORTS USE







ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 include('../db/db-con.php');
try {
    // Establish database connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if team selection data is received
    if(isset($_POST['teamname']) && isset($_POST['team_id'])) {
        $teamname = $_POST['teamname'];
        $team_id = $_POST['team_id']; // Get the selected team

        // Prepare and execute SQL query to fetch coder information for the selected team
        $sth = $conn->prepare("SELECT Coders, coder_emp_id FROM coders WHERE Team=:teamname AND team_emp_id=:team_id");
        $sth->bindParam(':teamname', $teamname);
        $sth->bindParam(':team_id', $team_id);
        $sth->execute();
        $coders = $sth->fetchAll(PDO::FETCH_ASSOC);
        
        // Send the fetched coder information back to the client as JSON
        echo json_encode($coders);
        exit(); // Stop further execution
    }
} catch(PDOException $e) {
    // Handle database connection or query errors
    echo "Error: " . $e->getMessage();
}
?>

 
