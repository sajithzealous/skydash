$(document).ready(function () {
  $.ajax({
    type: "GET",
    url: "Assign/final_preview_process.php",
    data: {},
    dataType: "json",
    success: function (response) {
      console.log("checj",response.oasisqc);
      //  personal Details
      var main = response.personal_details.data;
      main_Table(main);

      // Codesegementqc
      var datas = response.Codesegementqc.data;
      Codesegementqc_Table(datas);
      console.log('john',datas);

      var coding_cmd = response.Codesegementqc.coding_comments;
      CodingCmd(coding_cmd);

     
 var datas1 = response.oasisqc.data;

 console.log("datas1",datas1);
  var table = $("#oasisqc-table-body");

  // Clear existing content in the table (optional)
  table.empty();

  // Check if there is data to display
  if (datas1.length > 0) {
    // Loop through the data and append rows to the table
    $.each(datas1, function(index, data) {
      // Append a new row to the table body
      table.append('<tr><td>' + data['M_item'] + '</td><td>' + data['Agency_response'] + '</td><td>' + data['Qc_response'] + '</td><td>' + data['Coder_rationali'] + '</td></tr>');
    });
  } else {
    // If there is no data, display a message
    table.append('<tr><td colspan="4">No data available</td></tr>');
  }

      var oasis_comments = response.oasisqc.oasis_comments;
      OasisCmd(oasis_comments);

      // POC
      var datas2 = response.Pocsegementqc.data;
      poc_Table(datas2);

      var poc_comments = response.Pocsegementqc.poc_comments;
      pocCmd(poc_comments);
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
            data.alloted_to_coder +
            "</td></tr>"
        );
      });
    }
  }

  // Codesegementqc

//  function Codesegementqc_Table(datas) {
//     var $tableBody = $("#Codnig-table tbody:first");
//     $tableBody.empty();

//     if (!Array.isArray(datas) || datas.length === 0) {
//         $("#Codnig-nodata-table tr").show();
//         return;
//     } else {
//         $("#Codnig-nodata-table tr").hide();

//         const defaultMItem = [
//             "M1021A", "M1023B", "M1023C", "M1023D", "M1023E", "M1023F", "M1023G",
//             "M1023H", "M1023I", "M1023J", "M1023K", "M1023L", "M1023M", "M1023N",
//             "M1023O", "M1023P", "M1023Q", "M1023R", "M1023S", "M1023T", "M1023U",
//             "M1023V", "M1023W", "M1023X", "M1023Y"
//         ];

//         datas.forEach(function (data, index) {
//             var rowClass = "";
//             var mItem = defaultMItem[index] || ''; // Get the corresponding default MItem

//           if (mItem && mItem === data.MItems) {
//     $tableBody.append(
//         "<tr class='" + rowClass + "'>" +
//         "<td style='border: 1px solid black; white-space: pre-wrap; text-transform: uppercase'>" + mItem + "</td>" +
//         "<td style='border: 1px solid black; white-space: pre-wrap;text-transform:uppercase;'>" + data.Icd + "</td>" +
//         "<td style='border: 1px solid black; white-space: pre-wrap;'>" + data.Description + "</td>" +
//         "<td style='border: 1px solid black; white-space: pre-wrap;'>" + data.Effective_Date + "</td>" +
//         "<td style='border: 1px solid black; white-space: pre-wrap;'>" + data.Eo + "</td>" +
//         "<td style='border: 1px solid black; white-space: pre-wrap;'>" + (data.Icd.startsWith('Z') ? '' : data.Rating) + "</td>" +
//         "</tr>"
//     );
// } else {
//     $tableBody.append(
//         "<tr class='" + rowClass + "'>" +
//         "<td style='border: 1px solid black; white-space: pre-wrap;'></td>" + // Empty cell
//         "<td style='border: 1px solid black; white-space: pre-wrap;text-transform:uppercase;'>" + data.Icd + "</td>" +
//         "<td style='border: 1px solid black; white-space: pre-wrap;'>" + data.Description + "</td>" +
//         "<td style='border: 1px solid black; white-space: pre-wrap;'>" + data.Effective_Date + "</td>" +
//         "<td style='border: 1px solid black; white-space: pre-wrap;'>" + data.Eo + "</td>" +
//         "<td style='border: 1px solid black; white-space: pre-wrap;'>" + (data.Icd.startsWith('Z') ? '' : data.Rating) + "</td>" +
//         "</tr>"
//     );
// }

//         });
//     }
// }
function Codesegementqc_Table(datas) {
  var $tableBody = $("#Codnig-table tbody:first");
  $tableBody.empty();

  if (!Array.isArray(datas) || datas.length === 0) {
    $("#Codnig-nodata-table tr").show();
    // console.log("empty");
    return;
  } else {
    // console.log("there");
    $("#Codnig-nodata-table tr").hide();

    const defaultMItem = [
      "M1021A", "M1023B", "M1023C", "M1023D", "M1023E", "M1023F", "M1023G",
      "M1023H", "M1023I", "M1023J", "M1023K", "M1023L", "M1023M", "M1023N",
      "M1023O", "M1023P", "M1023Q", "M1023R", "M1023S", "M1023T", "M1023U",
      "M1023V", "M1023W", "M1023X", "M1023Y"
    ];

   datas.forEach(function (data, index) {
  var rowClass = "";
  var mItem = "";

  if (index <=25) {
    mItem = defaultMItem[index] || ""; // Use defaultMItem if available
  }

  // Append row to table
  $tableBody.append(
    "<tr class='" + rowClass + "'>" +
    "<td style='border: 1px solid black; white-space: pre-wrap;'>" + mItem + "</td>" +
    "<td style='border: 1px solid black; white-space: pre-wrap;text-transform: uppercase'>" + data.Icd + "</td>" +
    "<td style='border: 1px solid black; white-space: pre-wrap;'>" + data.Description + "</td>" +
    "<td style='border: 1px solid black; white-space: pre-wrap;'>" + data.Effective_Date + "</td>" +
    "<td style='border: 1px solid black; white-space: pre-wrap;'>" + data.Eo + "</td>" +
    "<td style='border: 1px solid black; white-space: pre-wrap;'>" + (data.Icd.startsWith('Z') || data.Icd.startsWith('z') ? '' : data.Rating) + "</td></tr>"
  );
});

  }
}


  
  
  

  function CodingCmd(coding_cmd) {
    var $tableBody = $("#Codnig-cmd tbody:first");
    $tableBody.empty(); // Clear existing data

    function appendComment(comment) {
      $tableBody.append(
        "<tr><td style='border: 1px solid black; white-space: pre-wrap; word-break: auto; word-spacing: normal; overflow-x: auto; max-width: 200px;'>" +
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
        coding_cmd.forEach(appendComment);
      }
    } else if (coding_cmd) {
      // Handle single comment
      $("#Codnig-no-comments").hide();
      appendComment(coding_cmd);
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
        var rowClass = "";
 
// Assuming data is an object containing your data

if (data.Agency_response === data.Qc_response) {
    // If they are the same, create an empty row
    var emptyRow = "<tr class='" + rowClass + "'>" +
        "<td colspan='4' style='border: 1px solid black; height: 50px;'>Empty Row</td>" +
        "</tr>";

    $tableBody.append(emptyRow);
} else {
    // If they are different, append the actual data
    var rowData = "<tr class='" + rowClass + "'>" +
        "<td style='border: 1px solid black; white-space: pre-wrap;'>" + data.M_item + "</td>" +
        "<td style='border: 1px solid black; white-space: pre-wrap;'>" + data.Agency_response + "</td>" +
        "<td style='border: 1px solid black; white-space: pre-wrap;'>" + data.Qc_response + "</td>" +
        "<td style='border: 1px solid black; white-space: pre-wrap;'>" + data.Coder_rationali + "</td>" +
        "</tr>";

    $tableBody.append(rowData);
}




        

      });
    }
  }

  function OasisCmd(oasis_comments) {
    var $tableBody = $("#oasisqc-cmd tbody:first");
    $tableBody.empty(); // Clear existing data

    function appendComment(comment) {
      $tableBody.append(
        "<tr><td style='border: 1px solid black; white-space: pre-wrap; word-break: auto; word-spacing: normal; overflow-x: auto; max-width: 200px;'>" +
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
        oasis_comments.forEach(appendComment);
      }
    } else if (oasis_comments) {
      // Handle single comment
      $("#oasis-no-comments").hide();
      appendComment(oasis_comments);
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
        var rowClass = "";

        $tableBody.append(
          "<tr class='" +
            rowClass +
            "'><td style='border: 1px solid black; white-space: pre-wrap;'>" +
            data.Poc_item +
            "</td><td style='border: 1px solid black; white-space: pre-wrap;'>" +
            data.Coder_response +
            "</td></td>"
        );
      });
    }
  }
  function pocCmd(qc_poc_comments) {
    var $tableBody = $("#poc-cmd tbody:first");
    $tableBody.empty(); // Clear existing data

    function appendComment(comment) {
      $tableBody.append(
        "<tr><td style='border: 1px solid black; white-space: pre-wrap; word-break: auto; word-spacing: normal; overflow-x: auto; max-width: 200px;'>" +
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
        qc_poc_comments.forEach(appendComment);
      }
    } else if (qc_poc_comments) {
      // Handle single comment
      $("#poc-no-comments").hide();
      appendComment(qc_poc_comments);
    } else {
      // Handle no comments
      $("#poc-no-comments").show();
    }
  }
});
