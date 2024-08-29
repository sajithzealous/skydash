

$(document).ready(function () {
    $("#datepickeruser").on('change', function () {
        var date = $("#datepickeruser").val();
        newdate(date);

         
    });

     
    // function newdateWithoutDate() {
        
    //     console.log("This is the function without a date parameter.");

    // $.ajax({
    //     url: "new_file.php",
    //     type: "GET",
    //     dataType:'json',
         
    //     success: function (response) {
    //         console.log("Success response:", response);
    //         // console.log(response.total_new);
    //         $("#NEW").text("");
    //         $("#NEW").text(response.New);
    //         $("#COM").text("");
    //         $("#COM").text(response.completed);
    //         $("#processing").text("");
    //         $("#processing").text(response.processing);
    //         $("#approved").text("");
    //         $("#approved").text(response.approved);
    //         $("#pending").text("");
    //         $("#pending").text(response.pending);
    //         $("#reject").text("");
    //         $("#reject").text(response.reject);
    //         $("#qc").text("");
    //         $("#qc").text(response.qc);
    //         $("#assing").text("");
    //         $("#assing").text(response.assing);

    //     },
    //     error: function (xhr, status, error) {
    //         console.error("AJAX Error: " + status, error);
    //     }
    // });
 
    // }

    // Call the function without date
   // newdateWithoutDate();
});

function newdate(date) {
    var val = date;
    var str = date;

    console.log("before split date values",date);
    var dateValues = str.split("-");
    var fromdate = dateValues[0];
    var todate = dateValues[1];
console.log("SPLIT_AND_before Formatted fromdate:", fromdate);
console.log("SPILT_AND_before Formatted todate:", todate);
    // Correct date formatting using JavaScript
    // Assuming fromdate and todate are date objects or date strings
// fromdate = new Date(fromdate).toISOString().slice(0, 10);
// todate = new Date(todate).toISOString().slice(0, 10);
// Assuming fromdate and todate are date objects or date strings
fromdate = new Date(fromdate).toLocaleDateString('en-CA'); // 'en-CA' represents the 'en'glish language in 'CA'nada
todate = new Date(todate).toLocaleDateString('en-CA');

 

console.log("After Formatted fromdate:", fromdate);
console.log("After Formatted todate:", todate);


 

 

    $.ajax({
        url: "team_count.php",
        type: "GET",
        dataType: 'json',
        data: {
            fromdate: fromdate,
            todate: todate
        },
        success: function (response) {
            console.log("Overall-Files_Count:", response);

             
               // $("#team_wip").text(response.processing);
                $("#team_wip").text(response.wip);
              $("#cdr").text(response.cdr);
             $("#team_appproved").text(response.approved);
             // $("#allot_qc").text(response.qc);
            // $("#qc_wip").text(response.qcwip);
              $("#team_cmd").text(response.cmd);
            $("#team_assing").text(response.New);

            // console.log(response.New);
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: " + status, error);
        }
    });
}

 