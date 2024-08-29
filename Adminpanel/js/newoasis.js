$(document).ready(function () {
  $("#newoasis").on("click", function () {
    modalData();
  });

  function modalData() {
    $.ajax({
      type: "GET",
      url: "Adminpanel/addnewoasis.php",
      dataType: "json",
      success: function (response) {
        console.log("AJAX response:", response);

        $("#modaloasisjsonbody").empty();
        $("#modalTableBody").empty();

        // Declare variables outside the loop
        let table = "<div class='table-responsive'><table class='table table-striped' id='table-ta'>";
        table += "<thead><tr class='center'>";
        table += "<th>S.No</th><th>Card Header</th><th>Check Box</th>";
        table += "</tr></thead><tbody>";
        
        var serialNumber=0;
        response.forEach(function (item) {
          const { Mitem, description, Section, json } = item;
          const fields = JSON.parse(json);
          const cardHeaderText = `${Section} (${Mitem} - ${description})`;
          serialNumber++;

          table += "<tr>";
          table += "<td>" + serialNumber + "</td>";
          table += "<td>" + cardHeaderText + "</td>";
          table += '<td><div class="checkbox-wrapper-12"><div class="cbx">';
          table += '<input type="checkbox" id="cbx-' + Mitem + '" value="' + fields + '">';
          table += '<label for="cbx-' + Mitem + '"></label>';
          table += '<svg fill="none" viewBox="0 0 15 14" height="14" width="15">';
          table += '<path d="M2 8.36364L6.23077 12L13 2"></path>';
          table += '</svg></div></div></td>';
          table += "</tr>";
        });

        table += "</tbody></table></div>";

        showModal(table);
      },
      error: function (xhr, status, error) {
        console.error("AJAX request failed:", status, error);
      },
    });
  }

//   function modalData() {
//     $.ajax({
//         type: "GET",
//         url: "Adminpanel/addnewoasis.php",
//         dataType: "json",
//         success: function (response) {
//             console.log("AJAX response:", response);

//             $("#modaloasisjsonbody").empty();
//             $("#modalTableBody").empty();

//             // Declare variables outside the loop
//             let table = "<div class='table-responsive'><table class='table table-striped' id='table-ta'>";
//             table += "<thead><tr class='center'>";
//             table += "<th>S.No</th><th>Card Header</th><th>Check Box</th><th>Select Option</th>";
//             table += "</tr></thead><tbody>";

            

//             var serialNumber = 0;
//             response.forEach(function (item) {
//                 const { Mitem, description, Section, json } = item;
//                 const fields = JSON.parse(json);
//                 const cardHeaderText = `${Section} (${Mitem} - ${description})`;
//                 serialNumber++;

//                 table += "<tr>";
//                 table += "<td>" + serialNumber + "</td>";
//                 table += "<td>" + cardHeaderText + "</td>";
//                 table += '<td><div class="checkbox-wrapper-12"><div class="cbx">';
//                 table += '<input type="checkbox" class="checkbox-cbx" id="cbx-' + Mitem + '" value="' + fields + '">';
//                 table += '<label for="cbx-' + Mitem + '"></label>';
//                 table += '<svg fill="none" viewBox="0 0 15 14" height="14" width="15">';
//                 table += '<path d="M2 8.36364L6.23077 12L13 2"></path>';
//                 table += '</svg></div></div></td>';
//                 table += '<td><select class="select-option" id="select-' + Mitem + '">';
//                 // Add options dynamically from the fields
//                 fields.forEach(function (option) {
//                     table += '<option value="' + option + '">' + option + '</option>';
//                 });
//                 table += '</select></td>';
//                 table += "</tr>";
//             });

//             table += "</tbody></table></div>";

//             showModal(table);
//         },
//         error: function (xhr, status, error) {
//             console.error("AJAX request failed:", status, error);
//         },
//     });
// }


  function showModal(table) {
    $("#Oasisjson").modal({
      backdrop: 'static',
      keyboard: false
    });

    $('#Oasisjson .modal-body').html(table);
    $('#Oasisjson').modal('show');
  }
});
