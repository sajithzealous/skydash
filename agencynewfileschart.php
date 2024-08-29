<?php

     include('db/db-con.php');
// Perform the SQL query to count new files per agency
$query = "SELECT Count(`agency`) as count, `agency` FROM `Main_Data` WHERE `status`='NEW'GROUP BY `agency` ";
$result = mysqli_query($conn, $query);

// Prepare the data for the chart
$dataPoints = array();
while ($row = mysqli_fetch_assoc($result)) {
    $dataPoints[] = array("label" => $row['agency'], "y" => $row['count']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
</head>
<body>

      <style>
      
        /* Style for the chart */
        #myPlot {
            width: 100%;
            max-width: 400px; /* Adjust the max-width as needed */
        }
        .modebar {
            display: none;
        }
    </style>
<div class="ageof">
<div id="myPlot" style="width:100%;max-width:700px"></div>
</div>

<script>
    // PHP data from the server
    const dataPoints = <?php echo json_encode($dataPoints); ?>;

    // Extracting labels and values from PHP data
    const xArray = dataPoints.map(dataPoint => dataPoint.label);
    const yArray = dataPoints.map(dataPoint => dataPoint.y);

    const layout = {title:""};

    const data = [{labels:xArray, values:yArray, hole:.4, type:"pie"}];

    Plotly.newPlot("myPlot", data, layout);
</script>

</body>
</html>
