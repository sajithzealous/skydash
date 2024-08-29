<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assesment Form Management</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- <link rel="stylesheet" href="code_des/css/code_desc.css"> -->
    <link rel="stylesheet" href="Adminpanel/css/usermanagement.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  
        <!-- Navbar -->
        <?php include 'include_file/profile.php'; ?>

      


                    <div class="container-fulid mt-5 p-5">
                           
                        <div class="card p-5">
                            <div class="row align-items-center">
                              <div class="col">
                                <h3 class="titledata"></h3>
                                <input type="text" class="form-control formid" hidden/>
                              </div>
                              <div class="col-auto d-flex align-items-center">
                                   <label class="form-label mt-2" style="font-size: 25px;">Time:</label>
                                   <input type="text" value="" class="timedata newtimedata" style="font-size: 25px; border: none; width: 120px;" readonly/>
                                   <button class="btn btn-primary me-2" style="width:100px;" id="submit">Submit</button>
                              </div>

                            </div>
                           <div class="mt-5">
                                <div id="formContainer" class="coderformdata"></div>

                            </div>
                        </div>
                    </div>
                
          
    <style>
        .form-group .labelook {

            font-size: 15px;
            font-weight: 500px;
            font-style: bold;
        }
    </style>
    <?php

    $randomNumber = rand(1000, 9999);
    ?>


    <!-- Modal Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
     <script src="Adminpanel/js/assessmentform.js?<?php echo $randomNumber ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        
                    window.addEventListener("beforeunload", function (event) {
                    // Customize the message in modern browsers
                    var message = "Are you sure you want to leave? Any unsaved changes may be lost.";

                    // Standard message in older browsers (note that most modern browsers don't show this message anymore)
                    event.returnValue = message;

                    // Return the message for older browsers
                    return message;
                });

    </script>
</body>

</html>