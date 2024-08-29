<?php
// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Including database connection
include ('../db/db-con.php');

// Checking request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST')
{
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit;
}

// Checking if 'Id' parameter is set
if (!isset($_POST['Id']))
{
    echo json_encode(['success' => false, 'error' => 'Id parameter is not set']);
    exit;
}

// Getting 'Id' parameter
$Id = $_POST['Id'];

// echo $Id;

// Checking if 'Id' parameter is not empty
if ($Id !== '')
{
    // Array to store agency and coder data
    $data = ['agency' => [], 'coder' => []];

    // Array to store agency comorbidity and clinical group data
    $datatwo = ['Comorbidity_group' => [], 'Clinical_group' => []];

    // Fetching agency data
    $agencyDataQuery = "SELECT `ICD-code` FROM `Codesegementqc` WHERE `Entry_Id` = '$Id' AND `Agencychecked` = 'Agency' AND `Agencyprimarycode` != 'Primary' AND `Error_type` !='Deleted' ";
    $agencyDataResult = $conn->query($agencyDataQuery);

    if ($agencyDataResult->num_rows > 0)
    {
        while ($row = $agencyDataResult->fetch_assoc())
        {
            $data['agency'][] = $row['ICD-code'];
        }
    }

    // Fetching coder data
    $coderDataQuery = "SELECT `ICD-code` FROM `Codesegementqc` WHERE `Entry_Id` = '$Id' AND `Coderchecked` = 'Coder' AND `M_Item` != 'M1021A' AND `Error_type` !='Deleted'";
    $coderDataResult = $conn->query($coderDataQuery);

    if ($coderDataResult->num_rows > 0)
    {
        while ($row = $coderDataResult->fetch_assoc())
        {
            $data['coder'][] = $row['ICD-code'];
        }
    }

    // Checking if agency data is found
    if (!empty($data['agency']))
    {
        $agencyicdcode = $data['agency'];

        $agencyicdcode = implode("','", $data['agency']);

        // echo $agencyicdcode;

        // Fetching agency comorbidity and clinical group data
        $selectagencyicdgroup = "SELECT `Comorbidity_group`,`Clinical_group` FROM `Codedescription` WHERE `ICD-10-code` IN ('$agencyicdcode')";
        $selectagencyicdgroupresult = $conn->query($selectagencyicdgroup);

        if ($selectagencyicdgroupresult->num_rows > 0)
        {
            while ($row = $selectagencyicdgroupresult->fetch_assoc())
            {
                $datatwo['Comorbidity_group'][] = $row['Comorbidity_group'];
                $datatwo['Clinical_group'][] = $row['Clinical_group'];
            }

            if (!empty($datatwo['Comorbidity_group']))
            {
                $agencyicdcomorbidity = $datatwo['Comorbidity_group'];


                // print_r($agencyicdcomorbidity);


                // Processing agency comorbidity data
                $flag = 0;
                // $res = [];
                $sqlselectagencydata = "SELECT `grp_1`,`grp_2`,`id` FROM `Comorbidity_grp_high` WHERE  `status` ='active' ORDER BY id ASC";
                $sqlselectagencydataresult = $conn->query($sqlselectagencydata);

                if ($sqlselectagencydataresult->num_rows > 0)
                {
                        
                    while ($rowdata = $sqlselectagencydataresult->fetch_assoc())
                    {
                         $grp_one_arry_value = $rowdata['grp_1'];
                         $grp_two_arry_value = $rowdata['grp_2'];

                        $sqlagencycomorbidity = in_array($grp_one_arry_value, $agencyicdcomorbidity);

                        if ($sqlagencycomorbidity == 1)
                        {
                            $check_value_in_array_final = in_array($grp_two_arry_value, $agencyicdcomorbidity);

                        

                            if ($check_value_in_array_final == 1)
                            {

                                $positionfourdata['agency'] = "3";

                                echo json_encode(['success' => true, 'data_agency' => $positionfourdata['agency']]);

                                $flag = 1;
                                break;
                            }
                        }
                        
                    }

                    if ($flag == 0)
                    {
                        // echo 'test';
                        // Handle when no high value found
                        $sqlagencydatatwo = "SELECT `grp_1`,`Id` FROM `Comorbidity_grp_low` WHERE `status`='active' ORDER BY id ASC ";
                        $sqlagencydatatworesult = $conn->query($sqlagencydatatwo);

                        if ($sqlagencydatatworesult->num_rows > 0)
                        {

                            while ($rowdata = $sqlagencydatatworesult->fetch_assoc())
                            {
                                $grp_one_arry_value = $rowdata['grp_1'];

                                $sqlagencycomorbiditytwo = in_array($grp_one_arry_value, $agencyicdcomorbidity);

                                // echo $sqlagencycomorbiditytwo;

                                if ($sqlagencycomorbiditytwo == 1)
                                {
                                    $positionfourdata['agency'] = "2";

                                    echo json_encode(['success' => true, 'data_agency' => $positionfourdata['agency']]);

                                    $flag = 1;
                                    break;

                                }

                            }

                            if($flag == 0){

                                 $positionfourdata['agency'] = "1";

                                    echo json_encode(['success' => true, 'data_agency' => $positionfourdata['agency']]);


                            }

                        }
                        else
                        {

                           
                        }
                    }
                }
            }
        }
    }
    else
    {
        echo json_encode(['success' => false, 'error' => 'No agency data found for the given criteria']);
    }

    // Checking if coder data is found
    if (!empty($data['coder']))
    {
        

        $codericdcode = $data['coder'];

        $codericdcode = implode("','", $data['coder']);

        // Fetching coder comorbidity and clinical group data
        $selectcodericdgroup = "SELECT `Comorbidity_group`,`Clinical_group` FROM `Codedescription` WHERE `ICD-10-code` IN ('$codericdcode')";
        $selectcodericdgroupresult = $conn->query($selectcodericdgroup);

        if ($selectcodericdgroupresult->num_rows > 0)
        {
            while ($row = $selectcodericdgroupresult->fetch_assoc())
            {
                $datatwo['Comorbidity_group'][] = $row['Comorbidity_group'];
                $datatwo['Clinical_group'][] = $row['Clinical_group'];
            }

            if (!empty($datatwo['Comorbidity_group']))
            {
                $codericdcomorbidity = $datatwo['Comorbidity_group'];



                 $flag = 0;
                // $res = [];
                $sqlselectagencydata = "SELECT `grp_1`,`grp_2`,`id` FROM `Comorbidity_grp_high` WHERE  `status` ='active' ORDER BY id ASC";
                $sqlselectagencydataresult = $conn->query($sqlselectagencydata);

                if ($sqlselectagencydataresult->num_rows > 0)
                {
                    while ($rowdata = $sqlselectagencydataresult->fetch_assoc())
                    {
                        $grp_one_arry_value = $rowdata['grp_1'];
                        $grp_two_arry_value = $rowdata['grp_2'];

                        $sqlagencycomorbidity = in_array($grp_one_arry_value, $codericdcomorbidity);

                        if ($sqlagencycomorbidity == 1)
                        {
                            $check_value_in_array_final = in_array($grp_two_arry_value, $codericdcomorbidity);

                            if ($check_value_in_array_final == 1)
                            {

                                $positionfourdata['coder'] = "3";

                                echo json_encode(['success' => true, 'data_coder' => $positionfourdata['coder']]);

                                $flag = 1;
                                break;
                            }
                        }
                    }

                    if ($flag == 0)
                    {
                        // Handle when no high value found
                        $sqlagencydatatwo = "SELECT `grp_1`,`Id` FROM `Comorbidity_grp_low` WHERE `status`='active' ORDER BY id ASC ";
                        $sqlagencydatatworesult = $conn->query($sqlagencydatatwo);

                        if ($sqlagencydatatworesult->num_rows > 0)
                        {

                            while ($rowdata = $sqlagencydatatworesult->fetch_assoc())
                            {
                                $grp_one_arry_value = $rowdata['grp_1'];


                                $sqlagencycomorbiditytwo = in_array($grp_one_arry_value, $codericdcomorbidity);

                             

                                if ($sqlagencycomorbiditytwo == 1)
                                {

                                    $positionfourdata['coder'] = "2";

                                    echo json_encode(['success' => true, 'data_coder' => $positionfourdata['coder']]);

                                    $flag = 1;
                                    break;

                                }

                            }

                            if($flag == 0){

                                $positionfourdata['coder'] = "1";

                                    echo json_encode(['success' => true, 'data_coder' => $positionfourdata['coder']]);


                            }

                        }
                        else
                        {

                            
                        }
                    }
                }
            }
        }
        else
        {
            echo json_encode(['success' => false, 'error' => 'No data found for the given criteria']);
        }
    }
    else
    {
        echo json_encode(['success' => false, 'error' => 'No coder data found for the given criteria']);
    }

}
else
{
    // 'Id' parameter is empty
    echo json_encode(['success' => false, 'error' => 'Id parameter is empty']);
}

// Closing the database connection
$conn->close();
?>
