$(document).ready(function () {
$(".clk").on("click", function (e) {
  e.preventDefault();
  var fileInput = $("#formFile")[0].files[0];
  var agencyValue = $("#agency_data").val().trim(); // Get and trim the agency value

  // Check if agencyValue is empty
 

  if (fileInput) {

     if (agencyValue === '') {
    showPopup("Please select an Agency Name Before Upload.");
    return;
  }
    var reader = new FileReader();
    reader.onload = function (e) {
      var csvData = e.target.result;
      var rows = csvData.split("\n");
      var headers = rows[0].split(",").map((h) => h.trim()); // Assuming first row is headers

      // Example: Check if 'agency' column exists in the CSV headers
      if (!headers.includes("agency")) {
        showError("CSV file must contain 'agency' column!");
        return;
      }

      var data = [];
      for (var i = 1; i < rows.length; i++) {
        var rowData = rows[i].split(",").map((d) => d.trim());
        if (rowData.length === headers.length) {
          var obj = {};
          for (var j = 0; j < headers.length; j++) {
            obj[headers[j]] = rowData[j];
          }
          data.push(obj);
        }
      }

      // Example: Check if any row's 'agency' value matches agencyValue
      var matchedRows = data.filter((row) => row.agency === agencyValue);
      if (matchedRows.length > 0) {
        console.log("Found matching rows:", matchedRows);
        // Proceed with uploading if match is found
        var formData = new FormData();
        formData.append("formFile", fileInput);
        uploadCSV(formData);
      } else {
        showError("Agency name mismatch. Please check your CSV file.");
        // Stop further execution or handle the error as needed
      }
    };

    reader.readAsText(fileInput);
  } else {
    showError("Please select a CSV file to upload!");
  }
});

 function showPopup(message) {
   Swal.fire({
      title: "Error",
      text: message,
      icon: "error",
    });
   
}

  function showError(message) {
    Swal.fire({
      title: "Error",
      text: message,
      icon: "error",
    });
  }

  function uploadCSV(formData) {
    $.ajax({
      url: "upload2.php", // Replace with your file upload endpoint
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        console.log("response",response.status);
        // var data = JSON.parse(response);
        // console.log(data);
        if (response.status == "Ok") {
          Swal.fire({
            title: "Success!",
            text: "Data Uploaded Sucessfully",
            icon: "success",
            confirmButtonText: "OK",
          }).then(function () {
            if (response.flag == 1) {
              modalData();
            }
          });
          $(".swal2-popup").addClass("pt-3");
        } else if (response.flag == 1) {
          Swal.fire({
            title: "Error",
            text: "One or more fields are empty",
            icon: "error",
            confirmButtonText: "OK",
          }).then(function () {
            modalData();
          });
        } else {
          Swal.fire({
            title: "Error",
            text: "Incorrect Formate",
            icon: "error",
            confirmButtonText: "OK",
          });
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error: " + status, error);
      },
    });
  }

  // Function to fetch data using AJAX
  function modalData() {
    $.ajax({
      url: "modal.php",
      method: "GET",
      dataType: "json",
      success: function (response) {
        displayDataInModal(response);
      },
      error: function (xhr, status, error) {
        // Handle errors if any occurred during fetching data
        console.error("Error fetching data:", error);
      },
    });
  }

  function displayDataInModal(response) {
    // Use response data to create and display the table

    createAndShowTable(response);
  }

  function createAndShowTable(response) {
    var table = "<table class='table table-striped'id='table-ta'>";

    table += "<thead><tr class='center'>";
    table +=
      "<th>Sno</th><th>Patient Name</th><th>Mrn</th><th>Phone Number</th><th>Insurance Type</th><th>Assessment Date</th><th>Assessment Type</th><th>Agency</th><th>Url</th><th>Priority</th><th>Status</th><th>Update</th>";
    table += "</tr></thead><tbody>";

    var id = 1;

    var datas = response.data;

    datas.forEach(function (row) {
      table += "<tr>";
      table += "<td hidden>" + id + "</td>";
      table += "<td>" + row.id + "</td>";
      table += '<td contenteditable="true">' + row.patient_name + "</td>";
      table += '<td contenteditable="true">' + row.mrn + "</td>";
      table += '<td contenteditable="true">' + row.phone_number + "</td>";
      table += '<td contenteditable="true">' + row.insurance_type + "</td>";
      table += '<td contenteditable="true">' + row.assesment_date + "</td>";
      table += '<td contenteditable="true">' + row.assesment_type + "</td>";
      table += '<td contenteditable="true">' + row.agency + "</td>";
      table += '<td contenteditable="true">' + row.url + "</td>";
      table += '<td contenteditable="true">' + row.priority + "</td>";
      table += '<td contenteditable="true">' + row.status + "</td>";
      table +=
        "<td><button class='btn btn-primary edit-button clk-3' id='table-btn' data-id='" +
        row.Id +
        "'>Save</button></td>";
      table += "</tr>";
      id++;
    });

    table += "</tbody></table>";

    showModal(table);
  }

  function showModal(table) {
    $("#myModal").modal({
      backdrop: "static",
      keyboard: false,
    });

    $("#myModal .modal-body").html(table);
    $("#myModal").modal("show");
    closeModalAndResetForm();
  }

  function closeModalAndResetForm() {
    // Reset the form with ID "myForm"
    $("#myForm")[0].reset();
    $("#formFile")[0].reset();
  }

  $(document).on("click", ".edit-button", function () {
    // Find the closest row to the clicked button
    var row = $(this).closest("tr");

    // Retrieve data from the editable cells within the row
    var Id = row.find("td:eq(1)").text();
    var Patient_Name = row.find("td:eq(2)").text();
    var Mrn = row.find("td:eq(3)").text();
    var Phone_Number = row.find("td:eq(4)").text();
    var Insurance_Type = row.find("td:eq(5)").text();
    var Assessment_Date = row.find("td:eq(6)").text();
    var Assessment_Type = row.find("td:eq(7)").text();
    var Agency = row.find("td:eq(8)").text();
    var Url = row.find("td:eq(9)").text();
    var Priority = row.find("td:eq(10)").text();
    var Status = row.find("td:eq(11)").text();

    // alert(Id);

    var successAlert = $(".alert-success");
    var errorAlert = $(".alert-danger");

    // Now, you have the data in the respective variables

    $.ajax({
      url: "edit.php", // Replace with the actual URL to handle the file upload
      type: "POST",
      data: {
        Id: Id,
        Patient_Name: Patient_Name,
        Mrn: Mrn,
        Phone_Number: Phone_Number,
        Insurance_Type: Insurance_Type,
        Assessment_Date: Assessment_Date,
        Assessment_Type: Assessment_Type,
        Agency: Agency,
        Url: Url,
        Priority: Priority,
        Status: Status,
      },
      success: function (response) {
        console.log(response);
        var data = JSON.parse(response);
        console.log(data);
        if (data.success) {
          successAlert
            .html(data.message)
            .removeClass("alert-negative")
            .addClass("alert-positive")
            .show();
          row.closest("tr").remove();

          setTimeout(function () {
            successAlert.hide();
          }, 1500);
        } else {
          errorAlert
            .html(data.message)
            .removeClass("alert-positive")
            .addClass("alert-negative")
            .show();
          setTimeout(function () {
            errorAlert.hide();
          }, 1500);
        }
      },

      error: function (jqXHR, textStatus, errorThrown) {
        console.log("Error:", errorThrown);
        errorAlert
          .html("An error occurred during your request")
          .removeClass("alert-positive")
          .addClass("alert-negative")
          .show();
        successAlert.hide(); // Hide the success alert
      },
    });
  });
});
