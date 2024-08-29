$(document).ready(function () {
  $("#btn_save_oasis").on("click", function () {
    const Id = $("#entryId").val();
    positionOne();
    positionTwodata(Id);
  });
});

//position one admission source  and timing taken
function positionOne() {
  var timing = $("#timingSelect").val();
  var source = $("#admissionSourceSelect").val();

  $.ajax({
    type: "POST",
    url: "Ryi_v2/position1_v2.php",
    data: {
      timing: timing,
      source: source,
    },

    success: function (response) {
      positionOnevalue = response;
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("Error:", errorThrown);
    },
  });
}

//position two icd and mitem taking
function positionTwodata(Id) {
  alert(Id);

  $.ajax({
    type: "POST",
    url: "Ryi_v2/positiontwodata.php",
    data: {
      Id: Id,
    },
    success: function (response) {
      console.log(response);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("Error:", errorThrown);
    },
  });
}
