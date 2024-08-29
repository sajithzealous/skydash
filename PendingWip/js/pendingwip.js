$(document).ready(function () {
  $("#Pendwip").on("click", function () {
    if (confirm("Are You Sure To Put The File In Hold?")) {
      var Id = $("#Pendwip").attr("value");
      // Initialize an array to store data from the table
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

        if (
          EntryId != "" &&
          mitems != "" &&
          icd != "" &&
          description != "" &&
          effectivedate != "" &&
          eo != "" &&
          rating != ""
        ) {
          var rowData = {
            EntryId: EntryId,
            mitems: mitems,
            icd: icd,
            description: description,
            effectivedate: effectivedate,
            eo: eo,
            rating: rating,
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
          us2Value != "" &&
          us3Value != ""
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
        url: "PendingWip/pendinwip.php",
        type: "post",
        data: {
          Id: Id,
          code_sege: code_sege,
          oasis_sege: oasis_sege,
          poc_sege: poc_sege,
        },
        success: function (response) {
          Swal.fire({
            title: "Success!",
            text: "File processed to in progression",
            icon: "success",
            confirmButtonText: "OK",
          }).then(function () {
            // code_sege.val("");
            // oasis_sege.val("");
            // poc_sege.val("");
            window.location.href = "assign_table.php";
          });

          var errormsg = JSON.parse(response);
          if (errormsg.error) {
            Swal.fire({
              title: "Error!",
              text: errormsg.error,
              icon: "error",
              confirmButtonText: "OK",
            });
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.error("Error:", errorThrown);
          // Handle error response
        },
      });
    } else {
    }
  });
});
