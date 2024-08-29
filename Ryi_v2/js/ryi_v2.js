$(document).ready(function () {
  ppsValue();
  datashow();
  $("#btn_save_oasis").on("click", function () {
    const Id = $("#entryId").val();

    // Using Promise.all to execute all position functions concurrently
    Promise.all([
      positionOne(),
      positionTwo(Id),
      positionFour(Id),
      positionFive(),
    ])
      .then(
        ([
          positionOneResponse,
          positionTwoResponse,
          positionFourResponse,
          positionFiveResponse,
        ]) => {
          // Concatenate all position values here
          var concatenatedValues = {
            positionOne: positionOneResponse,
            positionTwo: positionTwoResponse,
            positionFour: positionFourResponse,
            positionFive: positionFiveResponse,
          };

          // Concatenate agency data

          var concatenatedPositionValuesagency =
            concatenatedValues.positionOne +
            concatenatedValues.positionTwo.positionTwoResponse
              .positiontwovalueagency +
            concatenatedValues.positionTwo.positionThreeResponse
              .positionThreeagencyvalues +
            concatenatedValues.positionFour.positionfourvalueagency +
            concatenatedValues.positionFive.positionfivevalueagency;
          // Concatenate coder data
          var concatenatedPositionValuescoder =
            concatenatedValues.positionOne +
            concatenatedValues.positionTwo.positionTwoResponse
              .positiontwovaluecoder +
            concatenatedValues.positionTwo.positionThreeResponse
              .positionThreecodervalues +
            concatenatedValues.positionFour.positionfourvaluecoder +
            concatenatedValues.positionFive.positionfivevaluecoder;
          // console.log("johnvalue",concatenatedValues);
          // console.log("agency", agency);
          // console.log("coder", coder);

          hppsCode(
            concatenatedPositionValuesagency,
            concatenatedPositionValuescoder
          );
        }
      )
      .catch((error) => {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "An error occurred!",
          footer: error, // You can append the error message here
        });
        // console.error("An error occurred while fetching position data:", error);
      });
  });
});

//position one admission source  and timing taken
function positionOne() {
  var timing = $("#timingSelect").val();
  var source = $("#admissionSourceSelect").val();

  return new Promise((resolve, reject) => {
    $.ajax({
      type: "POST",
      url: "Ryi_v2/position1_v2.php",
      data: {
        timing: timing,
        source: source,
      },
      success: function (response) {
        resolve(
          (positiononevalueagency = response),
          (positiononevaluecoder = response)
        );
      },
      error: function (jqXHR, textStatus, errorThrown) {
        reject(errorThrown);
      },
    });
  });
}

// posiiton two data
function positionTwo(Id) {
  return new Promise((resolve, reject) => {
    $.ajax({
      type: "POST",
      url: "Ryi_v2/position2_v2.php",
      data: {
        Id: Id,
      },
      success: function (response) {
        // Parse JSON response
        var data = JSON.parse(response);

        var Clinicalgroupcoder = data.coder.Clinicalgroup.toString();
        var positiontwovaluecoder = Clinicalgroupcoder;

        var Clinicalgroupagency = data.agency.Clinicalgroup.toString();
        var positiontwovalueagency = Clinicalgroupagency;

        console.log("positiontwovalueagency", positiontwovalueagency);
        console.log("positiontwovaluecoder", positiontwovaluecoder);

        var clinicalGroupNamecoder = data.coder.Clinicalgroupname.toString();
        var clinicalGroupNameagency = data.agency.Clinicalgroupname.toString();

        // Call positionThree function
        positionThree(clinicalGroupNamecoder, clinicalGroupNameagency, Id)
          .then((positionThreeResponse) => {
            // Once positionThree function resolves, resolve this promise with the combined response
            resolve({
              positionTwoResponse: {
                positiontwovalueagency: positiontwovalueagency,
                positiontwovaluecoder: positiontwovaluecoder,
              },
              positionThreeResponse: positionThreeResponse,
            });
          })
          .catch((error) => {
            // If there's an error in positionThree function, reject this promise
            reject(error);
          });
      },
      error: function (jqXHR, textStatus, errorThrown) {
        // Reject this promise if there's an error in the AJAX call
        reject(errorThrown);
      },
    });
  });
}

//position Three data
function positionThree(clinicalGroupNamecoder, clinicalGroupNameagency, Id) {
  return new Promise((resolve, reject) => {
    var mItems = [];
    var agencyValues = [];
    var coderValues = [];

    $.ajax({
      type: "POST",
      url: "Ryi_v2/ryi_oasisjsonfetch_v2.php",
      data: {
        Id: Id,
      },
      success: function (response) {
        $.each(response, function (mItem, data) {
          mItems.push(mItem);
          agencyValues.push(data.Sum_Agency);
          console.log("agencyValues",agencyValues);
          console.log("coderValues",coderValues);
          coderValues.push(data.Sum_Coder);
        });

        var firstmitemdataagency = agencyValues[0];
        var secondmitemdataagency = agencyValues[1];
        var thirdmitemdataagency = agencyValues[2];
        var fourthmitemdataagency = agencyValues[3];
        var fifthtmitemdataagency = agencyValues[4];
        var sixmitemdataagency = agencyValues[5];
        var sevenmitemdataagency = agencyValues[6];
        var eigthmitemdataagency = agencyValues[7];

        if (firstmitemdataagency >= 4) {
          firstmitemdataagency = 11;
        } else {
          firstmitemdataagency = 0;
        }

        var totalAgencyValues =
          firstmitemdataagency +
          secondmitemdataagency +
          thirdmitemdataagency +
          fourthmitemdataagency +
          fifthtmitemdataagency +
          sixmitemdataagency +
          sevenmitemdataagency +
          eigthmitemdataagency;

        var firstmitemdatacoder = coderValues[0];
        var secondmitemdatacoder = coderValues[1];
        var thirdmitemdatacoder = coderValues[2];
        var fourthmitemdatacoder = coderValues[3];
        var fifthtmitemdatacoder = coderValues[4];
        var sixmitemdatacoder = coderValues[5];
        var sevenmitemdatacoder = coderValues[6];
        var eigthmitemdatacoder = coderValues[7];

        if (firstmitemdatacoder >= 4) {
          firstmitemdatacoder = 11;
        } else {
          firstmitemdatacoder = 0;
        }

        var totalCoderValues =
          firstmitemdatacoder +
          secondmitemdatacoder +
          thirdmitemdatacoder +
          fourthmitemdatacoder +
          fifthtmitemdatacoder +
          sixmitemdatacoder +
          sevenmitemdatacoder +
          eigthmitemdatacoder;

        console.log("totalAgencyValues", totalAgencyValues);
        console.log("totalCoderValues", totalCoderValues);

        $.ajax({
          type: "POST",
          url: "Ryi_v2/position3_v2.php",
          data: {
            clinicalGroupNamecoder: clinicalGroupNamecoder,
            clinicalGroupNameagency: clinicalGroupNameagency,
            totalAgencyValues: totalAgencyValues,
            totalCoderValues: totalCoderValues,
          },
          success: function (response) {
            var datapositionthree = JSON.parse(response);

            var positionThreeagencyvalues = datapositionthree.total_agency;
            var positionThreecodervalues = datapositionthree.total_coder;

            // Resolve the promise with the position three values
            resolve({
              positionThreeagencyvalues: positionThreeagencyvalues,
              positionThreecodervalues: positionThreecodervalues,
            });
          },
          error: function (jqXHR, textStatus, errorThrown) {
            reject(errorThrown);
          },
        });
      },
      error: function (jqXHR, textStatus, errorThrown) {
        reject(errorThrown);
      },
    });
  });
}

//position Four data
function positionFour(Id) {
  return new Promise((resolve, reject) => {
    $.ajax({
      type: "POST",
      url: "Ryi_v2/position4_v2.php",
      data: {
        Id: Id,
      },
      success: function (response) {
        // Parse JSON response
        var parsedResponse = JSON.parse(
          "[" + response.replace(/}{/g, "},{") + "]"
        );

        var positionfourdataagency = parsedResponse[0].data_agency;
        var positionfourdatacoder = parsedResponse[1].data_coder;

        // Set positionfourvalueagency based on its value
        var positionfourvalueagency;
        if (positionfourdataagency == 3) {
          positionfourvalueagency = 3;
        } else if (positionfourdataagency == 2) {
          positionfourvalueagency = 2;
        } else if (positionfourdataagency == 1) {
          positionfourvalueagency = 1;
        }

        // Set positionfourvaluecoder based on its value
        var positionfourvaluecoder;
        if (positionfourdatacoder == 3) {
          positionfourvaluecoder = 3;
        } else if (positionfourdatacoder == 2) {
          positionfourvaluecoder = 2;
        } else if (positionfourdatacoder == 1) {
          positionfourvaluecoder = 1;
        }

        console.log("positionfourvalueagency",positionfourvalueagency);
        console.log("positionfourvaluecoder",positionfourvaluecoder);

        // Resolve the promise with the processed data
        resolve({
          positionfourvalueagency: positionfourvalueagency,
          positionfourvaluecoder: positionfourvaluecoder,
        });
      },
      error: function (jqXHR, textStatus, errorThrown) {
        // Reject the promise if there's an error
        reject(errorThrown);
      },
    });
  });
}

//position Five data
function positionFive() {
  return new Promise((resolve, reject) => {
    // Implement positionFive function as per your requirements
    var positionfivevalueagency = 1;
    var positionfivevaluecoder = 1;

    // Resolve with position five values
    resolve({ positionfivevalueagency, positionfivevaluecoder });
  });
}

//hpps code value
function hppsCode(
  concatenatedPositionValuesagency,
  concatenatedPositionValuescoder
) {
  var hppsCodeagency = concatenatedPositionValuesagency;
  var hppsCodecoder = concatenatedPositionValuescoder;
  var cpscCode = $("#cpsc").val();
  var location = $("#location").val();

  console.log("hppsagency", hppsCodeagency);
  console.log("hppsCode", hppsCodecoder);
  // console.log("cpsc", cpscCode);
  // console.log("location", location);

  $.ajax({
    type: "POST",
    url: "Ryi_v2/hppscode_v2.php",
    data: {
      hppsCodeagency: hppsCodeagency,
      hppsCodecoder: hppsCodecoder,
      cpsccode: cpscCode,
      location: location,
    },
    success: function (response) {
      console.log(response);
      var total_value_agency = parseFloat(
        response.total_value_agency.replace(/[^0-9.]/g, "")
      );
      var total_value_coder = parseFloat(
        response.total_value_coder.replace(/[^0-9.]/g, "")
      );

      var total_value_agency_multiply = isNaN(total_value_agency)
        ? 0
        : total_value_agency * 2;
      var total_value_coder_multiply = isNaN(total_value_coder)
        ? 0
        : total_value_coder * 2;

      var additionvaluemultiply =
        parseFloat(total_value_coder_multiply) -
        parseFloat(total_value_agency_multiply);
      var additionvalue =
        parseFloat(total_value_coder) - parseFloat(total_value_agency);

      additionvaluemultiply = Number(additionvaluemultiply).toFixed(2);
      additionvalue = Number(additionvalue).toFixed(2);

      $("#precodevalue").text(total_value_agency);
      $("#precodevaluemultiply").text(total_value_agency_multiply);
      $("#postcodevalue").text(total_value_coder);
      $("#postcodevaluemultiply").text(total_value_coder_multiply);
      $("#additionalvaluemultiply").text(additionvaluemultiply);
      $("#additionvalue").text(additionvalue);

      // Swal.fire({
      //   icon: "success",
      //   title: "Success!",
      // });

      datainsertion();
    },
    error: function (xhr, status, error) {
      Swal.fire({
        icon: "error",
        title: "Error!",
        text: "An error occurred: " + error,
      });
    },
  });
}

// Function to get PPS value
function ppsValue() {
  const Id = $("#entryId").val();
  $.ajax({
    type: "POST",
    url: "Ryi_v2/casemix_display_v2.php",
    data: {
      Id: Id,
    },
    success: function (response) {
      const casemixdata = $(".casemixdata").text(
        String(response).substring(0, 8)
      );
    },
  });
}

//Function getting data and storing in database
function datainsertion() {
  var datastore = [];
  Id = $("#entryId").val();

  var timingtext = $("#timingSelect").val();
  var sourcetext = $("#admissionSourceSelect").val();
  var cpscCodetext = $("#cpsc").val();
  var locationtext = $("#location").val();

  var precodevalue = $("#precodevalue").text();
  var precodevaluemultiply = $("#precodevaluemultiply").text();
  var postcodevalue = $("#postcodevalue").text();
  var postcodevaluemultiply = $("#postcodevaluemultiply").text();
  var additionalvaluemultiply = $("#additionalvaluemultiply").text();
  var additionvalue = $("#additionvalue").text();

  // alert(precodevalue);

  var rowData = {
    Id: Id,
    timingtext: timingtext,
    sourcetext: sourcetext,
    cpscCodetext: cpscCodetext,
    locationtext: locationtext,
    precodevalue: precodevalue,
    precodevaluemultiply: precodevaluemultiply,
    postcodevalue: postcodevalue,
    postcodevaluemultiply: postcodevaluemultiply,
    additionalvaluemultiply: additionalvaluemultiply,
    additionvalue: additionvalue,
  };

  datastore.push(rowData);

  $.ajax({
    type: "POST",
    url: "Ryi_v2/ryiinsertdata_v2.php",
    data: {
      dataArray: datastore,
    },

    success: function (response) {},
  });
}

//Data showing in frontend hhrg
function datashow() {
  var Id = $("#entryId").val();
  $.ajax({
    type: "POST",
    url: "Ryi_v2/ryidisplaydata_v2.php",
    data: {
      Id: Id,
    },
    success: function (response) {
      // Parse the JSON response
      var keyValuePairs = [];
      var data = JSON.parse(response);

      console.log(data);

      // Iterate over the object properties (keys) and values
      for (var key in data) {
        if (data.hasOwnProperty(key)) {
          var value = data[key];
          keyValuePairs.push({ key: key, value: value });
        }
      }
      // console.log("keyValuePairs:", keyValuePairs);

      var timingshowdata = keyValuePairs[0].value;
      var sourceshowdata = keyValuePairs[1].value;
      var cpscshowdata = keyValuePairs[2].value;
      var locationshowdata = keyValuePairs[3].value;

      // console.log(keyValuePairs[9].value);
      var precodevalueshowdata = keyValuePairs[4].value;
      var precodevaluemultiplyshowdata = keyValuePairs[5].value;
      var postcodevalueshowdata = keyValuePairs[6].value;
      var postcodevaluemultiplyshowdata = keyValuePairs[7].value;
      var additionvalueshowdata = keyValuePairs[8].value;
      var additionalvaluemultiplyshowdata = keyValuePairs[9].value;
      // console.log(Bathingshowdata);
      $("#timingSelect").val(timingshowdata);
      $("#admissionSourceSelect").val(sourceshowdata);
      $("#location").val(locationshowdata);
      $("#cpsc").val(cpscshowdata);

      $("#precodevalue").text(precodevalueshowdata);
      $("#precodevaluemultiply").text(precodevaluemultiplyshowdata);
      $("#postcodevalue").text(postcodevalueshowdata);
      $("#postcodevaluemultiply").text(postcodevaluemultiplyshowdata);
      $("#additionvalue").text(additionvalueshowdata);
      $("#additionalvaluemultiply").text(additionalvaluemultiplyshowdata);
    },

    error: function (xhr, status, error) {
      // Handle errors
      console.error(xhr.responseText);
      alert(
        "An error occurred while processing your request. Please try again."
      );
    },
  });
}
