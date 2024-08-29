function createFormElements(fields, cardHeader,contentData) {
  // oasisqcReasondata();
  let formHtml = "";
  formHtml += '<form method="post" class="mt-4 oasis_form" id="myForm">';

  formHtml +=
    '<input type="hidden" class="mitem-input" data-mitem="' +
    cardHeader +
    '" name="mitem" value="' +
    cardHeader +
    '">';

  formHtml += '<div class="form-row">';

  let currentIndex = 1;

  for (let j = 0; j < fields.length; j++) {
    formHtml += '<div class="form-group col formclas">';

    switch (fields[j].type) {
      case "input":
        // Concatenate the current index to the class value
        formHtml +=
          '<input readonly type="text"  class="form-control us-input-' +
          currentIndex +
          '" data-mitem="' +
          cardHeader +
          '" name="' +
          fields[j].name +
          '" placeholder="' +
          fields[j].placeholder +
          '"';

        if (fields[j].required) {
          formHtml += "required";
        }
        formHtml += ' style="text-transform: uppercase">';
        currentIndex++; // Increment the current index for the next iteration
        break;
      case "number":
        formHtml +=
          '<input readonly type="number" class="form-control us-input-' +
          currentIndex +
          '" data-mitem="' +
          cardHeader +
          '" name="' +
          fields[j].name +
          '" placeholder="' +
          fields[j].placeholder +
          '"';
        if (fields[j].required) {
          formHtml += "required";
        }
        formHtml += ">";
        currentIndex++;
        break;
      case "date":
        formHtml +=
          '<input readonly type="text" class="form-control datenew  us-input-' +
          currentIndex +
          '" data-mitem="' +
          cardHeader +
          '" name="' +
          fields[j].name +
          '" placeholder="' +
          fields[j].placeholder +
          '"';

        if (fields[j].required) {
          formHtml += "required";
        }
        formHtml += ">";
        currentIndex++;
        break;
      case "textarea":
        formHtml += '<div class="form-group">';
        // formHtml += '<label>' + fields[j].label + '</label>';
        formHtml +=
          '<textarea readonly class="form-control resizable-textarea us-input-' +
          currentIndex +
          '" data-mitem="' +
          cardHeader +
          '" name="' +
          fields[j].name +
          '" placeholder="' +
          fields[j].placeholder +
          '"';
        if (fields[j].required) {
          formHtml += "required";
        }
        formHtml += ' style="text-transform: uppercase;width: 350px;height: 201px;"></textarea>';
        formHtml += "</div>";
        currentIndex++;
        break;

      case "select":
        formHtml += '<div class="form-group">';
        // formHtml += '<label>' + fields[j].label + '</label>';
        formHtml +=
          '<select disabled style="color: black;"class="form-control us-input-' +
          currentIndex +
          '" data-mitem="' +
          cardHeader +
          '" name="' +
          fields[j].name +
          '">';

        formHtml += '<option  value="">Select</option>';
        $.each(fields[j].options, function (i, option) {
          formHtml += '<option value="' + option + '">' + option + "</option>";
        });
        formHtml += "</option>";
        formHtml += "</select>";
        formHtml += "</div>";
        currentIndex++;
        break;

      case "checkbox":
        formHtml += '<div class="form-group">';
        if (fields[j].options) {
          fields[j].options.forEach(function (option) {
            const isChecked =
              fields[j].value && fields[j].value.includes(option.value);
            formHtml +=
              '<input readonly class="us-input-' +
              currentIndex +
              '" type="checkbox" id="' +
              option.value +
              '" data-mitem="' +
              cardHeader +
              '" name="' +
              fields[j].name +
              '[]" value="' +
              option.value +
              '"';

            if (isChecked) {
              formHtml += " checked";
            }
            formHtml += ">";
            formHtml +=
              '<label for="' +
              option.value +
              '">' +
              option.label +
              "</label><br>";

            var formData = [];

            // Add values to formData whether checked or not
            if (!formData[fields[j].name]) {
              formData[fields[j].name] = []; // Initialize array if not exists
            }
            if (isChecked) {
              formData[fields[j].name].push(option.value);
            } else {
              formData[fields[j].name].push(""); // Push empty string for unchecked value
            }
          });
        }
        formHtml += "</div>";

        currentIndex++;
        break;

      case "radio":
        formHtml += '<div class="form-group">';
        // formHtml += '<label>' + fields[j].label + '</label><br>';
        if (fields[j].options) {
          fields[j].options.forEach(function (option) {
            formHtml +=
              '<input readonly  class="us-input-' +
              currentIndex +
              '" type="radio" id="' +
              option.value +
              '" data-mitem="' +
              cardHeader +
              '" name="' +
              fields[j].name +
              '[]" value="' +
              option.value +
              '"';

            if (fields[j].value && fields[j].value.includes(option.value)) {
              formHtml += " checked";
            }
            formHtml += ">";
            formHtml +=
              '<label for="' +
              option.value +
              '">' +
              option.label +
              "</label><br>";
          });
        }
        formHtml += "</div>";
        currentIndex++;
        break;

      case "select2":
        formHtml += '<div class="form-group">';
        formHtml +=
          '<select disabled class="form-control js-example-basic-multiple sty us-input-' +
          currentIndex +
          '" data-mitem="' +
          cardHeader +
          '" name="' +
          fields[j].name +
          '" multiple="multiple">';

        $.each(fields[j].options, function (i, option) {
          formHtml += '<option value="' + option + '">' + option + "</option>";
        });
        formHtml += "</select>";
        formHtml += "</div>";
        currentIndex++;
        break;

      // Add cases for other input types like textarea, select, etc.
      default:
      // Code for default case
    }

    jQuery(document).ready(function ($) {
      $(".js-example-basic-multiple").select2({
        minimumResultsForSearch: -1,
        containerCssClass: "custom-select2",
        // Add any other Select2 options you need
      });
    });

    formHtml += "</div>";
  }
  formHtml +=
    `<div class="form-group col formclas oasiserror"> <select class="form-control oasiserrorreason" id="oasiserrorreason" data-mitem="${cardHeader}" style=" color: black;"hidden>
    <option value="None">None</option>
    <option value="Missed to review the M Item">Missed to review the M Item</option>
    <option value="Incorrect OASIS changes">Incorrect OASIS changes</option>
    <option value="Missed to apply OASIS rules">Missed to apply OASIS rules</option>
    <option value="Missed to Correlate OASIS with coding">Missed to Correlate OASIS with coding</option>
    <option value="Modified Wrong M item">Modified Wrong M item</option>
    <option value="Inappropriate rationale">Inappropriate rationale</option>
    <option value="Answered SKIP M items">Answered SKIP M items</option>
    <option value="Answered Non-scope M item">Answered Non-scope M item</option>
    </select></div>`;
    formHtml += `
    <div class="form-group col formclas">
      <select class="form-control oasiserrortype" id="oasiserrortype" data-mitem="${cardHeader}" style="color: black;" hidden>
        <option value="None">None</option>
        <option value="Added">Added</option>
        <option value="Deleted">Deleted</option>
        <option value="Modified">Modified</option>
        <option value="Other">Other</option>
      </select>
    </div>
  `;
  
  formHtml +=
    '<div class="form-group col formclas"><textarea class="form-control oasisqcrationaile resizable-textarea" id="oasisqcrationaile" data-mitem="' +
    cardHeader +
    '" style="text-transform: uppercase; visibility: hidden;width: 350px;height: 201px;"></textarea></div>';
  formHtml +=
    ' <button type="button" class="btn mt-2 addnewoasis"" data-mitem="' +
    cardHeader +
    '"><i class="fas fa-edit "title="close" style="color:#31029c;cursor:pointer"></i></button>';


  formHtml +=
    '<i class="fa fa-eye datashow-icon  us-input-' +
    currentIndex +
    '" id="" name="" title="" style="cursor: pointer;" data-mitem="' +
    cardHeader +
    '" data-content="' +
    contentData +
    '" data-toggle="modal" data-target="#exampleModalLong"></i>';

  formHtml += "</div>";

  

  return formHtml;
}

function handleAddNewOasis(event) {
  // Prevent default behavior of form submission
  event.preventDefault();
      var this_row = $(this).closest('.form-row').find('.us-input-1').val();
      $(this).closest('.form-row').find('.us-input-1 option[value="' + this_row + '"]').attr('selected', true);

      var this_row = $(this).closest('.form-row').find('.us-input-2').val();
      $(this).closest('.form-row').find('.us-input-2 option[value="' + this_row + '"]').attr('selected', true);

  // Get references to the clicked button and its closest form
  var $clickedButton = $(this);
  var $closestForm = $clickedButton.closest("form");

  // Disable the clicked button to prevent multiple clicks
  $clickedButton.attr("disabled", true);

  // Create a new form row div
  var $formRowDiv = $('<div class="form-row"></div>');

  // Clone form group elements with class "formclas" from the closest form
  var $formGroupDivs = $closestForm.find(".formclas").clone();

  // Modify cloned form group elements
  $formGroupDivs.find('input[type="text"]').addClass("addnewoasisdata");
  $formGroupDivs.find("textarea").addClass("addnewoasisdata");
  $formGroupDivs.find('input[type="text"].datenew').addClass("datepicker");
  $formGroupDivs.find('.us-input-4').addClass("oasisqcresponse").removeAttr('readonly').removeAttr('disabled');
  $formGroupDivs.find('.us-input-1').removeAttr('readonly').removeAttr('disabled');

  $formGroupDivs
    .find("select")
    .trigger("change")
    .addClass("addnewoasisdata")
    .css({
      color: "black",
    });
  $formGroupDivs
    .find("select.oasiserrorreason")
    .trigger("change")
    .css({
      color: "black",
    })
    .removeAttr("hidden");

  $formGroupDivs
    .find("select.oasiserrortype")
    .trigger("change")
    .css({
      color: "black",
    })
    .removeAttr("hidden");

  $formGroupDivs.find("textarea.oasisqcrationaile").val("").css({
    visibility: "visible",
  });

  $formGroupDivs.find(".select2").each(function () {
    $(this).trigger("change").addClass("addnewoasisdata");
  });
  // console.log(formGroupDivs);

  // Append cloned form group elements to the form row
  $formRowDiv.append($formGroupDivs);

  // Clone and modify the first form group with class "formclas"
  // var $formGroupDivfirst = $closestForm.find(".formclas:first").clone();

  // // Reset values, remove readonly, add classes, etc.
  // var $textInput = $formGroupDivfirst.find('input[type="text"]');
  // $textInput.val("").removeAttr("readonly").addClass("oasisqcresponse");

  // var $selectInput = $formGroupDivfirst.find("select");
  // $selectInput
  //   .val(null)
  //   .trigger("change")
  //   .removeAttr("disabled")
  //   .addClass("oasisqcresponse")
  //   .css({
  //     color: "black",
  //   });

  // $formGroupDivfirst.find(".select2").each(function () {
  //   var $select2 = $(this);
  //   $select2
  //     .val(null)
  //     .trigger("change")
  //     .removeAttr("disabled")
  //     .addClass("oasisqcresponse");
  // });

  // // Append modified first form group to the form row
  // $formRowDiv.append($formGroupDivfirst);

  // Create a remove button with click functionality
  var $removeButton = $(
    // '<td><i class="fas fa-times new-row remove_row" style="color:#ec111a;pointer"></i></td>'
    '<button class="btn mr-2"><i class="fas fa-times" title="close"style="color: #ec111a; cursor: pointer;"></i></button>'
    // '<button class="btn btn-danger mr-2" style="height: 50px; width: 100px;">X</button>'
  );
  $removeButton.on("click", function () {
    $clickedButton.attr("disabled", false);
    // Remove the closest form row when the remove button is clicked
    $(this).closest(".form-row").remove();
  });

  // Append the remove button to the form row
  $formRowDiv.append($removeButton);

  // Append the form row to the closest form
  $closestForm.append($formRowDiv);

  // Initialize datepicker functionality
  $(function () {
    var today = new Date();
    $(".datepicker").datepicker({
      maxDate: today,
      dateFormat: "mm/dd/yy",
      onSelect: function (dateText) {
        $(this).val(dateText);
      },
    });

    $(".datepicker").on("keyup", function () {
      var val = $(this).val().replace(/\D/g, "");
      if (val.length > 2) {
        $(this).val(
          val.slice(0, 2) + "/" + val.slice(2, 4) + "/" + val.slice(4, 8)
        );
      } else if (val.length > 0) {
        $(this).val(
          val.slice(0, 2) + (val.length > 2 ? "/" + val.slice(2, 4) : "")
        );
      }
    });
  });
}
// .then(function(){
//   var this_row = $(this).closest('.form-row').find('.us-input-1').val();
//   console.log(this_row);
//   $('.us-input-1.addnewoasisdata').find('option[value="' + this_row + '"]').prop('selected', true);
  

//   console.log($('.us-input-1.addnewoasisdata').html());
// });


//qcreson automatically fetch from database
// function oasisqcReasondata() {
//   $(document).ready(function () {
//     //error reason
//     $.ajax({
//       url: "QA/qc_reasonoasis.php",
//       type: "GET",
//       dataType: "json",
//       success: function (data) {
//         // console.log(data);
//         if (data) {
//           var select = $(".oasiserrorreason"); // Selecting the element by its class
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
//           var select = $(".oasiserrortype"); // Selecting the element by its class
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

//qcscoring data fetching 


//modal datacontent show 
$(document).on('click', '.datashow-icon', function() {
  // Get the title and content data from the clicked icon
  var title = $(this).data('mitem');
  var content = $(this).data('content');

  // alert(title);

  // Set the modal title and body content
  $('#titlecontent').text(title);
  $('.contentbody').html(content);

  // Show the modal (if not already triggered)
  $('#exampleModalLong').modal('show');
});


$(document).on('click', '#copyButton', function() {
  // Get the text content from the <p> tag
  var content = $('#contentToCopy').text();

  // Use the clipboard API to copy the text to the clipboard
  navigator.clipboard.writeText(content).then(function() {
      // Optional: Notify the user that the content has been copied
      // alert('Content copied to clipboard!');
  }).catch(function(err) {
      // Handle errors, if any
      console.error('Failed to copy content: ', err);
  });
});


function qcscoring(){

  const Id = $("#entryIdoasis").val();

  // alert('oasis')


  $.ajax({
    type:'post',
    url:'QA/qcscoringfetch_v2.php?action=oasisscore',
    data:{
      Id :Id 
    },

    success:function(response){

      // alert(response);


    },

    error: function (xhr, status, error) {
      console.error(xhr.responseText);
    
    },




  });


}

$(document).ready(function () {
  const Entry = $("#entryIdoasis").val();
  // AJAX call to retrieve data
  $.ajax({
    url: `Assign/page.php?action=filter&Id=${Entry}`,
    type: "GET",
    dataType: "json",
    success: function (response) {
      const numberOfItemsWithData = response.length;
      const mainCardDiv = document.createElement("div");
      mainCardDiv.classList.add(
        "card",
        "position-relative",
        "scroller",
        "col-lg-12"
      );
      const mainCardBodyDiv = document.createElement("div");
      mainCardBodyDiv.classList.add("card-body");

      for (let i = 0; i < numberOfItemsWithData; i++) {
        const { Mitem, description, Section, content} = response[i];
        const fields = JSON.parse(response[i].json);
        const cardHeaderText = `${Section} (${Mitem} - ${description})`;
        const contentData = `${content}`;
        // const carddes=`${description}`;

        const cardDiv = document.createElement("div");
        cardDiv.classList.add("card", "nested-card", "mb-2");

        const cardHeader = document.createElement("div");
        cardHeader.classList.add("card-header");
        cardHeader.textContent = cardHeaderText;
        // carddes.textContent=cardDesText;

        const cardBodyDiv = document.createElement("div");
        cardBodyDiv.classList.add("card-body");

        const formHtml = createFormElements(fields, cardHeaderText,contentData);
        cardBodyDiv.innerHTML = formHtml;

        cardDiv.appendChild(cardHeader);
        cardDiv.appendChild(cardBodyDiv);

        mainCardBodyDiv.appendChild(cardDiv);
      }

      mainCardDiv.appendChild(mainCardBodyDiv);
      // addnewRow(appendFormHtml);

      const carouselRow = document.getElementById("carouselRow");
      carouselRow.appendChild(mainCardDiv);


    $("body").on("click", ".addnewoasis", handleAddNewOasis);
      $(document).on("click", "#btn_save_oasis", function (event) {
   
        // alert();
        event.preventDefault();

        const formArray = [];

        $(".nested-card").each(function () {
          const mitemElement = $(this).find(".mitem-input").get(0);
          const mitemAttributeValue = $(mitemElement).attr("data-mitem");

          const us1Value = $(this).find(".us-input-1").val();
          const us2Value = $(this).find(".us-input-2").val();
          const us3Value = $(this).find(".us-input-3").val();
          //oasis qc data
          const new1oasisvalue = $(this)
            .find(".us-input-1.addnewoasisdata")
            .val();
          const new2oasisvalue = $(this)
            .find(".us-input-2.addnewoasisdata")
            .val();
          const new3oasisvalue = $(this)
            .find(".us-input-3.addnewoasisdata")
            .val();
          const new4oasisvalue = $(this)
            .find(".us-input-4.oasisqcresponse")
            .val();
          const oasisreason = $(this)
            .find(".oasiserrorreason.addnewoasisdata")
            .val();
          const oasiserrortype = $(this)
            .find(".oasiserrortype.addnewoasisdata")
            .val();
          const oasisqcrationaile = $(this)
            .find(".oasisqcrationaile.addnewoasisdata")
            .val();

    ;
       

          // if (us1Value && (!us2Value || !us3Value)) {
          //     $(this).append('<span class="text-danger">Please fill in all fields for this row.</span>');
          //     return false; // Exit the loop for this row
          // }
          if (us1Value!='' && us2Value!='' &&  us1Value!= null && us2Value!= null){
            $(this).find(".text-danger").remove(); // Remove error message if all fields are filled

            const formData = {
              mitemAttributeValue: mitemAttributeValue,
              us1: us1Value,
              us2: us2Value,
              us3: us3Value,
              newoasis1: new1oasisvalue,
              newoasis2: new2oasisvalue,
              newoasis3: new3oasisvalue,
              newoasis4: new4oasisvalue,
              oasisreason: oasisreason,
              oasiserrortype: oasiserrortype,
              oasisqcrationaile: oasisqcrationaile,
            };

            formArray.push(formData);
            // console.log(formData);
          } else if (new1oasisvalue || new2oasisvalue || new3oasisvalue) {
            $(this).find(".text-danger").remove(); // Remove error message if all fields are filled

            const formData = {
              mitemAttributeValue: mitemAttributeValue,
              us1: us1Value,
              us2: us2Value,
              us3: us3Value,
              newoasis1: new1oasisvalue,
              newoasis2: new2oasisvalue,
              newoasis3: new3oasisvalue,
              newoasis4: new4oasisvalue,
              oasisreason: oasisreason,
              oasiserrortype: oasiserrortype,
              oasisqcrationaile: oasisqcrationaile,
            };

            formArray.push(formData);
          }
        });

        // console.log(formArray);

        const Id = $("#entryIdoasis").val();



        $.ajax({
          url: "QA/qc_oasissegemet.php",
          type: "POST",
          data: {
            formData: formArray,
            Id: Id,
          },
          success: function (response) {
            // Log the response for debugging purposes
            var datae = JSON.parse(response);
            // console.log("HELLOOOOO",datae);



            if (datae.success) {
              // Display a success message if 'success' property is true
              Swal.fire({
                  title: "Success!",
                  text: "Data Inserted Successfully",
                  icon: "success",
                  confirmButtonText: "OK",
              }).then(function (result) {

                  if (result.isConfirmed) {
                      // alert('sajithhh');
                      $(".saved-qcoasissegement").removeAttr("hidden");
                      qcscoring();
                      fetchscore();


                  }
              });
          }
           else {
              // Display an error message if 'success' property is false
              Swal.fire({
                title: "Error",
                text: datae.error, // Display the error message from the response
                icon: "error",
                confirmButtonText: "OK",
              });
            }
          },
          error: function (jqXHR, textStatus, errorThrown) {
            console.error("Error:", errorThrown);
            // Handle error response
          },
        });
      });
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("Error:", errorThrown);
    },
  }).then(function(){


});

});
