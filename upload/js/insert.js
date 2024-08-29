     function resetInputFields() {
    //$("#team").val('');
    $("#agency").val('');
   // $("#location").val('');
    $("#patient").val('');
   // $("#task").val('');
    $("#mrn").val('');
    $("#asse_date").val('');
    //$("#dsi").val('');
   // $("#dsc").val('');
    $("#asse_type").val('');
    $("#insu_type").val('');
   // $("#status").val('');
    $("#priority").val('');
     $("#url").val('');
    //$("#remark").val('');
   // $("#phone").val('');
    $("#formFileMultiple").val('');
}
$(document).ready(function () {
  
    $(".clk_2").on("click", function () {
 

   

        //var team = $("#team").val();  
        var agency = $("#agency").val();
       // var location = $("#location").val();
        var patient = $("#patient").val();
       // var task = $("#task").val(); 
        var mrn = $("#mrn").val();
        var asse_date = $("#asse_date").val();
       // var dsi = $("#dsi").val();
       // var dsc = $("#dsc").val();
        var asse_type = $("#asse_type").val();
        var insu_type = $("#insu_type").val();
        var status = $("#status").val();
        var priority = $("#priority").val();
        var url = $("#url").val();
        var urlRegex = /^(https?|ftp):\/\/[^\s/$.?#].[^\s]*$/;
 
       // var phone = $("#phone").val();
 if (!urlRegex.test(url) && url!=="") {
    alert("Invalid URL Not Inserted");
    $("#url").val("");
    return; // Stops further execution
     }

if (agency != 'PSNE001') {

    function validateField(fieldValue, fieldId) {
        if (fieldValue === '') {
            $(fieldId).text('*');
            return false;
        } else {
            $(fieldId).text('');
            return true;
        }
    }

    if (!validateField(status, "#st", status) || 
        // !validateField(team, "#td", team) || 
        !validateField(agency, "#ag", agency) || 
        // !validateField(location, "#lc", location) ||
        !validateField(patient, "#pt", patient) ||
        // !validateField(task, "#tk", task) ||
        !validateField(mrn, "#mr", mrn) ||
        !validateField(asse_date, "#ad", asse_date) ||
        //!validateField(dsi, "#di", dsi) ||
        // !validateField(dsc, "#dc", dsc) ||
        !validateField(asse_type, "#at", asse_type) ||
        !validateField(insu_type, "#it", insu_type) ||
        !validateField(priority, "#pt", priority)
        // !isValidUrl(url) ||
        //!validateField(remark, "#rm", remark) ||
        // !validateField(phone, "#ph", phone) 
    ) {
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            text: 'Please fill in all fields.',
            width: '20%',
            height: '10%'
        });
    } else {
        uploadfile(agency, patient, mrn, asse_date, asse_type, insu_type, status, priority, url);
    }

} else {
    uploadfile(agency, patient, mrn, asse_date, asse_type, insu_type, status, priority, url);
}











 
//  function isValidUrl(value) {
//   // Regular expression for a simple URL validation
//   var urlRegex = /^(https?|ftp):\/\/[^\s/$.?#].[^\s]*$/;
//   if (urlRegex.test(value)) {
//     return true;  // Valid URL
//   } else {
//     alert('Please enter a valid URL.');
//     return false; // Not a valid URL
//   }
// }
    });
});


// function insertalldatas(agency,patient,mrn,asse_date,asse_type,insu_type,status,priority,url,phone){
 
    
//     $.ajax({
//         url: "entry.php",
//         type: "POST",
//         data: {
            
          
//             agency: agency,
          
//             patient: patient,
          
//             mrn: mrn,
//             asse_date: asse_date,
           
//             asse_type: asse_type,
//             insu_type: insu_type,
//             status: status,
//             priority: priority,
//             url: url,
            
//             phone: phone
//         },
// success: function (response) {
//     console.log("Success response:", response);

//     Swal.fire({
//           icon: 'success',
//         title: 'Success!',
//         text: 'Data Inserted!',
//     }).then((result) => {
//         resetInputFields();

//           $(".swal2-popup").addClass("pt-3"); // Reset the input fields
//     });
// },

//                    error: function (xhr, status, error) {
               
//                 console.error("AJAX Error: " + status, error);
//                 alert("An error occurred while sending the data to the server.");
//             }

//     });

// }

// function uploadfile() {
//     var formData = new FormData();
//     var fileInput = $("#formFileMultiple")[0].files;

//     if (fileInput.length === 0) {
//         alert("Please select at least one file.");
//         return;
//     }

 
//     for (var i = 0; i < fileInput.length; i++) {
//         console.log("File Name: " + fileInput[i].name);
//         console.log("File Size: " + fileInput[i].size + " bytes");
//         console.log("File Type: " + fileInput[i].type);
        
//         formData.append('files[]', fileInput[i]);
//     }

//     $.ajax({
//         url: "entry.php",
//         type: "POST",
//         processData: false,
//         contentType: false,
//         data: formData,
//         success: function (response) {
//             console.log("Success response:", response);

           
//             Swal.fire({
//                 icon: 'success',
//                 title: 'Success!',
//                 text: 'Data Inserted!',
//             });
//         },
//         error: function (xhr, status, error) {
//             console.error("AJAX Error: " + status, error);

//             // Display a generic error message to the user
//             alert("An error occurred while sending the data to the server.");
//         }
//     });
// }

function uploadfile(agency, patient, mrn, asse_date, asse_type, insu_type, status, priority,url) {



    var formData = new FormData();
    var fileInput = $("#formFileMultiple")[0].files;

    // if (fileInput.length === 0 && url==="") {
    //     alert("Please select at least one file.");
    //     return;
    // }
    


    for (var i = 0; i < fileInput.length; i++) {
        console.log("File Name: " + fileInput[i].name);
        console.log("File Size: " + fileInput[i].size + " bytes");
        console.log("File Type: " + fileInput[i].type);
       

        formData.append('files[]', fileInput[i]);
    }

    formData.append('agency', agency);
    formData.append('patient', patient);
    formData.append('mrn', mrn);
    formData.append('asse_date', asse_date);
    formData.append('asse_type', asse_type);
    formData.append('insu_type', insu_type);
    formData.append('status', status);
    formData.append('priority', priority);
   // formData.append('phone', phone);
    formData.append('url', url);

    $.ajax({
        url: "entry.php",
        type: "POST",
        processData: false,
        contentType: false,
        data: formData,
        success: function (response) {
            console.log("Success response:", response);

            // You can handle the response as needed

            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Data Inserted!',
            }).then((result) => {
         resetInputFields();

          
      });
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: " + status, error);

            // Display a generic error message to the user
            alert("An error occurred while sending the data to the server.");
        }
    });
    
        

}
