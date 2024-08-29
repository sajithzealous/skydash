$(document).ready(function () {
  var Id = $(".entryIdoasis").val();
  coderDatashow(Id);
  oasisshowDataqc(Id);
  pocshowDataqc(Id);
  codeDataQc(Id);
});

//coderdata show in qc
function coderDatashow(Id) {
  $.ajax({
    url: "QA/qc_displaydata.php",
    type: "POST",
    data: { Id: Id },
    success: function (response) {
      // Assuming response is an array of object
      var oasisData = response.oasis_data;
      var pocData = response.poc_data;
      var ggitemData = response.ggitem_data;

      // console.log(pocData);
      if (oasisData.length > 0) {
        $.each(oasisData, function (index, oasisrow) {
          var Mitem = oasisrow.M_item;
          var Agency_response = oasisrow.Agency_response;
          var Coder_response = oasisrow.Coder_response;
          var Coder_rationali = oasisrow.Coder_rationali;

          // data-mitem="Section A - Administrative Information (M0018 - NPI)= M0018 - NPI

          $('.us-input-3[data-mitem*="' + Mitem + '"]').val(Coder_rationali);

          if (Agency_response.includes(",")) {
            // Define a pattern to match numbered or lettered points followed by a space, capturing text until the next comma or end of line
            let pattern = /\b[A-Z\d]+(?:\.\s.*?|(?=,\s|$))/g;

            // Find matches based on the defined pattern in the Agency_response
            let matches = Agency_response.match(pattern);

            // If matches are found
            if (matches !== null) {
              let valuesArray = matches.map((value) => value.trim());
              // console.log("Values Array:", valuesArray); // Debugging
              valuesArray.forEach((value) => {
                $('.us-input-1[data-mitem*="' + Mitem + '"]')
                  .find("option")
                  .filter(function () {
                    // console.log("Comparing:", $(this).text(), value); // Debugging
                    return $(this).text().startsWith(value);
                  })
                  .prop("selected", true);
              });
            }
          } else {
            // If no commas in Agency_response, assign the value directly to the input field
            $('.us-input-1[data-mitem*="' + Mitem + '"]').val(Agency_response);
          }

          if (Coder_response.includes(",")) {
            // Define a pattern to match numbered or lettered points followed by a space, capturing text until the next comma or end of line
            let pattern = /\b[A-Z\d]+(?:\.\s.*?|(?=,\s|$))/g;

            // Find matches based on the defined pattern in the Coder_response
            let matches = Coder_response.match(pattern);

            // If matches are found
            if (matches !== null) {
              // Trim and extract the matched values into an array
              let valuesArray = matches.map((value) => value.trim());

              // Iterate through each value
              valuesArray.forEach((value) => {
                $('.us-input-2[data-mitem*="' + Mitem + '"]')
                  .find("option")
                  .filter(function () {
                    return $(this).text().startsWith(value);
                  })
                  .prop("selected", true);
              });
            }
          } else {
            // If no commas in Coder_response, assign the value directly to the input field
            $('.us-input-2[data-mitem*="' + Mitem + '"]').val(Coder_response);
          }
        });
      } else {
        console.log("1");
      }

      //poc retrive data
      $.each(pocData, function (index, pocrow) {
        var PocItem = pocrow.Poc_item;
        var Coder_response = pocrow.Coder_response;

        // alert("ssss",Coder_response)

        // Set values in HTML elements
        $('.us-inpu-1[data-pocitem="' + PocItem + '"]').val(Coder_response);
      });

      $(document).ready(function () {
        if (ggitemData.length > 0) {
          $.each(ggitemData, function (index, ggitemrow) {
            var ggitemheader = ggitemrow.header;
            var ggitemcoderrationali = ggitemrow.Coder_rationali;
            var ggitemerrorreason = ggitemrow.Error_reason;
            var ggitemerrortype = ggitemrow.Error_type;

            // console.log('ggitemerrorreason',ggitemerrorreason)

            if (ggitemcoderrationali === "Null") {
              ggitemcoderrationali = "";
            }

            if (ggitemerrorreason === "Null") {
              ggitemerrorreason = "";
            }

            if (ggitemerrortype === "Null") {
              ggitemerrortype = "";
            }

            // console.log("heyhello",ggitemcoderrationali);

            var $textarea = $(
              '.textareadata .textareafor[data-section*="' + ggitemheader + '"]'
            );

            // var errorreason = $(".ggmitemcard")
            //   .find(
            //     '.selectone .ggitemerrorreason[data-section*="' +
            //       ggitemheader +
            //       '"] option[value="' +
            //       ggitemerrorreason +
            //       '"]'
            //   )
            //   .prop("selected", true);

            // var errortype = $(".ggmitemcard")
            //   .find(
            //     '.selectone .ggitemerrortype[data-section*="' +
            //       ggitemheader +
            //       '"] option[value="' +
            //       ggitemerrortype +
            //       '"]'
            //   )
            //   .prop("selected", true);

            var errorreason =
              '.ggmitemcard .selectone .ggitemerrorreason[data-section*="' +
              ggitemheader +
              '"]';
            $(errorreason).val(ggitemerrorreason).change();

            var errortype =
              '.ggmitemcard .selectone .ggitemerrortype[data-section*="' +
              ggitemheader +
              '"]';
            $(errortype).val(ggitemerrortype).change();

            if ($textarea.length > 0) {
              $textarea.html(ggitemcoderrationali);

              // console.log(ggitemcoderrationali);
            } else {
              // console.error("Textarea not found for ggitemheader:", ggitemheader);
            }
          });
        }
      });
    },

    error: function (jqXHR, textStatus, errorThrown) {
      console.log(errorThrown);
    },
  });
}

//qc codesegementdata show
function codeDataQc(Id) {
  $.ajax({
    url: "QA/qc_showdata.php",
    type: "POST",
    data: { Id: Id },
    success: function (response) {
      // Assuming response is an array of object
      var codeData = response.code_data;

      console.log("coder_data", codeData);
      // console.log("sajith",codeData);

      // Move these outside the loop to maintain their state
      var rowC = $("#dynamic_field tr:last-child td:first-child span")
        .text()
        .trim();
      // var rowC = $("#dynamic_field tr:last-child td:first-child").text();
      // console.log("display_js",rowC)
      // console.log(rowC); // Output the text to console

      var rowCount = parseInt(rowC) + 1;

      serialNumber = rowCount;

      // alert('hello');
      // var rowCount = 26;
      // var serialNumber = 26;
      // Define a function to handle setting values
      function setSelectOption($form, mitem, selectName, optionValue) {
        $form
          .find(
            'select[name="' +
              selectName +
              '"].newcode[data-mitem*="' +
              mitem +
              '"]'
          )
          .find('option[value="' + optionValue + '"]')
          .prop("selected", true);
      }

      function setCheckboxOption($form, mitem, checkboxName, checkboxValue) {
        $form
          .find(
            'input[type="checkbox"][name="' +
              checkboxName +
              '"][data-mitem*="' +
              mitem +
              '"]'
          )
          .filter(function () {
            return $(this).val() === checkboxValue;
          })
          .prop("checked", true);
      }

      // Usage example:
      function setValuesForNewCode(
        mitem,
        icdcode,
        description,
        effective_Date,
        eo,
        rating,
        errorreason,
        errortype,
        qc_rationali,
        coder_checked,
        agency_checked,
        agencyprimarycode
      ) {
        var $form = $("#add_name");

        // Set input field values
        $form
          .find('input[name="icd"].newcode[data-mitem*="' + mitem + '"]')
          .val(icdcode);
        $form
          .find(
            'input[name="description"].newcode[data-mitem*="' + mitem + '"]'
          )
          .val(description);
        $form
          .find(
            'input[name="effectivedate"].newcode[data-mitem*="' + mitem + '"]'
          )
          .val(effective_Date);

        // Set select options using new function
        setSelectOption($form, mitem, "eo", eo);
        setSelectOption($form, mitem, "rating", rating);
        setSelectOption($form, mitem, "qcreason", errorreason);
        setSelectOption($form, mitem, "errortype", errortype);

        // Set textarea value
        $form
          .find(
            'textarea[name="Qarationaile"].newcode[data-mitem*="' + mitem + '"]'
          )
          .val(qc_rationali);
        setCheckboxOption($form, mitem, "coder", coder_checked);
        setCheckboxOption($form, mitem, "agency", agency_checked);

        setSelectOption($form, mitem, "mitemchecking", agencyprimarycode);
      }

      // Iterate through each object in codeData
      $.each(codeData, function (index, coderow) {
        var mitem = coderow.M_Item;
        var icdcode = coderow.icdcode;
        var description = coderow.Description;
        var effective_Date = coderow.Effective_Date;
        var eo = coderow.Eo;
        var rating = coderow.Rating;
        var errorreason = coderow.Error_reason;
        var errortype = coderow.Error_type;
        var qc_rationali = coderow.Qc_rationali;
        var coder_checked = coderow.Coderchecked;
        var agency_checked = coderow.Agencychecked;
        var agencyprimarycode = coderow.Agencyprimarycode;

        if (mitem != "") {
          if (
            mitem == "M1021A" ||
            mitem == "M1023B" ||
            mitem == "M1023C" ||
            mitem == "M1023D" ||
            mitem == "M1023E" ||
            mitem == "M1023F" ||
            mitem == "M1023G" ||
            mitem == "M1023H" ||
            mitem == "M1023I" ||
            mitem == "M1023J" ||
            mitem == "M1023K" ||
            mitem == "M1023L" ||
            mitem == "M1023M" ||
            mitem == "M1023N" ||
            mitem == "M1023O" ||
            mitem == "M1023P" ||
            mitem == "M1023Q" ||
            mitem == "M1023R" ||
            mitem == "M1023S" ||
            mitem == "M1023T" ||
            mitem == "M1023U" ||
            mitem == "M1023V" ||
            mitem == "M1023W" ||
            mitem == "M1023X" ||
            mitem == "M1023Y"
          ) {
            var button = $(".codesegement").find(
              '.addnewcode[data-mitem*="' + mitem + '"]'
            );
            button.trigger("click");

            setValuesForNewCode(
              mitem,
              icdcode,
              description,
              effective_Date,
              eo,
              rating,
              errorreason,
              errortype,
              qc_rationali,
              coder_checked,
              agency_checked,
              agencyprimarycode
            );
          } else {
            // Dynamically create and append HTML elements for new codes
            var Id = document.getElementById("entryId").value;
            $("#dynamic_field tbody").append(
              `<tr id="row${rowCount}"  ondragstart="ondragstart(event)" ondrop="drop(event, this)" draggable="true">
                              <td style="width: 10px; padding:10px;"><span class="spanremove" data-value="${serialNumber}">${serialNumber}</span></td>
                              <td hidden><input type="text" name="EntryId" value="${Id}" class="form-control name_list input-lg form-input" hidden readonly/></td>
                              <td style="width: 150px;padding:10px;"><input type="text" name="mitems" class="form-control   input-lg form-input" value="${mitem}"  hidden readonly data-mitem="${mitem}"/></td>
                              <td style="width: 150px;padding:10px;"> <input type="text" name="icd" autocomplete="off" class="form-control name_email input-lg form-input newcode"readonly style="text-transform: uppercase;" data-mitem="${mitem}"/></td>
                              <td style="width: 500px;padding:10px;"><input type="text" name="description" class="form-control total_amount input-lg description form-input newcode" readonly data-mitem="${mitem}" /></td>
                              <td style="width: 150px;padding:10px;"><input type="text" name="effectivedate" class="form-control total_amount input-lg form-input newcode" readonly data-mitem="${mitem}"/></td>
                              <td style="padding:15px;width:100px">
                                  <select name="eo" style="color: black;" class="form-control total_amount input-lg form-input newcode" disabled data-mitem="${mitem}">
                                      <option value="None">None</option>
                                      <option value="E">E</option>
                                      <option value="O">O</option>
                                  </select>
                              </td>
                              <td style="padding:10px;">
                                  <select name="rating" style="color: black;" class="form-control total_amount input-lg form-input newcode" disabled data-mitem="${mitem}">
                                      <option value="None">None</option>
                                      <option value="0">0</option>
                                      <option value="1">1</option>
                                      <option value="2">2</option>
                                      <option value="3">3</option>
                                      <option value="4">4</option>
                                  </select>
                              </td>
                              <td style="padding:10px;">
                                  <select name="reason" style="color: black;" class="form-control total_amount input-lg form-input qcreasonida_add newcode" id="qcreasonida_add" hidden disabled data-mitem="${mitem}">
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
                              <td style="padding:10px;"><select name="errortype" style="color: black;" class="form-control input_empty input-lg form-input errortypeid_add newcode" disabled hidden id="errortypeid_add" data-mitem="${mitem}">
                                  <option value="None">None</option>
                                  <option value="Added">Added</option>
                                  <option value="Deleted">Deleted</option>
                                  <option value="Modified">Modified</option>
                                  <option value="Other">Other</option>
                              </select></td>
                              <td style="padding:10px;"> <textarea name="Qarationaile" style="color: black; font-size: 13px;min-height:230px;width: 337px;" class="form-control-sm input_empty input-lg form-input Qarationaileid newcode" disabled hidden id="errortypeid" data-mitem="${mitem}"></textarea></td>
                              

                              <td style="padding:1px;"><input type="checkbox" class="newcode" value="Coder" name="coder" id="flexCheckCoder" data-mitem="${mitem}" disabled readonly></td>
                    <td style="padding:1px;"><input type="checkbox" name="agency" class="newcode" value="Agency" id="flexCheckAgency" data-mitem="${mitem}" disabled readonly></td>
                    <td style="padding:10px;">
                    <select name="mitemchecking" class="form-control total_amount input-lg newcode"  d0ata-mitem="${mitem}" disabled>
                        <option value="None">None</option>
                        <option value="Primary">Primary</option>
                    </select>
                </td>
                <td> <button type="button" class="btn mt-2 addnewcode" data-mitem="${mitem}"><i class="fas fa-edit" title="Add" style="color:#31029c; cursor: pointer;" ></i></button></td>
                          </tr>`
            );

            //Increment rowCount and serialNumber
            rowCount++;
            serialNumber++;
            // Set values for new code
            setValuesForNewCode(
              mitem,
              icdcode,
              description,
              effective_Date,
              eo,
              rating,
              errorreason,
              errortype,
              qc_rationali,
              coder_checked,
              agency_checked,
              agencyprimarycode
            );
            var button = $(".codesegement").find(
              '.addnewcode[data-mitem*="' + mitem + '"]'
            );
            button.trigger("click");
            // console.log('button',button);
          }
        }
      });
    },
  });
}

// qc oasissegementdata show
function oasisshowDataqc(Id) {
  // Id = $(".entryIdoasis").val();
  $.ajax({
    url: "QA/qc_showdata.php",
    type: "POST",
    data: { Id: Id },
    success: function (response) {
      // Assuming response is an array of object
      var oasisData = response.oasis_data;

      //  console.log(oasisData);

      // console.log(ggitemData);
      if (oasisData.length > 0) {
        $.each(oasisData, function (index, oasisrow) {
          var Mitem = oasisrow.M_item;
          var Agency_response = oasisrow.Agency_response;
          var Coder_response = oasisrow.Coder_response;
          var Qc_response = oasisrow.Qc_response;
          var Coder_rationali = oasisrow.Coder_rationali;
          var Qc_rationali = oasisrow.Qc_rationali;
          var Error_reason = oasisrow.Error_reason;
          var Error_type = oasisrow.Error_type;

          if (Qc_response !== "") {
            var button = $("#carouselRow").find(
              '.addnewoasis[data-mitem*="' + Mitem + '"]'
            );
            button.trigger("click");
          }

          $('.us-input-3[data-mitem*="' + Mitem + '"]').val(Coder_rationali);

          var oasiserrorreason = $(".oasis_form")
            .find(
              '.oasiserrorreason[data-mitem*="' +
                Mitem +
                '"] option[value="' +
                Error_reason +
                '"]'
            )
            .prop("selected", true);

          // console.log(oasiserrorreason);
          var oasiserrortype = $(".oasis_form")
            .find(
              '.oasiserrortype[data-mitem*="' +
                Mitem +
                '"] option[value="' +
                Error_type +
                '"]'
            )
            .prop("selected", true);

          // console.log(Error_reason);
          // console.log(Error_type);

          // $(".oasis_form .oasiserrorreason[data-mitem*='" + Mitem + "']").val(Error_reason).change();

          // $(".oasis_form .oasiserrortype[data-mitem*='" + Mitem + "']").val(Error_type).change();

          $('.oasisqcrationaile[data-mitem*="' + Mitem + '"]').val(
            Qc_rationali
          );

          if (Agency_response.includes(",")) {
            // Define a pattern to match numbered or lettered points followed by a space, capturing text until the next comma or end of line
            let pattern = /\b[A-Z\d]+(?:\.\s.*?|(?=,\s|$))/g;

            // Find matches based on the defined pattern in the Agency_response
            let matches = Agency_response.match(pattern);

            // If matches are found
            if (matches !== null) {
              // Trim and extract the matched values into an array
              let valuesArray = matches.map((value) => value.trim());
              valuesArray.forEach((value) => {
                $('.us-input-1[data-mitem*="' + Mitem + '"]')
                  .find("option")
                  .filter(function () {
                    return $(this).text().startsWith(value);
                  })
                  .prop("selected", true);
              });
            }
          } else {
            // If no commas in Agency_response, assign the value directly to the input field
            $('.us-input-1[data-mitem*="' + Mitem + '"]').val(Agency_response);
          }

          if (Coder_response.includes(",")) {
            // Define a pattern to match numbered or lettered points followed by a space, capturing text until the next comma or end of line
            let pattern = /\b[A-Z\d]+(?:\.\s.*?|(?=,\s|$))/g;

            // Find matches based on the defined pattern in the Coder_response
            let matches = Coder_response.match(pattern);

            // If matches are found
            if (matches !== null) {
              // Trim and extract the matched values into an array
              let valuesArray = matches.map((value) => value.trim());

              // Iterate through each value
              valuesArray.forEach((value) => {
                $('.us-input-2[data-mitem*="' + Mitem + '"]')
                  .find("option")
                  .filter(function () {
                    return $(this).text().startsWith(value);
                  })
                  .prop("selected", true);
              });
            }
          } else {
            // If no commas in Coder_response, assign the value directly to the input field
            $('.us-input-2[data-mitem*="' + Mitem + '"]').val(Coder_response);
          }

          if (Qc_response.includes(",")) {
            // Define a pattern to match numbered or lettered points followed by a space, capturing text until the next comma or end of line
            let pattern = /\b[A-Z\d]+(?:\.\s.*?|(?=,\s|$))/g;

            // Find matches based on the defined pattern in the  Qc_response
            let matches = Qc_response.match(pattern);
            // console.log("datawant", Qc_response);

            // If matches are found
            if (matches !== null) {
              // Trim and extract the matched values into an array
              let valuesArray = matches.map((value) => value.trim());
              valuesArray.forEach((value) => {
                $('.us-input-4[data-mitem*="' + Mitem + '"]')
                  .find("option")
                  .filter(function () {
                    return $(this).text().startsWith(value);
                  })
                  .prop("selected", true);
              });
            }
          } else {
            // console.log("datawant2222", Qc_response);
            // If no commas in  Qc_response, assign the value directly to the input field
            $('.us-input-4[data-mitem*="' + Mitem + '"]').val(Qc_response);
          }
        });
      } else {
        console.log("1");
      }
    },

    error: function (jqXHR, textStatus, errorThrown) {
      console.log(errorThrown);
    },
  });
}
// qc pocsegementdata show
function pocshowDataqc(Id) {
  $.ajax({
    url: "QA/qc_showdata.php",
    type: "POST",
    data: { Id: Id },
    success: function (response) {
      // Assuming response is an array of object
      var pocDatas = response.poc_data;

      console.log(pocDatas);

      $.each(pocDatas, function (index, pocrows) {
        var PocItem = pocrows.Poc_item;
        var Coder_response = pocrows.Coder_response;
        var Error_reason = pocrows.Error_reason;
        var Error_type = pocrows.Error_type;
        var Qc_rationali = pocrows.Qc_rationali;

        if (Coder_response != "") {
          var button = $("#pocsegementRow").find(
            '.addnewpoc[data-mitem*="' + PocItem + '"]'
          );
          button.trigger("click");
        }

        // Set values in HTML elements
        $('.inputpoc[data-pocitem*="' + PocItem + '"]').val(Coder_response);
        $('.pocqcrationaile[data-mitem*="' + PocItem + '"]').val(Qc_rationali);
        // var rowdtaapoc = $(".form-row")
        //   .find(
        //     '.pocerrorreason[data-mitem*="' + PocItem + '"] option[value="' +
        //       Error_reason +
        //       '"]'
        //   )
        //   .prop("selected", true);
        $(".form-row .pocerrorreason[data-mitem*='" + PocItem + "']")
          .val(Error_reason)
          .change();
        // var rowdta = $(".form-row")
        //   .find(
        //     '.pocerrortype[data-mitem*="' +
        //       PocItem +
        //       '"] option[value="' +
        //       Error_type +
        //       '"]'
        //   )
        //   .prop("selected", true);
        $(".form-row .pocerrortype[data-mitem*='" + PocItem + "']")
          .val(Error_type)
          .change();
      });
    },
  });
}
