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
  console.log("Id cookie value:", file_id);
  //  Comments
  $("#qc_saveComments").click(function () {
    alert(1);
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
        url: "QA/qc_comment_process.php",
      data: {
        file_id: file_id, // Ensure this variable is defined and has the correct value
        codesegment_cmd: codesegment_cmd,
        oasissegment_cmd: oasissegment_cmd,
        poc_cmd: poc_cmd,
      },
      success: function (response) {
        // alert(response);
        Swal.fire({
          title: "success!",
          text: response,
          icon: "success",
          confirmButtonText: "OK",
        });
      },
      error: function (error) {
        console.log("Error", error);
      },
    });
  });

});
