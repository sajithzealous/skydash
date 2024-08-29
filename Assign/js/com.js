let startTime;
let timerInterval;
let timerPaused = false;
let pausedTime = 0; // Initialize pausedTime

$(document).ready(function() {
    // Start the timer
    startTimer();

    function startTimer() {
        if (!timerPaused) {
            startTime = Date.now() - pausedTime; // Adjust start time if resuming from pause
            timerInterval = setInterval(updateTimer, 1000);
        }
    }

    function updateTimer() {
        if (!timerPaused) {
            const elapsedTime = new Date(Date.now() - startTime);
            const formattedTime = formatTime(elapsedTime);
            $('#timerDisplay').text(formattedTime);
        }
    }

    function formatTime(time) {
        const hours = time.getUTCHours().toString().padStart(2, '0');
        const minutes = time.getUTCMinutes().toString().padStart(2, '0');
        const seconds = time.getUTCSeconds().toString().padStart(2, '0');
        return `${hours}:${minutes}:${seconds}`;
    }

    function pauseTimer() {
        clearInterval(timerInterval);
        timerPaused = true;
        pausedTime = Date.now() - startTime; // Calculate elapsed time when pausing
    }

    function resumeTimer() {
        timerPaused = false;
        startTimer(); // Start the timer again
    }

    // Cache jQuery selectors
    const $completedButton = $('#completed');

    // Attach click event using event delegation
    $(document).on('click', '#completed', function(e) {
        const totalHours = $('#timerDisplay').text();

        
        pauseTimer();
        e.preventDefault();

        if (confirm("Are You Sure The File Was Completed?")) {
            const Id = $completedButton.attr("value");
            savetotime(totalHours);

            $.ajax({
                type: 'POST',
                url: 'Assign/Update_complete.php',
                data: { Id: Id },
                success: function(data) {
                    const response = typeof data === 'object' ? data : JSON.parse(data);
                    $completedButton.hide();

                    if (response.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(function(result) {
                            if (result.isConfirmed) {
                                window.location.href = "assign_table.php";
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
                    console.error('Ajax request failed');
                    console.error(xhr.responseText);
                }
            });
        } else {
            // If the user cancels, simply resume the timer without restarting it
            resumeTimer();
        }
    });

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
});
