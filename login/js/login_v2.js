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
      url: "login/logincheck_v2.php",
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
          rolecondition(role)
   

        } else {
          var loginerror = data.error;
          var userid=data.user_id;
          var userrole=data.user_role;

          if(loginerror=='The Password Is Expired. Please Change Your Password.'){

            Swal.fire({
              title: "Change Password",
              html: `
                <form id="changepasswordform">
                    <input type="text" id="useridc" value="${userid}" class="swal2-input" data-role="${userrole}"disabled> 
                    <div>
                        <label for="inputPassword">New Password:</label>
                        <input type="password" id="inputPassword" class="swal2-input" required>
                    </div>
                    <div>
                        <label for="cpassword">Confirm Password:</label>
                        <input type="password" id="cpassword" class="swal2-input" required>
                    </div>
                </form>
              `,
              confirmButtonText: "Submit",
              preConfirm: () => {
                  const userid = document.getElementById('useridc').value;
                  const password = document.getElementById('inputPassword').value;
                  const cpassword = document.getElementById('cpassword').value;
                  const userrole = document.getElementById('useridc').getAttribute('data-role');
      
                  if (password !== cpassword) {
                      Swal.showValidationMessage('Passwords do not match');
                      return false;
                  }
      
                  return {
                      userid: userid,
                      password: password,
                      cpassword: cpassword,
                      userrole:userrole
                  };
              }
          }).then((result) => {
              if (result.isConfirmed) {
                  // Handle the form data
                  const formData = result.value;
                  console.log(formData);
      
                  $.ajax({
                    url: 'login/passwordchanged_v2.php',
                    type: 'POST',
                    data: {
                        formData: JSON.stringify(formData) // Encode the form data as JSON
                    },
                    success: function(response) {
                        // Parse the JSON response
                        let data = JSON.parse(response);
                        if (data.success) {
                          Swal.fire('Success', data.message, 'success').then(() => {
                              var role = data.user_role;
                              rolecondition(role); 
                          });
                      } else {
                          Swal.fire('Error', data.error, 'error');
                      }
                    },
                    error: function(error) {
                        Swal.fire('Error', 'Failed to change the password', 'error');
                    }
                });
                
              }
          });
           

          }else{
           // Login failed, show an error message
          Swal.fire({
            title: "Warning",
            text: loginerror,
            icon: "warning",
            confirmButtonText: "OK",
          });

          }

        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        alert("Error: " + textStatus); // Display the error status
        console.log(jqXHR); // Log the entire response object for debugging
      },
    });
  }


  function rolecondition(role){


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
