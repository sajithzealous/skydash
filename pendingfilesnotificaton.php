<?php
include('db/db-con.php');

// Perform the SQL query to select pending files data
$query = "SELECT `alloted_to_coder`, `coder_emp_id`, `mrn`, `pending_comments`, `pending_date`, `pending_reason` FROM `Main_Data` WHERE `status` ='PENDING'";
$result = mysqli_query($conn, $query);

// Fetch the count of pending files
$query_count = "SELECT COUNT(`status`) as total_count FROM `Main_Data` WHERE `status` ='PENDING'";
$count_result = mysqli_query($conn, $query_count);
$count_row = mysqli_fetch_assoc($count_result);
$total_count = $count_row['total_count'];
?>

<div class="col-md-4 stretch-card grid-margin">
    <div class="card">
        <div class="card-body" style="max-height: 500px; overflow-y: auto;">
            <h4 class="card-title">Pending Files (Total: <?php echo $total_count; ?>)</h4>
            <ul class="icon-data-list">
                <?php
                // Loop through each row in the result set
                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <li style="margin-bottom: 20px;">
                    <div class="d-flex">
                        <div>
                            <h5 class="text-info mb-1">MRN: <?php echo $row['mrn']; ?></h5>
                            <h6 class="mb-1">Coder: <?php echo $row['alloted_to_coder']; ?></h6>
                            <h6>Pending Comments:</h6>
                            <p class="mb-0" style="word-wrap: break-word;"><?php echo $row['pending_comments']; ?></p>
                            <small><strong>Date: <?php echo $row['pending_date']; ?></strong></small>
                        </div>
                    </div>
                </li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>
</div>
