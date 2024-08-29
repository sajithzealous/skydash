$(document).ready(function () {
  $("#cmd").hide();
  // Attach a click event to the button
  $("#qc_preview").on("click", function (e) {
    if (confirm("Are You Sure")) {
      $("#cmd").show();
      e.preventDefault(); // Prevent the default behavior of the anchor tag

      // Get the user ID from the button's data attribute or any other way you have it available
      var Id = $("#qc_preview").attr("value");
      document.cookie = `Id=${Id}; path=/`;

      // Open generate_pdf.php in a new tab
      var firstWindow = window.open("qc_single_preview.php", "_blank");

      // Attach a callback to the first window's load event
      firstWindow.onload = function () {
        // Open final_preview.php in a new tab within the context of the first window
        firstWindow.open("final_preview.php", "_blank");
      };
    } else {
      // User clicked "NO" or closed the dialog, you can handle this case as needed
    }
  });
  $("#coder_preview").on("click", function (e) {
    if (confirm("Are You Sure")) {
      $("#cmd").show();
      e.preventDefault(); // Prevent the default behavior of the anchor tag

      // Get the user ID from the button's data attribute or any other way you have it available
      var Id = $("#coder_preview").attr("value");
      document.cookie = `Id=${Id}; path=/`;
      // Open generate_pdf.php in a new tab
      window.open("generate_pdf.php", "_blank");
    } else {
      // User clicked "NO" or closed the dialog, you can handle this case as needed
    }
  });

  $("#hhrgpreview").on("click", function () {
    if (confirm("Are You Sure")) {
      var Id = $(".hhrgpreview").attr("value");
      document.cookie = `Id=${Id}; path=/`;
      // Open generate_pdf.php in a new tab
      window.open("./hhrgpreview.php", "_blank");
    } else {
    }
  });
});
