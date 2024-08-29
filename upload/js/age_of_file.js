$(document).ready(function(){

   var currentDate = new Date();

// Options for formatting
var options = {
  month: '2-digit',
  day: '2-digit',
  year: 'numeric',
  timeZone: 'America/New_York',  
};

  var formattedDate = currentDate.toLocaleDateString('en-US', options);  
console.log("US_timestamp",formattedDate);

    var getdate = new Date(formattedDate).toLocaleDateString('en-CA');//
    console.log("US_split_timestamp",getdate);
    
  
   age_file(getdate);
});


 
// var formattedDate = currentDate.toLocaleDateString('en-US', options);

// console.log("johnson current date in us",formattedDate);















function age_file(getdate) {
    console.log("date_sento_db", getdate);
    
    $.ajax({
        url: "age_of_file.php",
        type: "GET",
        dataType: 'json',
        data: {
            getdate: getdate
        },
        success: function (response) {
            
            console.log("Age Of File:",response);
             var oneday = parseInt(response.oneday, 10);
             var twodays = parseInt(response.twodays, 10);
            var threedays =parseInt(response.threedays,10);
            var fourdays =parseInt(response.fourdays,10);
            var fivedays =parseInt(response.fivedays,10);
            var sixdays =parseInt(response.sixdays,10);

        var percentage_0 = calculatePercentage(oneday, 1, 50);
        var percentage_1 = calculatePercentage(twodays, 1, 50);
        var percentage_2= calculatePercentage(threedays, 1, 50);
        var percentage_3 = calculatePercentage(fourdays, 1, 50);
        var percentage_4= calculatePercentage(fivedays, 1, 50);
        var percentage_5 = calculatePercentage(sixdays, 1, 50);
        

        // Set the width of the progress bar dynamically
        $("#progressbar_1").css("width", percentage_0 + "%");
        $("#progressbar_2").css("width", percentage_1 + "%");
        $("#progressbar_3").css("width", percentage_2 + "%");
        $("#progressbar_4").css("width", percentage_3 + "%");
        $("#progressbar_5").css("width", percentage_4 + "%");
        $("#progressbar_6").css("width", percentage_5 + "%");



 
          var total = oneday + twodays + threedays + fourdays + fivedays + sixdays;
           
            $("#oneday").text("");
            $("#oneday").text(oneday);
            $("#twodays").text("");
            $("#twodays").text(twodays);
            $("#threedays").text("");
            $("#threedays").text(threedays);
            $("#fourdays").text("");
            $("#fourdays").text(fourdays);
            $("#fivedays").text("");
            $("#fivedays").text(fivedays);
            $("#sixdays").text("");
            $("#sixdays").text(sixdays);
            $("#total").text("");
            $("#total").text(total);
             
        },
     error: function (xhr, status, error) {
    console.error(xhr.responseText); // Log the entire response text
    console.error("Status: " + status + ", Error: " + error); // Log additional details
}

    });
}
function calculatePercentage(value, min, max) {
    // Ensure the value is within the specified range
    value = Math.max(min, Math.min(max, value));

    // Calculate the percentage based on the range
    return ((value - min) / (max - min)) * 100;
}