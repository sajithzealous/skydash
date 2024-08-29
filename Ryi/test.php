<?php
include('../db/db-con.php');

$main_arry = ['Behavioral_2', 'Circulatory_1', 'Cerebral_4', 'Cerebral_4', 'Skin_4', 'Circulatory_2', 'Neurological_7'];
$flag = 0;
$res = [];
$sql = mysqli_query($conn, "SELECT `grp_1`,`grp_2`,`id`  FROM `Comorbidity_grp_high` ORDER BY id ASC");
while($get_grps = mysqli_fetch_assoc($sql))
{
    $grp_one_arry_value = $get_grps['grp_1'];
    $grp_two_arry_value = $get_grps['grp_2'];
    $check_value_in_array = in_array($grp_one_arry_value, $main_arry);

    if($check_value_in_array == 1)
    {

        $check_value_in_array_final = in_array($grp_two_arry_value, $main_arry);

        if($check_value_in_array_final == 1)
        {
            $res['status'] = 'Found, This is High Value';
            $res['id'] = $get_grps['id'];
            $flag = 1;
            break;
        }
    }
}
echo json_encode($res);
?>