$(document).ready(function () {
  //  Comments
  $("#notes").click(function () {

    var chart_id = $("#chart_id").val();
    // alert(chart_id)
    var commentTextnotes = $("#commentTextnotes").val();
    console.log(chart_id, commentTextnotes);
    if (commentTextnotes == "") {
      alert("Please Enter Comments");
      return false;
    }
    $.ajax({
      type: "POST",
      url: "Assign/notes_to_agency_process.php",
      data: { chart_id: chart_id, commentTextnotes: commentTextnotes },
      success: function (response) {
        alert(response);
        $("#commentTextnotes").val("");
      },
      error: function () {
        console.log("Error", response);
      },
    });
  });
});
