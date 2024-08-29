// Initialize global variables to store position values
var positionOneValue = "";
var positionTwoValue = "";
var positionThreeValueagency = "";
var positionFourValue = "";
var positionFiveValue = 1;
var concatenatedPositionValues;
var positionThreeValuecoder = "";

// Function to concatenate position values
function concatenatePositionValues() {
  concatenatedPositionValuesagency =
    positionOneValue +
    positionTwoValue +
    positionThreeValueagency +
    positionFourValue +
    positionFiveValue;

  concatenatedPositionValuescoder =
    positionOneValue +
    positionTwoValue +
    positionThreeValuecoder +
    positionFourValue +
    positionFiveValue;
  // console.log(
  //   "Concatenated Final Position Values:",
  //   concatenatedPositionValuesagency
  // );


  console.log(positionOneValue,positionTwoValue,positionThreeValueagency,positionFourValue,positionFiveValue)

  // console.log(
  //   "Concatenated Final Position Values:",
  //   concatenatedPositionValuescoder
  // );
  // console.log("Final Position Length:", concatenatedPositionValues.length);
  hppsCode(concatenatedPositionValuesagency, concatenatedPositionValuescoder);
}

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
    url: "Ryi/hppscodeqc.php",
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

// Event handler for save button click
$(document).ready(function () {
  datashow();
  ppsValue();
  $(".btn_ryi_oasis").on("click", function () {
    // Use jQuery Deferred objects to wait for asynchronous calls
    var deferred1 = $.Deferred();
    var deferred2 = $.Deferred();
    var deferred3 = $.Deferred();
    var deferred4 = $.Deferred();


    // alert('new part')

    position1(deferred1);
    position2(deferred2);
    position3(deferred3);
    position4(deferred4);
  

    // When all deferred objects are resolved, call concatenatePositionValues
    $.when(deferred1, deferred2, deferred3,deferred4).done(function () {
      concatenatePositionValues();
    });
  });
});

// Update position1 to accept a deferred object
function position1(deferred) {
  var timing = $("#timingSelect").val();
  var source = $("#admissionSourceSelect").val();

  $.ajax({
    type: "POST",
    url: "Ryi/position1.php",
    data: {
      timing: timing,
      source: source,
    },
    success: function (response) {
      positionOneValue = response;
      console.log("position1", positionOneValue);

      if (positionOneValue.length != 1) {
        Swal.fire({
          icon: "error",
          title: "Validation Error",
          text: "Please fill in all HHRG Value.",
          width: "20%",
          height: "10%",
        });
        return;
      }

      deferred.resolve(); // Resolve the deferred object when the AJAX call is complete
    },
  });
}

function position2(deferred) {
  const data = [];

  const Id = $("#entryId").val();

  // alert(Id);

  $.ajax({
    type: "Post",
    url: "Ryi/testing_ryi.php?action=mitemdata",
    data: {
      Id: Id,
    },

    success: function (response) {
      var responseData = JSON.parse(response);
  
      // Iterate over the response data
      responseData.data.forEach(function(item) {
          // Create an object with keys 'mitems' and 'icd'
          var newItem = {
              mitems: item.mitems,
              icd: item.icd
          };
          // Push the new object to the global 'data' array
          data.push(newItem);
      });
  
      // Now 'data' array contains objects with keys 'mitems' and 'icd'
      console.log(data);
      position4(data);
      positiontwodata(data);
  }
  
  });

  // Iterate through each table row
  // $("#dynamic_field tbody tr").each(function (index, row) {
  //   var icdInput = $(row).find("td:eq(3) input");

  //   var errortype = $(row).find("td:eq(9) select");
  //   // Check if ICD field is not empty
  //   if (icdInput.val().trim() !== "" && errortype.val() !== "Deleted") {
  //     var icd = icdInput.val().trim();

  //     // console.log(icd);
  //     var mitems = $(row).find("td:eq(2) input").val();
  //     var rowData = {
  //       mitems: mitems,
  //       icd: icd,
  //     };

  //     data.push(rowData);
  //   }
  // });
 
  // Your AJAX request goes here
  function positiontwodata(data){

    console.log("positiontwodata:",data);
    $.ajax({
      type: "POST",
      url: "Ryi/position2.php",
      data: { dataArray: data },
      success: function (response) {
  
        console.log('position:2',response)
        var data = JSON.parse(response);
        positionTwoValue = data.Clinicalgroup.toString();
        var clinicalGroupName = data.Clinicalgroupname;
        console.log("clinicalGroupName",clinicalGroupName)
  
        // Call position3 with deferred object as a parameter
        position3(clinicalGroupName, deferred);
  
        console.log("position2", positionTwoValue);
      },
      error: function (response) {
        // Handle error if needed
        console.error("Error in position2 AJAX request:", response);
        deferred.resolve(); // Resolve the deferred object even in case of an error
      },
    });
  }

}

// Update position3 to accept a deferred object
function position3(clinicalGroupName, deferred) {
  // Define arrays to hold M items, Agency values, and Coder values
  var mItems = [];
  var agencyValues = [];
  var coderValues = [];

  Id = $("#entryId").val();

  $.ajax({
    type: "post",
    url: "Ryi/qc_ryi_oasisjsonfetch.php",
    data: {
      Id: Id,
    },

    success: function (response) {
      console.log(response);

      // Iterate through each M item in the response
      $.each(response, function (mItem, data) {
        // Push M item name to the mItems array
        mItems.push(mItem);

        // Push Agency and Coder values to their respective arrays
        agencyValues.push(data.Sum_Agency);
        coderValues.push(data.Sum_Coder);
      });

      console.log("agencyValues",agencyValues);
      console.log("coderValues",coderValues);

      // Now you have separate arrays containing M items, Agency values, and Coder values
      //agency values

      // console.log(mitemfirstagency);
      var mitemfirstagency = parseInt(agencyValues[0]);

      // console.log(mitemfirstagency);

      if (mitemfirstagency >= 4) {
        mitemfirstagency = 11;
      } else {
        mitemfirstagency = 0;
      }

      var mitemsecondagency = parseInt(agencyValues[1]);
      var mitemthirdagency = parseInt(agencyValues[2]);
      var mitemfourthagency = parseInt(agencyValues[3]);
      var mitemfifthagency = parseInt(agencyValues[4]);
      var mitemsixthagency = parseInt(agencyValues[5]);
      var mitemseventhagency = parseInt(agencyValues[6]);
      var mitemeightagency = parseInt(agencyValues[7]);

      // console.log(mitemfirstagency+mitemsecondagency+mitemthirdagency+mitemfourthagency+mitemfifthagency+mitemsixthagency+mitemseventhagency);

      var totalagencyvalue =
      mitemfirstagency +
      mitemsecondagency +
      mitemthirdagency +
      mitemfourthagency +
      mitemfifthagency +
      mitemsixthagency +
      mitemseventhagency +
      mitemeightagency;

        console.log("agency",totalagencyvalue);

      //   coder Values;

      var mitemfirstcoder = parseInt(coderValues[0]);

      if (mitemfirstcoder >= 4) {
        mitemfirstcoder = 11;
      } else {
        mitemfirstcoder = 0;
      }

      var mitemsecondcoder = parseInt(coderValues[1]);
      var mitemthirdcoder = parseInt(coderValues[2]);
      var mitemfourthcoder = parseInt(coderValues[3]);
      var mitemfifthcoder = parseInt(coderValues[4]);
      var mitemsixthcoder = parseInt(coderValues[5]);
      var mitemseventhcoder = parseInt(coderValues[6]);
      var mitemeightcoder = parseInt(coderValues[7]);

      var totalcodervalue =
        mitemfirstcoder +
        mitemsecondcoder +
        mitemthirdcoder +
        mitemfourthcoder +
        mitemfifthcoder +
        mitemsixthcoder +
        mitemseventhcoder +
        mitemeightcoder;

      console.log("coder",totalcodervalue);

      positionthreevalues(
        clinicalGroupName,
        deferred,
        totalcodervalue,
        totalagencyvalue
      );
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("Error:", errorThrown);
    },
  });

  function positionthreevalues(
    clinicalGroupName,
    deferred,
    totalcodervalue,
    totalagencyvalue
  ) {
    // var dynamicKeys = [
    //   "MMTA_INFECT",
    //   "NEURO_REHAB",
    //   "MS_REHAB",
    //   "NO_GROUP",
    //   "WOUND",
    //   "MMTA_OTHER",
    //   "MMTA_ENDO",
    //   "BEHAVE_HEALTH",
    //   "MMTA_CARDIAC",
    //   "MMTA_RESP",
    //   "COMPLEX",
    //   "MMTA_GI_GU",
    //   "MMTA_AFTER",
    // ];

    $.ajax({
      type: "POST",
      url: "Ryi/position3.php",
      data: {
        totalagencyvalue: totalagencyvalue,
        totalcodervalue: totalcodervalue,
        clinicalname: clinicalGroupName,
      },
      success: function (response) {
        // console.log(response);

        // Parse the response JSON string
        var parsedResponse = JSON.parse(response);

        // Access total_agency and total_coder properties from the parsed response
        var agency = parsedResponse.total_agency;
        var coder = parsedResponse.total_coder;

        console.log("Agency:", agency);
        console.log("Coder:", coder);

        // Loop through dynamic keys

        if (agency == "LOW") {
          positionThreeValueagency = "A";
        } else if (agency == "MEDIUM") {
          positionThreeValueagency = "B";
        } else if (agency == "HIGH") {
          positionThreeValueagency = "C";
        }

        if (coder == "LOW") {
          positionThreeValuecoder = "A";
        } else if (coder == "MEDIUM") {
          positionThreeValuecoder = "B";
        } else if (coder == "HIGH") {
          positionThreeValuecoder = "C";
        }

        console.log(positionThreeValueagency);
        console.log(positionThreeValuecoder);

        // Resolve the deferred object when the AJAX call is complete
        deferred.resolve();
      },
    });
  }
}

// Position4 function
function position4(data, deferred) {
  $.ajax({
    type: "POST",
    url: "Ryi/position4.php",
    data: {
      positionfourdata: data,
    },
    success: function (response) {
 
      positionFourValue = JSON.parse(response);

      // console.log("parsedResponse", positionFourValue);
      positionFourValue = positionFourValue[0];

      

      if (positionFourValue == 3) {
        positionFourValue = 3;
        console.log("positionfour",positionFourValue);
        return;
      } else if (positionFourValue == 2) {
        positionFourValue = 2;
        console.log("positionfour",positionFourValue);
        return;
      } else {
        positionFourValue = 1; // If the condition is not met, set default value to 1
        return;
      }
    },
    error: function (response) {
      // Handle error if needed
      console.error("Error in position4 AJAX request:", response);
    },
  });
}
// Function to get PPS value
function ppsValue() {
  const Id = $("#entryId").val();
  $.ajax({
    type: "POST",
    url: "Ryi/casemix_display.php",
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
    url: "Ryi/ryiinsertdata.php",
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
    url: "Ryi/ryidisplaydata.php",
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
