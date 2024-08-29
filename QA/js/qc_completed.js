$(document).ready(function() {
        // Attach a click event to the button
        $('#stcoder').on('click', function(e) {
            if (confirm("Are You Sure The File Was Completed?")) {
                e.preventDefault(); // Prevent the default behavior of the anchor tag

                // Get the user ID from the button's data attribute or any other way you have it available
                // var Id = <?php echo json_encode($dfghjkl;'
                // 2852'); ?>;
                // var Id = $(".completed").val();
                var Id = $("#stcoder").attr("value");
                // console.log(Id);
                // alert(Id)
                // Perform the Ajax request
                $.ajax({
                    type: 'POST',
                    url: 'QA/qc_complete.php',
                    data: {
                        Id: Id
                    },
                    success: function(data) {
                        console.log("res",data)
                        var response = typeof data === 'object' ? data : JSON.parse(data);
                        $('.stcoder').hide();

                        if (response.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(function(result) {
                                if (result.isConfirmed) {
                                    // window.location.href="generate_pdf.php?Id="+Id;
                                    window.location.href="Qa_work_files.php";

                                }
                            });
                        } else if (response.error) {
                            Swal.fire({
                                title: 'Error',
                                text: response.error,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle errors here
                        console.error('Ajax request failed');
                        console.error(xhr.responseText);
                    }

                });
            }
            else {
                // User clicked "NO" or closed the dialog, you can handle this case as needed
              }
        });
    });




