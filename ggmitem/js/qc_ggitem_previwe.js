$(document).ready(function() {
    // Function to load data using AJAX
    function loadData() {
        $.ajax({
            url: "ggmitem/qc-previwe_ggitem.php",
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

                        var qc_agencyData = JSON.parse(rowData.qc_agency_response);
                        var qccoderData = JSON.parse(rowData.QCCoder_response);
                        var qcrationaliData = rowData.QCCoder_rationali;
                        var Error_reason = rowData.Error_reason;
                        var Error_type = rowData.Error_type;

                        // Constructing table row
                        var row = $('<tr></tr>');
                        row.append(`<td>${mitem}</td>`);
                        row.append(`<td style="font-size:13px">${getFormattedTags(agencyData.fields)}</td>`);
                        row.append(`<td style="font-size:13px">${getFormattedTags(coderData.fields)}</td>`);

                        if(coderRationali && coderRationali !='Null'){
                        	row.append(`<td style="font-size:13px">${coderRationali}</td>`);
                        }
                        else{
                        	row.append(`<td></td>`);
                        }
                        if(getFormattedTags(agencyData.fields) == getFormattedTags(qc_agencyData.fields)){
                        	row.append(`<td></td>`);
                        }
                        else {

                        	 row.append(`<td style="font-size:13px">${getFormattedTags(qc_agencyData.fields)}</td>`);
                        }
                       
                        row.append(`<td style="font-size:13px">${getFormattedTags(qccoderData.fields)}</td>`);

                        if(coderRationali == qcrationaliData){
                        	row.append(`<td></td>`);
                        }
                        else{
                        	 row.append(`<td style="font-size:13px">${qcrationaliData}</td>`);
                        }
                       
                         
						if (Error_reason && Error_reason !== "None") {
						    row.append(`<td style="font-size:13px">${Error_reason}</td>`);
						} else {
						    row.append(`<td></td>`);
						}

						// Example of appending Error_type
						if (Error_type && Error_type !== "None") {
					     row.append(`<td style="font-size:13px">${Error_type}</td>`);

					    // Change row color based on Error_type
					    if (Error_type === "Modified" || Error_type ==="modified") {
					        row.css("background-color", "#EED68E");
					    }
					    else if(Error_type === "Added" || Error_type === "added"){
					    	row.css("background-color", "#8EEEAC");
					    }
					    else if(Error_type === "Deleted" || Error_type ==="deleted"){
					    	row.css("background-color", "#F68E98");
					    }
					} else {
					    row.append(`<td></td>`);
					}

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
