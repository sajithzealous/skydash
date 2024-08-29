

$(document).ready(function () {
    $("#ecommerce-dashboard-daterangepicker").on('change', function () {
        var date = $("#ecommerce-dashboard-daterangepicker").val();
        newdate(date);

       

         
    });

     
        
     
});

function newdate(date) {
    var val = date;
    var str = date;

    console.log("before split date values",date);
    var dateValues = str.split("-");
    var fromdate = dateValues[0];
    var todate = dateValues[1];
// console.log("SPLIT_AND_before Formatted fromdate:", fromdate);
// console.log("SPILT_AND_before Formatted todate:", todate);
    // Correct date formatting using JavaScript
    // Assuming fromdate and todate are date objects or date strings
// fromdate = new Date(fromdate).toISOString().slice(0, 10);
// todate = new Date(todate).toISOString().slice(0, 10);
// Assuming fromdate and todate are date objects or date strings
fromdate = new Date(fromdate).toLocaleDateString('en-CA'); // 'en-CA' represents the 'en'glish language in 'CA'nada
todate = new Date(todate).toLocaleDateString('en-CA');

 

// console.log("After Formatted fromdate:", fromdate);
// console.log("After Formatted todate:", todate);


 

    // console.log("fromdate",fromdate);
    // console.log("todate",todate)

    $.ajax({
        url: "clinet_new_file.php",
        type: "GET",
        dataType: 'json',
        data: {
            fromdate: fromdate,
            todate: todate
        },
        success: function (response) {
            console.log("Count:", response);
            // Update HTML elements with the response values
            $("#NEW").text(response.New);
            $("#COM").text(response.completed);
            $("#processing").text(response.processing);
            $("#app").text(response.approved);
            $("#allot_qc").text(response.qc);
            $("#ass_team").text(response.ass_team);
            $("#qc_com").text(response.qccompleted);
            $("#assing").text(response.assigned);
            $("#qcwip").text(response.qcwip);
            $("#inp").text(response.InProgression);
             $("#pnd").text(response.Pendding);

            // console.log(response.approved);
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: " + status, error);
        }
    });
}

 