// $(document).ready(function () {
//   $("#newpoc").on("click", function () {
//     // Alert for debugging purposes
//     alert("hi");

//     $.ajax({
//       type: "GET",
//       url: "Adminpanel/addnewpoc.php",
//       dataType: "json",
//       success: function (response) {
//         console.log(response);
//         // Assuming response is an array of checkbox values
//         const numberOfItemsWithData = response.length;

//         for (let i = 0; i < numberOfItemsWithData; i++) {
//           const { pocitems } = response[i];
//           const fields = JSON.parse(response[i].pocjson);
//           const cardHeaderText = `${pocitems}`;

//           console.log(cardHeaderText);
//           console.log(fields);

//           // Clear existing checkboxes before adding new ones
//           $("#checkboxContainer").empty();

//           // Add checkboxes dynamically based on the fields data
//           // Add checkboxes dynamically based on the fields data


//             // Append a checkbox to the container
//             $("#modalpocjsonbody").append(`
//         <div class="form-check">
//         <input type="checkbox" class="form-check-input" value="${fields}" id="checkbox${i}">
//             <label class="form-check-label" for="checkbox">${cardHeaderText}</label>
            
//         </div>
//     `);

//           // Set modal title
//           $("#Pocjson").on("show.bs.modal", function () {
//             $(".modal-title").text();
//           });

//           // Show the Bootstrap modal
//           $("#Pocjson").modal("show");
//         }
//       },
//       error: function (xhr, status, error) {
//         console.error("AJAX request failed:", status, error);
//       },
//     });
//   });
// });



$(document).ready(function () {
  $("#newpoc").on("click", function () {
    modalData();
  });

  function modalData() {
    $.ajax({
      type: "GET",
      url: "Adminpanel/addnewpoc.php",
      dataType: "json",
      success: function (response) {
        // console.log("AJAX response:", response);

        $("#modalpocjsonbody").empty();
        $("#modalTableBody").empty();

        // Declare variables outside the loop
        let table = "<div class='table-responsive'><table class='table table-striped' id='table-ta'>";
        table += "<thead><tr class='center'>";
        table += "<th>S.No</th><th>Card Header</th><th>Check Box</th>";
        table += "</tr></thead><tbody>";
        var serialNumber=0;
        response.forEach(function (item) {
          const  {pocitems,pocjson}  = item;

      
          const fields = JSON.parse(pocjson);
          console.log(pocitems);
          const cardHeaderText = `${pocitems}`;
          serialNumber++;
          table += "<tr>";
          table += "<td>" + serialNumber + "</td>";
          table += "<td>" + cardHeaderText + "</td>";
          table += '<td><div class="checkbox-wrapper-12"><div class="cbx">';
          table += '<input type="checkbox" id="cbx-' + pocitems + '" value="' + fields + '">';
          table += '<label for="cbx-' + pocitems + '"></label>';
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

  function showModal(table) {
    $("#Pocjson").modal({
      backdrop: 'static',
      keyboard: false
    });

    $('#Pocjson .modal-body').html(table);
    $('#Pocjson').modal('show');
  }
});

