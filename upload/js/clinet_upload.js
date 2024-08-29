$(document).ready(function () {
    $(".clk-upload").on("click", function (e) {

        e.preventDefault();
        var fileInput = $("#formFile")[0].files[0];

        console.log(fileInput);
  
        if (fileInput) {
            var formData = new FormData();
            formData.append("formFile", fileInput);
           // showLoadingIndicator("File Uploading..."); // Show loading indicator
            uploadCSV(formData);
            console.log(formData);
        } else {
            showError("Please select a CSV file to upload!"); // Show error message
        }
    });
  
    // function showLoadingIndicator(title) {
    //     Swal.fire({
    //         title: title,
    //         onBeforeOpen: () => {
    //             Swal.showLoading();
    //         }
    //     });
    // }
  
    function showError(message) {
        Swal.fire({
            title: "Error",
            text: message,
            icon: "error"
        });
    }
  
  
  
    function uploadCSV(formData) {
        $.ajax({
            url: "clinet_upload.php", // Replace with your file upload endpoint
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {

                console.log("response",response);
               
                if (response.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(function () {
                        //modalData();
                    });
                    $(".swal2-popup").addClass("pt-3");
                } else {
                    Swal.fire({
                        title: "Error",
                        text: response.error,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function (xhr, status, error) {
                alert("AJAX Error: " + status, error);
            }
        });
    }
  
  
  
  
   
   });
  
  
  
  
  
  
  