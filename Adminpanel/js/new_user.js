$(document).ready(function () {
  newagency();
  newuser();
  newqcerrortype();
  newoasiserrortype();
  newpocerrortype();
  newpendingreason();
});

//new agency added
function newagency() {
  $("#newagencydata").on("click", function () {
    var agencyname = $("#textInputagencyname").val();
    var clientname = $("#textInputclientname").val();
    var clientid = $("#textInputclientid").val();
    var agencystatus = $("#selectInputAgency").val();

    var emptyFieldsagency = [];

    if (agencyname === "") {
      emptyFieldsagency.push("Agency Name");
    }
    if (clientname === "") {
      emptyFieldsagency.push("Client Name");
    }
    if (clientid === "") {
      emptyFieldsagency.push("Client Id");
    }
    if (agencystatus === "") {
      emptyFieldsagency.push("Status");
    }

    if (emptyFieldsagency > 0) {
      var errorMessage =
        "The following fields are empty:\n" + emptyFieldsagency.join("\n");
      Swal.fire({
        title: "Error",
        text: errorMessage,
        icon: "error",
        confirmButtonText: "OK",
      });
      return;
    } else {
      $.ajax({
        type: "POST",
        url: "Adminpanel/new_user.php?action=newagency",
        data: {
          agencyname: agencyname,
          clientname: clientname,
          clientid: clientid,
          agencystatus: agencystatus,
        },
        dataType: "json", // Expect JSON response
        success: function (response) {
          if (response.success) {
            Swal.fire({
              title: "Success!",
              text: response.message,
              icon: "success",
              confirmButtonText: "OK",
            }).then(function () {
              reset();
            });
          } else {
            Swal.fire({
              title: "Error",
              text: response.message,
              icon: "error",
              confirmButtonText: "OK",
            });
          }
        },
        error: function (xhr, status, error) {
          console.error("Ajax request failed");
          console.error(xhr.responseText);
          Swal.fire({
            title: "Error",
            text: "Something went wrong. Please try again later.",
            icon: "error",
            confirmButtonText: "OK",
          });
        },
      });
    }
  });
}

//new user data entry
function newuser() {
  $("#newusersave").on("click", function () {
    var username = $("#textInputUser").val();
    var userpassword = $("#textInputpassword").val();
    var userempid = $("#textInputempid").val();
    var userrole = $("#selectInputuserrole").val();
    var userorganization = $("#textInputOrganization").val();
    var userstatus = $("#selectInputStatus").val();

    var emptyFields = [];

    if (username === "") {
      emptyFields.push("Username");
    }
    if (userpassword === "") {
      emptyFields.push("Password");
    }
    if (userempid === "") {
      emptyFields.push("Employee ID");
    }
    if (userrole === "") {
      emptyFields.push("User Role");
    }
    // if (userorganization === "") {
    //     emptyFields.push("Organization");
    // }
    if (userstatus === "") {
      emptyFields.push("Status");
    }

    if (emptyFields.length > 0) {
      var errorMessage =
        "The following fields are empty:\n" + emptyFields.join("\n");
      Swal.fire({
        title: "Error",
        text: errorMessage,
        icon: "error",
        confirmButtonText: "OK",
      });
      return; // Stop further execution if there are empty fields
    } else {
      $.ajax({
        type: "POST",
        url: "Adminpanel/new_user.php?action=newuser",
        data: {
          username: username,
          userpassword: userpassword,
          userempid: userempid,
          userrole: userrole,
          userorganization: userorganization,
          userstatus: userstatus,
        },
        dataType: "json", // Expect JSON response

        success: function (response) {
          if (response.success) {
            Swal.fire({
              title: "Success!",
              text: response.message,
              icon: "success",
              confirmButtonText: "OK",
            }).then(function () {
              reset();
            });
          } else {
            Swal.fire({
              title: "Error",
              text: response.message,
              icon: "error",
              confirmButtonText: "OK",
            });
          }
        },
        error: function (xhr, status, error) {
          console.error("Ajax request failed");
          console.error(xhr.responseText);
          Swal.fire({
            title: "Error",
            text: "Something went wrong. Please try again later.",
            icon: "error",
            confirmButtonText: "OK",
          });
        },
      });
    }
  });
}

//new qc code error type
function newqcerrortype() {
  $("#qccodeerrortype").on("click", function () {
    // Retrieve values from input fields
    var qccodeerrortype = $("#textInputcode").val();
    var qcerrorcodestatus = $("#selecterrorcodestatus").val();

    // Array to store empty fields
    var emptyFieldsqcerrortype = [];

    // Check if fields are empty
    if (qccodeerrortype === "") {
      emptyFieldsqcerrortype.push("Qc code error type");
    }
    if (qcerrorcodestatus === "") {
      emptyFieldsqcerrortype.push("Status");
    }

    // If any fields are empty, display error message
    if (emptyFieldsqcerrortype.length > 0) {
      var errorMessage =
        "The following fields are empty:\n" + emptyFieldsqcerrortype.join("\n");
      Swal.fire({
        title: "Error",
        text: errorMessage,
        icon: "error",
        confirmButtonText: "OK",
      });
      return;
    } else {
      // If all fields are filled, send AJAX request
      $.ajax({
        type: "POST",
        url: "Adminpanel/new_user.php?action=newerrorcodetype",
        data: {
          qccodeerrortype: qccodeerrortype,
          qcerrorcodestatus: qcerrorcodestatus,
        },
        dataType: "json", // Expect JSON response
        success: function (response) {
          // Handle success response
          if (response.success) {
            Swal.fire({
              title: "Success!",
              text: response.message,
              icon: "success",
              confirmButtonText: "OK",
            }).then(function () {
              // Reset form or perform any other action
              reset();
            });
          } else {
            // Handle failure response
            Swal.fire({
              title: "Error",
              text: response.message,
              icon: "error",
              confirmButtonText: "OK",
            });
          }
        },
        error: function (xhr, status, error) {
          // Handle AJAX error
          console.error("Ajax request failed");
          console.error(xhr.responseText);
          Swal.fire({
            title: "Error",
            text: "Something went wrong. Please try again later.",
            icon: "error",
            confirmButtonText: "OK",
          });
        },
      });
    }
  });
}



//new qc oasis error type
function newoasiserrortype(){
  $("#qcoasiserrortype").on("click", function () {
    // Retrieve values from input fields
    var qcoasiserrortype = $("#textInputoasis").val();
    var qcoasiscodestatus = $("#selecterroroasisstatus").val();

    // Array to store empty fields
    var emptyFieldsqcerrortype = [];

    // Check if fields are empty
    if (qcoasiserrortype === "") {
      emptyFieldsqcerrortype.push("Qc poc error type");
    }
    if (qcoasiscodestatus === "") {
      emptyFieldsqcerrortype.push("Status");
    }

    // If any fields are empty, display error message
    if (emptyFieldsqcerrortype.length > 0) {
      var errorMessage =
        "The following fields are empty:\n" + emptyFieldsqcerrortype.join("\n");
      Swal.fire({
        title: "Error",
        text: errorMessage,
        icon: "error",
        confirmButtonText: "OK",
      });
      return;
    } else {
      // If all fields are filled, send AJAX request
      $.ajax({
        type: "POST",
        url: "Adminpanel/new_user.php?action=newerroroasistype",
        data: {
          qcoasiserrortype: qcoasiserrortype,
          qcoasiscodestatus: qcoasiscodestatus,
        },
        dataType: "json", // Expect JSON response
        success: function (response) {
          // Handle success response
          if (response.success) {
            Swal.fire({
              title: "Success!",
              text: response.message,
              icon: "success",
              confirmButtonText: "OK",
            }).then(function () {
              // Reset form or perform any other action
              reset();
            });
          } else {
            // Handle failure response
            Swal.fire({
              title: "Error",
              text: response.message,
              icon: "error",
              confirmButtonText: "OK",
            });
          }
        },
        error: function (xhr, status, error) {
          // Handle AJAX error
          console.error("Ajax request failed");
          console.error(xhr.responseText);
          Swal.fire({
            title: "Error",
            text: "Something went wrong. Please try again later.",
            icon: "error",
            confirmButtonText: "OK",
          });
        },
      });
    }
  });



}

//new qc poc error type

function newpocerrortype(){

  $("#qcpocerrortype").on("click", function () {
    // Retrieve values from input fields
    var qcpocerrortype = $("#textInputpoc").val();
    var qcpocstatus = $("#selecterrorpocstatus").val();

    // Array to store empty fields
    var emptyFieldsqcerrortype = [];

    // Check if fields are empty
    if (qcpocerrortype === "") {
      emptyFieldsqcerrortype.push("Qc poc error type");
    }
    if (qcpocstatus === "") {
      emptyFieldsqcerrortype.push("Status");
    }

    // If any fields are empty, display error message
    if (emptyFieldsqcerrortype.length > 0) {
      var errorMessage =
        "The following fields are empty:\n" + emptyFieldsqcerrortype.join("\n");
      Swal.fire({
        title: "Error",
        text: errorMessage,
        icon: "error",
        confirmButtonText: "OK",
      });
      return;
    } else {
      // If all fields are filled, send AJAX request
      $.ajax({
        type: "POST",
        url: "Adminpanel/new_user.php?action=newerrorpoctype",
        data: {
          qcpocerrortype: qcpocerrortype,
          qcpocstatus: qcpocstatus,
        },
        dataType: "json", // Expect JSON response
        success: function (response) {
          // Handle success response
          if (response.success) {
            Swal.fire({
              title: "Success!",
              text: response.message,
              icon: "success",
              confirmButtonText: "OK",
            }).then(function () {
              // Reset form or perform any other action
              reset();
            });
          } else {
            // Handle failure response
            Swal.fire({
              title: "Error",
              text: response.message,
              icon: "error",
              confirmButtonText: "OK",
            });
          }
        },
        error: function (xhr, status, error) {
          // Handle AJAX error
          console.error("Ajax request failed");
          console.error(xhr.responseText);
          Swal.fire({
            title: "Error",
            text: "Something went wrong. Please try again later.",
            icon: "error",
            confirmButtonText: "OK",
          });
        },
      });
    }
  });








}



//new pendingreason type
function newpendingreason(){

  $("#pendingreasontype").on("click", function () {
    // Retrieve values from input fields
    var pendingreason = $("#textInputpending").val();
    var pendingreasonstatus = $("#selecterrorpendingstatus").val();

    // Array to store empty fields
    var emptyFieldsqcerrortype = [];

    // Check if fields are empty
    if (pendingreason === "") {
      emptyFieldsqcerrortype.push("pending reason type");
    }
    if (pendingreasonstatus === "") {
      emptyFieldsqcerrortype.push("Status");
    }

    // If any fields are empty, display error message
    if (emptyFieldsqcerrortype.length > 0) {
      var errorMessage =
        "The following fields are empty:\n" + emptyFieldsqcerrortype.join("\n");
      Swal.fire({
        title: "Error",
        text: errorMessage,
        icon: "error",
        confirmButtonText: "OK",
      });
      return;
    } else {
      // If all fields are filled, send AJAX request
      $.ajax({
        type: "POST",
        url: "Adminpanel/new_user.php?action=pendingreasontype",
        data: {
          pendingreason: pendingreason,
          pendingreasonstatus: pendingreasonstatus,
        },
        dataType: "json", // Expect JSON response
        success: function (response) {
          // Handle success response
          if (response.success) {
            Swal.fire({
              title: "Success!",
              text: response.message,
              icon: "success",
              confirmButtonText: "OK",
            }).then(function () {
              // Reset form or perform any other action
              reset();
            });
          } else {
            // Handle failure response
            Swal.fire({
              title: "Error",
              text: response.message,
              icon: "error",
              confirmButtonText: "OK",
            });
          }
        },
        error: function (xhr, status, error) {
          // Handle AJAX error
          console.error("Ajax request failed");
          console.error(xhr.responseText);
          Swal.fire({
            title: "Error",
            text: "Something went wrong. Please try again later.",
            icon: "error",
            confirmButtonText: "OK",
          });
        },
      });
    }
  });



}


//function for reset data
function reset() {
  $("#textInputUser").val("");
  $("#textInputpassword").val("");
  $("#textInputempid").val("");
  $("#selectInputuserrole").val("");
  $("#textInputOrganization").val("");
  $("#selectInputStatus").val("");
  $("#textInputagencyname").val("");
  $("#textInputclientname").val("");
  $("#textInputclientid").val("");
  $("#selectInputAgency").val("");
  $("#textInputcode").val("");
  $("#selecterrorcodestatus").val("");
  $("#textInputoasis").val("");
  $("#selecterroroasisstatus").val("");
  $("#textInputpoc").val("");
  $("#selecterrorpocstatus").val("");
  $("#textInputpending").val("");
  $("#selecterrorpendingstatus").val("");
}
