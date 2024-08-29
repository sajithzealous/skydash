  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">   -->
  <?php include('db/db-con.php'); 



// Check if the 'Id' cookie is set
if (isset($_COOKIE['Id'])) {
    // Get the value of the 'Id' cookie
    $Id = $_COOKIE['Id'];
    
    // Now you can use $Id as needed in this file
    // echo "The value of Id is: " . $Id;
} else {
    // Handle the case where 'Id' cookie is not set
    echo "No Id cookie found";
}
?>
<!-- <style>
    .custom-checkbox-container {
        display: flex;
        flex-direction: column;
    }

   .ryi{

            overflow-x: auto;
            overflow-y: auto;
            max-height:700px;
    } 

    .custom-checkbox {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
        cursor: pointer;
    }

    .custom-checkbox input {
        display: none;
    }

    .custom-checkbox .checkbox-icon {
        width: 20px;
        height: 20px;
        border: 2px solid #2196F3;
        border-radius: 4px;
        margin-right: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .custom-checkbox input:checked + .checkbox-icon::after {
        content: '\2713';
        font-size: 14px;
        color: #2196F3;
    }

    .custom-checkbox-label {
        font-size: 16px;
    }


    .styled-button {
        background-color: #3498db;
        border: none;
        color: #ffffff;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
        padding: 10px 20px;
        border-radius: 25px;
        transition: background-color 0.3s;
    }

    .styled-button:hover {
        background-color: orange;
    }

 
    /* Common styles for all screen sizes */
    .custom-radio-list {
        padding-left: 20px;
        list-style-type: decimal;
    }

    .custom-radio {
        margin-top: 5px;
        display: flex;
        align-items: center;
    }

    .radio-icon {
        margin-right: 10px; /* Adjust as needed */
        width: 16px;
        height: 16px;
        border: 1px solid #333; /* Add styling for the radio icon */
    }

    .custom-radio-label {
        flex: 1; /* Take remaining space */
        white-space: pre-wrap;
        word-wrap: break-word;
        font-size: 13px;
    }

    /* Responsive styles */
    @media (max-width: 1200px) {
        .custom-radio-list {
            padding-left: 15px;
        }
    }

    @media (max-width: 992px) {
        .custom-radio-list {
            padding-left: 10px;
        }
    }

    @media (max-width: 768px) {
        .custom-radio-list {
            padding-left: 5px;
        }

        .radio-icon {
            margin-right: 5px;
        }
    }

    /* Add more media queries for smaller screens if needed */
 
</style> -->
 <div class="ryi" style="width:100%">   

  <div class="container-fluid">
   
    <div class="card p-4" style="background-color: white;">
         <h4 style="font-style:bold">PDGM Payment:</h4><br><br>


         <table class="table table-bordered b-3" >
            <center>

              <thead>

                <tr>

                <th>Finanical Summary</th>
                <th>PDGM Value</th>
                <th>PDGM First 30 Days</th>
                </tr>

            </thead>
            <tbody>

                <tr>
                    <td>Prior-Audit-Amount</td>
                    <td id="precodevaluemultiply"></td>
                    <td id="precodevalue"></td>
                 
                </tr>
                  <tr>
                    <td>Post-Audit-Amount</td>
                    <td id="postcodevaluemultiply"></td>
                    <td id="postcodevalue"></td>
                </tr>
                <tr>
                    <td>Additional Amount</td>
                    <td id="additionalvaluemultiply"></td>
                    <td id="additionvalue"></td>
                </tr>
                

            </tbody>
                

            </center>

             

         </table>

</div>
</div><input type="text" name="EntryId" id="entryId" value="<?php echo $Id ?>" class="form-control name_list input-lg" hidden/>

<br><br>
                    <div class="col-12 grid-margin stretch-card">

                        <div class="card">
                            <p class="my-2" style="color:#3fa93f;margin-left:90%;font-size:15px;  -webkit-text-stroke-width: medium; " hidden></p>
                            <div class="card-head csd"><br>

                                 <h4 class="card-title d-inline m-5"> HHRG </h4> 
                             </div>
                          


                                <div class="card-body">
                                    <div class="container-fluid" style="background: white;">
                                        <div class="form-group text-center codePart">
                                           <form id="ryiform">
    <div class="row g-2">
        <div class="col-md-3">
            <div class="form-floating">
                <label for="timingSelect">Timing</label>
                <select class="form-control" name="timing" id="timingSelect" >
                    <option value="">Select</option>
                    <option value="Early" ><strong>Early</option></strong>
                    <option value="Late"><strong>Late</option></strong>
                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-floating">
                <label for="admissionSourceSelect">Admission Source</label>
                <select class="form-control" name="admissionSource" id="admissionSourceSelect">
                    <option value="">Select</option>
                    <option value="Community">Community</option>
                    <option value="Institutional">Institutional</option>
                </select>
            </div>
        </div>

    <div class="col-md-3">
    <div class="form-floating">
        <label for="locationSelect">Location</label>
        <select class="form-control" name="location" id="location">
            <option value="">Select</option>

            <?php
            // Assuming you have a database connection established

            // Fetch active states from cpsc_code table
            $query = "SELECT `State` FROM `cpsc_code` WHERE `Status`='active'";
            $result = mysqli_query($conn, $query);

            // Check if query was successful
            if ($result) {
                // Generate options for the dropdown
                while ($row = mysqli_fetch_assoc($result)) {
                    $state = $row['State'];
                    echo "<option value='$state'>$state</option>";
                }

                // Free result set
                mysqli_free_result($result);
            } else {
                // Handle the case when the query fails
                echo "<option value=''>Error fetching data</option>";
            }

            // Close the database connection
            mysqli_close($conn);
            ?>
        </select>
    </div>
</div>


        <div class="col-md-3">
            <div class="form-floating">
                <label for="CBS">CBSA</label>
                <input type ="text"class="form-control" name="cpsc" id="cpsc" required>
                </input>
            </div>
        </div>
    </div>
    <br>



  
</form>
 </div>

 </div>

 </div>
 </div>
 </div>
</div>




         
 

