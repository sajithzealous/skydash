   $(document).on('click', '#clk-wip', function(e) {
        const totalHours = $('#timerDisplay').text();

 
        e.preventDefault();

        if (confirm("Are You Sure The File Was WIP?")) {
           
            savetotime(totalHours);
    function savetotime(totalHours) {
        $.ajax({
            type: 'POST',
            url: 'Assign/Work_time.php',
            data: { totalHours: totalHours },
            success: function(response) {
                window.location.href = "assign_table.php";

                console.log(response);
               
            },
            error: function(xhr, status, error) {
                console.error('Ajax request failed');
                console.error(xhr.responseText);
            }
        });
    }
        } else {
  
        
        }
});

    