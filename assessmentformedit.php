<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assesment Form Edit</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- <link rel="stylesheet" href="code_des/css/code_desc.css"> -->
    <link rel="stylesheet" href="Adminpanel/css/usermanagement.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #F5F7FF;
            justify-content: center;
            align-items: flex-start;
            height: 100vh;
            margin: 0;
            padding-top: 20px;
        }

        .first-header{
          content:"";
          background: rgb(103, 58, 183);
          padding:10px;
          border-radius: 0px 0px 10px 10px;

        }

        .container{
          background-color: white;
          justify-items: right;
          border-radius: 25px;
/*          float: right;*/
        }

        .conatinersecond {
            width: 800px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .form-header {
            background-color: #673ab7;
            height: 10px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .form-title {
            font-size: 24px;
            font-weight: bold;
            color: #202124;
            border: none;
            border-bottom: 1px solid #dcdcdc;
            padding: 10px;
            outline: none;
        }

        .form-description {
            font-size: 14px;
            color: #5f6368;
            border: none;
            border-bottom: 1px solid #dcdcdc;
            padding: 10px;
            outline: none;
        }

        .question-container {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            margin-bottom: 30px;
            padding: 45px;
            background: #dedede;
        }

        .question-container h5 {
            margin-bottom: 15px;
            font-size: 18px;
        }

        .form-control, .form-check-input {
            margin-bottom: 10px;
        }

        .multiple-choice-container,
        .dropdown-container {
            margin-top: 10px;
        }

        .add-question-btn {
            background-color: #1a73e8;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        .add-question-btn:hover {
            background-color: #1558b0;
        }

        .toolbar {
            margin-top: 20px;
        }

        .toolbar button {
            border: none;
            background-color: rgb(103, 58, 183);
            color: white;
                 }

        .toolbar button:hover {
            background-color: #a683e5;
            color: white;
       
        }

        .deletebutton {
            background-color: #e18080;
           float: right;
           marign:25px;
        }

        .optionremove{
          padding-bottom:8px;

          float: right;
          margin-top:-44px;
        }

        label{

            font-size:  25px;
        }
    </style>

<body>
  
        <!-- Navbar -->
        <?php include 'include_file/profile.php'; ?>

      


                    <div class="container-fulid mt-5 p-5">

                           
                        <div class="card p-5 formContaineredits"> 
                            <div >
                                 <a href="assessmentform.php"><button class="btn
                        btn-warning ml-2" style="width:100px;float:right"
                        id="">Back</button></a> 
                            <button class="btn
                        btn-primary" style="width:100px;float:right"
                        id="editsubmit">Submit</button> 
                            </div>
                           
                        <div
                        class="row align-items-center mt-4"> <div class="col"> <h3
                        class="edittitledata" contenteditable="true"></h3>
                        <input type="text" class="form-control formid"
                        hidden/> </div> <div class="col-auto d-flex
                        align-items-center"> <label class="form-label"
                        style="font-size: 25px;">Time:</label> <p
                        class="timedata newtimedata" contenteditable="true"
                        style="font-size: 25px;"></p> </div>

                            </div>
                           <div class="mt-5">
                                <div id="formContaineredit" class="coderformdata"></div>
                                <div id="questions-container" class="scrollable" break></div>
                                   <div class="toolbar">
                                    <button class="btn" onclick="addQuestion()"><i class="fa-solid fa-plus"></i></button>
                                   </div>

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
<!--     <script>
        
                    window.addEventListener("beforeunload", function (event) {
                    // Customize the message in modern browsers
                    var message = "Are you sure you want to leave? Any unsaved changes may be lost.";

                    // Standard message in older browsers (note that most modern browsers don't show this message anymore)
                    event.returnValue = message;

                    // Return the message for older browsers
                    return message;
                });

    </script> -->
</body>

</html>