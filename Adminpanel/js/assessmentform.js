let questionCount = 0;

function addQuestion() {
  questionCount++;

  const questionContainer = document.createElement("div");
  questionContainer.classList.add("question-container");
  questionContainer.dataset.index = questionCount; // Add data-index attribute for easy identification

  const questionSerialNumber = document.createElement("input");
  questionSerialNumber.type = "text";
  questionSerialNumber.classList.add("form-control", "questionserialnumber");
  questionSerialNumber.value = questionCount;
  questionSerialNumber.disabled = true; // Disable the input so it can't be edited

  const questionTitle = document.createElement("input");
  questionTitle.type = "text";
  questionTitle.classList.add("form-control", "questionheading");
  questionTitle.placeholder = "Enter Your Question";

  const typeSelector = document.createElement("select");
  typeSelector.classList.add("form-control");
  typeSelector.innerHTML = `
        <option value="">Select</option>
        <option value="text">Text</option>
        <option value="dropdown">Dropdown</option>
        <option value="multi-select">Multi-Select Dropdown</option>
    `;

  const questionBody = document.createElement("div");
  questionBody.classList.add("question-body");

  typeSelector.addEventListener("change", function () {
    while (questionBody.firstChild) {
      questionBody.removeChild(questionBody.firstChild);
    }
    switch (typeSelector.value) {
      case "text":
        addTextField(questionBody);
        break;
      case "multiple-choice":
        addMultipleChoiceField(questionBody);
        break;
      case "dropdown":
      case "multi-select":
        addDropdownField(questionBody, typeSelector.value);
        break;
    }
  });

  const deleteButton = document.createElement("button");
  deleteButton.innerHTML = '<i class="fas fa-trash-alt"></i>';
  deleteButton.classList.add("btn", "deletebutton");
  deleteButton.onclick = function () {
    questionContainer.remove();
    updateSerialNumbers(); // Update serial numbers after removing a question
  };

  const questionMark = document.createElement("input");
  questionMark.type = "text";
  questionMark.classList.add("form-control", "markdata");
  questionMark.placeholder = "Enter Your Mark";

  questionContainer.appendChild(questionSerialNumber);
  questionContainer.appendChild(questionTitle);
  questionContainer.appendChild(typeSelector);
  questionContainer.appendChild(questionBody);
  questionContainer.appendChild(questionMark);
  questionContainer.appendChild(deleteButton);

  document.getElementById("questions-container").appendChild(questionContainer);
}

function updateSerialNumbers() {
  document
    .querySelectorAll(".question-container")
    .forEach((container, index) => {
      const serialNumberInput = container.querySelector(
        ".questionserialnumber"
      );
      if (serialNumberInput) {
        serialNumberInput.value = index + 1;
      }
    });
}

function addTextField(container) {
  const answerInput = document.createElement("textarea");
  answerInput.classList.add("form-control");
  answerInput.placeholder = "Long answer text";
  container.appendChild(answerInput);
}

function addMultipleChoiceField(container) {
  const multipleChoiceContainer = document.createElement("div");
  multipleChoiceContainer.classList.add("multiple-choice-container");

  for (let i = 0; i < 4; i++) {
    const choice = createChoice();
    multipleChoiceContainer.appendChild(choice);
  }

  container.appendChild(multipleChoiceContainer);
  const additionalInput = document.createElement("textarea");
  additionalInput.classList.add("form-control");
  additionalInput.placeholder = "Answer";
  container.appendChild(additionalInput);
}

function addDropdownField(container, type) {
  const dropdownContainer = document.createElement("div");
  dropdownContainer.classList.add("dropdown-container");

  const optionContainer = document.createElement("div");
  optionContainer.classList.add(
    "multiple-choice-container",
    "option-container"
  );

  for (let i = 0; i < 4; i++) {
    const option = createOption();
    optionContainer.appendChild(option);
  }

  container.appendChild(optionContainer);

  // Optionally, you can add a text area for additional input for the dropdown and multi-select types.
  const additionalInput = document.createElement("textarea");
  additionalInput.classList.add("form-control");
  additionalInput.placeholder = "Answer";
  container.appendChild(additionalInput);
}

function createChoice() {
  const choice = document.createElement("div");
  choice.classList.add("form-check");

  const choiceInput = document.createElement("input");
  choiceInput.type = "checkbox";
  choiceInput.classList.add("form-check-input");

  const choiceLabel = document.createElement("input");
  choiceLabel.type = "text";
  choiceLabel.classList.add("form-control");
  choiceLabel.placeholder = "Option";

  choice.appendChild(choiceInput);
  choice.appendChild(choiceLabel);

  return choice;
}

function createOption() {
  const option = document.createElement("div");
  option.classList.add("form-check");

  const optionInput = document.createElement("input");
  optionInput.type = "text";
  optionInput.classList.add("form-control");
  optionInput.placeholder = "Option";

  const removeButton = document.createElement("button");
  removeButton.textContent = "Remove";
  removeButton.innerHTML = '<i class="fas fa-trash-alt"></i>';
  removeButton.classList.add("btn", "btn-sm", "optionremove");
  removeButton.onclick = function () {
    option.remove();
  };

  option.appendChild(optionInput);
  option.appendChild(removeButton);

  return option;
}

$(document).ready(function () {
  submitForm();
  showform();
  tabchange();
  savedata();
  coderDetails();
  manualEvaluation();
  editformdatasubmit();
});

function submitForm() {
  $("#submitformdata").on("click", function () {
    var formTitle = $("#formtitle").val();
    var formDate = $("#formdate").val();
    var formtime = $("#formtime").val();

    var questions = [];

    // Loop through each question container
    $(".question-container").each(function () {
      var questionTitle = $(this).find(".questionheading").val();
      var questionType = $(this).find("select").val();
      var questionMark = $(this).find(".markdata").val();
      var options = [];
      var answers = [];

      // Get options or answers based on question type
      if (questionType === "text") {
        // For text questions, collect answer
        var answer = $(this).find("textarea").val();
        answers.push(answer);
      } else if (
        questionType === "multiple-choice" ||
        questionType === "dropdown" ||
        questionType === "multi-select"
      ) {
        $(this)
          .find(".multiple-choice-container, .dropdown-container")
          .find(".form-check")
          .each(function () {
            var optionText = $(this).find("input").val();
            if (optionText) {
              options.push(optionText);
            }
          });

        // Collect selected options for multiple-choice, dropdown, and multi-select
        var answer = $(this).find("textarea").val();
        answers.push(answer);
      }

      questions.push({
        title: questionTitle,
        type: questionType,
        mark: questionMark,
        options: options,
        answers: answers,
      });
    });

    var formData = {
      title: formTitle,
      date: formDate,
      time: formtime,
      questions: questions,
    };
    console.log(formData);

    // Send data to the server
    $.ajax({
      url: "Adminpanel/assessmentformsql.php?action=createdata", // Replace with your server endpoint
      method: "POST",
      contentType: "application/json",
      data: JSON.stringify(formData),
      success: function (response) {
        const jsonResponse = JSON.parse(response);
        console.log(jsonResponse);
        if (jsonResponse.status === "success") {
          Swal.fire({
            text: "New record created",
            icon: "success",
          }).then((response) => {
            window.location.href = "../assessmentform.php";
          });
        } else {
          Swal.fire({
            text: "The Issue On Created",
            icon: "error",
          });
        }
      },
      error: function (error) {
        console.error("Error:", error);
        // Optionally, handle error response
      },
    });
  });
}

function showform() {
  $.ajax({
    url: "Adminpanel/assessmentformsql.php?action=showdata", // URL to which the request is sent
    method: "post", // Method type POST
    dataType: "json", // Data type expected from the server
    success: function (response) {
      if (response.status === "success") {
        var data = response.data;

        // Clear existing table rows, if any
        $("#assessmentform_table tbody").empty();

        // Iterate over each item in the data array
        $.each(data, function (index, item) {
          // Create a new table row with the data
          var statusButton =
            item.status === "Active"
              ? `<button class="btn btn-primary statuschange btn-sm" data-id="${item.Id}" onclick="active(${item.Id})" data-item="Active">Active</button>`
              : `<button class="btn btn-warning statuschange btn-sm" data-id="${item.Id}"onclick="active(${item.Id})" data-item="In-Active">In Active</button>`;

          var publishedButton =
            item.published === "Yes"
              ? `<button class="btn btn-primary btn-sm" data-id="${item.Id}" onclick="published(${item.Id})">Published</button>`
              : `<button class="btn btn-success btn-sm" data-id="${item.Id}">Completed</button>`;

          var editButton = `<button class="btn btn-info btn-sm" data-id="${item.Id}" onclick="edit(${item.Id})">Edit</button>`;

          var row = $("<tr>").append(
            $("<td>").text(item.Id),
            $("<td>").text(item.title),
            $("<td>").text(item.date),
            $("<td>").text(item.status),
            $("<td>").html(statusButton),
            $("<td>").text(item.published),
            $("<td>").html(publishedButton),
            $("<td>").html(editButton),
            $("<td>").text(item.time_stamp)
          );

          // Append the row to the table
          $("#assessmentform_table tbody").append(row);
        });
      } else {
        console.error("Error:", response.message); // Log the error message from the server
      }
    },
    error: function (xhr, status, error) {
      console.error("AJAX Error:", status, error); // Log the status and error
    },
  });
}

//edit button
function edit(id) {
  $.ajax({
    type: "post",
    url: "Adminpanel/assessmentformsql.php?action=editformdata",
    data: {
      id: id,
    },

    success: function (response) {
      // console.log(response);
      var datae = JSON.parse(response);

      var data = datae.data;

      sessionStorage.setItem("formData", JSON.stringify(data));
      // Redirect to the next page
      window.location.href = "../assessmentformedit.php";
    },
    error: function (xhr, response) {},
  });
}

// Function to dynamically create the form to edit/
$(document).ready(function () {
  var formData = sessionStorage.getItem("formData");
  if (formData) {
    var data = JSON.parse(formData);
    editgenerateForm(data);
  } else {
    console.error("No form data found in sessionStorage.");
  }
});

//pubilshed button
function published(id) {
  
  // Show the modal
  $("#publishedModal").modal("show");

  $(".savedataasses").on("click", function () {
    var teamdata = [];
    var coderdata = [];

    $(".teamdata").each(function (index, element) {
      var teamname = $(element).val();
      teamdata.push(teamname);
    });
    console.log(teamdata);

    $(".coderCheckbox5:checked").each(function (index, element) {
      var codername = $(element).val();
      coderdata.push(codername);
    });
    console.log(coderdata);

    $.ajax({
      url: "Adminpanel/assessmentformsql.php?action=showformdata",
      type: "post",
      data: {
        id: id,
        teamdata: teamdata,
        coderdata: coderdata,
      },
      success: function (response) {
        // Split the response into multiple JSON strings if there are multiple
        const responses = response.split("}{").map((item, index, array) => {
          if (index !== 0) item = "{" + item;
          if (index !== array.length - 1) item += "}";
          return JSON.parse(item);
        });

        // Handle the first response only
        const jsonResponse = responses[0];
        console.log(jsonResponse);

        if (jsonResponse.status === "success") {
          Swal.fire({
            text: jsonResponse.message, // Use the message from the first JSON response
            icon: "success",
          }).then((result) => {
            $("#publishedModal").modal("hide");
            location.reload(); // Reload the page
          });
        } else {
          Swal.fire({
            text: jsonResponse.message || "The Assessment Form Not Assigned", // Fallback message if not provided
            icon: "error",
          });
        }
      },

      error: function (xhr, response) {},
    });
  });
}

//active button
function active(id) {
  $(".statuschange").on("click", function () {
    var status = $(this).data("item");

    // alert(status);
    $.ajax({
      type: "post",
      url: "Adminpanel/assessmentformsql.php?action=updateformdata",
      data: {
        status: status,
        id: id,
      },
      success: function (response) {
        var jsonResponse = JSON.parse(response);
        console.log(jsonResponse);
        if (jsonResponse.status === "success") {
          Swal.fire({
            text: "Record updated successfully",
            icon: "success",
          }).then((result) => {
            // $("#publishedModal").modal("hide");
            location.reload();
          });
        } else {
          Swal.fire({
            text: "Failed to update record",
            icon: "error",
          });
        }
      },
      error: function (xhr, response) {},
    });
  });
}

//startassessmentdata
function startassessment(Id) {
  $.ajax({
    type: "post",
    url: "Adminpanel/assessmentformsql.php?action=showcoderform",
    data: { Id: Id },
    success: function (response) {
      console.log(response);
      var jsonResponse = JSON.parse(response);

      if (jsonResponse.status == "success") {
        var data = jsonResponse.data;
        // console.log(data);
        // Store form data in session storage
        sessionStorage.setItem("formData", JSON.stringify(data));
        // Redirect to the next page
         window.location.href = "../assessmentformcoder.php";
      } else {
        // Handle error if needed
      }
    },
    error: function (xhr, response) {
      // Handle error if needed
    },
  });
}

// Function to dynamically create the form/
$(document).ready(function () {
  var formData = sessionStorage.getItem("formData");
  if (formData) {
    var data = JSON.parse(formData);
    generateForm(data);
  } else {
    console.error("No form data found in sessionStorage.");
  }
});

let countdownInterval;

function startTimer() {
  countdownInterval = setInterval(timerdata, 1000);
}

function timerdata() {
  let time = $(".newtimedata").val();
  let [hours, minutes, seconds] = time.split(":").map(Number);

  if (seconds > 0) {
    seconds--;
  } else {
    seconds = 59;
    if (minutes > 0) {
      minutes--;
    } else {
      minutes = 59;
      if (hours > 0) {
        hours--;
      } else {
        clearInterval(countdownInterval);
        return;
      }
    }
  }

  let newTime = `${String(hours).padStart(2, "0")}:${String(minutes).padStart(
    2,
    "0"
  )}:${String(seconds).padStart(2, "0")}`;
  $(".newtimedata").val(newTime);

  if (newTime == "00:00:00") {
    Swal.fire({
      title: "Sweet!",
      text: "The Time Has Over",
      imageUrl:
        "https://i.pinimg.com/originals/f4/03/58/f4035871917a794d9173a9164126e9ef.gif",
      imageWidth: 300,
      imageHeight: 300,
      imageAlt: "Custom image",
      allowOutsideClick: false,
      allowEscapeKey: false,
      showConfirmButton: true, // Show the confirm button
      confirmButtonText: "Submit", // Customize the button text
    }).then((result) => {
      if (result.isConfirmed) {
        $("#submit").trigger("click");
      }
    });
  } else {
  }
}

function generateForm(data) {
  // Clear the existing form content
  $("#formContainer").empty();
  let serialNumber = 1;

  // Set the title and time from the first data item
  const firstItem = data[0];
  $(".titledata").text(firstItem.title.toUpperCase());
  $(".timedata").val(firstItem.time);

  // Iterate over each item in the data array
  data.forEach((item) => {
    const formJson = JSON.parse(item.form_json);

    // Iterate over each question in the form JSON
    formJson.forEach((question) => {
      const questionContainer = $('<div class="form-group"></div>');
      questionContainer.append(`<h4>${serialNumber}. ${question.title}</h4>`);

      // Create the appropriate input field based on the question type
      switch (question.type) {
        case "text":
          questionContainer.append(
            `<input type="text" class="form-control" placeholder="${question.title}" data-answer="${question.answers}" />`
          );
          break;

        case "dropdown":
          const dropdown = $(
            `<select class="form-control" data-answer="${question.answers}"></select>`
          );
          question.options.forEach((option) => {
            dropdown.append(`<option value="${option}">${option}</option>`);
          });
          questionContainer.append(dropdown);
          break;

        case "multi-select":
          const multiSelect = $(
            `<select class="form-control" multiple data-answer="${question.answers}"></select>`
          );
          question.options.forEach((option) => {
            multiSelect.append(`<option value="${option}">${option}</option>`);
          });
          questionContainer.append(multiSelect);
          break;

        case "multiple-choice":
          question.options.forEach((option) => {
            questionContainer.append(`
              <div class="form-check">
                <input class="form-check-input ml-2" type="checkbox" name="${question.title}" value="${option}" data-answer="${question.answers}" />
                <label class="form-check-label">${option}</label>
              </div>
            `);
          });
          break;

        default:
          console.error("Unknown question type:", question.type);
      }

      // Append the question container to the form
      $("#formContainer").append(questionContainer);
      serialNumber++;
    });
  });

  // Start the timer after form generation
  startTimer();
}

//function tab change
function tabchange() {
  $.ajax({
    type: "post",
    url: "Adminpanel/assessmentformsql.php?action=activea",
    data: {
      status: status,
    },
    datatype: "json",
    success: function (response) {
      // Parse the JSON response
      var data = JSON.parse(response);
      // Check if the status is success
      if (data.status === "success") {
        var dataone = data.data;
        console.log(dataone);

        // Clear the existing table body
        var table = $(".assessmenttablebody").empty();

        // Check if dataone is an array and has content
        if (Array.isArray(dataone) && dataone.length > 0) {
          var serialnumber = 1;
          $.each(dataone, function (index, value) {
            var currentstatus = "";
            if (serialnumber == 1) {
              currentstatus = `<span class="badge rounded-pill bg-success">New</span>`;
            } else {
              currentstatus = `<span class="badge rounded-pill bg-danger">
                Old</span>`;
            }
            console.log(value.Id);
            table.append(`<tr>
                    <td>${serialnumber}</td>
                    <td>${value.form_id}</td>
                    <td>${value.assigned_coder_empid}</td>
                    <td>${value.team_name}</td>
                    <td>${value.form_assigned_by}</td>
                    <td>${currentstatus}</td>
                    <td>${value.time_stamp}</td>
                    <td><button class='btn btn-info' data-id='${value.Id}' onclick='startassessment(${value.Id})'>Start</button></td>
                </tr>`);
            serialnumber++;
          });
        } else {
          // If no data, you can display a message or keep the table empty
          table.append('<tr><td colspan="5">No data available</td></tr>');
        }
      } else {
        // Handle error status if needed
        console.error("Error:", data.message);
        alert("An error occurred: " + data.message);
      }
    },

    error: function (xhr, response) {},
  });
}

//save function
function savedata() {
  $("body").on("click", "#submit", function () {
    let totalMarks = 0;
    const coderData = [];
    var titledata = $(".titledata").val();
    var newtimedata = $(".newtimedata").val();
    var formid = $(".formid").val();

    // Iterate over each form-control
    $(".form-control").each(function () {
      const inputType =
        $(this).attr("type") || $(this).prop("tagName").toLowerCase();
      const markcoder = $(this).data("mark");
      let coderAnswer, correctAnswer, questionTitle;

      switch (inputType) {
        case "text":
        case "select":
        case "select-one": // For single select dropdown
          coderAnswer = $(this).val();
          correctAnswer = $(this).data("answer");
          questionTitle = $(this).closest(".form-group").find("h4").text();
          break;

        case "select-multiple": // Correct handling of multiple select
          if ($(this).prop("multiple")) {
            coderAnswer = $(this).val() ? $(this).val().join(", ") : "";
            correctAnswer = $(this).data("answer");
            questionTitle = $(this).closest(".form-group").find("h4").text();
          }
          break;

        case "checkbox":
          if ($(this).is(":checked")) {
            coderAnswer = $(this).val();
            correctAnswer = $(this).data("answer");
            questionTitle = $(this).closest(".form-group").find("h4").text();
          } else {
            return;
          }
          break;

        default:
          coderAnswer = $(this).val();
          correctAnswer = $(this).data("answer");
          questionTitle = $(this).closest(".form-group").find("h4").text();
          break;
      }

      // Ensure coderAnswer and correctAnswer are not undefined
      if (coderAnswer !== undefined && correctAnswer !== undefined) {
        // Determine if the answer is correct
        const isCorrect =
          coderAnswer.toString().toUpperCase() ===
          correctAnswer.toString().toUpperCase();

        // Push the data to the coderData array
        coderData.push({
          question: questionTitle,
          answer: coderAnswer,
          correctAnswer: correctAnswer,
          isCorrect: isCorrect,
          mark: markcoder,
        });

        // Update total marks if the answer is correct
        if (isCorrect) {
          totalMarks += markcoder;
        }
      } else {
        console.warn(
          "Undefined coderAnswer or correctAnswer for question:",
          questionTitle
        );
      }
    });

    // Convert coderData array to JSON string
    const coderDataJson = JSON.stringify(coderData);

    // Send data via AJAX
    $.ajax({
      type: "post",
      url: "Adminpanel/assessmentformsql.php?action=coderformdata",
      data: {
        coderData: coderDataJson,
        totalMarks: totalMarks,
        titledata: titledata,
        newtimedata: newtimedata,
        formid: formid,
      },
      success: function (response) {
        // Split multiple JSON responses
        var responses = response.split("}{").map((item, index, array) => {
          if (index !== 0) item = "{" + item;
          if (index !== array.length - 1) item += "}";
          return item;
        });

        // Parse the first response only
        var data = JSON.parse(responses[0]);
        var datastatus = data.status;

        if (datastatus === "success") {
          Swal.fire({
            text: "Assessment Completed SuccessFully", // Show the message from the first response
            icon: "success",
          }).then((result) => {
            window.location.href = "assessmenttablecoder.php";
          });
        } else {
          Swal.fire({
            text: "Error in Assessment",
            icon: "error",
          });
        }
      },

      error: function (xhr, status, error) {
        console.error("Error in saving data:", error);
      },
    });
  });
}

//coderdeatils of form
function coderDetails() {
  $.ajax({
    type: "post",
    url: "Adminpanel/assessmentformsql.php?action=coderformdetails",
    datatype: "json",
    success: function (response) {
      response = JSON.parse(response);
      if (response.status === "success") {
        var data = response.data;

        // Clear existing table rows, if any
        $("#assessmentformcoder_table tbody").empty();

        // Iterate over each item in the data array
        $.each(data, function (index, item) {
          // Create a new table row with the data
          var statusButton =
            item.status === "Active"
              ? `<button class="btn btn-primary statuschangecoder btn-sm" data-id="${item.Id}" onclick="activecoder(${item.Id})" data-item="Active">Active</button>`
              : `<button class="btn btn-warning statuschangecoder btn-sm" data-id="${item.Id}"onclick="activecoder(${item.Id})" data-item="In-Active">In Active</button>`;

          var pauseButton =
            item.status === "Active"
              ? `<button class="btn btn-danger  btn-sm" data-id="${item.Id}" data-item="Active">Pause</button>`
              : `<button class="btn btn-success  btn-sm" data-id="${item.Id}" data-item="In-Active">Play</button>`;

          var row = $("<tr>").append(
            $("<td>").text(item.Id),
            $("<td>").text(item.form_id),
            $("<td>").text(item.assigned_coder_empid),
            $("<td>").text(item.team_name),
            $("<td>").text(item.form_assigned_by),
            $("<td>").text(item.time_stamp),
            $("<td>").text(item.status),
            $("<td>").html(statusButton),
            $("<td>").html(pauseButton)
          );

          // Append the row to the table
          $("#assessmentformcoder_table tbody").append(row);
        });
      } else {
        console.error("Error:", response.message); // Log the error message from the server
      }
    },
    error: function (xhr, response) {},
  });
}

//active coder data
function activecoder(Id) {
  $(".statuschangecoder").on("click", function () {
    var status = $(this).data("item");

    $.ajax({
      type: "post",
      url: "Adminpanel/assessmentformsql.php?action=updatecoderformdata",
      data: {
        status: status,
        Id: Id,
      },
      success: function (response) {
        var jsonResponse = JSON.parse(response);
        console.log(jsonResponse);
        if (jsonResponse.status === "success") {
          Swal.fire({
            text: "Record updated successfully",
            icon: "success",
            confirmButtonText: "Submit",
          }).then((result) => {
            window.location.href = "";
          });
        } else {
          Swal.fire({
            text: "Failed to update record",
            icon: "error",
          });
        }
      },
    });
  });
}

//manual evolution
function manualEvaluation() {
  $.ajax({
    type: "post",
    url: "Adminpanel/assessmentformsql.php?action=manualevaluation",
    datatype: "json",
    success: function (response) {
      response = JSON.parse(response);

      if (response.status === "success") {
        var data = response.data;

        // Clear existing table rows, if any
        $("#assessmentformmanual_table tbody").empty();

        // Iterate over each item in the data array
        $.each(data, function (index, item) {
          console.log(item.statusdata);
          // Create a new table row with the data
          // coderanswer =item.answer;
          var statusButton =
            item.statusdata === "Not-Evaluated"
              ? `<button class="btn btn-primary statuschangeevalation btn-sm" data-id="${
                  item.Id
                }" onclick="evaluatedata(${
                  item.Id
                })"  data-item="Evaluated" data-answer='${JSON.stringify(
                  item.answer
                )}'>Evaluate</button>`
              : `<button class="btn btn-warning btn-sm" data-id="${item.Id}"onclick="evaluatedata(${item.Id})" data-item="Not-Evaluated">Not Evaluated</button>`;

          var row = $("<tr>").append(
            $("<td>").text(item.Id),
            $("<td>").text(item.fomrid),
            // $("<td>").text(item.answer),
            $("<td>").text(item.title),
            $("<td>").text(item.coder_empid),
            $("<td>").text(item.systemmark),
            $("<td>").text(item.submitted_date),
            $("<td>").text(item.statusdata),
            $("<td>").html(statusButton)
          );

          // Append the row to the table
          $("#assessmentformmanual_table tbody").append(row);
        });
      } else {
        console.error("Error:", response.message); // Log the error message from the server
      }
    },
    error: function (xhr, response) {},
  });
}

// Function to handle evaluation data
function evaluatedata(Id) {
  // alert(Id);
  // Show the modal for evaluation
  $("#evaluationModal").modal("show");
  $("#answerscoder").empty();
  var button = $(`.statuschangeevalation[data-id='${Id}']`);
  var answerdata = button.data("answer");

  coderanswer = JSON.parse(answerdata);

  coderanswertwo = JSON.parse(coderanswer);

  //Iterate through the coder answer data to generate form inputs
  coderanswertwo.forEach((item, index) => {
    const coderAnswer = Array.isArray(item.answer)
      ? item.answer.join(", ")
      : item.answer;

    // Create the HTML structure for each question's details
    const formGroup = `
        <div class="form-group mb-3">
            <label><strong>Question ${index + 1}: ${
      item.question
    }</strong></label>
            <div class="row">
                <div class="col-md-6">
                    <label>Coder Answer</label>
                    <textarea class="form-control" rows="3" style="resize: none;" disabled>${coderAnswer}</textarea>
                </div>
                <div class="col-md-6">
                    <label>Correct Answer</label>
                    <textarea class="form-control" rows="3" style="resize: none;" disabled>${
                      item.correctAnswer
                    }</textarea>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <label>Mark</label>
                    <input type="text" class="form-control system-mark" value="${
                      item.mark
                    }" disabled>
                </div>
                <div class="col-md-6">
                    <label>Manual Mark</label>
                    <input type="number" class="form-control manual-mark" data-question="${
                      item.question
                    }" placeholder="Enter manual mark">
                </div>
            </div>
        </div>
    `;

    // Append each form group to the modal's form
    $("#answerscoder").append(formGroup);
  });

  // Handle the 'Save changes' button click
  $("#saveChangesButton")
    .off("click")
    .on("click", function () {
      // Initialize total marks variable
      let totalMarks = 0;
      let manualMarks = [];
      let valid = true; // For checking if all marks are valid

      $(".manual-mark").each(function () {
        const question = $(this).data("question"); // Extract question from the data attribute
        const manualMark = parseFloat($(this).val()); // Get the manual mark value and convert it to a number
        const correctMark = parseFloat(
          $(this).closest(".row").find(".system-mark").val()
        ); // Get correct mark

        if (correctMark >= manualMark) {
          // Add to manualMarks array
          manualMarks.push({
            Id: Id, // Assuming Id is passed globally
            question: question,
            manualMark: manualMark,
          });

          // Calculate total marks
          totalMarks += manualMark;
        } else {
          Swal.fire({
            text: `Manual mark for question "${question}" exceeds the correct mark!`,
            icon: "error",
          });

          valid = false;
          return false;
        }
      });

      if (!valid) return;

      // Send the data via AJAX to the server
      $.ajax({
        type: "POST",
        url: "Adminpanel/assessmentformsql.php?action=manualmarkupdate", // Replace with actual server endpoint
        data: {
          Id: Id,
          totalMarks: totalMarks,
        },
        success: function (response) {
          var jsonResponse = JSON.parse(response);
          console.log(jsonResponse);
          if (jsonResponse.status === "success") {
            Swal.fire({
              text: "Record updated successfully",
              icon: "success",
            }).then((result) => {
              // $("#publishedModal").modal("hide");
              location.reload();
            });
          } else {
            Swal.fire({
              text: "Failed to update record",
              icon: "error",
            });
          }
        },
        error: function (error) {
          console.error("Error saving data:", error);
        },
      });
    });
}

// $("#team_select5").on("change", function () {
//   var team = $(this).val();
//   var parts = team.split(" - ");
//   var teamname = parts[0];
//   var team_id = parts[1];

//   $.ajax({
//     url: "filter/fetch_coders.php",
//     type: "POST",
//     data: {
//       teamname: teamname,
//       team_id: team_id,
//     },
//     dataType: "json",
//     success: function (response) {
//       console.log("Response from server:", response);
//       var options = '<option value="All">Select-Coder</option>';
//       $.each(response, function (index, coder) {
//         options +=
//           '<option value="' +
//           coder.Coders +
//           " - " +
//           coder.coder_emp_id +
//           '">' +
//           coder.Coders +
//           " - " +
//           coder.coder_emp_id +
//           "</option>";
//       });
//       $("#coder_name5").html(options);
//     },
//     error: function (xhr, status, error) {
//       console.error("Error:", error);
//     },
//   });
// });

// team selection
$("#team_select5").on("change", function () {
  var team = $(this).val();
  var parts = team.split(" - ");
  var teamname = parts[0];
  var team_id = parts[1];

  $.ajax({
    url: "filter/fetch_coders.php",
    type: "POST",
    data: {
      teamname: teamname,
      team_id: team_id,
    },
    dataType: "json",
    success: function (response) {
      console.log("Response from server:", response);
      var options = "";
      $.each(response, function (index, coder) {
        options +=
          '<label><input type="checkbox" class="coderCheckbox5" value="' +
          coder.Coders +
          " - " +
          coder.coder_emp_id +
          '">' +
          coder.Coders +
          "</label><br>";
      });
      $("#coderCheckboxList5").html(options);
    },
    error: function (xhr, status, error) {
      console.error("Error:", error);
    },
  });
});

$(document).on("change", "#selectAllCoders5", function () {
  $(".coderCheckbox5").prop("checked", this.checked);
});

$(document).on("change", ".coderCheckbox5", function () {
  if ($(".coderCheckbox5:checked").length === $(".coderCheckbox5").length) {
    $("#selectAllCoders5").prop("checked", true);
  } else {
    $("#selectAllCoders5").prop("checked", false);
  }
});

//edit form display
function editgenerateForm(data) {
  // Clear the existing form content
  $("#formContaineredit").empty();
  let serialNumber = 1;
  // console.log(data);

  // Set the title and time from the first data item
  const firstItem = data[0];
  $(".edittitledata").text(firstItem.title.toUpperCase());
  $(".timedata").text(firstItem.time);
  $(".formid").val(firstItem.Id);

  // Iterate over each item in the data array
  data.forEach((item) => {
    const formJson = JSON.parse(item.form_json);

    // Iterate over each question in the form JSON
    formJson.forEach((question) => {
      const questionContainer = $('<div class="form-group question-container"></div>');
      questionContainer.append(
         //`<h4 contenteditable="true" class="questionheading">${serialNumber}. ${question.title}</h4>`
        `<input type="text" class="form-control questionheading" value="${question.title}">`
      );

      // Create the appropriate input field based on the question type
      switch (question.type) {
        case "text":
          // Add editable fields for answer and mark
          questionContainer.append(`
            <div class="editable-answer-mark">
           <select class="form-control" disabled>
            <option value="${question.type}" selected>${question.type}</option>
          </select>

              <label class="form-check-label">Answer</label>
              <textarea class="form-control" placeholder="Long answer text">${question.answers[0]}</textarea><br>
              <label class="form-check-label">Mark</label>
              <input type="text" class="editable-mark form-control markdata" value="${question.mark[0]}">
            </div>
          `);
          break;

        case "dropdown":
          const dropdownContainer = $('<div class="multiple-choice-container"></div>');
          let numberdata = 1; // Initialize option numbering

          // Display all options together in a list format
          question.options.forEach((option) => {
            dropdownContainer.append(
              `<div class="form-check">
         <label>Option ${numberdata++}</label>  
        <input type="text" class="form-control" placeholder="Option" value="${option}">
       </div>`
            );
          });

          // Add answer and mark fields separately
          dropdownContainer.append(`
    <div class="option-answer-mark">
        <select class="form-control" disabled>
            <option value="${question.type}" selected>${question.type}</option>
          </select>
      <label>Answer</label>
      <textarea class="form-control" placeholder="Long answer text">${question.answers[0]}</textarea><br>
      
      <label>Mark</label>
      <input type="text" class="editable-mark form-control markdata" value="${question.mark[0]}">
    </div>
  `);

          // Append the dropdown container to the question container
          questionContainer.append(dropdownContainer);
          break;

        case "multi-select":
          const multiSelectContainer = $(
            '<div class="multiple-choice-container"></div>'
          );
          let multiSelectNumber = 1; // Initialize option numbering

          // Display all options together in a list format
          question.options.forEach((option) => {
            multiSelectContainer.append(
              `<div class="form-check">
                   <label class="form-check-label">Option ${multiSelectNumber++}</label>  
                   <input type="text" class="form-control" placeholder="Option" value="${option}">
                 </div>`
            );
          });

          // Add answer and mark fields separately
          multiSelectContainer.append(`
              <div class="option-answer-mark">
                  <select class="form-control" disabled>
                  <option value="${question.type}" selected>${question.type}</option>
                </select>
                <label class="form-check-label">Answer</label>
                <textarea class="form-control" placeholder="Long answer text">${question.answers[0]}</textarea><br>
                <label class="form-check-label">Mark</label>
                <input type="text" class="editable-mark form-control markdata" value="${question.mark[0]}">
              </div>
            `);

          // Append the multi-select container to the question container
          questionContainer.append(multiSelectContainer);
          break;

  //       case "multiple-choice":
  //         const multipleChoiceContainer = $(
  //           '<div class="multiple-choice-container"></div>'
  //         );
  //         let multipleChoiceNumber = 1; // Initialize option numbering

  //         // Display all options together in a list format
  //         question.options.forEach((option) => {
  //           multipleChoiceContainer.append(`
  //     <div class="form-check">
  //       <input class="form-check-input" type="text" name="${
  //         question.title
  //       }" value="${option}" required/>  
  //     </div>
  //   `);
  //         });

  //         // Add answer and mark fields separately
  //         multipleChoiceContainer.append(`
  //   <div class="option-answer-mark">
  //       <select class="form-control" disabled>
  //           <option value="${question.type}" selected>${question.type}</option>
  //         </select>
  //     <label class="form-check-label">Answer</label>
  //      <textarea class="form-control" placeholder="Long answer text">${question.answers[0]}</textarea><br>
  //     <label class="form-check-label">Mark</label>
  //     <input type="text" class="editable-mark form-control markdata" value="${question.mark[0]}">
  //   </div>
  // `);

  //         // Append the multiple-choice container to the question container
  //         questionContainer.append(multipleChoiceContainer);
  //         break;

        default:
          console.error("Unknown question type:", question.type);
      }

      const deleteButton = document.createElement("button");
      deleteButton.innerHTML = '<i class="fas fa-trash-alt"></i>';
      deleteButton.classList.add("btn", "deletebutton");
      deleteButton.onclick = function () {
        questionContainer.remove();
        updateSerialNumbers(); // Update serial numbers after removing a question
      };

      questionContainer.append(deleteButton);

      // Append the question container to the form
      $("#formContaineredit").append(questionContainer);
     
      serialNumber++;
    });
  });
}


//edit form data to submit
function editformdatasubmit(){

  $("#editsubmit").on("click", function () {
    var formTitle = $(".edittitledata").text();
    // var formDate = $("#formdate").val();
    var formtime = $(".timedata").text();
    var formid= $(".formid").val();

    var questions = [];

    // Loop through each question container
    $(".question-container").each(function () {
       var questionTitle = $(this).find(".questionheading").val();
      // var questionTitle = $(this).find(".questionheading").text();
      var questionType = $(this).find("select").val();
      var questionMark = $(this).find(".markdata").val();
      // var questionMark = $(this).find(".markdata").text();
      var options = [];
      var answers = [];

      // Get options or answers based on question type
      if (questionType === "text") {
        // For text questions, collect answer
        var answer = $(this).find("textarea").val();
        answers.push(answer);
      } else if (
        questionType === "multiple-choice" ||
        questionType === "dropdown" ||
        questionType === "multi-select"
      ) {
        $(this)
          .find(".multiple-choice-container, .dropdown-container")
          .find(".form-check")
          .each(function () {
            var optionText = $(this).find("input").val();
            if (optionText) {
              options.push(optionText);
            }
          });

        // Collect selected options for multiple-choice, dropdown, and multi-select
        var answer = $(this).find("textarea").val();
        answers.push(answer);
      }

      questions.push({
        title: questionTitle,
        type: questionType,
        mark: questionMark,
        options: options,
        answers: answers,
      });
    });

    var formData = {
      title: formTitle,
      time: formtime,
      id: formid,
      questions: questions,
    };
    console.log(formData);

    // Send data to the server
    $.ajax({
      url: "Adminpanel/assessmentformsql.php?action=editedform", // Replace with your server endpoint
      method: "POST",
      contentType: "application/json",
      data: JSON.stringify(formData),
      success: function (response) {
        const jsonResponse = JSON.parse(response);
        console.log(jsonResponse);
        if (jsonResponse.status === "success") {
          Swal.fire({
            text: "New record created",
            icon: "success",
          }).then((response) => {
            window.location.href = "../assessmentform.php";
          });
        } else {
          Swal.fire({
            text: "The Issue On Created",
            icon: "error",
          });
        }
      },
      error: function (error) {
        console.error("Error:", error);
        // Optionally, handle error response
      },
    });
  });





}
