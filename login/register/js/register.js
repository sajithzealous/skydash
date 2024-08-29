$(document).ready(function() {

    $("#registermyForm").submit(function (event) {
        event.preventDefault(); // Prevent the default form submission

        // Get form data
        var formData = $(this).serialize();

        // AJAX request
        $.ajax({
            type: "POST",
            url: "register/register_sql.php?action=register", // Specify your PHP script URL
            data: formData,
            success: function (data) {
                // Handle success, you can display a message or perform other actions
                //console.log(response);
                console.log(data);
                    var response = JSON.parse(data);
                    if(response==1){
                        swal(
                            '',
                            'Register <b style="color:green;">Successfully</b>',
                            'success',
                            4000
                          ).then(okay => {
                            if (okay) {
                              window.location.replace("register.php");
                              //window.location.reload();
                            }
                          })   
                     }
                     else{
                        swal(
                            '',
                            'Already Registed the <b style="color:red;"> User ID</b> !',
                            'error'
                        )
                     }
            },
            error: function (error) {
                // Handle error, display an error message, or perform other actions
                //console.log("Error: " + error);
            }
        });
    });
    $("#register_btn").click(function() {
       // event.preventDefault();
       

    //  if (username && password && userid && user_role &&  companyname && user_status )  {
    //         $.ajax({
    //             type: 'POST',
    //             url: 'register/register_sql.php?action=register',
    //             data: { username: username, password: password,userid: userid,user_role: user_role,companyname: companyname,user_status: user_status },
    //             success: function (data) {
    //                 console.log(data);
    //                 var response = JSON.parse(data);
    //                 if(response==1){
    //                     swal(
    //                         '',
    //                         'Register <b style="color:green;">Successfully</b>',
    //                         'success',
    //                         4000
    //                       ).then(okay => {
    //                         if (okay) {
    //                           window.location.replace("register.php");
    //                           //window.location.reload();
    //                         }
    //                       })   
    //                  }
    //                  else{
    //                     swal(
    //                         '',
    //                         'Please fill the <b style="color:red;"> required field</b> !',
    //                         'error'
    //                     )
    //                  }
    //               },
    //         });
    //      } 
    //         else{
    //             swal(
    //                 '',
    //                 'Please fill the <b style="color:red;"> required field</b> !',
    //                 'error'
    //             )
    //          }
        
    });

});