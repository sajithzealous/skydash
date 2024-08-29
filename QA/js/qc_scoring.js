$(document).ready(function () {
  containerShow();
  fetchscore();
});

//fetchscoring values and calculating overall
function fetchscore() {
  var Id = $(".dataId").val();

  $.ajax({
    type: "post",
    url: "QA/qcscoringdisplay.php", // Specify the URL of your PHP script
    data: {
      Id: Id,
    },
    success: function (response) {
      // Parse the response as JSON
      var responseData = JSON.parse(response);

      // Access properties from the parsed object
      var codescoring, oasisscoring, pocscoring;
      console.log(responseData.oasis_scoring);

      if (responseData.code_scoring !== "NaN") {
        codescoring = parseInt(responseData.code_scoring);
      } else {
        codescoring = 100;
      }

      if (responseData.oasis_scoring !== "NaN") {
        oasisscoring = parseInt(responseData.oasis_scoring);
      } else {
        oasisscoring = 100;
      }

      if (responseData.poc_scoring !== "NaN") {
        pocscoring = parseInt(responseData.poc_scoring);
      } else {
        pocscoring = 100;
      }

      var qccodescoring, qcoasisscoring, qcpocscoring;

      if (responseData.qc_code_scoring !== "NaN") {
        qccodescoring = parseInt(responseData.qc_code_scoring);
      } else {
        qccodescoring = 0;
      }

      if (responseData.qc_oasis_scoring !== "NaN") {
        qcoasisscoring = parseInt(responseData.qc_oasis_scoring);
      } else {
        qcoasisscoring = 0;
      }

      if (responseData.qc_poc_scoring !== "NaN") {
        qcpocscoring = parseInt(responseData.qc_poc_scoring);
      } else {
        qcpocscoring = 0;
      }

      var totalscoring = (codescoring + oasisscoring + pocscoring) / 3;

      var qctotalscoring = (qccodescoring + qcoasisscoring + qcpocscoring) / 3;

      var totalscoringString = totalscoring.toFixed(0);

      var qctotalscoringString = qctotalscoring.toFixed(0);

      $(".codescore").text(codescoring);
      $(".oasisscore").text(oasisscoring);
      $(".pocscore").text(pocscoring);
      $(".totalscore").text(totalscoringString);

      totaldatasend(
        totalscoringString,
        Id,
        qctotalscoringString,
        codescoring,
        oasisscoring,
        pocscoring,
        qccodescoring,
        qcoasisscoring,
        qcpocscoring
      );
    },
    error: function (xhr, status, error) {
      console.log(xhr.responseText);
      // Handle errors here
    },
  });
}

//total data sending to the qc scoring
function totaldatasend(
  totalscoringString,
  Id,
  qctotalscoringString,
  codescoring,
  oasisscoring,
  pocscoring,
  qccodescoring,
  qcoasisscoring,
  qcpocscoring
) {
  $.ajax({
    type: "post",
    url: "QA/qcscoringfetch_v2.php?action=totalscore",
    data: {
      totalscoringString: totalscoringString,
      Id: Id,
      qctotalscoringString: qctotalscoringString,
      codescoring: codescoring,
      oasisscoring: oasisscoring,
      pocscoring: pocscoring,
      qccodescoring: qccodescoring,
      qcoasisscoring: qcoasisscoring,
      qcpocscoring: qcpocscoring,
    },

    success: function (response) {
      // alert('DONE')
      console.log(response);
    },

    error: function (xhr, status, error) {
      console.log(xhr.responseText);
    },
  });
}

//container showing in data
function containerShow() {
  Id = $(".dataId").val();
  var agency = $(".dataagency").val();

  $.ajax({
    type: "post",
    url: "QA/qcscoringfetch_v2.php?action=containershow",
    data: {
      Id: Id,
      agency: agency,
    },

    success: function (response) {
      var data = JSON.parse(response);
      var codesegement = data.code_segment;
      var oasissegement = data.oasis_segment;
      var pocsegement = data.poc_segment;

      if (codesegement === "none") {
        $("#codescoringcontainer").hide();
        $(".codescoreshowing").hide();
      } else {
        $("#codescoringcontainer").show();
        $(".codescoreshowing").show();
      }

      if (oasissegement === "none") {
        $("#oasisscoringcontainer").hide();
        $(".oasisscoreshowing").hide();
      } else {
        $("#oasisscoringcontainer").show();
        $(".oasisscoreshowing").show();
      }

      if (pocsegement === "none") {
        $("#pocscoringcontainer").hide();
        $(".pocscoreshowing").hide();
      } else {
        $("#pocscoringcontainer").show();
        $(".pocscoreshowing").show();
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.error("Error:", errorThrown);
      // Handle error response
    },
  });
}
