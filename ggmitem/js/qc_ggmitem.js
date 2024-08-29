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
  $(document).on("keyup",".dynamicinputbox", handleArrowNavigation);

  
  function generateCardForm(item) {
    simple();
  //  ggitemqcReasondata();
    let formHTML = `<div class="row card-body">`;

    if (item && item.fields && Array.isArray(item.fields)) {
      // Check if item and item.fields are defined and item.fields is an array
      item.fields.forEach((field) => {
        formHTML += `<div class="col-4"><div class="form-group">
                        <label style="font-size:13px">${field.group}</label>`;
        field.tags.forEach((tag) => {
          //  console.log(tag.class);
          switch (tag.type) {
            case "text":
            case "textarea":
              formHTML += `<input type="${tag.type}" name="${
                tag.name
              }" placeholder="${tag.placeholder || ""}" maxlength="${
                tag.maxlength || ""
              }" value="${tag.value || ""}" class="${
                tag.class || ""
              } " data-input="${tag.codervalue || ""}">`;

              break;
            case "checkbox":
              formHTML += `<div class="form-check">`;
              formHTML += `<input type="checkbox" name="${tag.name}" ${
                tag.checked ? "checked" : ""
              } class="${
                tag.class || ""
              } form-check-input dynamicinputbox" style="margin:25px;padding:20px"  data-input="${tag.codervalue || ""}">${
                tag.label
              }`;
              formHTML += `</div>`;
              break;
            case "select":
              formHTML += `<select type="select" name="${tag.name}" class="${
                tag.class || ""
              } "  data-input="${tag.codervalue || ""}>`;
              tag.options.forEach((option) => {
                formHTML += `<option value="${option}" ${
                  tag.value === option ? "selected" : ""
                } class="opto">${option}</option>`;
              });
              formHTML += `</select>`;
              break;
            case "select2":

            // console.log("saa",tag.value)


            if(tag.value!=undefined){
              
              formHTML += `<select type="select2" name="${tag.name}" class="${tag.class || ""}  s-example-basic-multiple sty" multiple="multiple"  data-input="${tag.codervalue || ""}">`;
              tag.options.forEach((option) => {
                // console.log("value",tag.value);
                // console.log("arun bro",option);
                const isSelected = tag.value.includes(option);

                // console.log("ss",isSelected)
                  formHTML += `<option value="${option}" ${isSelected == true ? "selected" : ""} class="opto">${option}</option>`;
              });
              formHTML += `</select>`;
              
            }
            else{

              
              formHTML += `<select type="select2" name="${tag.name}" class="${tag.class || ""}  s-example-basic-multiple sty" multiple="multiple"  data-input="${tag.codervalue || ""}">`;
              tag.options.forEach((option) => {
                // console.log("value",tag.value);
                // console.log("arun bro",option);
                // const isSelected = tag.value.includes(option);

                // console.log("ss",isSelected)
                  formHTML += `<option value="${option}" ${tag.value===option ? "selected" : ""} class="opto">${option}</option>`;
              });
              formHTML += `</select>`;

            }

      


                break;

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





  $("body").on("click", "#btn_save_ggitem", function () {
    const formData = [];
    const codeHeader = [];
    const codeData = [];
    const codeType = [];
    const codeCategory = [];
    var section_count = 1;
    var overallTotalValues = 0;
    var overallIncorrectValues = 0;
    var ggmitemvalue=0;

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
        const this_header = $(this).closest(".nested-card").find(".card-header").html();
      
        if (this_header == cardHeader) {
          const groupData = {
            group: this_input,
            tags: [],
          };
      
          var correctedValues = 0;
          var incorrectedValues = 0;
          var inputBoxCount = 0;
          var totalValues;
      
          $(this)
            .closest(".form-group")
            .find(".dynamicinputbox")
            .each(function () {
              const inputValue = $(this).val();
              const inputType = $(this).attr("type");
              const inputPlaceholder = $(this).attr("placeholder");
              const inputName = $(this).attr("name");
              const inputMaxLength = $(this).attr("maxlength");
              const inputClass = $(this).attr("class");
              const coderValue = $(this).data("input");
              inputBoxCount++;
      
              if (inputValue == coderValue) {
                correctedValues++;
              } else {
                incorrectedValues++;
              }
      
              let options = [];
              $(this)
                .find("option")
                .each(function () {
                  options.push($(this).val());
                });
      
              let tag;
              if (inputType === "select" || inputType === "select2") {
                tag = {
                  type: inputType,
                  options: options,
                  value: inputValue,
                  placeholder: inputPlaceholder,
                  name: inputName,
                  label: inputName,
                  maxlength: inputMaxLength,
                  class: inputClass,
                  codervalue: coderValue,
                  totalvalues: totalValues,
                };
              } else {
                tag = {
                  type: inputType,
                  value: inputValue,
                  placeholder: inputPlaceholder,
                  name: inputName,
                  label: inputName,
                  maxlength: inputMaxLength,
                  class: inputClass,
                  codervalue: coderValue,
                  totalvalues: totalValues,
                };
              }
              groupData.tags.push(tag);
            });
      
          totalValues = parseInt(correctedValues) + parseInt(incorrectedValues);
          overallTotalValues += totalValues;
          overallIncorrectValues += incorrectedValues;
      
          codersData.push(groupData);
        }
      });
      
     
      

      

      const coderData = {
        section: cardsection,
        mitem: cardmitem,
        mitem_type: cardmitemtype,
        fields: codersData,
      };

      // console.log(coderData);

      const textareadata = $(this)
        .closest(".nested-card")
        .find(".textareafor")
        .val();

        const errorreason =$(this).closest(".nested-card").find(".ggitemerrorreason").val();
        const errortype=$(this).closest(".nested-card").find(".ggitemerrortype").val();

      var Id = $("#entryIdggmitem").val();

      // console.log("textarea",textareadata);

      handleSubmit(cardData, coderData, textareadata, Id, cardHeader,errorreason,errortype,section_count);
    });
     // After the loop, log the overall totals
    //  console.log("overallTotalValues: ", overallTotalValues);
    //  console.log("overallIncorrectValues: ", overallIncorrectValues);
     ggmitemvalue =  overallTotalValues - overallIncorrectValues;
    //  console.log(ggmitemvalue);
    ggmitemscore(ggmitemvalue);
  });

  function handleSubmit(cardData, coderData, textareadata, Id, cardHeader,errorreason,errortype,section_count) {
    event.preventDefault();
    //   console.log(cardData);
    var swalShown = false;
    $.ajax({
      url: "ggmitem/qc_ggmitem_insert.php?action=insert",
      type: "POST",
      data: {
        Id: Id,
        cardHeader: cardHeader,
        cardData: cardData,
        coderData: coderData,
        textareadata: textareadata,
        errorreason:errorreason,
        errortype:errortype

      },
      success: function (response) {
        // console.log(response);
        // Handle success response here

        if (!swalShown) {
          if(section_count == 17)
          {
            Swal.fire({
              title: "Success!",
              text: 'GGITEM Data Inserted Successfully', // Display the response data in the message
              icon: "success",
              confirmButtonText: "OK",
            }).then(function () {
              $(".saved-ggmitem").removeAttr("hidden");
              swalShown = false; // Reset the flag after user interaction
              // qcscoring();
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
    cardsection
) {
    const cardHeader = document.createElement("div");
    cardHeader.classList.add("card-header");
    cardHeader.textContent = cardHeaderText;
    cardHeader.setAttribute("data-cardmitem", cardMitem);
    cardHeader.setAttribute("data-cardmitemtype", cardMitemType);
    cardHeader.setAttribute("data-cardsection", cardsection);

    const cardDiv = document.createElement("div");
    cardDiv.classList.add("card", "nested-card","ggmitemcard", "mb-2", "col-12");

    const cardBodyDiv = document.createElement("div");
    cardBodyDiv.classList.add("card-body", "row", "col-12","ml-5");

    const rowDiv = document.createElement("div");
    rowDiv.classList.add("row", "col-8");

    const rowDivtwo = document.createElement("div");
    rowDivtwo.classList.add("row", "col-2", "textareadata", "mr-2");

    const rowDivthree = document.createElement("div");
    rowDivthree.classList.add("row", "col-2", "selectone");

    const agencyColumnDiv = document.createElement("div");
    agencyColumnDiv.classList.add("col-md-6", "agencycol");
    agencyColumnDiv.innerHTML = agencyFormHtml;

    const coderColumnDiv = document.createElement("div");
    coderColumnDiv.classList.add("col-md-6", "codercol");
    coderColumnDiv.innerHTML = coderFormHtml;

    const textArea = document.createElement("textarea");
    textArea.classList.add("form-control", "textareafor","mt-5");
    textArea.setAttribute("data-section", cardHeaderText);
     textArea.style.width = "100%";

     const options = [
      { text: "None", value: "" },
      { text: "Missed to review the M Item", value: "missed_review" },
      { text: "Incorrect OASIS changes", value: "incorrect_changes" },
      { text: "Missed to apply OASIS rules", value: "missed_apply_rules" },
      { text: "Missed to Correlate OASIS with coding", value: "missed_correlate" },
      { text: "Modified Wrong M item", value: "modified_wrong_item" },
      { text: "Inappropriate rationale", value: "inappropriate_rationale" },
      { text: "Answered SKIP M items", value: "answered_skip_items" },
      { text: "Answered Non-scope M item", value: "answered_nonscope_item" }
    ];
    
    const selectOne = document.createElement("select");
    selectOne.classList.add("ggitemerrorreason", "form-control", "col-5", "m-2", "mt-5");
    selectOne.setAttribute("data-section", cardHeaderText);
    
    options.forEach(option => {
      const optionElement = document.createElement("option");
      optionElement.text = option.text;
      optionElement.value = option.value;
      selectOne.appendChild(optionElement);
    });
    

    const optionstwo = [
      { text: "None", value: "" },
      { text: "Added", value: "added" },
      { text: "Deleted", value: "deleted" },
      { text: "Modified", value: "modified" },
      { text: "Other", value: "other" }
    ];
    
    const selectTwo = document.createElement("select");
    selectTwo.classList.add("ggitemerrortype", "form-control", "col-5", "m-2", "mt-5");
    selectTwo.setAttribute("data-section", cardHeaderText);
    
    optionstwo.forEach(option => {
      const optionElement = document.createElement("option");
      optionElement.text = option.text;
      optionElement.value = option.value;
      selectTwo.appendChild(optionElement);
    });
    

    rowDiv.appendChild(agencyColumnDiv);
    rowDiv.appendChild(coderColumnDiv);

    rowDivtwo.appendChild(textArea);

    rowDivthree.appendChild(selectOne);
    rowDivthree.appendChild(selectTwo);

    cardBodyDiv.appendChild(rowDiv);
    cardBodyDiv.appendChild(rowDivtwo);
    cardBodyDiv.appendChild(rowDivthree);

    cardDiv.appendChild(cardHeader);
    cardDiv.appendChild(cardBodyDiv);

    return cardDiv;
}


  const form = document.getElementById("gg-mitems");
  form.addEventListener("submit", handleSubmit);
  Id = $("#entryIdggmitem").val();

  $.ajax({
    type: "post",
    url: "ggmitem/qc_ggmitem.php?action=statusdata",

    data: {
      Id: Id,
    },

    success: function (response) {
      // Debugging: Log the response to see its structure
      console.log(response);

      
   
    
      const jsonData = response.agencyResponse;
      const codejsonData = response.coderResponse;

      // console.log("saassss",qcjsonData);
  
    
      for (let i = 0; i < jsonData.length; i++) {
        const agencyItem = JSON.parse(jsonData[i]);
        const coderItem = JSON.parse(codejsonData[i]); 
        const cardsection = agencyItem.section;
        const cardMitem = agencyItem.mitem;
        const cardMitemType = agencyItem.mitem_type;
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
          cardsection
        );
    
        const container = document.getElementById("gg-mitems");
        container.appendChild(cardDiv);

      }
    },
    
  });



  //qcscoring data fetching 



function ggmitemscore(ggmitemvalue){

  const Id = $("#entryIdoasis").val();

  $.ajax({
    type:'post',
    url:'QA/qcscoringfetch_v2.php?action=ggmitemcore',
    data:{
      Id :Id,
      ggmitemvalue:ggmitemvalue,
    },  

    success:function(response){

      // alert(response);


    },

    error: function (xhr, status, error) {
      console.error(xhr.responseText);
    
    },




  });


}




  //qcreson automatically fetch from database
// function ggitemqcReasondata() {
//   $(document).ready(function () {
//     //error reason
//     $.ajax({
//       url: "QA/qc_reasonoasis.php",
//       type: "GET",
//       dataType: "json",
//       success: function (data) {
//         // console.log(data);
//         if (data) {
//           var select = $(".ggitemerrorreason"); // Selecting the element by its class
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
//           var select = $(".ggitemerrortype"); // Selecting the element by its class
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

});
