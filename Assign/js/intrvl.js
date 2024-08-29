$(document).ready(function() {

 
 alert("intrvel");
  });
//     $.ajax({
//     type: 'GET',
//     url: 'Assign/logincheck.php?action=f1',
//     data: {},
//     success: function(response) {
//         console.log("get_response",response);

//         Swal.fire({
//               html: '<p style="font-size: 40px;" id="timerDisplay">00:00:00</p>',
//             imageUrl: "https://apartostudent.com/media/bggbysnj/happy-students-take-a-moment-for-yourself.gif?width=254&height=254&mode=max",
//             imageWidth: 250,
//             imageHeight: 200,
//             imageAlt: "Custom image",
//             confirmButtonText: 'Yes, proceed',
//             allowEscapeKey: false, 
//             allowOutsideClick: false,
//             didOpen: () => {
//                 timerInterval = setInterval(updateTimer, 1000);
//             },
//             willClose: () => {
//                 clearInterval(timerInterval);
//             }
//         }).then((result) => {
//             if (result.isConfirmed) {
//                 processData();
//             }
//         });
//     },
//     error: function(xhr, status, error) {
//         console.error(error);
//     }
// });