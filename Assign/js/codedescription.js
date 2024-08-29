// // ON CHANGE FUNCTION
// $(document).ready(function () {
//     $("#icd").change(function (event) {
//         event.preventDefault();
//         var icd = $("#icd").val();

//         if (icd == '') {
//             alert('Please Enter Icd');
//             return false;
//         }

//         console.log(icd);  // Corrected variable name

//         $.ajax({
//             type: 'POST',
//             url: 'Assign/code_description.php',
//             data: {icd: icd},
//             success: function (data) {
//                 console.log(data);
//                 // Check if data is already an object (JSON)
//                 var response =JSON.parse(data);
//                 var des = response.description
//                 console.log(des);
//                 $(".description").val(des);

//                 if (response.success) {
//                     Swal.fire({
//                         title: 'Success!',
//                         text: response.success,
//                         icon: 'success',
//                         confirmButtonText: 'OK'
//                     }).then(function (result) {
//                         if (result.isConfirmed) {
//                             modal_close();
//                         }
//                     });
//                 } else if (response.error) {
//                     Swal.fire({
//                         title: 'Error',
//                         text: response.error,
//                         icon: 'error',
//                         confirmButtonText: 'OK'
//                     });
//                 }

//                 fetchData();
//             },
//             error: function (data) {
//                 console.log(data);
//             }
//         });
//     });
// });
