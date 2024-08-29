<?php

include 'include_file/link.php';
 include('../db/db-con.php');

   try {
     $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

         $sth = $conn->prepare("SELECT `team_name`,`team_emp_id` FROM `team` WHERE `coder_status`='active'"); // Corrected column name
       $sth->execute();
               $team = $sth->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
              echo "Error: " . $e->getMessage();
           }


       echo '<div class="wrapper">';
       echo '  <button class="form-control toggle-next ellipsis font-weight-bolder">Team</button>';
       echo '  <div class="checkboxes" id="status">';
       echo '    <div class="inner-wrap">';
       foreach ($team as $status) {
           echo '      <label>';
           echo '<div class="d-flex"><div class="form-check"> <label class="form-check-label"> <input type="checkbox" class="form-check-input myCheckboxTeam"  value="' . $status['team_emp_id'] . '" name="Team"></label> </div> <span class="mt-2">' . $status['team_name'] .'('.$status['team_emp_id'].')'. '</span> </div>'; // Corrected array key
           echo '      </label><br>';
       }
       echo '    </div>';
       echo '  </div>';
       echo '</div>';
       ?>

