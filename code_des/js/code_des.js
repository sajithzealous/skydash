

$(document).ready(function() {
    var register_id=""; var code="";
    var codedescription_table="";
    // !  code description datatable   function 
       $.getJSON('code_des/code_dessql.php?action=codedescriptiontable', function (data) {
        codedescription_table = new DataTable('#codedescription_table', {
            lengthMenu: [
                [15, 25, 50, -1],
                [15, 25, 50, 'All']
            ],
            // fixedHeader: true,
            data: data,
            columns: [
                { data: 'index_id' },
                { data: 'code' },
                { data: 'effective_date' },
                { data: 'short_desc' },
                { data: 'logn_desc' },
                { data: 'classification' },
                {
                    data: null,
                    render: function (data, type, row) {
                        return '<div class="form-check"> <label class="form-check-label"> <center><input type="checkbox" class=" row-checkbox  form-check-input fileCheck"  data-index="' + row.index_id + '"><i class="input-helper float-right"></i></center></label> </div>';
                    }
                }
            ],
                initComplete: function () { 
                    // Add input fields and a checkbox for search in the table header
                    var table = $('#codedescription_table');
                    var inputsAndCheckbox = '<tr>' +
                        '<th><input type="text" id="search_index_id" class="dataTables_wrapper select" placeholder="Search Index ID"></th>' +
                        '<th><input type="text" id="search_code" class="dataTables_wrapper select" placeholder="Search Code"></th>' +
                        '<th><input type="text" id="search_effective_date" class="dataTables_wrapper select" placeholder="Search Effective Date"></th>' +
                        '<th><input type="text" id="search_short_desc" class="dataTables_wrapper select" placeholder="Search Short Description"></th>' +
                        '<th><input type="text" id="search_logn_desc" class="dataTables_wrapper select" placeholder="Search Long Description"></th>' +
                        '<th><input type="text" id="search_classification" class="dataTables_wrapper select" placeholder="Search Classification"></th>' +
                        '<th><input type="checkbox" id="select-all-checkbox" class="checkbox-lg"> Select All</th>' +
                        '</tr>';
                    
                    // Append input fields and a checkbox to the table header
                    table.find('thead').append(inputsAndCheckbox);
                }
        });
        
          
                // Add event listeners for individual column search      
                $('#search_index_id').on('keyup', function () {
                    codedescription_table.columns(0).search(this.value).draw();
                });

                $('#search_code').on('keyup', function () {
                    codedescription_table.columns(1).search(this.value).draw();
                });

                $('#search_effective_date').on('keyup', function () {
                    codedescription_table.columns(2).search(this.value).draw();
                });

                $('#search_short_desc').on('keyup', function () {
                    codedescription_table.columns(3).search(this.value).draw();
                });

                $('#search_logn_desc').on('keyup', function () {
                    codedescription_table.columns(4).search(this.value).draw();
                });

                $('#search_classification').on('keyup', function () {
                    codedescription_table.columns(5).search(this.value).draw();
                });
            });
            //   // Add event listeners for individual column search
            //     $('#search_index_id').on('keyup', function () {
            //         codedescription_table.columns(0).search(this.value).draw();
            //     });
                // Select all checkbox
                $('#select-all-checkbox').on('change', function () {
                    var checkboxes = $('.row-checkbox');
                    checkboxes.prop('checked', $(this).prop('checked'));
                });

                // Delete selected rows
                $('#delete-selected').on('click', function () {
                    var selectedRows = [];
                    $('.row-checkbox:checked').each(function () {
                        selectedRows.push($(this).data('index'));
                    });

                    // Perform deletion based on selectedRows array
                    // Replace the following line with your actual AJAX call for deletion
                    $.ajax({
                        url: 'code_des/code_dessql.php?action=codedescriptiontable_checkbox',
                        method: 'POST',
                        data: { selectedRows: selectedRows },
                        success: function (response) {
                            console.log(response);
                            // After successful deletion, redraw the DataTable
                            
                            //console.log(response);
                            
                            if(response==1){
                                swal.fire(
                            '',
                            'Rows deleted   <b style="color:green;">Successfully</b>',
                            'success'
                            ).then(okay => {
                            if (okay) {
                                window.location.replace("code_description.php");
                                //window.location.reload();
                            }
                            }) ;
                            codedescription_table.clear().draw();
                            }
                            
                            else{
                                swal.fire(
                            '',
                            '   <b style="color:red;">Please Select Check </b> Box!',
                            'error'
                            ) ;
                            
                            }
                            
                        },
                        error: function (error) {
                            console.error('Error deleting rows: ', error);
                        }
                    });
           });


          
          
      //! coder description  submit function
        $("#codedesFrom").submit(function (event) {
            event.preventDefault(); // Prevent the default form submission
    
            // Get form data
            var formData = $(this).serialize();
    
            // AJAX request
            $.ajax({
                type: "POST",
                url: "code_des/code_dessql.php?action=code_description", // Specify your PHP script URL
                data: formData,
                success: function (data) {
                    // Handle success, you can display a message or perform other actions
                    //console.log(response);
                    console.log(data);
                        var response = JSON.parse(data);
                        if(response==1){
                            swal.fire(
                                '',
                                'Code Description Added <b style="color:green;">Successfully</b>',
                                'success',
                                4000
                              ).then(okay => {
                                if (okay) {
                                  window.location.replace("code_description.php");
                                  //window.location.reload();
                                }
                              })   
                         }
                         else{
                            swal.fire(
                                '',
                                'Record Already  <b style="color:red;"> Exists</b> !',
                                'error'
                            )
                         }
                },
                error: function (error) {
                    // Handle error, display an error message, or perform other actions
                    //console.log("Error: " + error);
                }
            });
        });
         function refreshPage() {
        // Redirect to the same page using JavaScript
        window.location.href = window.location.href;
       }
        $('#refreshBtn').on('click', function () {
            refreshPage();
        });
        // ! code description  bulk upload function
        $('#uploadCsvBtn').on('click', function () {
    
            var formData = new FormData($('#csvUploadForm')[0]);
            //alert(formData);
    
            $.ajax({
                type: 'POST',
                url: 'code_des/code_dessql.php?action=file_upload',
                data: formData,
                contentType: false,
                processData: false,
                success: function (data) {
                    console.log(data);
                // alert(data);
                    if(data==""){
                        swal.fire(
                            '',
                            'File already exists. Please choose a <b style="color:red;"> different file</b> !',
                            'error'
                        )
                     }
                    
                     else{

                        swal.fire(
                            '',
                            'CSV file has been uploaded <b style="color:green;">Successfully</b>',
                            'success',
                            4000
                          ).then(okay => {
                            if (okay) {
                              window.location.replace("code_description.php");
                              //window.location.reload();
                            }
                          })   
                       
                     }
                }
            });
        });
       
    });
