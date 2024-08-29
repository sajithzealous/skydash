<?php
// Start the session


session_start(); // Start the session

include 'include_file/link.php';


$role = isset($_SESSION['role']) ? $_SESSION['role'] : null;


$user = isset($_SESSION['username']) ? $_SESSION['username'] : null;
$password = isset($_SESSION['password']) ? $_SESSION['password'] : null;
$emp_id = isset($_SESSION['empid']) ? $_SESSION['empid'] : null;

if (!isset($emp_id)) {
    // Redirect to session_des.php or login.php if $emp_id is not set
    header("Location: session_des.php");
    header("Location: login.php");
    exit; // Stop executing further code
}

include  'include_file/link.php';
// include('../db/db-con.php');


// Database connection details
$servername = "localhost";
$username = "zhcadmin";
$password = "d0m!n$24";
$dbname = "HCLI";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize counts
$countQcCompleted = 0;
$countNew = 0;


if ($role == 'user') {


    // Query for QC COMPLETED count
    $sqlQcCompleted = "SELECT COUNT(*) as QcCompletedCount FROM `Main_Data` WHERE `status` = 'QC COMPLETED' AND `alloted_to_coder`='$user' AND `coder_emp_id`='$emp_id'";
    $runqueryQcCompleted = mysqli_query($conn, $sqlQcCompleted);

    if ($runqueryQcCompleted) {
        $resultQcCompleted = mysqli_fetch_assoc($runqueryQcCompleted);
        $countQcCompleted = $resultQcCompleted['QcCompletedCount'];
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Query for New count
    $sqlNew = "SELECT COUNT(*) as NewCount FROM `Main_Data` WHERE `status` IN ('ASSIGNED TO CODER', 'REASSIGNED TO CODER') AND alloted_to_coder='$user'AND `coder_emp_id`='$emp_id'";
    $runqueryNew = mysqli_query($conn, $sqlNew);

    if ($runqueryNew) {
        $resultNew = mysqli_fetch_assoc($runqueryNew);
        $countNew = $resultNew['NewCount'];
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Query for New count
    $sqlNew = "SELECT COUNT(*) as PendingCount FROM `Main_Data` WHERE `status` IN ('PENDING') AND alloted_to_coder='$user' AND `coder_emp_id`='$emp_id'";
    $runqueryNew = mysqli_query($conn, $sqlNew);

    if ($runqueryNew) {
        $resultNew = mysqli_fetch_assoc($runqueryNew);
        $PendingCount = $resultNew['PendingCount'];
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    // Calculating the total count
    $totalCount = $countQcCompleted + $countNew;
    // Use $countQcCompleted and $countNew as needed in your HTML or further logic
} else if ($role == 'TeamLeader') {

    $sqlQcCompleted = "SELECT COUNT(*) as QcCompletedCount FROM `Main_Data` WHERE `status` = 'QC COMPLETED' AND `alloted_team`='$user' AND `team_emp_id`='$emp_id'";
    $runqueryQcCompleted = mysqli_query($conn, $sqlQcCompleted);

    if ($runqueryQcCompleted) {
        $resultQcCompleted = mysqli_fetch_assoc($runqueryQcCompleted);
        echo  $countQcCompletedTeam = $resultQcCompleted['QcCompletedCount'];
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Query for qc completed count
    $sqlNew = "SELECT COUNT(*) as NewCount FROM `Main_Data` WHERE `status` IN ('ASSIGNED TO TEAM', 'REASSIGNED TO TEAM') AND alloted_team='$user'AND `team_emp_id`='$emp_id'";
    $runqueryNew = mysqli_query($conn, $sqlNew);

    if ($runqueryNew) {
        $resultNew = mysqli_fetch_assoc($runqueryNew);
        $countNewTeam = $resultNew['NewCount'];
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Query for Pending count
    $sqlNew = "SELECT COUNT(*) as PendingCount FROM `Main_Data` WHERE `status` IN ('PENDING') AND alloted_team='$user' AND `team_emp_id`='$emp_id'";
    $runqueryNew = mysqli_query($conn, $sqlNew);

    if ($runqueryNew) {
        $resultNew = mysqli_fetch_assoc($runqueryNew);
        $PendingCountTeam = $resultNew['PendingCount'];
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    // Calculating the total count
    $totalCount = $countQcCompleted + $countNew;
    // Use $countQcCompleted and $countNew as needed in your HTML or further logic



        // Query for Realloaction count
    $sqlNew = "SELECT COUNT(*) as RealloactionCount FROM `Main_Data` WHERE `status` IN ('APPROVED') AND alloted_team='$user' AND `team_emp_id`='$emp_id' AND `coder_comments`!='' ";
    $runqueryNew = mysqli_query($conn, $sqlNew);

    if ($runqueryNew) {
        $resultNew = mysqli_fetch_assoc($runqueryNew);
        $ReallocationTeam = $resultNew['RealloactionCount'];
    } else {
        echo "Error: " . mysqli_error($conn);
    }


}

?>




<style>
    /* .signout {
    padding: 10px 10px;
    font-size: 16px;
    font-weight: bold;

    letter-spacing: 1px;

    color: #ffff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    border-radius: 15px;
  }

  .signout:hover {
    color: orange;
  } */

    /* logout button */

    .logout_Btn {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        width: 45px;
        height: 45px;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        transition-duration: 0.3s;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.199);
         background: linear-gradient(to right,rgb(128, 128, 255),rgb(183, 128, 255));
        margin:5px;
    }

    /* plus sign */
    .sign {
        width: 100%;
        transition-duration: .3s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .sign svg {
        width: 17px;
    }

    .sign svg path {
        fill: var(--night-rider);
    }

    /* text */
    .text {
        position: absolute;
        right: 0%;
        width: 0%;
        opacity: 0;
        color: var(--night-rider);
        font-size: 1.2em;
        font-weight: 600;
        transition-duration: .3s;
    }

    /* hover effect on button width */
    .logout_Btn:hover {
        width: 125px;
        border-radius: 5px;
        transition-duration: .3s;
    }

    .logout_Btn:hover .sign {
        width: 30%;
        transition-duration: .3s;
        padding-left: 20px;
    }

    /* hover effect button's text */
    .logout_Btn:hover .text {
        opacity: 1;
        width: 70%;
        transition-duration: .3s;
        padding-right: 10px;
    }

    /* button click effect*/
    .logout_Btn:active {
        transform: translate(2px, 2px);
    }
</style>

<!-- <script
  src="https://js.sentry-cdn.com/674bb75e7dd901a97f7eeeb7c0e326d6.min.js"
  crossorigin="anonymous"
></script> -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">

    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="#"><img src="include_file/ElevateLogo.png" class="mr-2" alt="logo" style="height:100%;width: 100%;"></a>
        <a class="navbar-brand brand-logo-mini" href="#"><img src="include_file/ELogo.png" alt="logo" style="height: 81%;
    width: 105%;"></a>
    </div>



    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            
        </button>

 
 
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<div class="single-date-calendar">
    <button class="nav-button prev"  onclick="flipButton(this)"> <i class="fas fa-chevron-left"></i></button>
    <div class="date-display">
        <span class="day-name"></span>, 
        <span class="month-name"></span> 
        <span class="day-number"></span>, 
        <span class="year"></span>
    </div>
      <button class="nav-button next" onclick="flipButton(this)"> <i class="fas fa-chevron-right"></i></button>
</div>

<style>
  
        .nav-button {
            background: none;
            border: none;
            font-size: 30px; /* Increased size for visibility */
            cursor: pointer;
            padding: 10px;
            color: #333;
            position: relative;
            display: inline-block;
        }

        .nav-button.flip {
            animation: flip 0.6s forwards;
        }

        @keyframes flip {
            0% {
                transform: rotateY(0);
                opacity: 1;
            }
            50% {
                transform: rotateY(90deg);
                opacity: 0.5;
            }
            100% {
                transform: rotateY(180deg);
                opacity: 1;
            }
        }
 
.single-date-calendar {
    display: flex;
    align-items: center;
    justify-content: center;
/*    background-image: url('include_file/j.jpg'); /* Replace with your image path */ 
background-color: #e8e9e9;
    background-size: cover; /* Makes sure the image covers the entire background */
/*     background-size: 300px 200px; /* Set width and height in pixels */
    background-repeat: no-repeat; /* Prevents repeating the image */
    background-position: center; /* Centers the image */
    padding: 10px;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    font-family: Arial, sans-serif;
    color: black;
}


.nav-button {
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
    padding: 5px 10px;
    color: #333;
}

 

.date-display.hide {
    opacity: 0; /* Hide the element by setting opacity to 0 */

}

.date-display {
    font-size: 16px;
    padding: 0 20px;
    transition: opacity 0.3s ease-in-out; /* Smooth transition for the opacity */
    opacity: 1; /* Default opacity */
   color: #003366; /* Dark blue color */
    font-weight: bold; /* Makes the text bold */
}


</style>

  <script>
        function flipButton(button) {
            button.classList.add('flip');
            // Remove the class after animation to allow replay
            setTimeout(() => {
                button.classList.remove('flip');
            }, 600); // Duration of the animation
        }
    </script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const dateDisplay = document.querySelector('.date-display');
    const dayNameSpan = document.querySelector('.day-name');
    const monthNameSpan = document.querySelector('.month-name');
    const dayNumberSpan = document.querySelector('.day-number');
    const yearSpan = document.querySelector('.year');
    let currentDate = new Date();

    function updateDateDisplay(date) {
        // Wait for the fade out to complete before updating the date
        dateDisplay.addEventListener('transitionend', function updateDate() {
            const dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

            dayNameSpan.textContent = dayNames[date.getDay()];
            monthNameSpan.textContent = monthNames[date.getMonth()];
            dayNumberSpan.textContent = date.getDate();
            yearSpan.textContent = date.getFullYear();
            dateDisplay.classList.remove('hide'); // Bring the opacity back to 1
            dateDisplay.removeEventListener('transitionend', updateDate); // Remove the event listener to prevent issues on multiple clicks
        }, { once: true });

        dateDisplay.classList.add('hide'); // Start the fade out
    }

    document.querySelector('.prev').addEventListener('click', () => {
        currentDate.setDate(currentDate.getDate() - 1);
        updateDateDisplay(currentDate);
    });

    document.querySelector('.next').addEventListener('click', () => {
        currentDate.setDate(currentDate.getDate() + 1);
        updateDateDisplay(currentDate);
    });

    updateDateDisplay(currentDate); // Initialize with the current date
});

</script>
 
 
 

  

        <ul class="navbar-nav navbar-nav-right notifications">


            <?php if ($role == 'TeamLeader') { ?>
                <ul class="nav-item dropdown alertnotify" id="notification">
                    <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                        <i class="icon-bell mx-0 notify"> </i>
                        <span class="count"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                        <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>

                        <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <div class="preview-icon bg-secondary">
                                    <!-- <i class="ti-info-alt mx-0"></i> -->
                                    <span class="icon"> <img src="Patient-Chart.png" style="height: 35px;"></span>
                                </div>
                            </div>
                            <div class="preview-item-content" id="">
                                <h6 class="preview-subject font-weight-normal">New Files</h6>
                                <p class="font-weight-light small-text mb-0 text-muted">
                                    <?php echo $countNewTeam ?>
                                </p>
                            </div>
                        </a>

                        <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <div class="preview-icon bg-secondary">
                                    <!-- <i class="ti-settings mx-0"></i> -->
                                    <span class="icon"> <img src="completed.png" style="height: 35px;"></span>
                                </div>
                            </div>
                            <div class="preview-item-content" id="">
                                <h6 class="preview-subject font-weight-normal">QC Completed Files</h6>
                                <p class="font-weight-light small-text mb-0 text-muted">
                                    <?php echo $countQcCompletedTeam ?>
                                </p>
                            </div>
                        </a>

                        <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <div class="preview-icon bg-secondary">
                                    <!-- <i class="ti-settings mx-0"></i> -->
                                    <span class="icon"> <img src="pending_file.png" style="height: 35px;"></span>
                                </div>
                            </div>
                            <div class="preview-item-content" id="">
                                <h6 class="preview-subject font-weight-normal">Pending Files</h6>
                                <p class="font-weight-light small-text mb-0 text-muted">
                                    <?php echo $PendingCountTeam ?>
                                </p>
                            </div>
                        </a>


                      <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <div class="preview-icon bg-secondary">
                                    <!-- <i class="ti-settings mx-0"></i> -->
                                    <span class="icon"> <img src="pending_file.png" style="height: 35px;"></span>
                                </div>
                            </div>
                            <div class="preview-item-content" id="">
                                <h6 class="preview-subject font-weight-normal">Reallocation Files</h6>
                                <p class="font-weight-light small-text mb-0 text-muted">
                                    <?php echo $ReallocationTeam ?>
                                </p>
                            </div>
                        </a>

                    </div>
                </ul>
            <?php } ?>

                        <?php  if ($role == 'user') { ?>
                <ul class="nav-item dropdown alertnotify" id="notification">
                    <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                        <i class="icon-bell mx-0 notify"> </i>
                        <span class="count"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                        <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>

                        <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <div class="preview-icon bg-secondary">
                                    <!-- <i class="ti-info-alt mx-0"></i> -->
                                    <span class="icon"> <img src="Patient-Chart.png" style="height: 35px;"></span>
                                </div>
                            </div>
                            <div class="preview-item-content" id="new">
                                <h6 class="preview-subject font-weight-normal">New Files</h6>
                                <p class="font-weight-light small-text mb-0 text-muted">
                                    <?php echo $countNew ?>
                                </p>
                            </div>
                        </a>

                        <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <div class="preview-icon bg-secondary">
                                    <!-- <i class="ti-settings mx-0"></i> -->
                                    <span class="icon"> <img src="completed.png" style="height: 35px;"></span>
                                </div>
                            </div>
                            <div class="preview-item-content" id="qccomp">
                                <h6 class="preview-subject font-weight-normal">QC Completed Files</h6>
                                <p class="font-weight-light small-text mb-0 text-muted">
                                    <?php echo $countQcCompleted ?>
                                </p>
                            </div>
                        </a>

                        <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <div class="preview-icon bg-secondary">
                                    <!-- <i class="ti-settings mx-0"></i> -->
                                    <span class="icon"> <img src="pending_file.png" style="height: 35px;"></span>
                                </div>
                            </div>
                            <div class="preview-item-content" id="pend">
                                <h6 class="preview-subject font-weight-normal">Pending Files</h6>
                                <p class="font-weight-light small-text mb-0 text-muted">
                                    <?php echo $PendingCount ?>
                                </p>
                            </div>
                        </a>

                    </div>
                </ul>
            <?php } ?>


                                    <?php  if ($role == 'QA') { ?>
                <ul class="nav-item dropdown alertnotify" id="notification">
                    <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                        <i class="icon-bell mx-0 notify"> </i>
                        <span class="count"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                        <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>

                        <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <div class="preview-icon bg-secondary">
                                    <!-- <i class="ti-info-alt mx-0"></i> -->
                                    <span class="icon"> <img src="Patient-Chart.png" style="height: 35px;"></span>
                                </div>
                            </div>
                            <div class="preview-item-content" id="new">
                                <h6 class="preview-subject font-weight-normal">New Files</h6>
                                <p class="font-weight-light small-text mb-0 text-muted">
                                    <?php echo $countNew ?>
                                </p>
                            </div>
                        </a>

                        <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <div class="preview-icon bg-secondary">
                                    <!-- <i class="ti-settings mx-0"></i> -->
                                    <span class="icon"> <img src="completed.png" style="height: 35px;"></span>
                                </div>
                            </div>
                            <div class="preview-item-content" id="qccomp">
                                <h6 class="preview-subject font-weight-normal">QC Completed Files</h6>
                                <p class="font-weight-light small-text mb-0 text-muted">
                                    <?php echo $countQcCompleted ?>
                                </p>
                            </div>
                        </a>

                        <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <div class="preview-icon bg-secondary">
                                    <!-- <i class="ti-settings mx-0"></i> -->
                                    <span class="icon"> <img src="pending_file.png" style="height: 35px;"></span>
                                </div>
                            </div>
                            <div class="preview-item-content" id="pend">
                                <h6 class="preview-subject font-weight-normal">Approved Files</h6>
                                <p class="font-weight-light small-text mb-0 text-muted">
                                    <?php echo $PendingCount ?>
                                </p>
                            </div>
                        </a>

                    </div>
                </ul>
            <?php } ?>
 <!-- ==========================================================================================PROFILE PIC CODE HERE START=============================================================================================== -->
 
 
 
 

 
 <?php
// Database connection
$mysqli = new mysqli("localhost", "zhcadmin", "d0m!n$24", "HCLI");

 
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
 
$sql = "SELECT `profile_pic` FROM `userlogin` WHERE `user_id` = '$emp_id'";

 
$result = $mysqli->query($sql);

 
$profilePicUrl = "default_profile_pic.jpg";
 
if ($result && $result->num_rows > 0) {
    // Fetch the row
    $row = $result->fetch_assoc();
    $profilePicUrl = $row['profile_pic'];
}

// Close the database connection
$mysqli->close();
?>

<!-- HTML to display the profile picture -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Picture</title>
    <!-- Add any necessary CSS styles here -->
</head>
<body>

<!-- Display the profile picture -->
<div class="nav-item nav-profile dropdown">
    <div class="circle">
        <img class="profile-pic" title="Upload Profile"id="profile-pic" src="<?php echo !empty($profilePicUrl) ? $profilePicUrl : 'https://upload.wikimedia.org/wikipedia/commons/b/b5/Windows_10_Default_Profile_Picture.svg'; ?>" alt="Profile Picture">

      
    </div>
<!--     <div class="p-image">
        <input class="file-upload" id="file-upload" type="file" accept="image/*"/>
    </div> -->
</div>
<div class="card cardesss" id="profilecard" hidden>
    <button class="close-btn" id="close-btn">&times;</button>
    <img src="<?php echo !empty($profilePicUrl) ? $profilePicUrl : 'https://upload.wikimedia.org/wikipedia/commons/b/b5/Windows_10_Default_Profile_Picture.svg'; ?>" alt="Profile Picture" class="profile-img">
    <h3 class="uppercase">User: <?php echo $user; ?></h3>
    <h4>Role: <?php echo $role; ?></h4>
    <h6>ID: <?php echo $emp_id; ?></h6>
    <input type="file" class="file-upload" id="file-upload" accept="image/*" hidden>
    <label for="file-upload" class="change-photo-btn">Change Photo</label>
</div>






</body>
</html>


 


 
 
 

 

<!-- ==========================================================================================PROFILE PIC CODE HERE END=============================================================================================== -->

                <h5 style="padding:10px ;color:#4C4CAC;margin:15px ;border-radius:8px"><?php echo strtoupper($_SESSION['username']); ?>&nbsp(<?php echo $emp_id ?>)</h5>


                <a href="session_des.php" class="ml-3" title="Logout">
                   
                    <button class="logout_Btn" id="tempoarylogout">
                        <!-- <input type="text" class="ion1" value="<?php $user ?>" hidden>
<input type="password" class="ion2" value="<?php $password; ?>" hidden> -->


                        <div class="sign"><svg viewBox="0 0 512 512">
                                <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path>
                            </svg></div>

                        <div class="text">Logout</div>
                    </button>
                </a>
                <!-- 
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">

          <a class="dropdown-item" href="session_des.php">
            <i class="ti-power-off text-primary"></i>
            Logout
          </a>
        </div> -->
            </div>

        </ul>

    </div>
</nav>

<script type="text/javascript" src="login/js/signout.js"></script>
<!-- <script type="text/javascript" src="login/js/perventlogin.js"></script> -->

<script>
    $(document).ready(function() {

        $("#qccomp").on('click', function() {

            // windows.load("qc_completed_table.php");
            window.location.href = "qc_completed_table.php";

        });
        $("#new").on('click', function() {


            window.location.href = "assign_table.php";

        });
        $("#pend").on('click', function() {


            window.location.href = "assign_table.php";

        });
        var codingpage_url = "http://crm.selectrcm.com/Elevate/coding.php";
        var dash_url = "http://crm.selectrcm.com/Elevate/coder_main.php";
        var currentURL = window.location.href;

        if (currentURL === codingpage_url || currentURL === dash_url) {
            $(".alertnotify").attr('style', 'display: none !important'); // Hide the .alertnotify element
        }
    });
</script>

<!-- ====================================================================================================PROFILE PIC STYLE CSS START====================================================================================== -->

<style>
    
    body {
  background-color: #efefef;
}
    .profile-pic {
  width: 100px; /* Adjust the width as needed */
  height: auto;
  cursor: pointer;
}
.profile-pic {
    width: 200px;
    max-height: 200px;
    display: inline-block;
}

.file-upload {
    display: none;
}
 
img {
    max-width: 200%;
    height: auto;
}
.p-image {
  position: absolute;
  top: 97px;
  right: 70px;
  color: #666666;
  transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
}
.p-image:hover {
  transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
}
.upload-button {
  font-size: 1.2em;
}

.upload-button:hover {
  transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
  color: #999;
}


.cardesss {
  padding: 20px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  width: 300px;
  height: 400px;
  background: #fff;
  border-radius: 1rem;
  box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px,
              rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
  transition: all 0.3s ease-in-out;
  position: relative;
}

.cardesss:hover {
  background-color: #f9f9f9;
  box-shadow: rgba(0, 0, 0, 0.09) 0px 2px 1px, 
              rgba(0, 0, 0, 0.09) 0px 4px 2px,
              rgba(0, 0, 0, 0.09) 0px 8px 4px, 
              rgba(0, 0, 0, 0.09) 0px 16px 8px,
              rgba(0, 0, 0, 0.09) 0px 32px 16px;
}

.profile-img {
  width: 200px;
  height: 200px;
  border-radius: 50%;
  margin-bottom: 20px;
}

.cardesss h3, .cardesss h4 {
  margin: 10px 0;
  color: #333;
}

.cardesss h3 {
  font-size: 1.5rem;
  font-weight: 600;
}

.cardesss h4 {
  font-size: 1.2rem;
  font-weight: 400;
}

.file-upload {
  display: none;
}

.change-photo-btn {
  display: inline-block;
  margin-top: 20px;
  padding: 10px 20px;
  font-size: 1rem;
  color: #fff;
  background-color: #007bff;
  border: none;
  border-radius: 0.5rem;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.change-photo-btn:hover {
  background-color: #0056b3;
}

.close-btn {
  position: absolute;
  top: 10px;
  right: 10px;
  background: transparent;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
}

.uppercase {
  text-transform: uppercase;
}


</style>

<!-- ====================================================================================================PROFILE PIC STYLE CSS END====================================================================================== -->

 

<!-- ====================================================================================================PROFILE PIC script   start====================================================================================== -->

<script>
$(document).ready(function() {
    $(".file-upload").on('change', function(){
        var formData = new FormData();
        formData.append('file', $(this)[0].files[0]);
        
        $.ajax({
            url: "profile_uploaded.php?action=pic",
            type: "POST",
            processData: false,
            contentType: false,
            data: formData,
            success: function (response) {
                console.log("Success response:", response);

             Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Profile_Uploaded!',
            });
     
                
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error: " + status, error);

                // Display a generic error message to the user
                alert("An error occurred while sending the data to the server.");
            }
        });
    });
    
    $(".upload-button").on('click', function() {
        $(".file-upload").click();
    });
});
</script>

 
<!-- <script>
// JavaScript to handle click event
document.getElementById("profile-pic").addEventListener("click", function() {
  window.open('<?php echo $profilePicUrl; ?>'); // Open the profile picture in a new tab
});
</script> -->

<script>
    document.getElementById('profile-pic').addEventListener('click', function() {
        var profileCard = document.getElementById('profilecard');
        profileCard.hidden = false;
    });

    document.getElementById('close-btn').addEventListener('click', function() {
        var profileCard = document.getElementById('profilecard');
        profileCard.hidden = true;
    });
</script>

<!-- ====================================================================================================PROFILE PIC script  END====================================================================================== -->

 
