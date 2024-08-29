$(document).ready(function () {
    showData();
});

function showData() {
    $.ajax({
        type: "GET",
        url: "Adminpanel/autologout.php?action=getuserdata",
        success: function (response) {
            console.log(response);

            // Clear existing table rows
            $("#autologout tbody").empty();

            // Iterate over each element in the response array
            $.each(response, function (index, userdata) {
                var Id = userdata.Id;
                var username = userdata.username;
                var userid = userdata.emp_id;
                var userrole = userdata.role;
                // var userdate = userdata.logdate;
                // var userlogintime = userdata.logintime;
                // var userlogouttime = userdata.logouttime;
                var status = userdata.status_2;

                if (userrole === "user") {
                    userrole = "Coder";
                } else if (userrole === "QA") {
                    userrole = "QA-Coder";
                }

                if (status === "1") {
                    status = "Login";
                } else {
                    status = "Logout";
                }

                // Append a new row to the table with user data
                var row = $("<tr>").append(
                    "<td>" + (index + 1) + "</td>",
                    "<td>" + username + "</td>",
                    "<td>" + userid + "</td>",
                    "<td>" + userrole + "</td>",
                    "<td>" + status + "</td>"
                    
                   
                  
                );

                // Conditionally append the "Force Logout" button
                if (status === "Login") {
                    row.append('<td><button class="btn btn-danger" onclick="forceLogout(' + Id + ', \'' + userid + '\', \'' + username + '\', \'' + userrole + '\')">Force Logout</button></td>');


                } else {
                    row.append("<td></td>"); // Placeholder for empty cell if status is not "In-Active"
                }

                // Append the row to the table body
                $("#autologout tbody").append(row);
            });
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("Error:", errorThrown);
        },
    });
}

// Function to handle Force Logout button click
function forceLogout(Id,userid,username,userrole) {
    alert(userid);
     $.ajax({
         type: 'POST',
         url: 'Adminpanel/autologout.php?action=updatestatus',
         data: {
             Id: Id,
               username:username,
               userid:userid,
               userrole:userrole
         },
         success: function (response) {
             if (response.success) {
                 Swal.fire({
                     title: "Success!",
                     text: "User status updated successfully.",
                     icon: "success",
                     confirmButtonText: "OK",
                 }).then(function (result) {
                     if (result.isConfirmed) {
                         location.reload();
                     }
                 });
             } else {
                 Swal.fire({
                     title: "Error!",
                     text: response.message,
                     icon: "error",
                     confirmButtonText: "OK",
                 });
             }
         },
         error: function (jqXHR, textStatus, errorThrown) {
             console.log("Error:", errorThrown);
             Swal.fire({
                 title: "Error!",
                 text: "Failed to update user status.",
                 icon: "error",
                 confirmButtonText: "OK",
             });
         },
     });
}
