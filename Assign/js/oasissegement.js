$(document).ready(function () {
  // Save button click event
  $(".btn_sa").on("click", function () {
      // Get form data

    
    
          var agencyResponse =$("input[name='agencyResponse']:checked").val();
          var corridorResponse=$("input[name='corridorResponse']:checked").val();
          var corridorRationale= $("textarea[name='corridorRationale']").val();
    

      // console.log(formData);

      // Send data to the server using AJAX
      $.ajax({
          type: "POST",
          url: "Assign/oasissegement.php", // Replace with the actual path to your PHP script
          data: {

              agencyResponse:agencyResponse,
              corridorResponse:corridorResponse,
              corridorRationale:corridorRationale

},
success: function (response) {
    // Handle the server response here
    console.log(response); // You can log the response to the console for debugging
    Swal.fire({
        title: "Success!",
        text: "Server responded successfully.",
        icon: "success",
        button: "OK",
    });
},
error: function () {
    Swal.fire({
        title: "Error!",
        text: "Unable to communicate with the server.",
        icon: "error",
        button: "OK",
    });
}

      });
  });

  // Remove button click event
  $(document).on("click", ".btn_remove", function () {
      // Remove the corresponding row
      $(this).closest("tr").remove();
  });
});