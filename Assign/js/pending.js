$(document).ready(function () {
  // Open the modal when the button is clicked
  $(".Pending_btn").on("click", function (e) {
    e.preventDefault();
    $(".commentModal").modal("show");
  });

  // Handle the submission inside the modal
  $("#submitComment").on("click", function () {

     const totalHours = $('#timerDisplay').text();
    
     savetotime(totalHours);

    const Reason = $("#commentType").val();
    const Comment = $("#commentText").val();

    // const Id=$('#pending').val();
    var Id = $("#pending").attr("value");

    // alert(Id);

    // Perform actions with commentType and commentText as needed
    // For example, display the selected option and entered comment
    console.log("Selected:", commentType);
    console.log("Comment:", commentText);

    if (Reason == "" || Comment == "") {
      alert("enter valid data");
      return false;
    }
    var code_data = [];

    // CODE
    $("#dynamic_field tbody tr").each(function (index, row) {
      // Get values from specific input fields within each row
      var EntryId = $(row).find("td:eq(1) input").val();
      var mitems = $(row).find("td:eq(2) input").val();
      var icd = $(row).find("td:eq(3) input").val().trim();
      var description = $(row).find("td:eq(4) input").val();
      var effectivedate = $(row).find("td:eq(5) input").val();
      var eo = $(row).find("td:eq(6) select").val();
      var rating = $(row).find("td:eq(7) select").val();
      var coderchecked = $(row).find("td:eq(8) input[type='checkbox']:checked").val();
      if (coderchecked === undefined) {
        coderchecked = "";
      }

      var agencychecked = $(row).find("td:eq(9) input[type='checkbox']:checked").val();
      if (agencychecked === undefined) {
        agencychecked = "";
      }
      var agencyprimarycode =$(row).find("td:eq(10) select").val();






      if (
        EntryId != "" &&
        mitems != "" &&
        icd != "" &&
        description != "" &&
        effectivedate != "" &&
        eo != "" &&
        coderchecked !="" &&
        agencychecked !="" && 
        agencyprimarycode !=""
      ) {
        var rowData = {
          EntryId: EntryId,
          mitems: mitems,
          icd: icd,
          description: description,
          effectivedate: effectivedate,
          eo: eo,
          rating: rating,
          coderchecked:coderchecked,
          agencychecked:agencychecked,
          agencyprimarycode:agencyprimarycode,

        };
        code_data.push(rowData);
      }
    });

    var code_sege = code_data;

    //OASIS
    var oasis_data = [];

    $(".nested-card").each(function () {
      var mitemElement = $(this).find(".mitem-input").get(0);
      var mitemAttributeValue = $(mitemElement).attr("data-mitem");

      var us1Value = $(this).find(".us-input-1").val();
      var us2Value = $(this).find(".us-input-2").val();
      var us3Value = $(this).find(".us-input-3").val();

      if (
        mitemAttributeValue != "" &&
        us1Value != "" &&
        us2Value != "" 
      ) {
        var rowData = {
          mitemAttributeValue: mitemAttributeValue,
          oasis_inpu1: us1Value,
          oasis_inpu2: us2Value,
          oasis_inpu3: us3Value,
        };
        oasis_data.push(rowData);
      }
    });
    var oasis_sege = oasis_data;

    var poc_data = [];

    // POC
    $(".nested-card").each(function () {
      const pocitemAttributeValue = $(this)
        .find(".pocitem-input")
        .attr("data-pocitem");

      const pocvalue = $(this).find(".us-inpu-1").val();

      if (pocitemAttributeValue != "" && pocvalue != "") {
        var pocdata = {
          pocitemAttributeValue: pocitemAttributeValue,
          pocvalue: pocvalue,
        };

        poc_data.push(pocdata);
      }
    });

    var poc_sege = poc_data;


    $.ajax({
      type: "POST",
      url: "Assign/pending.php",

      data: {
        Id: Id,
        Reason: Reason,
        Comment: Comment,
        code_sege: code_sege,
        oasis_sege: oasis_sege,
        poc_sege: poc_sege,
      },

      success: function (data) {
        closeModalAndResetForm();
        modal_close();
        Swal.fire({
          title: "Success!",
          text: "File processed to in Pending",
          icon: "success",
          confirmButtonText: "OK",
        }).then(function () {
          // code_sege.val("");
          // oasis_sege.val("");
          // poc_sege.val("");
          window.location.href = "assign_table.php";
        });
        var errormsg = JSON.parse(data);
        if (errormsg.error) {
          Swal.fire({
            title: "Error!",
            text: errormsg.error,
            icon: "error",
            confirmButtonText: "OK",
          });
        }


        // Handle success response if needed
      },
      error: function (xhr, status, error) {
        // Handle error if the AJAX request fails
        console.error(error);
      },
    });

    function closeModalAndResetForm() {
      // Reset the form with ID "myForm"
      $("#commentType").val("");
      $("#commentText").val("");
    }

    function modal_close() {
      $("#exampleModal").removeClass("show");
      $("#modal-body").removeClass("modal-open");
      $(".Pending_btn").hide();
      $(".modal-backdrop").remove();
    }

     function savetotime(totalHours) {
        $.ajax({
            type: 'POST',
            url: 'Assign/Work_time.php',
            data: { totalHours: totalHours },
            success: function(response) {

                console.log(response);
                // if (response.success) {
                //     Swal.fire({
                //         title: 'Success!',
                //         text: response.message,
                //         icon: 'success',
                //         confirmButtonText: 'OK'
                //     }).then(function(result) {
                //         if (result.isConfirmed) {
                //             window.location.href = "assign_table.php";
                //         }
                //     });
                // } else if (response.error) {
                //     Swal.fire({
                //         title: 'Error',
                //         text: response.error,
                //         icon: 'error',
                //         confirmButtonText: 'OK'
                //     });
                // }
            },
            error: function(xhr, status, error) {
                console.error('Ajax request failed');
                console.error(xhr.responseText);
            }
        });
    }

    // You can also hide the modal after submission if needed
  });

});
