$(document).ready(function () {
  window.sharedData = [];
  const renderFields = (fieldData) => {
    var mIndex = 0;
    var rowCount = 0;
    var serialNumber = 1;

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

    defaultMItem.map(function (mitemdefault, idx) {
      // console.log(mitemdefault);
    });

    var Id = document.getElementById("entryId").value;
    $("#dynamic_field tbody").html(
      fieldData.map(
        (item, index) => `<tr id="row${
          index + 1
        }" draggable="true" ondragstart="start(event)"  ondragover="dragover(event)">
            <td style="width: 100px;"><span > ${index + 1}</span></td>
            <td hidden style="width: 100px;"><input type="text" name="EntryId"  value="${Id}" class="form-control name_list input-lg"/></td>
            <td style="width: 150px;" data-draggable="false">
            ${
            defaultMItem.includes(item["M-Items"])
                ? `<input type="text" name="mitems" id="mitem" value="${item["M-Items"]}" tabindex="-1" class="form-control name_list input-lg" readonly />`
                : `<input type="text" name="mitems" value="${item["M-Items"]}" tabindex="-1" class="form-control name_list input-lg" readonly hidden>`
            }
        </td>
            <td style="width: 150px;"><input type="text" id="icd-row${
              index + 1
            }" name="icd"  value="${
          item["ICD-code"]
        }" autocomplete="off" class="form-control name_email input-lg " style="text-transform: uppercase;"/></td>
            <td style="width: 400px;">
    <input type="text" 
           value="${item["Description"]}"
           name="description" 
           class="form-control total_amount input-lg description" 
           data-toggle="tooltip" 
           data-html="true" 
           id="description-row${index + 1}" 
           readonly 
           title="${item["Description"]}" />
</td>

            <td style="width: 200px;"><input type="text" id="date-row${index + 1}" value="${
          item["Effective_Date"]
        }"name="effectivedate" autocomplete="off" class="datepicker form-control total_amount input-lg"   ></td>
            <td>
                <select name="eo" class="form-control total_amount input-lg"  id="eo-row${
                  index + 1
                }">
                    <option value="None">None</option>
                    <option value="E" ${
                      item.Eo === "E" ? "selected" : ""
                    }>E</option>
                    <option value="O" ${
                      item.Eo === "O" ? "selected" : ""
                    }>O</option>
                </select>
            </td>
            <td>
                <select name="rating" class="form-control total_amount input-lg" id="rating-row${
                  index + 1
                }">
                    <option value="None">None</option>
                    <option value="0"${
                      item.Rating === "0" ? "selected" : ""
                    }>0</option>
                    <option value="1"${
                      item.Rating === "1" ? "selected" : ""
                    }>1</option>
                    <option value="2"${
                      item.Rating === "2" ? "selected" : ""
                    }>2</option>
                    <option value="3"${
                      item.Rating === "3" ? "selected" : ""
                    }>3</option>
                    <option value="4"${
                      item.Rating === "4" ? "selected" : ""
                    }>4</option>
                </select>
            </td>
 
             <td><i class="fas fa-trash-alt query-icon remove" id="row_remove${
               index + 1
             }" name="rowdelete" style="cursor: pointer;"></i> &nbsp; <i class="fas fa-plus query-icon insert" name="" style="cursor: pointer;"></i></td>

        </tr>`
      )
    );
  
    var count_drag = [];
    var mitem_drag = [];
    $('body').on('dragstart', '#dynamic_field tbody tr', function(event) {
      // Check if any cell in the row has a specific value that should prevent dragging
      
      $('#dynamic_field tbody tr').each(function() {
        var firstTdContent = $(this).find('td:first').text();
        var secondTdContent = $(this).find('td:eq(2)').html();
  
        count_drag.push(firstTdContent);
        mitem_drag.push(secondTdContent);
      //  console.log('start');
      });
      if ($(event.target).is('td:first-child, td:nth-child(2)')) {
          event.preventDefault(); // Prevent dragging if the dragged element is the first or second td
      } else {
          // Continue dragging for other elements
          const rowId = $(this).attr('id');
          event.originalEvent.dataTransfer.setData("text/plain", rowId);
      }
  });
  
  $('body').on('dragover', '#dynamic_field tbody tr', function(event) { // Corrected event name to 'dragover'
      event.preventDefault();
  });
  
  $('body').on('drop', '#dynamic_field tbody tr', function (event) {
      event.preventDefault();
      // console.log('end');
      
      const fromId = event.originalEvent.dataTransfer.getData("text/plain");
      const toId = this.id; 
      
      // Swap values between corresponding input fields of cloned rows
      swapValues(this, fromId, toId);
      reArrangeMItems();
  });



  
  function reArrangeMItems()
  {
       
    var sno_drag = 0;
    $('#dynamic_field tbody tr').each(function() {
      if(sno_drag > 24)
      {
        const randomSlug = generateRandomString(existingRowsData);

        var midtem_html = '<input type="text" name="mitems" class="form-control   input-lg" value="'+randomSlug+'" hidden="">';
      }
      else
      {
        var midtem_html = mitem_drag[sno_drag];
      }
      $(this).find('td:eq(2)').html(midtem_html);
      sno_drag++;
      $(this).find('td:first').text(sno_drag);
      $(this).attr('id', 'row'+sno_drag);
      
    });
  }

  function swapValues(element, fromId, toId) {
      const fromElement = document.getElementById(fromId);
      const toElement = document.getElementById(toId);
  
      // Reorder the elements in the DOM structure
      if (fromElement && toElement) {
          if (fromElement.parentNode === toElement.parentNode) {
              if (Array.from(fromElement.parentNode.children).indexOf(fromElement) < Array.from(toElement.parentNode.children).indexOf(toElement)) {
                  fromElement.parentNode.insertBefore(fromElement, toElement.nextSibling);
              } else {
                  fromElement.parentNode.insertBefore(fromElement, toElement);
              }
          }
      }
  }
  

 
 //tabIndex start
const inputs = document.querySelectorAll('#dynamic_field tbody input[type="text"], #dynamic_field tbody select');

 
inputs.forEach((input, index) => {
    input.tabIndex = index + 1;
});
 
document.addEventListener('keydown', (event) => {
    if (event.key === 'ArrowDown' || event.key === 'ArrowUp' || event.key === 'ArrowLeft' || event.key === 'ArrowRight') {
        event.preventDefault();  

        let currentIndex = Array.from(inputs).findIndex(input => input === document.activeElement);
        let nextIndex;

        if (event.key === 'ArrowDown') {
            nextIndex = currentIndex + 7;  
        } else if (event.key === 'ArrowUp') {
            nextIndex = currentIndex - 7;  
        } else if (event.key === 'ArrowLeft') {
            nextIndex = currentIndex - 1;  
        } else if (event.key === 'ArrowRight') {
            nextIndex = currentIndex + 1;  
        }

        if (nextIndex >= 0 && nextIndex < inputs.length) {
            inputs[nextIndex].focus();  
        }
    }
});


//tabIndex End


 
// description show tooltip
 $('[data-toggle="tooltip"]').tooltip();

// description show tooltip end

// active Tab hglight 
$(document).ready(function() {
    $('.form-control').focus(function() {
        $(this).addClass('input-active'); // Add the input-active class when the input is focused
    });

    $('.form-control').blur(function() {
        $(this).removeClass('input-active'); // Remove the input-active class when the input loses focus
    });
 
});

$(document).ready(function() {
    // Add border style when the select element with id starting with "eo-row" or "rating-row" is focused
    $(document).on('focus', 'select[id^="eo-row"], select[id^="rating-row"]', function() {
        $(this).css({
            'border': '2px solid #a0c4ff',
            'border-radius': '5px'
        });
    });

    // Remove border style when select elements lose focus
    $(document).on('blur', 'select', function() {
        $(this).css({
            'border': '',
            'border-radius': '0px'
        });
    });
});

 
// active Tab hglight 


 
    // Remove button START

    $(".remove").on("click", function () {
      var getRow = $(this).closest("tr");
      const icdValue = getRow.find('[name="icd"]').val().trim();
      const mitem = getRow.find('[name="mitems"]').val().trim();

      console.log("icdValue:", icdValue);
      console.log("mitem:", mitem);

      sendDataToServer(icdValue, mitem, getRow);
    });

    function sendDataToServer(icdValue, mitem, getRow) {
      $.ajax({
        type: "POST",
        url: "Assign/primary.php",
        data: {
          mitem: mitem,
          icdValue: icdValue,
        },
        success: function (data) {
          const response = JSON.parse(data);
          if (response.error) {
            console.error("Error:", response.error);
            alert("Error: " + response.error);
          } else if (response.success) {
            console.log("Success:", response.success);
            alert("Success: " + response.success);

            // Clear input fields
            getRow.find('[name="icd"]').val("");
            getRow.find('[name="description"]').val("");
            getRow.find('[name="effectivedate"]').val("");
            getRow.find('[name="eo"]').val("");
            getRow.find('[name="rating"]').val("");
          } else {
            console.error("Unexpected response:", response);
          }
        },
        error: function () {
          // Handle error
        },
      });
    }

    // Remove button END

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
      // $(".datepicker").on("keyup", function () {
      //   var val = $(this).val().replace(/\D/g, "");
      //   if (val.length > 2) {
      //     $(this).val(
      //       val.slice(0, 2) + "/" + val.slice(2, 4) + "/" + val.slice(4, 8)
      //     );
      //   } else if (val.length > 0) {
      //     $(this).val(
      //       val.slice(0, 2) + (val.length > 2 ? "/" + val.slice(2, 4) : "")
      //     );
      //   }
      // });

   // datepicker_hide AND SHOW CODE START   

$(".datepicker").on("focus", function () {
 
  var $this = $(this);
  
  $this.datepicker('hide');
  
  // Event handler for keyup (including F2 key)
  $(document).on("keyup.datepicker", function (e) {
    // Check if the focused field is the current input field and the F2 key is pressed
    if ($this.is(":focus") && e.keyCode === 113) {
      // Open the datepicker
      $this.datepicker('show');
    }
  });
});

// Event handler to remove the keyup event when focus is lost
$(".datepicker").on("blur", function () {
  $(document).off("keyup.datepicker");
});

// Event handler for formatting date input
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


//datepicker_hide AND SHOW CODE END  










    });

    while (mIndex < fieldData.length) {
      var n = fieldData[mIndex];
      rowCount++;
      serialNumber++;
      $(function () {
        // Get today's date
        var today = new Date();

        // Set datepicker with maxDate as today
        $(".datepicker").datepicker({
          maxDate: today,
        });
      });

      var current_count = mIndex++;

      $(this).val("");
    }

    $(".add").show();
  };

  function start(){  
    row = event.target; 
  }
  function dragover(){
    var e = event;
    e.preventDefault(); 
    
    let children= Array.from(e.target.parentNode.parentNode.children);
    
    if(children.indexOf(e.target.parentNode)>children.indexOf(row))
      e.target.parentNode.after(row);
    else
      e.target.parentNode.before(row);
  }

  const generateRandomString = (existingRowsData) => {
    const alphanumericCharacters =
      "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    const minLength = 2;
    const maxLength = ;

    const length =
      Math.floor(Math.random() * (maxLength - minLength + 1)) + minLength;



    const randomSlug = Array.from({ length }, () =>
      alphanumericCharacters.charAt(
        Math.floor(Math.random() * alphanumericCharacters.length)
      )
    ).join("");

    const formattedRandomString = `M102${randomSlug.toUpperCase()}`;

    const findData = existingRowsData.find((item) => {
      if (item["M-Items"] === formattedRandomString) {
        return item;
      }
    });

    if (findData) {
      generateRandomString(existingRowsData);
    }
    return formattedRandomString;
  };

  var Id = document.getElementById("entryId").value;
  // alert(Id);
  var m = [
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
  var newArray = m.map(function (item) {
    return {
      "M-Items": item,
      "ICD-code": "",
      Description: "",
      Effective_Date: "",
      default: true,
    };
  });
  var mIndex = 0;
  var rowCount = 0;
  var serialNumber = 0;
  var add_mItem = 0;
  var existingRowsData = [];

  async function fetchDataAndRender(Id, url, dataArray) {
    try {
      const response = await $.ajax({
        url: url,
        type: "POST",
        data: { Id: Id },
      });
      console.log(response);
      return response;
    } catch (error) {
      console.error(`Error fetching data from ${url}:`, error);
      return null;
    }
  }

  const renderMethod = (response, dataArray) => {
    if (response && typeof response !== "string") {
      const codeData = response.code_data || [];

      const removeExistingData = dataArray.filter((item) => {
        return !codeData.find((data) => data["M-Items"] === item["M-Items"]);
      });

      const filteredData = [...codeData, ...removeExistingData];

      existingRowsData = filteredData;
      serialNumber = filteredData.length;
      rowCount = filteredData.length;

      // console.log(filteredData);
      renderFields(filteredData);
    } else {
      console.error("Invalid response or response is a string:", response);
    }
  };

  async function fetchDataAndRenderAndRender(Id, url, dataArray) {
    const response = await fetchDataAndRender(Id, url, dataArray);
    renderMethod(response, dataArray);
  }

  async function executeSequentially() {
    const urls = [
      "Assign/penddisplaydata.php",
      "PendingWip/pendingdisplaydata.php",
      "Assign/wipdisplaydata.php",
    ];

    for (const url of urls) {
      await fetchDataAndRenderAndRender(Id, url, newArray);
    }
  }

  // Call the function to execute sequentially
  executeSequentially();

  // ADD function

  $("#add").click(function () {
    var rowid = serialNumber;
    serialNumber++;
    add_mItem++;

    const randomSlug = generateRandomString(existingRowsData);

    console.log(randomSlug);

    $("#dynamic_field tbody").append(
      `<tr id="row${
        rowid + 1
      }" ondragstart="ondragstart(event)" ondrop="drop(event, this)" draggable="true">
                    <td style="width: 100px;"><span > ${serialNumber}</span></td>
                    <td hidden style="width: 100px;"><input type="text" name="EntryId" value="${Id}" class="form-control name_list input-lg" hidden/></td>
                    <td style="width: 150px;"><input type="text" name="mitems" class="form-control   input-lg" value="${randomSlug}" hidden /></td>
                    <td style="width: 150px;"><input type="text" name="icd" id="icd-row${
                      rowid + 1
                    }" autocomplete="off" class="form-control name_email input-lg" style="text-transform: uppercase;"/></td>
                    <td style="width: 400px;"><input type="text" name="description" id="description-row${
                      rowid + 1
                    }" class="form-control total_amount input-lg description" readonly /></td>
                    <td style="width: 200px;"><input type="text" name="effectivedate" id="date-row${
                      rowid + 1
                    }"  class="datepicker form-control total_amount input-lg" /></td>
                    <td>
                        <select name="eo" class="form-control total_amount input-lg"  id="eo-row${
                          rowid + 1
                        }">
                            <option value="None">None</option>
                            <option value="E">E</option>
                            <option value="O">O</option>
                        </select>
                    </td>
                    <td>
                        <select name="rating" class="form-control total_amount input-lg" id="rating-row${
                          rowid + 1
                        }">
                            <option value="None">None</option>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </td>
                     <td><i class="fas fa-trash-alt query-icon remove" id="row_remove${
                       rowid + 1
                     }" name="rowdelete" style="cursor: pointer;"></i> &nbsp; <i class="fas fa-plus query-icon insert" name="" style="cursor: pointer;"></i></td>
                </tr>`
    );

//active tab hilight start
      $('.form-control').focus(function() {
        $(this).addClass('input-active'); // Add the input-active class when the input is focused
    });

    $('.form-control').blur(function() {
        $(this).removeClass('input-active'); // Remove the input-active class when the input loses focus
    });

 //active tab hilight End

    
// remove item or delete icon process start
    $(".remove").on("click", function () {
      var getRow = $(this).closest("tr");
      const icdValue = getRow.find('[name="icd"]').val().trim();
      const mitem = getRow.find('[name="mitems"]').val().trim();

      console.log("icdValue:", icdValue);
      console.log("mitem:", mitem);

      sendDataToServer2(icdValue, mitem, getRow);
    });

    function sendDataToServer2(icdValue, mitem, getRow) {
      $.ajax({
        type: "POST",
        url: "Assign/primary.php",
        data: {
          mitem: mitem,
          icdValue: icdValue,
        },
        success: function (data) {
          const response = JSON.parse(data);
          if (response.error) {
            console.error("Error:", response.error);
            alert("Error: " + response.error);
          } else if (response.success) {
            console.log("Success:", response.success);
            alert("Success: " + response.success);

            // Clear input fields
            getRow.find('[name="icd"]').val("");
            getRow.find('[name="description"]').val("");
            getRow.find('[name="effectivedate"]').val("");
            getRow.find('[name="eo"]').val("");
            getRow.find('[name="rating"]').val("");
          } else {
            console.error("Unexpected response:", response);
          }
        },
        error: function () {
          // Handle error
        },
      });
    }

 // remove item or delete icon process End

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
  });

  //efective date validation

  $("body").on("blur change toggle", '[name="effectivedate"]', function () {
    var dateInput = $(this);
    var dateval = dateInput.val().trim();

    const assDateValue = $("#assdate").val();
    const currentRow = dateInput.closest("tr");

    const effectivedateInput = currentRow.find('[name="effectivedate"]');
    const effectivedate = effectivedateInput.val().trim();

    if (new Date(dateval) > new Date(assDateValue)) {
      Swal.fire({
        title: "Error!",
        text: "Please enter a valid effective date",
        icon: "error",
        confirmButtonText: "OK",
      }).then((result) => {
        if (result.isConfirmed) {
          effectivedateInput.val("");
        }
      });
      return;
    }

    // Check if the date is empty
    // if (effectivedate === "") {
    //     Swal.fire({
    //         title: "Error!",
    //         text: "Not Allow Empty Date",
    //         icon: "error",
    //         confirmButtonText: "OK",
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             // You might want to do something with the 'icd' element here
    //             currentRow.find('[name="icd"], [name="description"]').val("");

    //         }
    //     });
    //     return;
    // }

    // Check if the date is valid
  });

  $("#dynamic_field tbody").on(
    "change ",
    '[name="effectivedate"]',
    function () {
      var dateInput = $(this);
      var dateval = dateInput.val().trim();

      const assDateValue = $("#assdate").val();
      const currentRow = dateInput.closest("tr");

      const effectivedateInput = currentRow.find('[name="effectivedate"]');
      const effectivedate = effectivedateInput.val().trim();

      if (!isValidDate(effectivedate)) {
        Swal.fire({
          title: "Error!",
          text: "Please enter a valid date with the format MM/DD/YYYY and within the specified range",
          icon: "error",
          confirmButtonText: "OK",
        }).then((result) => {
          if (result.isConfirmed) {
            currentRow.find('[name="effectivedate"]').val("");
          }
        });
        return;
      }

      // Continue with your code if the date is valid

      function isValidDate(dateString) {
        // Extract month, day, and year
        const match = dateString.match(/^(\d{2})\/(\d{2})\/(\d{4})$/);

        if (!match) {
          return false;
        }

        const month = parseInt(match[1], 10);
        const day = parseInt(match[2], 10);
        const year = parseInt(match[3], 10);

        // Basic date validation
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
    }
  );

  var enteredIcds = [];
  var filledValues = [];

  $("body").on("change", "#gender", function () {
    var icdElement = $('#dynamic_field[name="icd"]');

    icdElement.change();
  });
  $("#dynamic_field").on("change", '[name="icd"]', function () {
    const currentRow = $(this).closest("tr"); // Find the parent row
    const icdValue = currentRow.find('[name="icd"]').val().trim();
    const descriptionField = currentRow.find('[name="description"]');
    const ratingField = currentRow.find('select[name="rating"]');
    filledValues = [];

    var mitem = $(this).closest("tr").find('[name="mitems"]').val();

    var code = $(this).closest("tr").find('[name="icd"]').val();

    $("#dynamic_field tbody tr").each(function (_, row) {
      var icd = $(row).find("td:eq(3) input").val().trim();
      // console.log(icd);
      if (icd?.length > 0) {
        filledValues.push(icd);
      }
    });

    if (
      filledValues
        .map((item) => item.toLowerCase())
        .filter((item) => item === icdValue.toLowerCase()).length > 1
    ) {
      Swal.fire({
        title: "Duplicate! (" + icdValue + ")",
        text: "ICD ID already entered in another row",
        icon: "error",
        confirmButtonText: "OK",
      }).then((result) => {
        if (result.isConfirmed) {
          // Clear the ICD input field
          currentRow.find('[name="icd"]').val("");
        }
      });
      currentRow.find('[name="icd"]').addClass("duplicate");
      return;
    }

    // descriptionField.val("");
    if (icdValue == "") {
      descriptionField.val("");
      return;
    }

    // Check if the icdValue is not empty
    if (icdValue?.length > 0) {
      // Disable or enable the rating field based on the icdValue
      if (icdValue.charAt(0).toUpperCase() === "Z") {
        ratingField.prop("disabled", true).val("");
      } else {
        ratingField.prop("disabled", false);
      }
    }

    var gender = $("#gender").val();

    if (gender == "") {
      Swal.fire({
        title: "Select Gender",
        text: "Please select a gender before proceeding.",
        icon: "warning",
        confirmButtonText: "OK",
      }).then((result) => {
        if (result.isConfirmed) {
          currentRow.find('[name="icd"]').val("");
        }
      });
      return;
    }

    $.ajax({
      type: "POST",
      url: "Assign/code_description.php",
      data: { icd: icdValue, gender: gender },
      success: function (data) {
        const response = JSON.parse(data);
        if (response.error) {
          Swal.fire({
            title: "Error!",
            text: response.error,
            icon: "error",
            confirmButtonText: "OK",
          }).then((result) => {
            if (result.isConfirmed) {
              currentRow.find('[name="icd"]').val("");
              currentRow.find('[name="description"]').val("");
            }
          });
          return;
        }
        const des = response.description;

        descriptionField.val(des);
        currentRow.find('[name="icd"]').removeClass("duplicate");
      },
      error: function () {
        currentRow.find('[name="icd"]').addClass("duplicate");
      },
    });

    if (mitem === "M1021A" && code) {
      $.ajax({
        type: "POST",
        url: "Assign/primary.php",
        data: { code: code },
        success: function (data) {
          const response = JSON.parse(data);
          if (response.error) {
            Swal.fire({
              title: "Error!",
              text: response.error,
              icon: "error",
              confirmButtonText: "OK",
            }).then((result) => {
              if (result.isConfirmed) {
                currentRow.find('[name="icd"]').val("");
                currentRow.find('[name="description"]').val("");
              }
            });
            return;
          }
          const des = response.description;

          descriptionField.val(des);
          currentRow.find('[name="icd"]').removeClass("duplicate");
        },
        error: function () {
          currentRow.find('[name="icd"]').addClass("duplicate");
        },
      });
    }
  });

  //save the codesegement data

  $("#btn_save").on("click", function () {
    var data = [];
    var enteredIcds = [];
    var hasError = false;
    var formattedDate;

    function isEmpty(value) {
      return value.trim() === "";
    }

    // Iterate through each table row
    $("#dynamic_field tbody tr").each(function (index, row) {
      var icdInput = $(row).find("td:eq(3) input");
      var mitems = $(row).find("td:eq(2) input").val();

      // Check if ICD field is not empty
      if (icdInput.val().trim() !== "") {
        var icd = icdInput.val().trim();

        enteredIcds.push(icd);
        var gender = $("#gender").val();
        var Id = $("#entryId").val();
        var EntryId = $(row).find("td:eq(1) input").val();
        var description = $(row).find("td:eq(4) input").val();
        var effectivedate = $(row).find("td:eq(5) input").val();
        var eo = $(row).find("td:eq(6) select").val();
        var rating = $(row).find("td:eq(7) select").val();

        var rowData = {
          EntryId: EntryId,
          mitems: mitems,
          icd: icd,
          description: description,
          effectivedate: effectivedate,
          eo: eo,
          rating: rating,
          gender: gender,
        };

        data.push(rowData);

        // window.sharedData.push(rowData);
        position2(rowData);
      } else {
        isAnyFieldEmpty = true;
      }
    });

    // Your AJAX request goes here
    $.ajax({
      type: "POST",
      url: "Assign/insert_code_segement.php",
      data: { dataArray: data,
      Id:Id },
      success: function (response) {
        console.log(response);
        if (response == "") {
          Swal.fire({
            title: "Success!",
            text: "Data Inserted Successfully",
            icon: "success",
            confirmButtonText: "OK",
          }).then(function () {
            $(".saved-codesegement").removeAttr("hidden");
          });
        }
        var res = JSON.parse(response);

        if (res.success) {
          Swal.fire({
            title: "Success!",
            text: res.message,
            icon: "success",
            confirmButtonText: "OK",
          });
        } else {
          Swal.fire({
            title: "Error",
            text: res.error,
            icon: "error",
            confirmButtonText: "OK",
          });
        }
      },
      error: function (response) {
        alert(response);
      },
    });

    // //AJAX for Clinican group

    // $.ajax({

    //   type: "POST",
    //   url: "Ryi/",
    //   data: { dataArray: data },

    // });

    if (data.length === 0 && isAnyFieldEmpty) {
      Swal.fire({
        title: "ERROR!",
        text: "Please fill in all fields",
        icon: "error",
        confirmButtonText: "OK",
      });
    }
  });

  $('body').on('click','.insert', function(){
    var this_row = $(this).closest('tr');
    
    var count = [];
    var mitem = [];
    $('#dynamic_field tbody tr').each(function() {
      var firstTdContent = $(this).find('td:first').text();
      var secondTdContent = $(this).find('td:eq(2)').html();

      count.push(firstTdContent);
      mitem.push(secondTdContent);
     
    });
    this_row.after(`
      <tr id="row26" ondragstart="ondragstart(event)" ondrop="drop(event, this)" draggable="true">
          <td style="width: 100px;"><span> 26</span></td>
          <td hidden="" style="width: 100px;"><input type="text" name="EntryId" value="433" class="form-control name_list input-lg" hidden=""></td>
          <td style="width: 150px;"><input type="text" name="mitems" class="form-control   input-lg" value="MVIIVE" hidden=""></td>
          <td style="width: 150px;"><input type="text" name="icd" id="icd-row26" autocomplete="off" class="form-control name_email input-lg" style="text-transform: uppercase;"></td>
          <td style="width: 400px;"><input type="text" name="description" id="description-row26" class="form-control total_amount input-lg description" readonly=""></td>
          <td style="width: 200px;"><input type="text" name="effectivedate" id="date-row26" class="datepicker form-control total_amount input-lg hasDatepicker"></td>
          <td>
              <select name="eo" class="form-control total_amount input-lg" id="eo-row26">
                  <option value="None">None</option>
                  <option value="E">E</option>
                  <option value="O">O</option>
              </select>
          </td>
          <td>
              <select name="rating" class="form-control total_amount input-lg" id="rating-row26">
                  <option value="None">None</option>
                  <option value="0">0</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
              </select>
          </td>
          <td><i class="fas fa-trash-alt query-icon remove" id="row_remove26" name="rowdelete" style="cursor: pointer;"></i> &nbsp; <i class="fas fa-plus query-icon insert" name="" style="cursor: pointer;"></i></td>
      </tr>
    `);

    var sno = 0;
    $('#dynamic_field tbody tr').each(function() {
      if(sno > 24)
      {
        const randomSlug = generateRandomString(existingRowsData);

        var midtem_html = '<input type="text" name="mitems" class="form-control   input-lg" value="'+randomSlug+'" hidden="">';
      }
      else
      {
        var midtem_html = mitem[sno];
      }
      $(this).find('td:eq(2)').html(midtem_html);
      sno++;
      $(this).find('td:first').text(sno);
      $(this).attr('id', 'row'+sno);
      
    });
  });
});
