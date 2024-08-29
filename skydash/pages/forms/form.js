
$(document).ready(function () {
    $(".clk").on("click", function (e) {
        e.preventDefault();
alert("submit");

        var fileInput = $("#formFile")[0].files[0];

        if (fileInput) {
            var formData = new FormData();
            formData.append("formFile", fileInput);

            var reader = new FileReader();

            reader.onload = function (e) {
                var csvData = e.target.result;
                $.ajax({
                    url: "http://localhost/hlc/skydash/skydash/pages/forms/upload.php",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {

                        $(".box-body").html(response);
                        $(".preview-zone").removeClass("hidden");
                        alert(response);
                    },
                    error: function (xhr, status, error) {
                        console.log("Error: " + error);
                    },
                });
            };

            reader.readAsDataURL(fileInput);
        } else {
            alert("Please select a CSV file to upload.");
        }
    });
});
