$(document).ready(function () {
  //rendering fields
  coderselectall();
  agencyselectall();


  const renderFields = (fieldData) => {
    // qcReasondata();
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
        }"  ondragstart="ondragstart(event)" ondrop="drop(event, this)" draggable="true" >
              <td style="width: 10px; padding:10px;"><span class="spanremove">${
                index + 1
              }</span></td>
              <td hidden><input type="text" name="EntryId"   value="${Id}" class="form-control  input-lg entryid"/></td>
              <td  style="width: 150px;padding:10px;">
              ${
                defaultMItem.includes(item["M-Items"])
                  ? `<input type="text" name="mitems" value="${item["M-Items"]}" class="form-control name_list input-lg" readonly data-mitem="${item["M-Items"]}"/>`
                  : `<input type="text" name="mitems" value="${item["M-Items"]}" class="form-control name_list input-lg" data-mitem="${item["M-Items"]}" readonly  hidden>`
              }
            </td>
              <td  style="width: 150px;padding:10px;"><input type="text" readonly id="icd-row${
                index + 1
              }" name="icd"  value="${
          item["ICD-code"]
        }" autocomplete="off" class="form-control input_empty input-lg form-input" style="text-transform: uppercase; " data-mitem="${
          item["M-Items"]
        }"/></td>
              <td style="width: 500px;padding:10px;"><input type="text" readonly value="${
                item["Description"]
              }"name="description" class="form-control input_empty input-lg description "data-toggle="tooltip" 
           data-html="true"   id="description-row${
             index + 1
           }" readonly  title="${item["Description"]}" data-mitem="${
          item["M-Items"]
        }"/></td>

      
              <td style="width: 150px;padding:10px;"><input type="text" readonly value="${
                item["Effective_Date"]
              }"name="effectivedate" autocomplete="off"  class=" form-control input_empty input-lg form-input" data-mitem="${
          item["M-Items"]
        }" /></td>
              <td style="padding:15px;width:100px">
                  <select name="eo"  class="form-control input_empty input-lg form-input " data-mitem="${
                    item["M-Items"]
                  }" disabled id="eo-row${index + 1}">
                      <option value="None">None</option>
                      <option value="E" ${
                        item.Eo === "E" ? "selected" : ""
                      }>E</option>
                      <option value="O" ${
                        item.Eo === "O" ? "selected" : ""
                      }>O</option>
                  </select>
              </td>
              <td style="padding:10px;">
                  <select name="rating"  class="form-control input_empty input-lg form-input" data-mitem="${
                    item["M-Items"]
                  }" disabled id="rating-row${index + 1}">
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
              <td style="padding:10px;"><select name="qcreason" style="color: black;" class="form-control input_empty input-lg form-input qcreasonid" disabled hidden id="qcreasonid" data-mitem="${
                item["M-Items"]
              }" id="qcreason-row${index + 1}">
              <option value="None"${
                item.Error_reason === "None" ? "selected" : ""
              }>None</option>
              <option value="Incorrect FOC"${
                item.Error_reason === "Incorrect FOC" ? "selected" : ""
              }>Incorrect FOC</option>
               <option value="Focus code specification modified"${
                 item.Error_reason === "Focus code specification modified"
                   ? "selected"
                   : ""
               }>Focus code specification modified</option>
                <option value="Missed to Follow ICD Guideline"${
                  item.Error_reason === "Missed to Follow ICD Guideline"
                    ? "selected"
                    : ""
                }>Missed to Follow ICD Guideline</option>
                 <option value="Missed to Follow HH Guideline"${
                   item.Error_reason === "Missed to Follow HH Guideline"
                     ? "selected"
                     : ""
                 }>Missed to Follow HH Guideline</option>
                  <option value="Missed to review document properly"${
                    item.Error_reason === "Missed to review document properly"
                      ? "selected"
                      : ""
                  }>Missed to review document properly</option>
                  <option value="Sequencing guidelines missed"${
                    item.Error_reason === "Sequencing guidelines missed"
                      ? "selected"
                      : ""
                  }>Sequencing guidelines missed</option>
                  <option value="Type-O-Error"${
                    item.Error_reason === "Type-O-Error" ? "selected" : ""
                  }>Type-O-Error</option>
                  <option value="Misssing Comorbid conditions"${
                    item.Error_reason === "Misssing Comorbid conditions"
                      ? "selected"
                      : ""
                  }>Misssing Comorbid conditions</option>
                  <option value="Inappropriate code"${
                    item.Error_reason === "Inappropriate code" ? "selected" : ""
                  }>Inappropriate code</option>


               </select></td>
               <td style="padding:10px;"><select name="errortype" style="color: black;" class="form-control input_empty input-lg form-input errortypeid" disabled hidden id="errortypeid" data-mitem="${
                 item["M-Items"]
               }" id="errortype-row${index + 1}">
               <option value="None"${
                 item.Error_type === "None" ? "selected" : ""
               }>None</option>
               <option value="Added"${
                 item.Error_type === "Added" ? "selected" : ""
               }>Added</option>
               <option value="Deleted"${
                 item.Error_type === "Deleted" ? "selected" : ""
               }>Deleted</option>
               <option value="Modified"${
                 item.Error_type === "Modified" ? "selected" : ""
               }>Modified</option>
               <option value="Other"${
                 item.Error_type === "Other" ? "selected" : ""
               }>Other</option>

                </select></td>
                <td style="padding:10px;">
 
        <textarea name="Qarationaile" style="color: black; font-size: 13px;height: 230px;
    width: 337px;" class="form-control-sm input_empty input-lg form-input Qarationaileid" disabled hidden   data-mitem="${
      item["M-Items"]
    }" id="Qarationaile-row${index + 1}"></textarea>
 
</td>


<td style="padding:1px;">
<input type="checkbox" name="coder" readonly disabled value="Coder"${
          item.Coderchecked === "Coder" ? "checked" : ""
        } id="flexCheckCoder" data-mitem="${item["M-Items"]}">
</td>

<td style="padding:1px;">
   <input type="checkbox" name="agency"  readonly disabled value="Agency" ${
     item.Agencychecked === "Agency" ? "checked" : ""
   } id="flexCheckAgency" data-mitem="${item["M-Items"]}">
</td>

<td style="padding:10px;">
<select name="mitemchecking" disabled class="form-control total_amount input-lg" id="mitemchecking-row${
          index + 1
        }" data-mitem="${item["M-Items"]}">
   <option value="None"${
     item.Agencyprimarycode === "None" ? "selected" : ""
   }>None</option>
   <option value="Primary"${
     item.Agencyprimarycode === "Primary" ? "selected" : ""
   }>Primary</option>
</select>
</td>


         <td style="padding:10px"> <button type="button" class="btn mt-2 addnewcode" data-mitem="${
           item["M-Items"]
         }"><i class="fas fa-edit" title="Add"style="color:#31029c; cursor: pointer;"></i></button></td>

 
          </tr>`
      )
    );

    $('[data-toggle="tooltip"]').tooltip();

    $(document).ready(function () {
      $(".form-control").focus(function () {
        $(this).addClass("input-active"); // Add the input-active class when the input is focused
      });

      $(".form-control").blur(function () {
        $(this).removeClass("input-active"); // Remove the input-active class when the input loses focus
      });
    });

    while (mIndex < fieldData.length) {
      var n = fieldData[mIndex];
      rowCount++;
      serialNumber++;

      var current_count = mIndex++;

      $(this).val("");
    }

    $(".add").show();
  };

  //generating random mitems
  // const generateRandomString = (existingRowsData) => {
  //   const alphanumericCharacters =
  //     "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
  //   const minLength = 5;
  //   const maxLength = 5;

  //   const length =
  //     Math.floor(Math.random() * (maxLength - minLength + 1)) + minLength;

  //   const randomSlug = Array.from({ length }, () =>
  //     alphanumericCharacters.charAt(
  //       Math.floor(Math.random() * alphanumericCharacters.length)
  //     )
  //   ).join("");

  //   const formattedRandomString = `M${randomSlug.toUpperCase()}`;

  //   const findData = existingRowsData.find((item) => {
  //     if (item["M-Items"] === formattedRandomString) {
  //       return item;
  //     }
  //   });

  //   if (findData) {
  //     generateRandomString(existingRowsData);
  //   }
  //   return formattedRandomString;
  // };

  const generateRandomString = () => {
    var lastValue = $(
      "#dynamic_field tr:last-child td:first-child span"
    ).text();
    var valuelastdata = parseInt(lastValue) + 1;
    console.log(valuelastdata);
    let currentCharCode = 65;
    const formattedRandomString = `M10${valuelastdata}${String.fromCharCode(
      currentCharCode
    )}`;

    const findData = existingRowsData.find((item) => {
      if (item["M-Items"] === formattedRandomString) {
        return item;
      }
    });

    if (findData) {
      generateRandomString(existingRowsData);
    }
    console.log(formattedRandomString);
    return formattedRandomString;
  };

  var Id = document.getElementById("entryId").value;
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
    "M1024A",
    "M1025A",
    "M1026A",
    "M1027A",
    "M1028A",
    "M1029A",
    "M1030A",
    "M1031A",
    "M1032A",
    "M1033A",
    "M1034A",
    "M1035A",
    "M1036A",
    "M1037A",
    "M1038A",
    "M1039A",
    "M1040A",
    "M1041A",
    "M1042A",
    "M1043A",
    "M1044A",
    "M1045A",
    "M1046A",
    "M1047A",
    "M1048A",
    "M1049A",
    "M1050A",
    "M1051A",
    "M1052A",
    "M1053A",
    "M1054A",
    "M1055A",
    "M1056A",
    "M1057A",
    "M1058A",
    "M1059A",
    "M1060A"
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

  $.ajax({
    url: "QA/qc_displaydata.php",
    type: "POST",
    data: { Id: Id },
    success: function (response) {
      console.log(response);
      const codeData = response?.code_data || [];

      const removeExistingData = newArray.filter((item) => {
        const existingMItem = codeData?.find(
          (data) => data["M-Items"] === item["M-Items"]
        );
        if (!existingMItem) {
          return item;
        }
      });

      const filteredData = [...codeData, ...removeExistingData];

      existingRowsData = filteredData;

      // serialNumber = filteredData.length;
      // rowCount = filteredData.length;
      renderFields(filteredData);

      //       serialNumber = filteredData.length;
      //  rowCount = filteredData.length;
    },
    error: function (xhr, status, error) {
      console.error(error);
    },
  });

  //effective date checking

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

  // Event delegation for change events on dynamically added elements

  var enteredIcds = [];
  var filledValues = [];

  $("body").on("change", "#gender", function () {
    var icdElement = $('#dynamic_field[name="icd"]');

    // Trigger the event handler directly (assuming it's a separate function)
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

    if (icdValue.startsWith("Z")) {
      // Disable or hide the corresponding <td> element

      // Option 1: Disable the <select> element inside the <td>
      const ratingField = currentRow.find('select[name="rating"]');
      ratingField.prop("disabled", true);
    }

    $("#dynamic_field tbody tr").each(function (_, row) {
      var icd = $(row).find("td:eq(3) input").val().trim();
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
          currentRow.find('[name="icd"]').val("");
        }
      });
      currentRow.find('[name="icd"]').addClass("duplicate");
      return;
    }

    if (icdValue == "") {
      descriptionField.val("");
      return;
    }

    // Check if the icdValue is not empty
    if (icdValue?.length > 0) {
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
    //primary code checking

    if (mitem === "M1021A" && code) {
      $.ajax({
        type: "POST",
        url: "QA/qc_primary.php",
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

  // add more button function dynamic data display

  $("body").on("click", "#add", function () {
    var rowC = $(
      ".codesegement #dynamic_field tbody tr:last-child td:first-child span"
    ).text();

    console.log("insert", rowC);
    serialNumber = rowC;
    serialNumber++;
    add_mItem++;
    rowC++;

    const randomSlug = generateRandomString(existingRowsData);

    $("#dynamic_field tbody").append(
      `<tr id="row${rowCount}"  ondragstart="ondragstart(event)" ondrop="drop(event, this)" draggable="true">
                <td style="width: 10px; padding:10px;"><span class="spanremove">${serialNumber}</span></td>
                <td hidden><input type="text" name="EntryId" value="${Id}" class="form-control name_list input-lg form-input" hidden readonly/></td>
                <td style="width: 150px;padding:10px;"><input type="text" name="mitems" class="form-control   input-lg form-input" value="${randomSlug}"  hidden readonly data-mitem="${randomSlug}"/></td>
                <td style="width: 150px;padding:10px;"> <input type="text" name="icd" autocomplete="off" class="form-control name_email input-lg form-input"readonly style="text-transform: uppercase;" data-mitem="${randomSlug}"/></td>
                <td style="width: 500px;padding:10px;"><input type="text" name="description" class="form-control total_amount input-lg description form-input" readonly data-mitem="${randomSlug}" /></td>
                <td style="width: 150px;padding:10px;"><input type="text" name="effectivedate" class="form-control total_amount input-lg form-input" readonly data-mitem="${randomSlug}"/></td>
                <td style="padding:15px;width:100px">
                    <select name="eo" style="color: black;" class="form-control total_amount input-lg form-input" disabled data-mitem="${randomSlug}">
                        <option value="None">None</option>
                        <option value="E">E</option>
                        <option value="O">O</option>
                    </select>
                </td>
                <td style="padding:10px;">
                    <select name="rating" style="color: black;" class="form-control total_amount input-lg form-input" disabled data-mitem="${randomSlug}">
                        <option value="None">None</option>
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                </td>
                <td style="padding:10px;">
                <select name="reason" style="color: black;" class="form-control total_amount input-lg form-input qcreasonida_add" id="qcreasonida_add"hidden disabled data-mitem="${randomSlug}">
                <option value="None">None</option>
                <option value="Incorrect FOC">Incorrect FOC</option>
                <option value="Focus code specification modified">Focus code specification modified</option>
                <option value="Missed to Follow ICD Guideline">Missed to Follow ICD Guideline</option>
                <option value="Missed to Follow HH Guideline">Missed to Follow HH Guideline</option>
                <option value="Missed to review document properly">Missed to review document properly</option>
                <option value="Sequencing guidelines missed">Sequencing guidelines missed</option>
                <option value="Type-O-Error">Type-O-Error</option>
                <option value="Missed to Check Support for Acute DX">Missed to Check Support for Acute DX</option>
                <option value="Inappropriate code">Inappropriate code</option>
                <option value="Misssing Comorbid conditions">Misssing Comorbid conditions</option>

            </select>
                </td>
                <td style="padding:10px;"><select name="errortype" style="color: black;" class="form-control input_empty input-lg form-input errortypeid_add" disabled hidden id="errortypeid_add" data-mitem="${randomSlug}">
         <option value="None">None</option>
         <option value="Added">Added</option>
         <option value="Deleted">Deleted</option>
         <option value="Modified">Modified</option>
         <option value="Other">Other</option>
  
          </select></td>
          <td style="padding:10px;"> <textarea name="Qarationaile" style="color: black; font-size: 13px; height: 230px;
    width: 337px;" class="form-control-sm input_empty input-lg form-input Qarationaileid" disabled hidden id="errortypeid" data-mitem="${randomSlug}"></textarea>
</td>

<td style="padding:1px;"><input type="checkbox" value="Coder" readonly disabled name="coder" id="flexCheckCoder" data-mitem="${randomSlug}"></td>
                    <td style="padding:1px;"><input type="checkbox" readonly disabled name="agency" value="Agency" id="flexCheckAgency" data-mitem="${randomSlug}" ></td>
                    <td style="padding:10px;">
                    <select name="mitemchecking"  disabled class="form-control total_amount input-lg" data-mitem="${randomSlug}">
                        <option value="None">None</option>
                        <option value="Primary">Primary</option>
                    </select>
                </td>



              
<td> <button type="button" class="btn mt-2 addnewcode"><i class="fas fa-edit" title="Add"style="color:#31029c; cursor: pointer;"></i></button></td>

            </tr>`
    );
  });

  $('[data-toggle="tooltip"]').tooltip();

  //save the codesegement data
  $("body").on("click", ".addnewcode", handleAddNewCode);

  $("#btn_save").on("click", function () {
    var data = [];
    var enteredIcds = [];
    var isAnyFieldEmpty = false;
    var hasDuplicateIcd = false;
    var formattedDate;

    function isEmpty(value) {
      return value.trim() === "";
    }

    $("#dynamic_field tbody tr").each(function (index, row) {
      var icdInput = $(row).find("td:eq(3) input");
      var mitems = $(row).find("td:eq(2) input").val();

      if (icdInput.val().trim() !== "") {
        var icd = icdInput.val().trim();

        enteredIcds.push(icd);
        var gender = $("#gender").val();
        var EntryId = $(row).find("td:eq(1) input").val();
        var description = $(row).find("td:eq(4) input").val();
        var effectivedate = $(row).find("td:eq(5) input").val();
        var eo = $(row).find("td:eq(6) select").val();
        var rating = $(row).find("td:eq(7) select").val();
        var reason = $(row).find("td:eq(8) select").val();
        var errortype = $(row).find("td:eq(9) select").val();
        var qcrationaile = $(row).find("td:eq(10) textarea").val();

        var coderchecked = $(row)
          .find("td:eq(11) input[type='checkbox']:checked")
          .val();
        if (coderchecked === undefined) {
          coderchecked = "";
        }

        // alert(coderchecked);

        var agencychecked = $(row)
          .find("td:eq(12) input[type='checkbox']:checked")
          .val();
        if (agencychecked === undefined) {
          agencychecked = "";
        }
        var mitemchecking = $(row).find("td:eq(13) select").val();

        // console.log(qcrationaile);

        var rowData = {
          EntryId: EntryId,
          mitems: mitems,
          icd: icd,
          description: description,
          effectivedate: effectivedate,
          eo: eo,
          rating: rating,
          gender: gender,
          reason: reason,
          errortype: errortype,
          qcrationaile: qcrationaile,
          coderchecked: coderchecked,
          agencychecked: agencychecked,
          mitemchecking: mitemchecking,
        };

        data.push(rowData);

        console.log("insertdata", data);
      } else {
        isAnyFieldEmpty = true;
      }
    });
    $.ajax({
      type: "POST",
      url: "QA/qc_codesegement_v2.php",
      data: { dataArray: data },
      success: function (response) {
        // console.log(response);
        if (response == "") {
          Swal.fire({
            title: "Success!",
            text: "Data Inserted Successfully",
            icon: "success",
            confirmButtonText: "OK",
          }).then(function () {
            $(".saved-qccodesegement").removeAttr("hidden");
            qcscoringdisplay();
            fetchscore();
            $("#oasisscoringcontainer").load(
              window.location.href + "#oasisscoringcontainer"
            );
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
          return;
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
        // alert(response);
      },
    });

    if (data.length === 0 && isAnyFieldEmpty) {
      Swal.fire({
        title: "ERROR!",
        text: "Please fill in all fields",
        icon: "error",
        confirmButtonText: "OK",
      });
    }
  });
});

function handleAddNewCode(event) {
  event.preventDefault();
  var $clickedButton = $(this);

  var id = $clickedButton.closest("tr").attr("id");

  // console.log("arun",id);

  // console.log(id);
  $clickedButton.attr("disabled", true);

  var $closestRow = $clickedButton.closest("tr");

  // Change color of the original row to red
  $closestRow.css("background-color", "lightblue");

  var $clonedRow = $closestRow.clone();

  if ($clonedRow.css("background-color") === "lightblue") {
    $clonedRow.addClass("cloneddata");

    var spandata = $clonedRow.find(".spanremove").text();

    // console.log(spandata);

    $clonedRow.attr("data-cloneid", 100 + spandata);
  }

  $clonedRow.find("td:last-child").remove();
  $clonedRow.find(".spanremove").hide();
  $clonedRow
    .find('input.form-input[type="text"]')
    .removeAttr("readonly")
    .addClass("newcode");
  // Assuming this line is within your existing code logic
  $clonedRow
    .find('input.form-input[name="effectivedate"]')
    .addClass("datepicker");
  $clonedRow.find('input[name="description"]').addClass("newcode");
  $clonedRow.find('input[name="mitems"]').addClass("newcode");

  $clonedRow
    .find('input[type="checkbox"]')
    .removeAttr("readonly")
    .removeAttr("disabled")
    .addClass("newcode");

  $clonedRow
    .find("select")
    .trigger("change")
    .removeAttr("disabled")
    .removeAttr("hidden")

    .addClass("newcode")
    .css({
      color: "black",
    });

  $clonedRow.find('input.input_empty[type="text"]');
  $clonedRow
    .find("textarea")
    .removeAttr("disabled")
    .removeAttr("hidden")

    .addClass("newcode");

  var $removeButton = $(
    '<td><button class="btn new-row remove_row"><i class="fas fa-times"  title="close" style="color:#ec111a; cursor: pointer;"></i></button></td>'
  );
  $removeButton.on("click", function () {
    $clickedButton.attr("disabled", false);
    $(this).closest("tr").remove();
  });

  $closestRow.css("background-color", ""); // Reset the background color of the original row

  // Append the remove button to the cloned row
  $clonedRow.append($removeButton);

  // Append QC Reason section next to the remove button in the cloned row
  // $clonedRow.append($qcReasonContainer);

  $closestRow.after($clonedRow);

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

    // datepicker_hide AND SHOW CODE START
    $(".datepicker").on("focus", function () {
      var $this = $(this);

      $this.datepicker("hide");

      // Event handler for keyup (including F2 key)
      $(document).on("keyup.datepicker", function (e) {
        // Check if the focused field is the current input field and the F2 key is pressed
        if ($this.is(":focus") && e.keyCode === 113) {
          // Open the datepicker
          $this.datepicker("show");
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
  });
}

function qcscoringdisplay() {
  var Id = $(".entryid").val();

  $.ajax({
    type: "post",
    url: "QA/qcscoringfetch_v2.php?action=codescore",
    data: {
      Id: Id,
    },

    success: function (resposne) {
      console.log("codescore:", response);

      // alert(response);
    },

    error: function (xhr, status, error) {
      console.error(xhr.responseText);
      // $("#result").text("Error occurred while fetching data");
    },
  });
}

function coderselectall() {
  $("#coderselectall").on("click", function () {
    var anyChecked = false;

    // Check if any checkbox is checked
    $("#dynamic_field tbody tr").each(function () {
      if (
        $(this)
          .find("input[type='checkbox'][id='flexCheckCoder']")
          .prop("checked")
      ) {
        anyChecked = true;
        return false; // Exit the loop early since we found a checked checkbox
      }
    });

    // Toggle checkboxes based on anyChecked
    $("#dynamic_field tbody tr").each(function () {
      // Find the icd input field in the current row
      var icdField = $(this).find("input[name='icd']");
      // Check if the icd field has a value
      if (!anyChecked) {
        // If no checkbox is checked, check all checkboxes
        if (icdField.val().trim() !== "") {
          $(this)
            .find("input[type='checkbox'][id='flexCheckCoder']")
            .prop("checked", true);
        }
      } else {
        // If any checkbox is checked, uncheck all checkboxes
        $(this)
          .find("input[type='checkbox'][id='flexCheckCoder']")
          .prop("checked", false);
      }
    });
  });
}

function agencyselectall() {
  $("#agencyselectall").on("click", function () {
    var anyChecked = false;

    // Check if any checkbox is checked
    $("#dynamic_field tbody tr").each(function () {
      if (
        $(this)
          .find("input[type='checkbox'][id='flexCheckAgency']")
          .prop("checked")
      ) {
        anyChecked = true;
        return false; // Exit the loop early since we found a checked checkbox
      }
    });

    // Toggle checkboxes based on anyChecked
    $("#dynamic_field tbody tr").each(function () {
      // Find the icd input field in the current row
      var icdField = $(this).find("input[name='icd']");
      // Check if the icd field has a value
      if (!anyChecked) {
        // If no checkbox is checked, check all checkboxes
        if (icdField.val().trim() !== "") {
          $(this)
            .find("input[type='checkbox'][id='flexCheckAgency']")
            .prop("checked", true);
        }
      } else {
        // If any checkbox is checked, uncheck all checkboxes
        $(this)
          .find("input[type='checkbox'][id='flexCheckAgency']")
          .prop("checked", false);
      }
    });
  });
}
