$(document).ready(function () {



  function handleArrowNavigation(event) {
    const arrowKeys = ["ArrowUp", "ArrowDown","ArrowLeft"];
    const currentIndex = $(this).index(".dynamicinputbox");
  
    if (arrowKeys.includes(event.key)) {
      event.preventDefault();
  
      // Define the target index based on arrow keys
      let targetIndex;
      switch (event.key) {
        case "ArrowUp":
          targetIndex = currentIndex - 1;
          break;
        case "ArrowDown":
          targetIndex = currentIndex + 1;
          break;
        // case "ArrowLeft":
        //   targetIndex = currentIndex + ;
        //   break;  
      }
  
      // Focus on the target input field if it exists
      const targetInput = $(".dynamicinputbox").eq(targetIndex);
      if (targetInput.length) {
        targetInput.focus();
      }
    }
  }
  

  // Attach event listener for keydown event on input fields
  $(document).on("keyup",".dynamicinputbox", handleArrowNavigation);

  function generateCardForm(item) {
    simple();
    let formHTML = `<div class="row card-body">`;

    if (item && item.fields && Array.isArray(item.fields)) {
      // Check if item and item.fields are defined and item.fields is an array
      item.fields.forEach((field) => {
        formHTML += `<div class="col-4"><div class="form-group">
                        <label style="font-size:13px">${field.group}</label>`;
        field.tags.forEach((tag) => {
          // console.log(tag.class)
          switch (tag.type) {
            case "text":
            case "textarea":
              formHTML += `<input type="${tag.type}" name="${
                tag.name
              }" placeholder="${tag.placeholder || ""}" maxlength="${
                tag.maxlength || ""
              }" value="${tag.value || ""}" class="${
                tag.class || ""
              } form-control dynamicinputbox" >`;

              break;
            case "checkbox":
              formHTML += `<div class="form-check">`;
              formHTML += `<input type="checkbox" name="${tag.name}" ${
                tag.checked ? "checked" : ""
              } class="${
                tag.class || ""
              } form-check-input dynamicinputbox" style="margin:25px;padding:20px">${
                tag.label
              }`;
              formHTML += `</div>`;
              break;
            case "select":
              formHTML += `<select type="select" name="${tag.name}" class="${
                tag.class || ""
              } form-control dynamicinputbox">`;
              tag.options.forEach((option) => {
                formHTML += `<option value="${option}" ${
                  tag.value === option ? "selected" : ""
                } class="opto">${option}</option>`;
              });
              formHTML += `</select>`;
              break;
            case "select2":
              if (tag.value != undefined) {
                formHTML += `<select type="select2" name="${tag.name}" class="${
                  tag.class || ""
                } form-control dynamicinputbox s-example-basic-multiple sty" multiple="multiple" >`;
                tag.options.forEach((option) => {
                  // console.log("value",tag.value);
                  // console.log("arun bro",option);
                  const isSelected = tag.value.includes(option);

                  // console.log("ss",isSelected)
                  formHTML += `<option value="${option}" ${
                    isSelected == true ? "selected" : ""
                  } class="opto">${option}</option>`;
                });
                formHTML += `</select>`;
              } else {
                formHTML += `<select type="select2" name="${tag.name}" class="${
                  tag.class || ""
                } form-control dynamicinputbox s-example-basic-multiple sty" multiple="multiple" >`;
                tag.options.forEach((option) => {
                  // console.log("value",tag.value);
                  // console.log("arun bro",option);
                  // const isSelected = tag.value.includes(option);

                  // console.log("ss",isSelected)
                  formHTML += `<option value="${option}" ${
                    tag.value === option ? "selected" : ""
                  } class="opto">${option}</option>`;
                });
                formHTML += `</select>`;
              }

            // case "select2":
            //   formHTML += `<select type="select2" name="${tag.name}" class="${
            //     tag.class || ""
            //   } form-control dynamicinputbox s-example-basic-multiple sty" multiple="multiple">`;
            //   tag.options.forEach((option) => {
            //     // Check if the current option is selected
            //     const isSelected = tag.value.includes(option);
            //     formHTML += `<option value="${option}" ${
            //       isSelected
            //         ? 'selected="selected"'
            //         : ""
            //     }>${option}</option>`;
            //   });
            //   formHTML += `</select>`;
            //   break;

            default:
              break;
          }
        });
        formHTML += `</div></div>`;
      });
    } else {
      // Handle the case where item.fields is undefined or not an array
      console.error("Item fields are undefined or not an array.");
    }

    let count = 1;

    if (item && item.fields && Array.isArray(item.fields)) {
      // Check if item and item.fields are defined and item.fields is an array
      item.fields.forEach((field) => {
        formHTML += `<div class="col-4 mt-4">`;
        field.tags.forEach((tag) => {
          if (count == 1 && !item.select2 && tag.type !== "select2") {
            formHTML += `<input type="text" class="form-control" disabled value="${tag.label}" style="font-size:12px">`;
          }
        });
        formHTML += `</div>`;
        count++;
      });
    } else {
      // Handle the case where item.fields is undefined or not an array
      console.error("Item fields are undefined or not an array.");
    }

    formHTML += `</div>`;
    return formHTML;
  }



  function simple() {
    $(".form-control.donot").prop("disabled", true);
  }

  $("body").on("click", "#btn_save_oasis", function () {
    const formData = [];
    const codeHeader = [];
    const codeData = [];
    const codeType = [];
    const codeCategory = [];
    var section_count = 1;

    $("#gg-mitems .card-header").map(function (array, idx) {
      const cardmitem = $(this).data("cardmitem");
      const cardmitemtype = $(this).data("cardmitemtype");
      const cardsection = $(this).data("cardsection");
      var cardHeader =
        cardsection + " " + "(" + cardmitem + "-" + cardmitemtype + ")";
        section_count++;
      const formData = [];

      $(".agencycol label").each(function () {
        const this_input = $(this).html();
        const this_header = $(this)
          .closest(".nested-card")
          .find(".card-header")
          .html();

        if (this_header == cardHeader) {
          const groupData = {
            group: this_input,
            tags: [],
          };

          $(this)
            .closest(".form-group")
            .find(".dynamicinputbox")
            .each(function () {
              const inputValue = $(this).val();
              const inputtype = $(this).attr("type");
              const inputplaceholder = $(this).attr("placeholder");
              const inputname = $(this).attr("name");
              const inputmaxlength = $(this).attr("maxlength");
              const inputclass = $(this).attr("class");


              // console.log("select2 data",dataselect)

              let options = [];

              // For select elements, collect options
              $(this)
                .find("option")
                .each(function () {
                  options.push($(this).val());
                });

              let tag; // Define tag variable outside the if statement

              if (inputtype === "select" || inputtype === "select2") {
                // Define tag object
                tag = {
                  type: inputtype,
                  options: options,
                  value: inputValue,
                  placeholder: inputplaceholder,
                  name: inputname,
                  label: inputname,
                  maxlength: inputmaxlength,
                  class: inputclass,
                  codervalue:options,
                };
              } else {
                // Define tag object
                tag = {
                  type: inputtype,
                  value: inputValue,
                  placeholder: inputplaceholder,
                  name: inputname,
                  label: inputname,
                  maxlength: inputmaxlength,
                  class: inputclass,
                  codervalue:inputValue,
                };
              }

              groupData.tags.push(tag); // Push tag object into groupData array
            });

          formData.push(groupData);
        }
      });

      const cardData = {
        section: cardsection,
        mitem: cardmitem,
        mitem_type: cardmitemtype,
        fields: formData,
      };

      const codersData = [];

      $(".codercol label").each(function () {
        const this_input = $(this).html();
        const this_header = $(this)
          .closest(".nested-card")
          .find(".card-header")
          .html();

        if (this_header == cardHeader) {
          const groupData = {
            group: this_input,
            tags: [],
          };

          $(this)
            .closest(".form-group")
            .find(".dynamicinputbox")
            .each(function () {
              const inputValue = $(this).val();
              const inputtype = $(this).attr("type");
              const inputplaceholder = $(this).attr("placeholder");
              const inputname = $(this).attr("name");
              const inputmaxlength = $(this).attr("maxlength");
              const inputclass = $(this).attr("class");

              let options = [];

              // For select elements, collect options
              $(this)
                .find("option")
                .each(function () {
                  options.push($(this).val());
                });

              let tag; // Define tag variable outside the if statement

              if (inputtype === "select" || inputtype === "select2") {
                // Define tag object
                tag = {
                  type: inputtype,
                  options: options,
                  value: inputValue,
                  placeholder: inputplaceholder,
                  name: inputname,
                  label: inputname,
                  maxlength: inputmaxlength,
                  class: inputclass,
                  codervalue:inputValue
                };
              } else {
                // Define tag object
                tag = {
                  type: inputtype,
                  value: inputValue,
                  placeholder: inputplaceholder,
                  name: inputname,
                  label: inputname,
                  maxlength: inputmaxlength,
                  class: inputclass,
                  codervalue:inputValue
                };
              }
              groupData.tags.push(tag);
            });

          codersData.push(groupData);
        }
      });

      const coderData = {
        section: cardsection,
        mitem: cardmitem,
        mitem_type: cardmitemtype,
        fields: codersData,
      };

      const textareadata = $(this)
        .closest(".nested-card")
        .find(".textareafor")
        .val();

      var Id = $("#entryIdggmitem").val();

      // console.log("textarea",textareadata);

      handleSubmit(cardData, coderData, textareadata, Id, cardHeader, section_count);
    });
  });

  function handleSubmit(cardData, coderData, textareadata, Id, cardHeader, section_count) {
    event.preventDefault();
    //   console.log(cardData);
    var swalShown = false; // Flag to keep track of whether Swal has been shown
    $.ajax({
      url: "ggmitem/ggmitem_insert.php?action=insert",
      type: "POST",
      data: {
        Id: Id,
        cardHeader: cardHeader,
        cardData: cardData,
        coderData: coderData,
        textareadata: textareadata,
      },
    

      success: function (response) {
        // Check if Swal has already been shown
        if (!swalShown) {
          if(section_count == 18)
          {
          Swal.fire({
            title: "Success!",
            text: 'GGITEM Data Inserted Successfully', // Display the response data in the message
            icon: "success",
            confirmButtonText: "OK",
          }).then(function () {
            $(".saved-ggmitem").removeAttr("hidden");
            swalShown = false; // Reset the flag after user interaction
          });
        }
      
          swalShown = true; // Set flag to true after showing Swal
        }
      },
      error: function (error) {
        console.error("Error fetching data:", error);
      },
    });
  }

  function createCardForBoth(
    cardHeaderText,
    agencyFormHtml,
    coderFormHtml,
    cardMitem,
    cardMitemType,
    cardsection,
    cardMitemInput
  ) {
    const cardHeader = document.createElement("div");
    cardHeader.classList.add("card-header");
    cardHeader.textContent = cardHeaderText;
    cardHeader.setAttribute("data-cardmitem", cardMitem);
    cardHeader.setAttribute("data-cardmitemtype", cardMitemType);
    cardHeader.setAttribute("data-cardsection", cardsection);
    cardHeader.setAttribute("data-inputcount", cardMitemInput);

    const cardDiv = document.createElement("div");
    cardDiv.classList.add("card", "nested-card", "mb-2", "col-12");

    const cardBodyDiv = document.createElement("div");
    cardBodyDiv.classList.add("card-body", "row", "col-12");

    const rowDiv = document.createElement("div");
    rowDiv.classList.add("row", "col-8");

    const rowDivtwo = document.createElement("div");
    rowDivtwo.classList.add("row", "col-4", "textareadata");

    const agencyColumnDiv = document.createElement("div");
    agencyColumnDiv.classList.add("col-md-6", "agencycol");
    agencyColumnDiv.innerHTML = agencyFormHtml;

    const coderColumnDiv = document.createElement("div");
    coderColumnDiv.classList.add("col-md-6", "codercol");
    coderColumnDiv.innerHTML = coderFormHtml;

    const textArea = document.createElement("textarea");
    textArea.classList.add("form-control", "textareafor","resizable-textarea", "mt-4");
    textArea.setAttribute("data-section", cardHeaderText);
    textArea.style.height = "50%";
    // textArea.value = coderrationalidata;

    rowDiv.appendChild(agencyColumnDiv);
    rowDiv.appendChild(coderColumnDiv);
    rowDivtwo.appendChild(textArea);
    cardBodyDiv.appendChild(rowDiv);
    cardBodyDiv.appendChild(rowDivtwo);

    cardDiv.appendChild(cardHeader);
    cardDiv.appendChild(cardBodyDiv);

    return cardDiv;
  }

  const form = document.getElementById("gg-mitems");
  form.addEventListener("submit", handleSubmit);
  Id = $("#entryIdggmitem").val();

  $.ajax({
    type: "post",
    url: "ggmitem/ggmitem.php?action=statusdata",

    data: {
      Id: Id,
    },

    success: function (response) {
      // Debugging: Log the response to see its structure
      console.log(response);

      const jsonData = response.agencyResponse;
      const codejsonData = response.coderResponse;

      for (let i = 0; i < jsonData.length; i++) {
        const agencyItem = JSON.parse(jsonData[i]);
        console.log(agencyItem);
        const coderItem = JSON.parse(codejsonData[i]);
        const cardsection = agencyItem.section;
        const cardMitem = agencyItem.mitem;
        const cardMitemType = agencyItem.mitem_type;
        const cardMitemInput = agencyItem.inputs;
        const cardHeaderText =
          agencyItem.section +
          " " +
          "(" +
          agencyItem.mitem +
          "-" +
          agencyItem.mitem_type +
          ")";
        const agencyFormHtml = generateCardForm(agencyItem);
        const coderFormHtml = generateCardForm(coderItem);

        const cardDiv = createCardForBoth(
          cardHeaderText,
          agencyFormHtml,
          coderFormHtml,
          cardMitem,
          cardMitemType,
          cardsection,
          cardMitemInput
        );

        const container = document.getElementById("gg-mitems");
        container.appendChild(cardDiv);
      }
    },
  });
});
