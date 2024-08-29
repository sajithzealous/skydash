// Function to create the form HTML
function createForm(fields, cardHeader) {
  // pocqcReasondata();
  let formHtml = `<form method="post" class="mt-4" id="myForm">
    <input type="hidden" class="pocitem-input" id="pocitem-input" data-pocitem="${cardHeader}" name="pocitem" value="${cardHeader}">
    <div class="form-row">`;

  let currentIndex = 1;

  fields.forEach((field) => {
    formHtml += `<div class="form-group col formclas">`;

    switch (field.type) {
      case "textarea":
        formHtml += `<div class="form-group">
          <textarea readonly class="form-control resizable-textarea us-inpu-${currentIndex}" data-pocitem="${cardHeader}" name="${
          field.name
        }" placeholder="${field.placeholder}" ${
          field.required ? "required" : ""
        } ' style="text-transform: uppercase"></textarea>
        </div>`;
        currentIndex++;
        break;
      case "date":
        formHtml += `<input readonly type="text" class="form-control us-inpu-${currentIndex}" data-pocitem="${cardHeader}" name="${
          field.name
        }" placeholder="${field.placeholder}" ${
          field.required ? "required" : ""
        }">`;
        currentIndex++;
        break;
      // Add cases for other input types like select, etc.
      default:
      // Code for default case
    }

     

    formHtml += `</div>`;
  });
  formHtml +=
    `<div class="form-group col formclas qcpocerrorreason"> <select class="form-control pocerrorreason" id="pocerrorreason" data-mitem='${cardHeader}'" style="color: black"hidden>
    <option value="None">None</option>
    <option value="Missed to review the POC section">Missed to review the POC section</option>
    <option value="Missed to apply POC guidelines">Missed to apply POC guidelines</option>
    <option value="Missed to correlate POC with Coding">Missed to correlate POC with Coding</option>
    <option value="Missed to Compare OASIS with POC">Missed to Compare OASIS with POC</option>
    <option value="Missed Goals">Missed Goals</option>
    <option value="Missed Interventions">Missed Interventions</option>
    </select></div>`;
  formHtml +=
    `<div class="form-group col formclas qcpocerrortype"><select class="form-control pocerrortype" id="pocerrortype" data-mitem="${cardHeader}" style="color: black" hidden>
    <option value="None">None</option>
    <option value="Added">Added</option>
    <option value="Deleted">Deleted</option>
    <option value="Modified">Modified</option>
    <option value="Other">Other</option>
    </select></div>`;
  formHtml +=
    `<div class="form-group col formclas"><textarea class="form-control pocqcrationaile  resizable-textarea" id="pocqcrationaile" data-mitem="${cardHeader}" style="text-transform: uppercase;height:230px;width:500px ;visibility: hidden;"></textarea></div>`;

  formHtml += `<button type="button" class="btn mt-2 addnewpoc" data-mitem="${cardHeader}"><i class="fas fa-edit "title="Add"style="color:#31029c;cursor:pointer"></i></button></div></form> `;

  return formHtml;
}

// Function to handle form addition on button click
function handleAddNewPoc(event) {
  event.preventDefault();
  var $clickedButton = $(this);
  var $closestForm = $clickedButton.closest("form");
  $clickedButton.attr("disabled", true);

  var $formRowDiv = $('<div class="form-row"></div>');
  var $formGroupDivs = $closestForm.find(".formclas").clone();
  // Remove readonly attribute and set empty value for textareas
  $formGroupDivs
    .find('input[type="text"], textarea')
    .prop("readonly", false)
    .addClass("inputpoc");
  $formRowDiv.append($formGroupDivs);

  // var $selectOption = $('<div class="form-group col formclas"> <select class="form-control pocerrorreason" id="pocerrorreason"></select></div>');
  // $formRowDiv.append($selectOption);

  // var $selectOption2 = $('<div class="form-group col formclas"><select class="form-control pocerrortype" id="pocerrortype"></select></div>');
  // $formRowDiv.append($selectOption2);

  // var $qcrationaile=$('<div class="form-group col formclas"><textarea class="form-control pocqcrationaile" id="pocqcrationaile"  style="text-transform: uppercase"></textarea></div>')
  // $formRowDiv.append($qcrationaile);

  $formGroupDivs
    .find("select.pocerrorreason")
    .val(null)
    .trigger("change")
    .css({
      color: "black",
    })
    .removeAttr("hidden")
    .addClass("inputpoc");

  $formGroupDivs
    .find("select.pocerrortype")
    .val(null)
    .trigger("change")
    .css({
      color: "black",
    })
    .removeAttr("hidden")
    .addClass("inputpoc");

  $formGroupDivs.find("textarea.pocqcrationaile").css({
    visibility: "visible",
  });

  var $removeButton = $(
      '<button class="btn mr-2"><i class="fas fa-times " title="close"style="color: #ec111a; cursor: pointer;"></i></button>'
  );
  $removeButton.on("click", function () {
    $clickedButton.attr("disabled", false);
    $(this).closest(".form-row").remove();
  });
  $formRowDiv.append($removeButton);
  $closestForm.append($formRowDiv);

  //datepicker function for clone input

  // $(function () {
  //   // Function to initialize datepicker
  //   function initializeDatepicker() {
  //     var today = new Date();
  //     $(".datepicker").datepicker({
  //       maxDate: today,
  //       dateFormat: "mm/dd/yy",
  //       onSelect: function (dateText) {
  //         $(this).val(dateText);
  //       },
  //     });
  //   }

  //   // Function to format input while typing
  //   $(".datepicker").on("input", function () {
  //     var val = $(this).val().replace(/\D/g, "");

  //     if (val.length >= 2 && val.length < 4) {
  //       $(this).val(val.slice(0, 2) + "/" + val.slice(2));
  //     } else if (val.length >= 4 && val.length < 6) {
  //       $(this).val(
  //         val.slice(0, 2) + "/" + val.slice(2, 4) + "/" + val.slice(4)
  //       );
  //     } else if (val.length > 6) {
  //       $(this).val(
  //         val.slice(0, 2) + "/" + val.slice(2, 4) + "/" + val.slice(4, 8)
  //       );
  //     }
  //   });

  //   // Call the datepicker initialization function
  //   initializeDatepicker();
  // });
}

//qcreson automatically fetch from database
// function pocqcReasondata() {
//   $(document).ready(function () {
//     //error reason
//     $.ajax({
//       url: "QA/qc_reasonpoc.php",
//       type: "GET",
//       dataType: "json",
//       success: function (data) {
//         // console.log(data);
//         if (data) {
//           var select = $(".pocerrorreason"); // Selecting the element by its class
//           select.empty(); // Clearing any existing options

//           // Loop through the data array and create options
//           data.forEach(function (option) {
//             var optionElement = $("<option>", {
//               value: option,
//               text: option,
//               // // Mark selected based on some condition, modify this condition accordingly
//               // selected: (item && item.Reason === option) // Check if item.Reason matches
//             });
//             select.append(optionElement); // Append the option to the select element
//           });
//         } else {
//           $("#result").text("No data received or invalid format");
//         }
//       },
//       error: function (xhr, status, error) {
//         console.error(xhr.responseText);
//         $("#result").text("Error occurred while fetching data");
//       },
//     });

//     //error type
//     $.ajax({
//       url: "QA/qc_errortype.php",
//       type: "GET",
//       dataType: "json",
//       success: function (data) {
//         // console.log(data);
//         if (data) {
//           var select = $(".pocerrortype"); // Selecting the element by its class
//           select.empty(); // Clearing any existing options

//           // Loop through the data array and create options
//           data.forEach(function (option) {
//             var optionElement = $("<option>", {
//               value: option,
//               text: option,
//               // // Mark selected based on some condition, modify this condition accordingly
//               // selected: (item && item.Reason === option) // Check if item.Reason matches
//             });
//             select.append(optionElement); // Append the option to the select element
//           });
//         } else {
//           $("#result").text("No data received or invalid format");
//         }
//       },
//       error: function (xhr, status, error) {
//         console.error(xhr.responseText);
//         $("#result").text("Error occurred while fetching data");
//       },
//     });
//   });
// }

//qcscoring poc segement

function pocscoring() {
  const Id = $("#poc").val();

  // alert(Id);

  $.ajax({
    type: "post",
    url: "QA/qcscoringfetch_v2.php?action=pocscore",
    data: {
      Id: Id,
    },

    success: function (response) {
      console.log(response);
    },

    error: function (xhr, status, error) {
      console.error(xhr.responseText);
    },
  });
}

$(document).ready(function () {
  const Entry = $("#poc").val();

  //

  $.ajax({
    url: "Assign/pocdynamic_page.php?action=filter&Id=" + Entry,
    type: "GET",
    dataType: "json",
    success: function (response) {
      const mainCardDiv = document.createElement("div");
      mainCardDiv.classList.add(
        "card",
        "position-relative",
        "scroller",
        "col-lg-12"
      );
      const mainCardBodyDiv = document.createElement("div");
      mainCardBodyDiv.classList.add("card-body");

      for (let i = 0; i < response.length; i++) {
        const { pocitems } = response[i];
        const fields = JSON.parse(response[i].pocjson);
        const cardHeaderText = `${pocitems}`;

        const cardDiv = document.createElement("div");
        cardDiv.classList.add("card", "nested-card", "mb-2");

        const cardHeader = document.createElement("div");
        cardHeader.classList.add("card-header");
        cardHeader.textContent = cardHeaderText;

        const cardBodyDiv = document.createElement("div");
        cardBodyDiv.classList.add("card-body");

        const formHtml = createForm(fields, cardHeaderText);
        cardBodyDiv.innerHTML = formHtml;

        cardDiv.appendChild(cardHeader);
        cardDiv.appendChild(cardBodyDiv);

        mainCardBodyDiv.appendChild(cardDiv);
      }

      mainCardDiv.appendChild(mainCardBodyDiv);

      const carouselRow = document.getElementById("pocsegementRow");
      carouselRow.appendChild(mainCardDiv);

      $("body").on("click", ".addnewpoc", handleAddNewPoc);

      $(document).on("click", "#btn_save_poc", function (event) {
        event.preventDefault();
        const formArray = [];

        $(".nested-card").each(function () {
          const pocitemAttributeValue = $(this)
            .find(".pocitem-input")
            .attr("data-pocitem");
          const us1Value = $(this).find(".us-inpu-1").val();
          const usValue = $(this).find(".inputpoc").val(); //qc changed data...
          const pocreason = $(this).find(".pocerrorreason.inputpoc").val();
          const pocerrortype = $(this).find(".pocerrortype.inputpoc").val();
          const pocqcrationaile = $(this)
            .find(".pocqcrationaile.inputpoc")
            .val();

          const formData = {
            pocitemAttributeValue: pocitemAttributeValue,
            us1: us1Value,
            usVal: usValue,
            pocreason: pocreason,
            pocerrortype: pocerrortype,
            pocqcrationaile: pocqcrationaile,
          };

          if (!(pocitemAttributeValue && (us1Value || usValue))) {
            // console.log("Incomplete data, skipping push for this element.");
            return true;
          }

          formArray.push(formData);
        });

        console.log(formArray);

        const Id = $("#poc").val();

        $.ajax({
          url: "QA/qc_pocsegement.php",
          type: "POST",
          data: {
            formDataArray: formArray,
            Id: Id,
          },
          success: function (response) {
            console.log(response);

            var responses = response.split("}{");

            // Correct the format by adding missing curly braces
            responses = responses.map(function (jsonString) {
              return JSON.parse(
                (jsonString[0] === "{" ? "" : "{") +
                  jsonString +
                  (jsonString.slice(-1) === "}" ? "" : "}")
              );
            });

            var successMessage = "";
            var errorMessage = "";

            var anySuccess = responses.some(function (res) {
              if (res.success) {
                successMessage = res.message;
                return true; // Stop iterating once a successful response is found
              } else {
                errorMessage = res.message;
                // Continue iterating through the responses
                return false;
              }
            });

            if (anySuccess) {
              Swal.fire({
                  title: "Success!",
                  text: successMessage,
                  icon: "success",
                  confirmButtonText: "OK",
              }).then(function () {
                  // Additional actions after the success message is closed
                  $(".saved-qcpocsegement").removeAttr("hidden");
                  pocscoring();
                  fetchscore();

              });
          } else {
              // Display the error message if none of the responses have 'success' property
              Swal.fire({
                title: "Error",
                text: "Please enter valid data",
                icon: "error",
                confirmButtonText: "OK",
              });
            }
          },

          error: function (jqXHR, textStatus, errorThrown) {
            console.error("Error:", errorThrown);
          },
        });
      });
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("Error:", errorThrown);
    },
  });
});
