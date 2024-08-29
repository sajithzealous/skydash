
<?php
include('db/db-con.php');

// Declare the current date in a variable


// Perform the SQL query to select approved files data for today and group by coder and team
$query = "SELECT `alloted_team`, `alloted_to_coder`, `coder_emp_id`, COUNT(`status`) AS total_count 
          FROM `Main_Data` 
          WHERE `status` ='APPROVED'
          GROUP BY `alloted_team`, `alloted_to_coder`, `coder_emp_id`
          ORDER BY total_count DESC";

// Execute the query and check for errors
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<div class="col-md-12 stretch-card grid-margin">
    <div class="card">
        <div class="card-body" style="">
            <div class="card-title " style="text-align: center;margin-top: 20px;">Approved Count Status</div>
            <div class="table-responsive" style="max-height: 500px;overflow-y: auto;">
                <table class="table table-border table-striped" >
                    <thead>
                        <tr>
                            <th class="pl-0 pb-2 border-bottom">Alloted Team</th>
                            <th class="border-bottom pb-2">Coder</th>
                            <th class="border-bottom pb-2">Coder ID</th>
                            <th class="border-bottom pb-2">Total Approved</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Loop through each row in the result set
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td class="pl-0"><?php echo $row['alloted_team']; ?></td>
                            <td><?php echo $row['alloted_to_coder']; ?></td>
                            <td><?php echo $row['coder_emp_id']; ?></td>
                            <td><?php echo $row['total_count']; ?></td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


