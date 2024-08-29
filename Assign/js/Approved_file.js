$(document).ready(function() {
        // Attach a click event to the button
        $('#Approved').on('click', function(e) {
            if (confirm("Are You Sure The File Was Completed?")) {
                e.preventDefault(); // Prevent the default behavior of the anchor tag

                $.ajax({
                    type: 'POST',
                    url: 'Assign/Approved_file.php',
                    data: {},
                    success: function(data) {
                        console.log("res", data)
                        var response = typeof data === 'object' ? data : JSON.parse(data);

                        // Replace 'someElementId' with the actual ID of the element you want to hide
                        // $('#someElementId').hide();
                        $('').hide();

                        if (response.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(function(){



                                window.location.href="assign_table.php";





                            })
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle errors here
                        console.error('Ajax request failed');
                        console.error(xhr.responseText);
                    }
                });
            } else {
                // User clicked "NO" or closed the dialog, you can handle this case as needed
            }
        });

    });




