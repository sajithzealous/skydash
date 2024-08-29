$(document).ready(function(){

icd_description();

});

function icd_description()
{
	 $("#icdone").on("change", function () {
     
      var icdone = $("#icdone").val();
 
    $.ajax({
      type: "POST",
      url: "Assign/billing_description.php?action=billingone",
      data: { icdone: icdone },
      success: function (data) {
 
           var response = JSON.parse(data);
         $("#desone").val(response.description);
        //  $("#desone").val(response.description);
         $("#cglone").val(response.clinicalgroup);

         if(response.error)

         {
         	alert(response.error);
         }
    
     },
     error: function () {
        
     },
   });
 
  });

  $("#icdtwo").on("change", function () {
     
    var icdtwo = $("#icdtwo").val();

  $.ajax({
    type: "POST",
    url: "Assign/billing_description.php?action=billingtwo",
    data: { icdtwo: icdtwo },
    success: function (data) {

         var response = JSON.parse(data);
       $("#destwo").val(response.description);
       $("#cgltwo").val(response.clinicalgroup);
      //  $("#destwo").val(response.description);

       if(response.error)

       {
           alert(response.error);
       }
  
   },
   error: function () {
      
   },
 });

});
}

//billing save
$(document).on("click", "#billingsave", function() {
   // Collect billing data
var billingData = {
    icdone: $("#icdone").val(),
    desone: $("#desone").val(),
    adtone: $("#adtone").val(),
    cglone: $("#cglone").val(),
    levelone: $("#levelone").val(),
    caone: $("#caone").val(),
    lupaone: $("#lupaone").val(),
    hippsone: $("#hippsone").val(),
    revenueone: $("#revenueone").val(),
    icdtwo: $("#icdtwo").val(),
    destwo: $("#destwo").val(),
    adttwo: $("#adttwo").val(),
    cgltwo: $("#cgltwo").val(),
    leveltwo: $("#leveltwo").val(),
    catwo: $("#catwo").val(),
    lupatwo: $("#lupatwo").val(),
    hippstwo: $("#hippstwo").val(),
    revenuetwo: $("#revenuetwo").val()
};

// Log the billing data for debugging
console.log('Billing data:', billingData);

// Check if any field is empty
var isEmpty = Object.values(billingData).some(value => value === "");

if (isEmpty) {
    // Show error alert using SweetAlert

    alert("Please fill in all the required billing data.!")
     
} else {
    // Send billing data via AJAX
    $.ajax({
        url: 'Assign/billing_description.php?action=billing_insert',
        method: 'POST',
        data: billingData,
        success: function(response) {
            var data = JSON.parse(response);
            var status = data.status;

            if (status === 'success') {
                // Show success alert using SweetAlert2
                Swal.fire({
                    icon: "success",
                    title: "Success!",
                    text: data.message,
                    showConfirmButton: false,
                    timer: 1500
                });
            } else {
                // Show error alert using SweetAlert
                swal({
                    title: "Error!",
                    text: data.message,
                    icon: "error",
                    button: "OK"
                });
            }
        },
        error: function(error) {
            // Handle error response
            console.error('Error saving billing data:', error);
            swal({
                title: "Error!",
                text: "An unexpected error occurred. Please try again.",
                icon: "error",
                button: "OK"
            });
        }
    });
}




});







