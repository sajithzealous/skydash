$(document).ready(function(){
    $.ajax({
        url: 'Assign/pendingreason.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            // console.log(data);
            if (data) {
                var select = $('#commentType');
                $.each(data, function(index, value) {
                    select.append($('<option>', {
                        text: value,
                        value: value
                    }));
                });
            } else {
                $('#result').text("No data received or invalid format");
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            $('#result').text("Error occurred while fetching data");
        }
    });
});
