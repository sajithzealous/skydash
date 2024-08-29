$(document).ready(function() {
    // Function to load data using AJAX
    function loadData() {
        $.ajax({
            url: "ggmitem/finalpreviwe_ggitem.php",
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log(response); // Logging response for debugging purposes

                var tableBody = $('#dataTableBody'); // Select the correct table body

                if (response.error) {
                    // If there's an error in the response, log it and return
                    console.error('Error in response:', response.error);
                    return;
                }

                if (response.length === 0) {
                    $("#gg-items").hide();
                    // If response is empty, display "No data available" message
                    tableBody.append('<tr><td colspan="8" style="text-align: center;">No data available</td></tr>');

                } else {
                    // Populate table with response data
                    response.forEach(function(rowData) {
                        // Extracting data from each row
                        var agencyData = JSON.parse(rowData.agencydata);
                        var mitem = agencyData.mitem;
                        var mitemType = agencyData.mitem_type;

                        var coderData = JSON.parse(rowData.coderdata);
                        var coderRationali = rowData.Coder_rationali;

                        

                        // Constructing table row
                        var row = $('<tr></tr>');
                        row.append(`<td>${mitem}</td>`);
                        row.append(`<td style="font-size:13px">${getFormattedTags(agencyData.fields)}</td>`);
                        row.append(`<td style="font-size:13px">${getFormattedTags(coderData.fields)}</td>`);
                        row.append(`<td style="font-size:13px">${coderRationali}</td>`);
                     
                        tableBody.append(row);
                    });
                }
            },
            error: function(error) {
                console.error('Error loading data:', error);
                // Handle errors gracefully, e.g., display an error message to the user
            }
        });
    }

    // Function to format tags with group
  function getFormattedTags(fields) {
    var formattedTags = "";
    if (Array.isArray(fields)) {
        fields.forEach(function(field) {
            var groupName = field.group;
            if (Array.isArray(field.tags)) {
                field.tags.forEach(function(tag) {
                    // Check if the tag has a value
                    if (tag.value) {
                        // Highlight the tag value as bold
                        //formattedTags += `<span>${groupName}: ${tag.name}: <strong style="font-size:15px">${tag.value}</strong></span><br>`;
                        formattedTags += `<div style="border: 1px solid black; padding: 5px; margin-bottom: 5px;">${groupName}: ${tag.name}: <strong>${tag.value}</strong></div>`;
                    }
                });
            }
        });
    }
    return formattedTags;
}


    // Initial load of data when the document is ready
    loadData();
});
