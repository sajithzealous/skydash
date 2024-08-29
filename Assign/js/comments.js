$(document).ready(function () {
  medical_profile_update();
  function getCookieValue(cookieName) {
    const cookies = document.cookie.split("; ");

    for (let i = 0; i < cookies.length; i++) {
      const cookiePair = cookies[i].split("=");
      if (cookiePair[0] === cookieName) {
        return cookiePair[1];
      }
    }

    return null;
  }

  // Usage
  const file_id = getCookieValue("Id");
  showcommentsdata(file_id);

  // console.log("Id cookie value:", file_id);
  //  Comments
  $("#saveComments").click(function () {
    $(".settings-panel").css("display", "none");

    $("#settings-trigger").on("click", function () {
      $(".settings-panel").css("display", "block");
    });

    codesegment_cmd = $("#codesegment_cmd").val();
    oasissegment_cmd = $("#oasissegment_cmd").val();
    poc_cmd = $("#poc_cmd").val();

    // Check if at least one field has data
    if (codesegment_cmd === "" && oasissegment_cmd === "" && poc_cmd === "") {
      // alert("Please enter comments in at least one of the sections.");
      Swal.fire({
        title: "Warning!",
        text: "Please enter comments in at least one of the sections",
        icon: "warning",
        confirmButtonText: "OK",
      });
      return;
    }

    console.log("codesegment_cmd", codesegment_cmd);
    console.log("oasissegment_cmd", oasissegment_cmd);
    console.log("poc_cmd", poc_cmd);

    // Send data to server
    $.ajax({
      type: "POST",
      url: "Assign/comment_process.php",
      data: {
        file_id: file_id, // Ensure this variable is defined and has the correct value
        codesegment_cmd: codesegment_cmd,
        oasissegment_cmd: oasissegment_cmd,
        poc_cmd: poc_cmd,
      },
      success: function (response) {
        // console.log(response);
        var res = JSON.parse(response);
        console.log(res);
        if (res.success) {
          Swal.fire({
            title: "success!",
            text: res.message,
            icon: "success",
            confirmButtonText: "OK",
          });
        } else {
          Swal.fire({
            title: "Warning!",
            text: res.message,
            icon: "warning",
            confirmButtonText: "OK",
          });
        }
      },
      error: function (error) {
        console.log("Error", error);
      },
    });
  });

  // medical profile update process

  function medical_profile_update() {
    $("#medical_profile_update").click(function () {

      var file_id=$("#medicalid").val();
      // alert(file_id);
      var patientname = $("#Patientname").val();
      var insurancetype = $("#InsuranceType").val();
      var mrn = $("#mrn").val();
      var agency = $("#agency").val();
      var assesmentdate = $("#assdate").val();
      var assesmenttype = $("#asstype").val();
      var dob = $("#datepicker").val();
      var gender = $("#gender").val();


      // alert(dob);

      if (gender == "") {
        Swal.fire({
          title: "Please Enter Gender",
          icon: "info",
          confirmButtonText: "OK",
        });

        return false;
      }
      // alert(dob);
      // alert(gender);

      $.ajax({
        type: "GET",
        url: "Assign/comment_process.php",
        data: { 
          file_id: file_id,
          dob: dob, 
          gender: gender,
          patientname:patientname,
          insurancetype:insurancetype,
          mrn:mrn,
          agency:agency,
          assesmentdate:assesmentdate,
          assesmenttype:assesmenttype,
      

         },
        success: function (response) {
          console.log(response);
          Swal.fire({
            title: "Success!",
            text: response,
            icon: "success",
            confirmButtonText: "OK",
          });
        },
        error: function (response) {
          Swal.fire({
            title: "Error",
            text: response,
            icon: "error",
            confirmButtonText: "OK",
          });
        },
      });
    });
  }
});

function showcommentsdata(file_id) {
  // console.log("comments",file_id);

  $.ajax({
    type: "POST",
    url: "Assign/commentsshowdata.php",
    data: { file_id: file_id },
    success: function (response) {
      console.log(response);

      $("#codesegment_cmd").text(response.coding_comments);
      $("#oasissegment_cmd").text(response.oasis_comments);
      $("#poc_cmd").text(response.poc_comments);
    },
  });
}
