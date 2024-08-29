 

$(document).ready(function(){

$(".signout").click(function() {
    
 Swal.fire({
    title: 'Are you sure?',
    html: '<marquee scrollamount="5"><p style="color: red; font-size: 16px; background-color:white">You will only be able to log in tomorrow if you log out now!</p> </marquee>',
    imageUrl: 'images/clock.gif',  // Replace with the actual path to your image
    imageWidth: 250,  // Adjust the width of the image as needed
    imageHeight: 200, // Adjust the height of the image as needed,
    showCancelButton: true,
    confirmButtonColor: '#4CAF50', // Change to the color you prefer
    cancelButtonColor: '#D32F2F', //
    confirmButtonText: 'Yes, log out!'
}).then((result) => {
  if (result.isConfirmed) {
     
    signOut();
  } else {
    
  }
});
});


 












function signOut(){

 
  $.ajax({

      url: 'login/checkout.php',
      type: "POST",
      data: {
          

      },
      success: function (response) {
           if (response === "done") {
           window.location.href = 'login.php';
        } else {
            
            console.log("Unexpected response:", response);
        }
      },
      
      error: function (jqXHR, textStatus, errorThrown) {
          console.log("Error:", errorThrown);
          errorAlert.html("An error occurred during your request").removeClass("alert-positive").addClass("alert-negative").show();
          successAlert.hide(); // Hide the success alert
      }
  });
}


});

 