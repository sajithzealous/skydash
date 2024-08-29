$(document).ready(function () {
  var Id = $(".entryIdoasis").val();

  $.ajax({
    url: "PendingWip/pendingdisplaydata.php",
    type: "POST",
    data: { Id: Id },
    success: function (response) {
      // Assuming response is an array of object
      var oasisData = response.oasis_data;
      var pocData = response.poc_data;

      console.log(pocData);
      if (oasisData.length > 0) {
        $.each(oasisData, function (index, oasisrow) {
          var Mitem = oasisrow.M_item;
          var Agency_response = oasisrow.Agency_response;
          var Coder_response = oasisrow.Coder_response;
          var Coder_rationali = oasisrow.Coder_rationali;

          $('.us-input-3[data-mitem="' + Mitem + '"]').val(Coder_rationali);

          if (Agency_response.includes(",")) {
            // Define a pattern to match numbered or lettered points followed by a space, capturing text until the next comma or end of line
            let pattern = /\b[A-Z\d]+(?:\.\s.*?|(?=,\s|$))/g;

            // Find matches based on the defined pattern in the Agency_response
            let matches = Agency_response.match(pattern);

            // If matches are found
            if (matches !== null) {
              // Trim and extract the matched values into an array
              let valuesArray = matches.map((value) => value.trim());

              // Iterate through each value
            //   valuesArray.forEach((value) => {
            //     // Select the corresponding option in the dropdown menu by text content
            //     $('.us-input-1[data-mitem="' + Mitem + '"]')
            //       .find('option:contains("' + value + '")')
            //       .prop("selected", true);
            //   });
            valuesArray.forEach(value => {
                $('.us-input-1[data-mitem="' + Mitem + '"]').find('option').filter(function() {
                    return $(this).text().startsWith(value);
                }).prop('selected', true);
            });
            }
          } else {
            // If no commas in Agency_response, assign the value directly to the input field
            $('.us-input-1[data-mitem="' + Mitem + '"]').val(Agency_response);
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
              valuesArray.forEach(value => {
                $('.us-input-2[data-mitem="' + Mitem + '"]').find('option').filter(function() {
                    return $(this).text().startsWith(value);
                }).prop('selected', true);
            });
            }
          } else {
            // If no commas in Coder_response, assign the value directly to the input field
            $('.us-input-2[data-mitem="' + Mitem + '"]').val(Coder_response);
          }
        });
      } else {
        console.log("1");
      }

      //poc retrive data
      $.each(pocData, function (index, pocrow) {
        var PocItem = pocrow.Poc_item;
        var Coder_response = pocrow.Coder_response;

        // Set values in HTML elements
        $('.us-inpu-1[data-pocitem="' + PocItem + '"]').val(Coder_response);
      });
    },

    error: function (jqXHR, textStatus, errorThrown) {
      console.log(errorThrown);
    },
  });
});
