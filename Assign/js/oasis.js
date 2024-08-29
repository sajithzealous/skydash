function createFormElements(fields, cardHeader, contentData) {
  console.log("cardheader", contentData);
  let formHtml = "";
  formHtml += '<form method="post" class="mt-4 " id="myForm">';

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

    // console.log(typeof fields)

    switch (fields[j].type) {
      case "input":
        // Concatenate the current index to the class value
        formHtml +=
          '<input type="text"   class="form-control us-input-' +
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
        formHtml += ' style="color: black;"';
        formHtml += " >";
        currentIndex++; // Increment the current index for the next iteration
        break;
      case "number":
        formHtml +=
          '<input type="number" class="form-control us-input-' +
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
        formHtml += ' style="color: black;"';
        formHtml += " >";
        currentIndex++;
        break;
      case "date":
        formHtml +=
          '<input type="text"  class="form-control   datepicker us-input-' +
          currentIndex +
          '  efea" data-mitem="' +
          cardHeader +
          '" name="' +
          fields[j].name +
          '" placeholder="' +
          fields[j].placeholder +
          '"';

        if (fields[j].required) {
          formHtml += "required";
        }
        formHtml += ' style="color: black;"';
        formHtml += ">";
        currentIndex++;
        break;
      case "textarea":
        formHtml += '<div class="form-group">';
        // formHtml += '<label>' + fields[j].label + '</label>';
        formHtml +=
          '<textarea id="textarea" class="form-control resizable-textarea us-input-' +
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
        //formHtml += ' style="height:150px;width:200px"';
        formHtml += ' style="width: 100%; height: 280px;color:black;"';
        formHtml += " ></textarea>";
        formHtml += "</div>";
        currentIndex++;
        break;

      case "select":
        formHtml += '<div class="form-group">';
        // formHtml += '<label>' + fields[j].label + '</label>';
        formHtml +=
          '<select class="form-control us-input-' +
          currentIndex +
          '" data-mitem="' +
          cardHeader +
          '" name="' +
          fields[j].name +
          '"  style="color: black;">';

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
              '<input class="us-input-' +
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
              '<input class="us-input-' +
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
          '<select class="form-control js-example-basic-multiple sty us-input-' +
          currentIndex +
          '" data-mitem="' +
          cardHeader +
          '" name="' +
          fields[j].name +
          '" multiple="multiple"  style="color: black;">';

        $.each(fields[j].options, function (i, option) {
          formHtml += '<option value="' + option + '">' + option + "</option>";
        });
        formHtml += ' style="color: black;"';
        formHtml += "</select>";
        formHtml += "</div>";
        currentIndex++;
        break;

      // Add cases for other input types like textarea, select, etc.
      default:
      // Code for default case
    }

    $(function () {
      // Get today's date
      var today = new Date();

      // Set datepicker with maxDate as today
      $(".datepicker").datepicker({
        maxDate: today,
        dateFormat: "mm/dd/yy", // Set the desired date format
        onSelect: function (dateText) {
          $(this).val(dateText); // Remove slashes when selecting the date
        },
      });

      // Automatically insert slashes while typing
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

    // jQuery(document).ready(function ($) {
    //     $('.js-example-basic-multiple').select2({
    //         minimumResultsForSearch: -1,
    //         containerCssClass: "custom-select2"

    //     });
    // });

    formHtml += "</div>";
  }

  formHtml +=
    '<td><i class="fa fa-eye datashow-icon  us-input-' +
    currentIndex +
    '" id="" name="" title="" style="cursor: pointer;margin-length:50px" data-mitem="' +
    cardHeader +
    '" data-content="' +
    contentData +
    '" data-toggle="modal" data-target="#exampleModalLong"></i></td>';

  formHtml +=
    '<td><i class="ml-5 fa fa-trash-alt query-icon remove-item us-input-' +
    currentIndex +
    '" id="row_remove-item" name="rowdelete" title="Delete" style="cursor: pointer;color:red; margin-length:50px" data-mitem="' +
    cardHeader +
    '"></i></td>';

  formHtml += "</div>";
  return formHtml;
}

// active tab focus start
$(document).ready(function () {
  // Add border style when regular select elements are focused
  $(document).on("focus", "select", function () {
    $(this).css({
      border: "2px solid #a0c4ff",
      "border-radius": "5px",
    });
  });

  // Add border style when select2 elements are focused
  $(document).on("focus", ".select2-selection--single", function () {
    $(this).closest(".form-group").find("select").css({
      border: "2px solid #a0c4ff",
      "border-radius": "5px",
    });
  });

  // Remove border style when select elements lose focus
  $(document).on("blur", "select", function () {
    $(this).css({
      border: "",
      "border-radius": "0px",
    });
  });

  // Remove border style when select2 elements lose focus
  $(document).on("blur", ".select2-selection--single", function () {
    $(this).closest(".form-group").find("select").css({
      border: "",
      "border-radius": "0px",
    });
  });
});





// active tab focus End


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




//modal datacontent show End 

$("body").on("change toggle", ".efea", function () {
  var dateInput = $(this);
  var dateval = dateInput.val();
  console.log(dateval);

  const assDateValue = $("#assdate").val();

  if (new Date(dateval) > new Date(assDateValue)) {
    Swal.fire({
      title: "Error!",
      text: "Please enter a valid effective date",
      icon: "error",
      confirmButtonText: "OK",
    }).then((result) => {
      if (result.isConfirmed) {
        $(this).val("");
      }
    });
    return;
  }

  if (!isValidDate(dateval)) {
    Swal.fire({
      title: "Error!",
      text: "Please enter a valid date with the format MM/DD/YYYY and within the specified range",
      icon: "error",
      confirmButtonText: "OK",
    }).then((result) => {
      if (result.isConfirmed) {
        $(this).val("");
      }
    });
    return;
  }

  function isValidDate(dateString) {
    const match = dateString.match(/^(\d{2})\/(\d{2})\/(\d{4})$/);

    if (!match) {
      return false;
    }

    const month = parseInt(match[1], 10);
    const day = parseInt(match[2], 10);
    const year = parseInt(match[3], 10);

    if (
      isNaN(month) ||
      isNaN(day) ||
      isNaN(year) ||
      month < 1 ||
      month > 12 ||
      day < 1 ||
      day > 31 ||
      year < 2000 ||
      year > 2100
    ) {
      return false;
    }

    return true;
  }
});

$(document).ready(function () {
  const Entry = $("#entryIdoasis").val();

  // AJAX call to retrieve data
  $.ajax({
    url: `Assign/page.php?action=filter&Id=${Entry}`,
    type: "GET",
    dataType: "json",
    success: function (response) {
      console.log("oasis:", response);
      const numberOfItemsWithData = response.length;
      const mainCardDiv = document.createElement("div");
      mainCardDiv.classList.add(
        "card",
        "position-relative",
        "scroller",
        "col-lg-12"
      );
      const mainCardBodyDiv = document.createElement("div");
      mainCardBodyDiv.classList.add("card-body", "card-new");

      for (let i = 0; i < numberOfItemsWithData; i++) {
        const { Mitem, description, Section, content } = response[i];
        const fields = JSON.parse(response[i].json);
        const cardHeaderText = `${Section} (${Mitem} - ${description})`;
        const contentData = `${content}`;
        // const carddes=`${description}`;

        // console.log(contentData);
        const cardDiv = document.createElement("div");
        cardDiv.classList.add("card", "nested-card", "mb-2");

        const cardHeader = document.createElement("div");
        cardHeader.classList.add("card-header");
        cardHeader.textContent = cardHeaderText;
        // carddes.textContent=cardDesText;

        const cardBodyDiv = document.createElement("div");
        cardBodyDiv.classList.add("card-body");

        const formHtml = createFormElements(
          fields,
          cardHeaderText,
          contentData
        );
        cardBodyDiv.innerHTML = formHtml;

        cardDiv.appendChild(cardHeader);
        cardDiv.appendChild(cardBodyDiv);

        mainCardBodyDiv.appendChild(cardDiv);
      }

      mainCardDiv.appendChild(mainCardBodyDiv);

      const carouselRow = document.getElementById("carouselRow");
      carouselRow.appendChild(mainCardDiv);

      $(document).ready(function () {
        // Hide the element with class us-input-3
        $(".us-input-4").hide();

        $(".hide-this").hide();
      });

      // DELETED MITEM CODE    START HERE

      $(document).on("click", ".remove-item", function () {
        var mitemdatacard = $(this).closest(".nested-card");
        var header = mitemdatacard.find(".mitem-input").data("mitem");
        var us1 = mitemdatacard.find(".us-input-1").val();
        var us2 = mitemdatacard.find(".us-input-2").val();
        var us3 = mitemdatacard.find(".us-input-3").val();

        mitemdatacard.find(".us-input-1").val("");
        mitemdatacard.find(".us-input-2").val("");
        mitemdatacard.find(".us-input-3").val("");

        // Given string
        const inputString = header;

        // Split the string by '(' and ')'
        const parts = inputString.split("(");

        // Extract the part containing the information we need
        const infoPart = parts[1].split(")")[0];

        // Output the extracted information
        // console.log(infoPart.trim());

        const oasismitem = infoPart;
        oasisDataToServer(oasismitem);
      });

      function oasisDataToServer(oasismitem) {
        $.ajax({
          type: "POST",
          url: "Assign/oasissegement.php",
          data: {
            oasismitem: oasismitem,
          },
          success: function (data) {
            // Parse the JSON response
            const response = JSON.parse(data);

            // Check if there's an error
            if (response.error) {
              // Log and alert the error
              console.error("Error:", response.error);
              alert("Error: " + response.error);
            }
            // Check if the operation was successful
            else if (response.success) {
              // Log and alert the success message
              console.log("Success:", response.success);
              alert("Success: " + response.success);

              // Clear input fields (assuming mitemdatacard is a valid selector for the input fields)
              mitemdatacard.find(".us-input-1").val("");
              mitemdatacard.find(".us-input-2").val("");
              mitemdatacard.find(".us-input-3").val("");
            }
            // Handle unexpected response
            else {
              console.error("Unexpected response:", response);
            }
          },

          error: function () {
            // Handle error
          },
        });
      }

      // DELETED MITEM CODE   END HERE

      // Save Oasis item data

      $(document).on("click", "#btn_save_oasis", function (event) {
        event.preventDefault();

        const formArray = [];

        $(".nested-card").each(function () {
          const mitemElement = $(this).find(".mitem-input").get(0);
          const mitemAttributeValue = $(mitemElement).attr("data-mitem");
          //   console.log("mitemAttributeValue", mitemAttributeValue);
          const cardheader = $(this).find(".mitem-input").val();
          const us1Value = $(this).find(".us-input-1").val();
          const us2Value = $(this).find(".us-input-2").val();
          const us3Value = $(this).find(".us-input-3").val();

          // alert(cardheader);

          // if (us1Value && (!us2Value || !us3Value)) {
          //     $(this).append('<span class="text-danger">Please fill in all fields for this row.</span>');
          //     return false; // Exit the loop for this row
          // }

          if (
            us1Value != "" &&
            us2Value != "" &&
            us1Value != null &&
            us2Value != null
          ) {
            // $(this).find('.text-danger').remove(); // Remove error message if all fields are filled

            const formData = {
              cardheader: cardheader,
              mitemAttributeValue: mitemAttributeValue,
              us1: us1Value,
              us2: us2Value,
              us3: us3Value,
            };

            formArray.push(formData);
          }
        });

        const Id = $("#entryIdoasis").val();

        $.ajax({
          url: "Assign/oasissegement.php",
          type: "POST",
          data: {
            formDataArray: formArray,
            Id: Id,
          },
          success: function (response) {
            // Log the response for debugging purposes
            var datae = JSON.parse(response);
            console.log(datae);

            if (datae.success) {
              // Display a success message if 'success' property is true
              Swal.fire({
                title: "Success!",
                text: datae.message, // Display the response data in the message
                icon: "success",
                confirmButtonText: "OK",
              }).then(function () {
                $(".saved-oasissegement").removeAttr("hidden");

                // oasisryidatafetch(Id);
              });
            } else {
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
  });
});
