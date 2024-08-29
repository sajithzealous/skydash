// Variable to store the start time of the timer
let startTime;
// Interval ID for the timer
let timerInterval;
// Flag to indicate whether the timer is paused
let timerPaused = false;

// Function to start the timer
function startTimer() {
    // Only start the timer if it's not paused
    if (!timerPaused) {
        startTime = Date.now(); // Record the current time
        timerInterval = setInterval(updateTimer, 1000); // Start updating the timer every second
    }
}

// Function to update the timer display
function updateTimer() {
    // Only update the timer if it's not paused
    if (!timerPaused) {
        const elapsedTime = new Date(Date.now() - startTime); // Calculate elapsed time
        const formattedTime = formatTime(elapsedTime); // Format the time
        $('#timerDisplay').text(formattedTime); // Update the timer display using jQuery
    }
}

// Function to format the elapsed time
function formatTime(time) {
    const hours = time.getUTCHours().toString().padStart(2, '0'); // Extract hours
    const minutes = time.getUTCMinutes().toString().padStart(2, '0'); // Extract minutes
    const seconds = time.getUTCSeconds().toString().padStart(2, '0'); // Extract seconds
    return `${hours}:${minutes}:${seconds}`; // Format the time
}

// Function to pause the timer
function pauseTimer() {
    clearInterval(timerInterval); // Clear the interval
    timerPaused = true; // Set the flag to indicate timer is paused
}

// Function to resume the timer
function resumeTimer() {
    timerPaused = false; // Set the flag to indicate timer is resumed
    startTimer(); // Start the timer again
}

// Event listener to start the timer when the document is ready
$(document).ready(function() {
    startTimer(); // Start the timer

    // Event listener for the "completed" button
    $("#completed").on('click', function() {
        const totalHours = $('#timerDisplay').text(); // Get the total elapsed time
        pauseTimer(); // Pause the timer
        alert(totalHours); // Display total elapsed time
        timerPaused = false; // Reset the timer pause flag
        resumeTimer(); // Resume the timer
        sendDataToServer(totalHours); // Send total elapsed time to the server
    });
});
