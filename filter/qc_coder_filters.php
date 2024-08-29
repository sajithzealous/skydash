<?php
include 'include_file/link.php';
 include('../db/db-con.php');
session_start();
$user = $_SESSION['username'];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sth = $conn->prepare("SELECT `Coders`,`coder_emp_id` FROM `coders` WHERE `category` = 'qc_coder'");
    $sth->bindParam(':user', $user); // Binding parameter to avoid SQL injection
    $sth->execute();
    $coders = $sth->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

echo '<div class="wrapper">';
echo '  <button class="form-control toggle-next ellipsis font-weight-bolder">Coders</button>';
echo '  <div class="checkboxes" id="status">';
echo '    <div class="inner-wrap">';
foreach ($coders as $coder) {
    echo '      <label>';
    echo '        <div class="d-flex">';
    echo '          <div class="form-check">';
    echo '            <label class="form-check-label">';
    echo '              <input type="checkbox" class="form-check-input " value="' . $coder['coder_emp_id'] . '" name="Coder">';
    echo '            </label>';
    echo '          </div>';
    echo '          <span class="mt-2">' .$coder['Coders'].'&nbsp'.'('.$coder['coder_emp_id'].')'. '</span>';
    echo '        </div>';
    echo '      </label><br>';
}
echo '    </div>';
echo '  </div>';
echo '</div>';
?>
