<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assesment Form </title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
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
            background: #90aee2;
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

        .scrollable {
            overflow: auto;
            max-height: 300px;
        }
        .optionremove{
          padding-bottom:8px;

          float: right;
          margin-top:-44px;
        }
    </style>
<body>
    <div class="container-scroller">
        <!-- Navbar -->
        <?php include 'include_file/profile.php'; ?>

        <div class="container-fluid page-body-wrapper">
            <!-- Sidebar -->
            <?php include 'include_file/sidebar.php'; ?>

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="conatiner m-5">

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12 custom-scroll">
                                <div class="container">
                                
                                        <a href="assessmentform.php"><button class="btn " style="color: white;background-color: #303195"  id="backbutton">Back</button></a>
                                        <button class="btn m-3" style="color: white;background-color: rgb(103, 58, 183);"  id="submitformdata">Submit</button>
                                             <button class="btn" style="color: white;  background-color: #0b5be680;margin-right: 5px;"  id="">Upload</button>
                                </div>
                                            
                                   
                                      
                                        <div class="container conatinersecond mt-5">
                                              <div class="first-header mb-2"></div>
                                      
                                            <input type="text" id="formtitle" class="form-control form-title mb-3" placeholder="Untitled form" required>
                                            <input type="date" id="formdate" class="form-control form-description mb-3" placeholder="Date" required>
                                            <input type="time" id="formtime" class="form-control form-description mb-3" placeholder="Time" required>
                                            <div id="questions-container" class="scrollable" break></div>
                                            <div class="toolbar">
                                                <button class="btn" onclick="addQuestion()"><i class="fa-solid fa-plus"></i></button>
                                            </div>
                                        </div>

                            </div>
                    
                    </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="Adminpanel/js/assessmentform.js?<?php echo $randomNumber ?> "></script>
</body>

</html>