$(document).ready(function () {


        var Id = $("#hhrgview").val();
        gettingData(Id);
       
        
   
});

function gettingData(Id) {
    $.ajax({
        type: "post",
        url: "Assign/hhrgpreviewdisplay.php",
        data: {
            Id: Id,
        },
        success: function (response) {
            var data = JSON.parse(response);
            updateHTML(data);
            // window.location.href="./hhrgpreview.php";


           

        },
        error: function () {
            console.error("Error occurred while fetching data.");
        },
    });
}

function updateHTML(data) {
    var userData = data.user_data;
    var codeData = data.codedata;


    console.log(userData);

    $('#subject_id').text(userData.mrn);
    $('#subject_name').text(userData.patient_name);
    $('#assesment_type').text(userData.assesment_type);
    $('#assesment_date').text(userData.assesment_date);
    $('#insurance_type').text(userData.insurance_type);
    $('#agency').text(userData.agency);
    $('#team').text(userData.alloted_team + ' (' + userData.team_emp_id + ')');
    $('#coder').text(userData.alloted_to_coder+ ' (' + userData.coder_emp_id + ')');

    // Update other HTML elements as needed

    // Update chart data if required
    // var precodevalue = codeData.precodevalue;
    // var precodevaluemultiply = codeData.precodevaluemultiply;
    // var postcodevalue = codeData.postcodevalue;
    // var postcodevaluemultiply = codeData.postcodevaluemultiply;
    // var additionalvaluemultiply = codeData.additionalvaluemultiply;
    // var additionvalue = codeData.additionvalue;

    $('#precodevaluemultiplyview').text(codeData.precodevaluemultiply);
    $('#precodevalueview').text(codeData.precodevalue);
    $('#postcodevaluemultiplyview').text(codeData.postcodevaluemultiply);
    $('#postcodevalueview').text(codeData.postcodevalue);
    $('#additionalvaluemultiplyview').text( codeData.additionalvaluemultiply);
    $('#additionvalueview').text(codeData.additionvalue);




    

    // Handle any chart updates or other tasks
}
