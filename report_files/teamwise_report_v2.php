    <?php

// Include database connection
include('../db/db-con.php');

// Error reporting setup
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialize data array
$data = array();
$action = $_GET['action'];


if ($action == 'coder_with_status_feedback') {

        $fromdate = $_GET['fromdate'];
        $todate = $_GET['todate'];
        $teamname = $_GET['teamname'];
        $team_id = $_GET['team_id'];
        $codername = $_GET['codername'];
        $coderid = $_GET['coderid'];
        $status = $_GET['status'];
        $Segment = $_GET['Segment'];
        $Agency=$_GET['Agency'];


        // echo $coderid;

        $teamQuery = '';
        if($teamname != "")
        {
            $teamQuery = "AND md.alloted_team = '$teamname'";
        }
       

        $teamIdQuery = '';
        if($team_id != "")
        {
            $teamIdQuery = "AND md.team_emp_id = '$team_id'";
        }
       

        $agencyQuery = '';
        if($Agency != "")
        {
            $agencyQuery = "AND md.agency = '$Agency'";
        }


        $coderIdQuery = '';
        if($coderid != "")
        {
            $coderIdQuery = "AND md.coder_emp_id = '$coderid'";
        }
       

        $statusQuery = '';
        if($status == "")
        {
            $statusQuery = "AND cd.Error_type NOT IN ('None', '')";
        }
        else
        {
            $statusQuery = "AND cd.Error_type = '$status'";
        }


        if($Segment == 'All')
        {
            $segments = ['Codesegementqc', 'oasisqc', 'Pocsegementqc'];
        }
        else
        {
            $segments = [$Segment];
        }

        foreach($segments as $segdb)
        {
             if($segdb == "Pocsegementqc")
            {
                 $Mitem_All = 'Poc_item';
            }
            else
            {
                 $Mitem_All = 'M_item';
            }

            if($segdb == "Codesegementqc"){


                $codesegementselect=",ccd.`ICD-code` AS codericdcode";
                $codesegementdb=",Codesegement ccd";
                $codesegementdata="AND cd.Entry_Id = ccd.Entry_Id AND cd.M_item = ccd.`M-Items`";


            }
            else{
                $codesegementselect="";
                 $codesegementdb="";
                 $codesegementdata="";


            }
                $sql1 = mysqli_query($conn, "SELECT md.status AS Filestatusdata,md.coder_emp_id AS coderempidmain $codesegementselect,md.*,cd.* FROM Main_Data md, $segdb cd $codesegementdb WHERE cd.timestamp BETWEEN '$fromdate 00:00:00' AND '$todate 23:59:59' AND md.id = cd.Entry_id AND md.status IN('APPROVED','QC COMPLETED') $coderIdQuery $teamIdQuery $agencyQuery $statusQuery $codesegementdata ORDER BY cd.Entry_id ASC");
                while($getOne = mysqli_fetch_assoc($sql1))
                {
                    $data[$segdb][] = $getOne;
                }
        }

}







else if ($action == 'production_report') {
    // Ensure variables are initialized
    $fromdate1 = isset($_GET['fromdate1']) ? $_GET['fromdate1'] : '';
    $todate1 = isset($_GET['todate1']) ? $_GET['todate1'] : '';
    $fromdate = isset($_GET['fromdate']) ? $_GET['fromdate'] : '';
    $todate = isset($_GET['todate']) ? $_GET['todate'] : '';
    $teamname = isset($_GET['teamname']) ? $_GET['teamname'] : '';
    $team_id = isset($_GET['team_id']) ? $_GET['team_id'] : '';
    $codername = isset($_GET['codername']) ? $_GET['codername'] : '';
    $coderid = isset($_GET['coderid']) ? $_GET['coderid'] : '';
    $mrn = isset($_GET['mrn']) ? $_GET['mrn'] : '';
    $status = isset($_GET['status']) ? $_GET['status'] : '';
    $p_name = isset($_GET['p_name']) ? $_GET['p_name'] : '';
    $Agency = isset($_GET['agencies']) && is_array($_GET['agencies']) ? $_GET['agencies'] : []; // Ensure $Agency is an array

    // Initialize $agencyQuery
    $agencyQuery = '';

    // If $Agency is an array, sanitize each value
    if (!empty($Agency)) {
        // Assuming $conn is your database connection object
        $sanitizedAgencies = array_map(function($value) use ($conn) {
            return mysqli_real_escape_string($conn, $value);
        }, $Agency);

        // Implode sanitized values into a comma-separated string for SQL query
        $agencyQuery = "AND agency IN ('" . implode("','", $sanitizedAgencies) . "')";
    }

    // Handle timezone conversion
    $indiaTimeZone = new DateTimeZone('Asia/Kolkata');
    $nyTimeZone = new DateTimeZone('America/New_York');

    // Convert fromdate from Indian time to New York time
    $fromDateTime = new DateTime($fromdate . ' 00:00:00', $indiaTimeZone);
    $fromDateTime->setTimezone($nyTimeZone);
    $fromdateConverted = $fromDateTime->format('Y-m-d H:i:s');

    // Convert todate from Indian time to New York time
    $toDateTime = new DateTime($todate . ' 23:59:59', $indiaTimeZone);
    $toDateTime->setTimezone($nyTimeZone);
    $todateConverted = $toDateTime->format('Y-m-d H:i:s');

    // Initialize other query parts
    $teamQuery = !empty($teamname) ? "AND alloted_team = '$teamname'" : '';
    $teamIdQuery = !empty($team_id) ? "AND team_emp_id = '$team_id'" : '';
    $coderIdQuery = !empty($coderid) ? "AND coder_emp_id = '$coderid'" : '';
    $statusQuery = !empty($status) ? "AND status = '$status'" : '';
    $mrnQuery = !empty($mrn) ? "AND mrn = '$mrn'" : '';

    // Example of how to handle optional variable like phonenumber
    $phonenumber = isset($_GET['phonenumber']) ? $_GET['phonenumber'] : '';

    $phonenumberQuery = '';
    if (!empty($phonenumber)) {
        $phonenumberQuery = "AND phone_number = '$phonenumber'";
    }

    // Build the SQL query based on conditions
    if (empty($fromdate1) && empty($todate1)) {
        $sql = "SELECT `Id`, `patient_name`, `mrn`, `insurance_type`, `assesment_date`, `assesment_type`, 
                `pending_comments`, `pending_reason`, `pending_date`, `agency`, `status`, `alloted_team`, 
                `alloted_to_coder`, `coder_emp_id`, `AssignCoder_date`, `total_working_hours`, `totalcasemix`, 
                `totalcasemixagency`, `qc_date`, `qc_completed_date`, `file_completed_date`
                FROM Main_Data
                WHERE `AssignCoder_date` >= '$fromdateConverted' 
                AND `AssignCoder_date` <= '$todateConverted' 
                $teamQuery 
                $teamIdQuery 
                $agencyQuery 
                $coderIdQuery 
                $statusQuery 
                $mrnQuery 
                $phonenumberQuery";

    } else {
        $sql = "SELECT `Id`, `patient_name`, `mrn`, `insurance_type`, `assesment_date`, `assesment_type`, 
                `pending_comments`, `pending_reason`, `pending_date`, `agency`, `status`, `alloted_team`, 
                `alloted_to_coder`, `coder_emp_id`, `AssignCoder_date`, `total_working_hours`, `totalcasemix`, 
                `totalcasemixagency`, `qc_date`, `qc_completed_date`, `file_completed_date`
                FROM Main_Data
                WHERE `File_Status_Time` >= '$fromdate1 00:00:00' 
                AND `File_Status_Time` <= '$todate1 23:59:59' 
                $teamQuery 
                $teamIdQuery 
                $agencyQuery 
                $coderIdQuery 
                $statusQuery 
                $mrnQuery 
                $phonenumberQuery";
    }

    // Execute the SQL query
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        // Handle query error
        $error = mysqli_error($conn);
        echo json_encode(['error' => 'Query execution error: ' . $error]);
        exit;
    }

    // Fetch data from the result set
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

   

} 

 // header('Content-Type: application/json');
echo json_encode($data);

// Close the database connection
$conn->close();

?>
