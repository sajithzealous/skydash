$(document).ready(function () {
  var Id = $("#wipdata").val();

  $.ajax({
    url: "Assign/wipdisplaydata.php",
    type: "POST",
    data: { Id: Id },
    success: function (response) {
      // Assuming response is an array of object
      // console.log(response);

      var oasisData = response.oasis_data;
      var pocData = response.poc_data;
      var ggitemData = response.ggitem_data;
console.log("oasisData",oasisData);
      // console.log(ggitemData);
      if (oasisData.length > 0) {
        $.each(oasisData, function (index, oasisrow) {
          var header = oasisrow.header;
          var Mitem = oasisrow.M_item;
          var Agency_response = oasisrow.Agency_response;
          var Coder_response = oasisrow.Coder_response;
          var Coder_rationali = oasisrow.Coder_rationali;

          $('.us-input-3[data-mitem="' + header + '"]').val(Coder_rationali);

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
                $('.us-input-1[data-mitem="' + header + '"]')
                  .find("option")
                  .filter(function () {
                    return $(this).text().startsWith(value);
                  })
                  .prop("selected", true);
              });
            }
          } else {
            // console.log(Agency_response);
            // If no commas in Agency_response, assign the value directly to the input field
            $('.us-input-1[data-mitem="' + header + '"]').val(Agency_response);
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
                $('.us-input-2[data-mitem="' + header + '"]')
                  .find("option")
                  .filter(function () {
                    return $(this).text().startsWith(value);
                  })
                  .prop("selected", true);
              });
            }
          } else {
            // If no commas in Coder_response, assign the value directly to the input field
            $('.us-input-2[data-mitem="' + header + '"]').val(Coder_response);
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

      //ggitem retervie data process
      //  if(ggitemData.length > 0){

      //   $.each(ggitemData , function (index,ggitemrow){

      //     var ggitemheader=ggitemrow.header;
      //     var ggitemmitem=ggitemrow.M_item;
      //     var ggitemagecnyresponse=ggitemrow.Agency_response;
      //     var ggitemcoderresponse=ggitemrow.Coder_response;
      //     var ggitemcoderrationali=ggitemrow.Coder_rationali;

      //     ('.textareadata .textareafor[data-section="' + ggitemheader + '"]').val(ggitemcoderrationali);

      //     console.log(ggitemcoderrationali);

      //   });


        
      //  }

      $(document).ready(function() {
        if (ggitemData.length > 0) {
            $.each(ggitemData, function(index, ggitemrow) {
                var ggitemheader = ggitemrow.header;
                var ggitemcoderrationali = ggitemrow.Coder_rationali;
    
                if(ggitemcoderrationali === 'Null') {
                    ggitemcoderrationali = '';
                }
    
                var $textarea = $('.textareadata .textareafor[data-section="' + ggitemheader + '"]');
    
                if ($textarea.length > 0) {
                    $textarea.html(ggitemcoderrationali);
                } else {
                    console.error("Textarea not found for ggitemheader:", ggitemheader);
                }
            });
        }
    });
    

   

   
    
    

    },

    error: function (jqXHR, textStatus, errorThrown) {
      console.log(errorThrown);
    },
  });
});
