$(document).ready(function() {
        $("#cmd").hide();
        $("#qccmd").hide();
        $('#preview').on('click', function(e) {
              $("#cmd").show();
              $("#qccmd").show();

            if (confirm("Are You Sure")) {
                e.preventDefault(); // Prevent the default behavior of the anchor tag


                // Get the user ID from the button's data attribute or any other way you have it available
                var Id = $("#preview").attr("value");
                document.cookie = `Id=${Id}; path=/`;
                // Open generate_pdf.php in a new tab
                window.open("generate_pdf.php", "_blank");


            }
            else {
                // User clicked "NO" or closed the dialog, you can handle this case as needed
              }
        });

        $("#hhrgpreview").on("click", function () {

          var Id = $(".hhrgpreview").attr("value");
          document.cookie = `Id=${Id}; path=/`;
          // Open generate_pdf.php in a new tab
          window.open("./hhrgpreview.php", "_blank");
          
      });

         $("#hhrgworksheet").on("click", function () {

          var Id = $(".hhrgworksheet").attr("value");
          document.cookie = `Id=${Id}; path=/`;
          // Open generate_pdf.php in a new tab
          window.open("./hhrg_worksheet.php", "_blank");
          
      });


    });



