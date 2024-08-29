// Wait for the document to be fully loaded before executing JavaScript
$(document).ready(function () {
  // Attach a click event to the button with class 'break_btn'
  $(".break_btn").on("click", function (e) {
    if (confirm("Are You Sure Do You Want To Break?")) {
      e.preventDefault(); // Prevent default form submission behavior

      // Define variables for the timer
      let timerInterval;
      let seconds = 0;
      let minutes = 0;
      let hours = 0;

      // Function to update the timer
      function updateTimer() {
        seconds++;
        if (seconds >= 60) {
          seconds = 0;
          minutes++;
          if (minutes >= 60) {
            minutes = 0;
            hours++;
          }
        }

        // Format the time components
        const formattedTime =
          formatTime(hours) +
          ":" +
          formatTime(minutes) +
          ":" +
          formatTime(seconds);

        // Update the content of the SweetAlert with the timer
        Swal.getContent().querySelector("#timerDisplay").innerText =
          formattedTime;
      }

      // Function to format time (adds leading zero if time is less than 10)
      function formatTime(time) {
        return time < 10 ? "0" + time : time.toString();
      }

      // Open SweetAlert modal with timer content and image
      Swal.fire({
        html: '<p style="font-size: 40px;" id="timerDisplay">00:00:00</p>',
        imageUrl:
          "https://apartostudent.com/media/bggbysnj/happy-students-take-a-moment-for-yourself.gif?width=254&height=254&mode=max",
        imageWidth: 250,
        imageHeight: 200,
        imageAlt: "Custom image",
        confirmButtonText: "Yes, proceed",
        allowEscapeKey: false,
        allowOutsideClick: false,

        didOpen: () => {
          // Start the timer when the Swal modal is shown
          timerInterval = setInterval(updateTimer, 1000); // Update timer every second
        },
        willClose: () => {
          // Clear the timer interval when the Swal modal is closed
          clearInterval(timerInterval);
        },
      }).then((result) => {
        if (result.isConfirmed) {
          // Action to take when the user clicks the confirmation button
          // Display an alert message
          processData(); // Call a function for further data processing or actions
        }
      });

      // Get the value of the element with ID 'break'
      // var Id = $("#break").val();
      var Id = $("#break").attr("value");
      // alert(Id)

      // Send an AJAX request to 'break.php' with the retrieved value
      $.ajax({
        type: "POST",
        url: "Assign/break.php?action=insertbreaktime",
        data: {
          Id: Id,
        },
        success: function (data) {
          console.log(data);
          // Handle success response if needed
        },
        error: function (xhr, status, error) {
          // Handle error if the AJAX request fails
          console.error(error);
        },
      });

      $.ajax({
        type: "GET",
        url: "Assign/logincheck.php?action=f1",
        data: {},
        success: function (response) {
          console.log("get_response", response);

          Swal.fire({
            html: '<p style="font-size: 30px;" id="timerDisplay">00:00:00</p>',
            imageUrl:
              "https://apartostudent.com/media/bggbysnj/happy-students-take-a-moment-for-yourself.gif?width=254&height=254&mode=max",
            imageWidth: 250,
            imageHeight: 200,
            imageAlt: "Custom image",
            confirmButtonText: "Yes, proceed",
            allowEscapeKey: false,
            allowOutsideClick: false,
            didOpen: () => {
              timerInterval = setInterval(updateTimer, 1000);
            },
            willClose: () => {
              clearInterval(timerInterval);
            },
          }).then((result) => {
            if (result.isConfirmed) {
              processData();
            }
          });
        },
        error: function (xhr, status, error) {
          console.error(error);
        },
      });

      function processData() {
        $.ajax({
          type: "POST",
          url: "Assign/break.php?action=updatebreaktime",
          data: {
            Id: Id,
          },
          success: function (data) {
            console.log(data);
            // Handle success response if needed
          },
          error: function (xhr, status, error) {
            // Handle error if the AJAX request fails
            console.error(error);
          },
        });
      }
    } else {
      // User clicked "NO" or closed the dialog, you can handle this case as needed
    }
  });

});
