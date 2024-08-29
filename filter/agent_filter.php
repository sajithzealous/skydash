   <?php
   include 'include_file/link.php';
    include('../db/db-con.php');
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sth = $conn->prepare("SELECT `agency_name` FROM `Agent` WHERE `agency_status`='active'"); // Corrected column name
    $sth->execute();
    $Agent = $sth->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

echo '<div class="wrapper">';
echo '  <button class="form-control toggle-next ellipsis font-weight-bolder">Agents</button>';
echo '  <div class="checkboxes" id="status">';
echo '    <div class="inner-wrap">';
foreach ($Agent as $status) {
    echo '      <label>';
    echo '<div class="d-flex"><div class="form-check"> <label class="form-check-label"> <input type="checkbox" class="form-check-input"  value="' . $status['agency_name'] . '" name="Agent"></label> </div> <span class="mt-2">' . $status['agency_name'] . '</span> </div>'; // Corrected array key
    echo '      </label><br>';
}
echo '    </div>';
echo '  </div>';
echo '</div>';
?>
