$(document).ready(function () {
  // Define a function for the login process
  function performLogin() {
    var empid = $("#empid").val();
    var password = $("#password").val();
    // get_break(username);

    // alert(empid);
    // alert(password);

    if (!empid || !password) {
      Swal.fire({
        title: "Warning",
        text: "Please enter your empid and password to proceed.",
        icon: "warning",
        confirmButtonText: "OK",
      });
      return;
    }

    $.ajax({
      type: "POST",
      url: "login/logincheck.php",
      data: {
        empid: empid,
        password: password,
      },
      dataType: "json", // Parse the response as JSON
      success: function (data) {
        if (data.success) {
          var role = data.success;
          console.log(role);
          // alert(role);
        
       switch (role) {
    case "admin":
    case "superadmin":
    case "tm":
        window.location.href = "index.php";
        break;
    case "TeamLeader":
        window.location.href = "team_main.php";
        break;

    case "user": 
        window.location.href = "assign_table.php";
        break;

    case "client":
        window.location.href = "fileupload.php";
        break;

    case "agency":
        window.location.href = "agent_dash.php";
        break;
    case "ceo":
          window.location.href = "index.php";
          break;

    case "QA":
        window.location.href = "qc_main.php";
        break;

    case "QaTl":
       window.location.href = "Qcteam_main.php";
      break;

    default:
        // Handle unrecognized roles
        alert("Role not recognized");
}

        } else {
          var loginerror = data.error;
          // Login failed, show an error message
          Swal.fire({
            title: "Warning",
            text: loginerror,
            icon: "warning",
            confirmButtonText: "OK",
          });
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        alert("Error: " + textStatus); // Display the error status
        console.log(jqXHR); // Log the entire response object for debugging
      },
    });
  }

  //BREAK
  // function get_break(username) {

  //   $.ajax({
  //     type: "POST",
  //     url: "login/brk_process.php",
  //     success: function (data) {
  //       var response = JSON.parse(data);
  //       var id = response[0].entry_id;
  //       var Coder = response[0].Coder;
  //       alert(id);

  //       // Check if the break_status is "Break_In"
  //       if (response[0].break_status === "Break_In" && Coder.toUpperCase() === username.toUpperCase()) {
  //         // Trigger an alert or perform any action here

  //         // Define variables for the timer
  //         let timerInterval;
  //         let seconds = 0;
  //         let minutes = 0;
  //         let hours = 0;

  //         // Function to update the timer
  //         function updateTimer() {
  //           seconds++;
  //           if (seconds >= 60) {
  //             seconds = 0;
  //             minutes++;
  //             if (minutes >= 60) {
  //               minutes = 0;
  //               hours++;
  //             }
  //           }

  //           // Format the time components
  //           const formattedTime =
  //             formatTime(hours) +
  //             ":" +
  //             formatTime(minutes) +
  //             ":" +
  //             formatTime(seconds);

  //           // Update the content of the SweetAlert with the timer
  //           Swal.getContent().querySelector("#timerDisplay").innerText =
  //             formattedTime;
  //         }

  //         // Function to format time (adds leading zero if time is less than 10)
  //         function formatTime(time) {
  //           return time < 10 ? "0" + time : time.toString();
  //         }

  //         // Open SweetAlert modal with timer content and image
  //         Swal.fire({
  //           html: '<p style="font-size: 40px;" id="timerDisplay">00:00:00</p>',
  //           imageUrl:
  //             "https://apartostudent.com/media/bggbysnj/happy-students-take-a-moment-for-yourself.gif?width=254&height=254&mode=max",
  //           imageWidth: 250,
  //           imageHeight: 200,
  //           imageAlt: "Custom image",
  //           confirmButtonText: "Yes, proceed",
  //           allowEscapeKey: false,
  //           allowOutsideClick: false,

  //           didOpen: () => {
  //             // Start the timer when the Swal modal is shown
  //             timerInterval = setInterval(updateTimer, 1000); // Update timer every second
  //           },
  //           willClose: () => {
  //             // Clear the timer interval when the Swal modal is closed
  //             clearInterval(timerInterval);
  //           },
  //         }).then((result) => {
  //           if (result.isConfirmed) {
  //             // Action to take when the user clicks the confirmation button
  //             // Display an alert message
  //             $.ajax({
  //               type: "POST",
  //               url: "login/break.php?action=updatebreaktime",
  //               data: {
  //                 Id: id,
  //               },
  //               success: function (data) {
  //                 console.log(data);
  //                 // Handle success response if needed
  //               },
  //               error: function (xhr, status, error) {
  //                 // Handle error if the AJAX request fails
  //                 console.error(error);
  //               },
  //             });
  //           }
  //         });
  //       } else {
  //         // alert("noooo");
  //       }
  //     },
  //     error: function (xhr, status, error) {
  //       // Handle error if the AJAX request fails
  //       console.error(error);
  //     },
  //   });
  // }
  // get_break();

  // Attach the click event to the button
  $("#button").on("click", performLogin);
  $(".presskey").keypress(function (e) {
    if (e.which === 13) {
      // "Enter" key has keyCode 13
      performLogin(); // Assuming performLogin is a function that handles login
    }
  });
});
