$(document).ready(function () {
  $.ajax({
    type: "GET",
    url: "QA/qc_single_preview_process_2.php",
    data: {},
    dataType: "json",
    success: function (response) {
      console.log(response);
      //  personal Details
      var main = response.personal_details.data;
      main_Table(main);

      // Codesegementqc
      var datas = response.Codesegementqc.data;
      Codesegementqc_Table(datas);

      var coding_cmd = response.Codesegementqc.coding_comments;
   

      var coder_comment = response.Codesegement.codercomment;
      CodingCmd(coding_cmd,coder_comment);
      console.log("coder",coder_comment);
 



      // Oasis
      var datas1 = response.oasisqc.data;
      oasisqc_Table(datas1);

      var oasis_comments = response.oasisqc.oasis_comments;
      var coder_oasis_comments = response.oasis.oasis_codercomment;
      OasisCmd(oasis_comments,coder_oasis_comments);
      console.log("oasis ",coder_oasis_comments);

      // POC
      var datas2 = response.Pocsegementqc.data;
      poc_Table(datas2);

      var qc_poc_comments = response.Pocsegementqc.qc_poc_comments;
       var coder_poc_comments = response.Pocsegement.coder_poccomment;
      pocCmd(qc_poc_comments,coder_poc_comments);

      // var qc_Notes_to_agency =response.Main_Data.qc_Notes_to_agency;
      // notes(qc_Notes_to_agency);
    },
    error: function (response) {
      console.error(response);
      // Display error to the user
    },
  });

  // personal Details

  function main_Table(main) {
    var $tableBody = $("#main-table tbody");
    $tableBody.empty();

    if (!Array.isArray(main) || main.length === 0) {
      $("#no-data-message-table").show();
    } else {
      $("#no-data-message-table").hide();

      main.forEach(function (data) {
        $tableBody.append(
          "<tr><td style='border: 1px solid black; white-space: pre-wrap;' >" +
            data.patient_name +
            "</td><td style='border: 1px solid black; white-space: pre-wrap;'>" +
            data.mrn +
            "</td><td style='border: 1px solid black; white-space: pre-wrap;'>" +
            data.agency +
            "</td><td style='border: 1px solid black; white-space: pre-wrap;'>" +
            data.insurance_type +
            "</td><td style='border: 1px solid black; white-space: pre-wrap;'>" +
            data.assesment_date +
            "</td><td style='border: 1px solid black; white-space: pre-wrap;'>" +
            data.assesment_type +
            "</td><td style='border: 1px solid black; white-space: pre-wrap;word-break: auto;word-spacing: normal;overflow: auto;overflow-x: auto; max-width: 100px;width: 30%;'>" +
            data.qc_person +
            "</td></tr>"
        );
      });
    }
  }

  // Codesegementqc

  function Codesegementqc_Table(datas) {
    var $tableBody = $("#Codnig-table tbody:first");
    $tableBody.empty();

    if (!Array.isArray(datas) || datas.length === 0) {
      $("#Codnig-nodata-table tr").show();
      console.log("empty");
      return;
    } else {
      console.log("there");

      $("#Codnig-nodata-table tr").hide();

      datas.forEach(function (data) {
        var errorReason = data.Reason !== "None" ? data.Reason : "";
        var errorType = data.Errortype !== "None" ? data.Errortype : "";

        // Check if errorReason and/or errorType have data to decide on highlighting
        var shouldHighlight = errorReason !== "" || errorType !== "";

        if (data.Errortype == "Deleted") {
          var rowClass = shouldHighlight ? "red-row" : "";
        } else if (data.Errortype == "Modified") {
          var rowClass = shouldHighlight ? "yellow-row" : "";
        } else if (data.Errortype == "Added") {
          var rowClass = shouldHighlight ? "green-row" : "";
        }

        const defaultMItem = [
          "M1021A",
          "M1023B",
          "M1023C",
          "M1023D",
          "M1023E",
          "M1023F",
          "M1023G",
          "M1023H",
          "M1023I",
          "M1023J",
          "M1023K",
          "M1023L",
          "M1023M",
          "M1023N",
          "M1023O",
          "M1023P",
          "M1023Q",
          "M1023R",
          "M1023S",
          "M1023T",
          "M1023U",
          "M1023V",
          "M1023W",
          "M1023X",
          "M1023Y",
        ];

        // Function to check if MItem should be displayed
        function shouldDisplayMItem(mItem) {
          return defaultMItem.includes(mItem);
        }

        // Append row to table
        $tableBody.append(
          "<tr class='" +
            rowClass +
            "'>" +
            (shouldDisplayMItem(data.MItems)
              ? "<td style='border: 1px solid black; white-space: pre-wrap;text-transform: uppercase;'>" +
                data.MItems +
                "</td>"
              : "<td style='border: 1px solid black; white-space: pre-wrap;text-transform: uppercase;'></td>") +
            "<td style='border: 1px solid black; white-space: pre-wrap;text-transform:uppercase;'>" +
            data.Icd +
            "</td>" +
            "<td style='border: 1px solid black; white-space: pre-wrap;text-transform: uppercase;'>" +
            data.Description +
            "</td>" +
            "<td style='border: 1px solid black; white-space: pre-wrap;text-transform: uppercase;'>" +
            data.Effective_Date +
            "</td>" +
            "<td style='border: 1px solid black; white-space: pre-wrap;text-transform: uppercase;'>" +
            data.Eo +
            "</td>" +
            "<td style='border: 1px solid black; white-space: pre-wrap;text-transform: uppercase;'>" +
            data.Rating +
            "</td>" +
            "<td style='border: 1px solid black; white-space: pre-wrap;text-transform: uppercase;'>" +
            errorReason +
            "</td>" +
            "<td style='border: 1px solid black; white-space: pre-wrap;text-transform: uppercase;'>" +
            errorType +
            "</td>" +
            "<td style='border: 1px solid black; white-space: pre-wrap;text-transform: uppercase; word-break: auto; word-spacing: normal; overflow-x: auto; max-width: 200px;'>" +
            data.Qcrationaile +
            "</td>" +
            "</tr>"
        );
      });
    }
  }

// conding comments
function CodingCmd(coding_cmd, coder_comment) {
    var $tableBody = $("#Codnig-cmd tbody:first");
    $tableBody.empty(); // Clear existing data

    function appendComment(comment, coder_comment) {
        $tableBody.append(
            "<tr><td style='border: 1px solid black; white-space: pre-wrap;'>" +
            coder_comment +
            "</td><td style='border: 1px solid black; white-space: pre-wrap;'>" +
            comment +
            "</td></tr>"
        );
    }

    if (Array.isArray(coding_cmd)) {
        // Handle array of comments
        if (coding_cmd.length === 0) {
            $("#Codnig-no-comments").show();
        } else {
            $("#Codnig-no-comments").hide();
            coding_cmd.forEach(function (comment, index) {
                appendComment(comment, coder_comment[index]); // Pass coder_comment[index] for each comment
            });
        }
    } else if (coding_cmd) {
        // Handle single comment
        $("#Codnig-no-comments").hide();
        appendComment(coding_cmd, coder_comment);
    } else {
        // Handle no comments
        $("#Codnig-no-comments").show();
    }
}


  // Oasis

  function oasisqc_Table(datas1) {
    var $tableBody = $("#oasisqc-table tbody:first");
    $tableBody.empty();

    if (!Array.isArray(datas1) || datas1.length === 0) {
      $("#oasis-nodata-table tr").show();
    } else {
      $("#oasis-nodata-table tr").hide();

      datas1.forEach(function (data) {
        var errorReason = data.Error_reason !== "None" ? data.Error_reason : "";
        var errorType = data.Error_type !== "None" ? data.Error_type : "";

        // Check if errorReason and/or errorType have data to decide on highlighting
        var shouldHighlight = errorReason !== "" || errorType !== "";

        if (data.Error_type == "Deleted") {
          var rowClass = shouldHighlight ? "red-row" : "";
        } else if (data.Error_type == "Modified") {
          var rowClass = shouldHighlight ? "yellow-row" : "";
        } else if (data.Error_type == "Added") {
          var rowClass = shouldHighlight ? "green-row" : "";
        }



        $tableBody.append(
          "<tr class='" +
            rowClass +
            "'><td style='border: 1px solid black; white-space: pre-wrap;word-wrap: break-word;text-transform: uppercase;'>" +
            data.M_item +
            "</td><td style='border: 1px solid black; white-space: pre-wrap;word-wrap: break-word;text-transform: uppercase;'>" +
            data.Agency_response +
            "</td><td style='border: 1px solid black; white-space: pre-wrap;word-wrap: break-word;text-transform: uppercase;'>" +
            data.Coder_response +
            "</td><td style='border: 1px solid black; white-space: pre-wrap;word-wrap: break-word;text-transform: uppercase;'>" +
            data.Qc_response +
            "</td><td style='border: 1px solid black; white-space: pre-wrap;word-wrap: break-word;text-transform: uppercase;'>" +
            data.Coder_rationali +
            "</td><td style='border: 1px solid black; white-space: pre-wrap;word-wrap: break-word;text-transform: uppercase;'>" +
            data.Error_reason +
            "</td><td style='border: 1px solid black; white-space: pre-wrap;word-wrap: break-word;text-transform: uppercase;'>" +
            data.Error_type +
            "</td><td style='border: 1px solid black; white-space: pre-wrap;word-wrap: break-word;text-transform: uppercase;'>" +
            data.Qc_rationali +
            "</td></tr>"
        );
      });
    }
  }

  // Oasis comments

  function OasisCmd(oasis_comments,coder_oasis_comments) {
    var $tableBody = $("#oasisqc-cmd tbody:first");
    $tableBody.empty(); // Clear existing data

    function appendComment(comment,coder_oasis_comments) {
      $tableBody.append(
        "<tr><td style='border: 1px solid black; white-space: pre-wrap;'>" +
          coder_oasis_comments +
          "</td><td style='border: 1px solid black; white-space: pre-wrap;'>" +
          comment +
          "</td></tr>"
      );
    }

    if (Array.isArray(oasis_comments)) {
      // Handle array of comments
      if (oasis_comments.length === 0) {
        $("#oasis-no-comments").show();
      } else {
        $("#oasis-no-comments").hide();
       
        oasis_comments.forEach(function (comment, index) {
                appendComment(comment, coder_oasis_comments[index]); // Pass coder_comment[index] for each comment
            });
      }
    } else if (oasis_comments) {
      // Handle single comment
      $("#oasis-no-comments").hide();
      appendComment(oasis_comments,coder_oasis_comments);
    } else {
      // Handle no comments
      $("#oasis-no-comments").show();
    }
  }

  // POC

  function poc_Table(datas2) {
    var $tableBody = $("#poc-table tbody:first");
    $tableBody.empty();

    if (!Array.isArray(datas2) || datas2.length === 0) {
      $("#poc-nodata-table tr").show();
    } else {
      $("#poc-nodata-table tr").hide();

      datas2.forEach(function (data) {
        var errorReason = data.Error_reason !== "None" ? data.Error_reason : "";
        var errorType = data.Error_type !== "None" ? data.Error_type : "";

        // Check if errorReason and/or errorType have data to decide on highlighting
        var shouldHighlight = errorReason !== "" || errorType !== "";

        if (data.Error_type == "Deleted") {
          var rowClass = shouldHighlight ? "red-row" : "";
        } else if (data.Error_type == "Modified") {
          var rowClass = shouldHighlight ? "yellow-row" : "";
        } else if (data.Error_type == "Added") {
          var rowClass = shouldHighlight ? "green-row" : "";
        }


        $tableBody.append(
          "<tr class='" +
            rowClass +
            "'><td style='border: 1px solid black; white-space: pre-wrap;text-transform: uppercase;'>" +
            data.Poc_item +
            "</td><td style='border: 1px solid black; white-space: pre-wrap;text-transform: uppercase;'>" +
            data.Poc_coder_response +
            "</td><td style='border: 1px solid black; white-space: pre-wrap;text-transform: uppercase;'>" +
            data.Poc_qc_response +
            "</td><td style='border: 1px solid black; white-space: pre-wrap;text-transform: uppercase;word-break: auto; word-spacing: normal; overflow-x: auto; max-width: 200px;'>" +
            data.Error_reason +
            "</td><td style='border: 1px solid black; white-space: pre-wrap;text-transform: uppercase;'>" +
            data.Error_type +
            "</td><td style='border: 1px solid black; white-space: pre-wrap;text-transform: uppercase;word-break: auto; word-spacing: normal; overflow-x: auto; max-width: 200px;'>" +
            data.Qc_rationali +
            "</td></td>"
        );
      });
    }
  }

    // POC Comments

  function pocCmd(qc_poc_comments, coder_poc_comments) {
    var $tableBody = $("#poc-cmd tbody:first");
    $tableBody.empty(); // Clear existing data

    function appendComment(comment, coder_poc_comments) {
        $tableBody.append(
            "<tr><td style='border: 1px solid black; white-space: pre-wrap;'>" +
            coder_poc_comments +
            "</td><td style='border: 1px solid black; white-space: pre-wrap;'>" +
            comment +
            "</td></tr>"
        );
    }

    if (Array.isArray(qc_poc_comments)) {
        // Handle array of comments
        if (qc_poc_comments.length === 0) {
            $("#poc-no-comments").show();
        } else {
            $("#poc-no-comments").hide();
            qc_poc_comments.forEach(function(comment, index) {
                appendComment(comment, coder_poc_comments[index]); // Pass coder_poc_comments[index] for each comment
            });
        }
    } else if (qc_poc_comments) {
        // Handle single comment
        $("#poc-no-comments").hide();
        appendComment(qc_poc_comments, coder_poc_comments);
    } else {
        // Handle no comments
        $("#poc-no-comments").show();
    }
}





  //Notes To Agency
//   function notes(qc_Notes_to_agency) {
//     var $tableBody = $("#notestoagency tbody:first");
//     $tableBody.empty(); // Clear existing data

//     function appendComment(Notes_to_agency) {
//       console.log(qc_Notes_to_agency)
//         $tableBody.append(
//             "<tr><td style='border: 1px solid black; white-space: pre-wrap;'>" +
//             Notes_to_agency +
//             "</td></tr>"
//         );
//     }

//     if (Array.isArray(qc_Notes_to_agency)) {
//         // Handle array of comments
//         if (qc_Notes_to_agency.length === 0) {
//             $("#notestoagency").show();
//         } else {
//             $("#notestoagency").hide();
//             qc_Notes_to_agency.forEach(appendComment);
//         }
//     } else if (qc_Notes_to_agency) {
//         // Handle single comment
//         $("#notestoagency").hide();
//         appendComment(qc_Notes_to_agency);
//     } else {
//         // Handle no comments
//         $("#notestoagency").show();
//     }
// }

});
