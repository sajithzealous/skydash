<?php
include 'include_file/link.php';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Selecting active coders and their IDs
    $sth = $conn->prepare("SELECT `Coders`, `coder_emp_id` FROM `coders` WHERE `status`='active'");
    $sth->execute();
    $coders = $sth->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// HTML output
echo '<div class="coder-wrapper">';
echo '  <button class="form-control toggle-next ellipsis font-weight-bolder">Coders</button>';
echo '  <div class="checkboxes" id="status">';
echo '    <input type="text" class="form-control" id="searchInput" placeholder="Search..."/>';

echo '    <div class="inner-wrap">';
foreach ($coders as $coder) {
    echo '      <label class="coder-label">';
    echo '          <div class="form-check">';
    echo '              <input type="checkbox" class="form-check-input coder-checkbox" value="' . $coder['coder_emp_id'] . '" name="Coder">';
    echo '          </div>';
    echo '          <span>' . $coder['Coders'] . '(' . $coder['coder_emp_id'] . ')' . '</span>';
    echo '      </label>';
}
echo '    </div>';
echo '  </div>';
echo '</div>';
?>

<style>
    .coder-wrapper {
        width: 300px;
    }

    .coder-label {
        display: block;
        align-items: center;
        margin-left: 15px;
         justify-content: space-between;
   

    }

    .coder-checkbox {
        height: 20px;
        width: 20px;
        border: 3px solid #4c4cac;
    }

    span {
        padding: 5px;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById('searchInput');
        const checkboxes = document.querySelectorAll('.coder-checkbox');

        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.trim().toLowerCase();
            checkboxes.forEach(function(checkbox) {
                const coderName = checkbox.parentElement.nextElementSibling.textContent.trim().toLowerCase();
                const label = checkbox.closest('.coder-label');
                if (coderName.includes(searchTerm)) {
                    label.style.display = 'block';
                } else {
                    label.style.display = 'none';
                }
            });
        });
    });
</script>
