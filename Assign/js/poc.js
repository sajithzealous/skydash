function createform(fields, cardHeader) {
    let formHtml = '';
    formHtml += '<form method="post" class="mt-4 " id="myForm">';

    formHtml += '<input type="hidden" class="pocitem-input" id="pocitem-input" data-pocitem="' + cardHeader + '" name="pocitem" value="' + cardHeader + '">';

    formHtml += '<div class="form-row">';




    let currentIndex = 1;

    for (let j = 0; j < fields.length; j++) {

        formHtml += '<div class="form-group col formclas">';


        switch (fields[j].type) {


            case 'textarea':
                formHtml += '<div class="form-group ">';
                // formHtml += '<label>' + fields[j].label + '</label>';
                formHtml += '<textarea class="form-control resizable-textarea  us-inpu-' + currentIndex + '" data-pocitem="' + cardHeader + '" name="' + fields[j].name + '" placeholder="' + fields[j].placeholder + '"';
                if (fields[j].required) {
                    formHtml += 'required';
                }
                formHtml += ' style= "height: 80px;color:black;"';
                formHtml += ' ></textarea>';
                formHtml += '</div>';
                currentIndex++;
                break;

                case 'date':
                formHtml += '<input type="text" class="form-control datepicker us-inpu-' + currentIndex + '" data-pocitem="' + cardHeader + '" name="' + fields[j].name + '" placeholder="' + fields[j].placeholder + '"';
                if (fields[j].required) {
                    formHtml += 'required';
                }
                formHtml += '>';
                currentIndex++;
                break;

            // Add cases for other input types like textarea, select, etc.
            default:
            // Code for default case

        }


        

        formHtml += '</div>';
    }
        formHtml += '<td><i class="fas fa-trash-alt query-icon remove-poc us-inpu-' + currentIndex + '" id="row_remove-poc" title="Delete" name="rowdelete" style="cursor: pointer;color:#d74a49; margin-length:50px" data-mitem="' + cardHeader + '"></i></td>'


    formHtml += '</div>';
    return formHtml;
}

$(document).on("click", '.remove-poc', function() {
  
  var mitemdatacard = $(this).closest(".nested-card");
  var pocitem = mitemdatacard.find('.pocitem-input').data('pocitem');
  var poccode = mitemdatacard.find('.us-inpu-1').val();
 
 
 mitemdatacard.find('.us-inpu-1').val("");
 
 pocDataToServer(pocitem,poccode);
   
});

  function pocDataToServer(pocitem,poccode) {
     $.ajax({
         type: "POST",
         url: "Assign/pocsegement.php",
         data: {
             pocitem: pocitem,
             poccode:poccode
            
         },
         success: function(data) {
      //Parse the JSON response
      const response = JSON.parse(data);
    
     // Check if there's an error
      if (response.error) {
          // Log and alert the error
          console.error("Error:", response.error);
          alert("Error: " + response.error);
      } 
      // Check if the operation was successful
     else if (response.success) {
          
         console.log("Success:", response.success);
         alert("Success: " + response.success);

        
//         // Clear input fields (assuming mitemdatacard is a valid selector for the input fields)
         mitemdatacard.find('.us-inpu-1').val("");
         
     } 
     // Handle unexpected response
     else {
         console.error("Unexpected response:", response);
     }
 },

         error: function() {
              
         }
     });
 }





 





$(document).ready(function () {
    Entry = $('#poc').val();
    //  alert(Entry);
    // AJAX call to retrieve data
    $.ajax({
        url: "Assign/pocdynamic_page.php?action=filter&Id=" + Entry,
        type: "GET",
        dataType: "json",
        success: function (response) {
            const numberOfItemsWithData = response.length;
            const mainCardDiv = document.createElement('div');
            mainCardDiv.classList.add('card', 'position-relative', 'scroller', 'col-lg-12');
            const mainCardBodyDiv = document.createElement('div');
            mainCardBodyDiv.classList.add('card-body');


            for (let i = 0; i < numberOfItemsWithData; i++) {

                const { pocitems } = response[i];
                const fields = JSON.parse(response[i].pocjson);
                const cardHeaderText = `${pocitems}`;

                const cardDiv = document.createElement('div');
                cardDiv.classList.add('card', 'nested-card', 'mb-2');

                const cardHeader = document.createElement('div');
                cardHeader.classList.add('card-header');
                cardHeader.textContent = cardHeaderText;

                const cardBodyDiv = document.createElement('div');
                cardBodyDiv.classList.add('card-body');

                const formHtml = createform(fields, cardHeaderText);
                cardBodyDiv.innerHTML = formHtml;

                cardDiv.appendChild(cardHeader);
                cardDiv.appendChild(cardBodyDiv);

                mainCardBodyDiv.appendChild(cardDiv);
            }

            mainCardDiv.appendChild(mainCardBodyDiv);

            const carouselRow = document.getElementById('pocsegementRow');
            carouselRow.appendChild(mainCardDiv);



            $(document).on('click', '#btn_save_poc', function (event) {

                 event.preventDefault();
                 const formArray = [];

              

                $('.nested-card').each(function () {
                    // const pocitemElement = $(this).find('#pocitem-input')[0];
                    // const pocitemAttributeValue = pocitemElement.getAttribute('data-pocitem');

                    const pocitemAttributeValue = $(this).find('.pocitem-input').attr('data-pocitem');

                    //  console.log('mitem:john', pocitemAttributeValue);

                     const us1Value = $(this).find('.us-inpu-1').val();

                     const formData = {
                         'pocitemAttributeValue': pocitemAttributeValue,
                        'us1': us1Value,
                    };

             // Check if any required field is empty, skip pushing incomplete data
                   if (!(pocitemAttributeValue && us1Value)) {
                        console.log('Incomplete data, skipping push for this element.');
                         return true; // Continue to the next iteration without pushing incomplete data
                  }

                    formArray.push(formData);
         });


                 // Now formArray contains all data, excluding incomplete elements
                 console.log(formArray);



                 // Sample output of formArray
                 const Id = $('#poc').val();

                 // Sending formArray to PHP via AJAX
                  $.ajax({
                      url: 'Assign/pocsegement.php',
                    type: 'POST',
                    data: {
                        formDataArray: formArray,
                        Id: Id
                    },
                    success: function (response) {
                        // Log the response for debugging purposes
                            var pocdata =JSON.parse(response);
                            console.log(pocdata);

                            if (pocdata.success) {
                                // Display a success message if 'success' property is true
                                Swal.fire({
                                    title: 'Success!',
                                    text: pocdata.message, // Display the response data in the message
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(function () {
                                    $('.saved-pocsegement').removeAttr("hidden");
                                });
                            } else {
                                // Display an error message if 'success' property is false
                                Swal.fire({
                                    title: 'Error',
                                    text: pocdata.error, // Display the error message from the response
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        }, function (jqXHR, textStatus, errorThrown) {
                        console.error('Error:', errorThrown);
                        // Handle error response
                    }
                });
            });




            //Pendingpocsegement


        //     $(document).on('click', '#Pendwip', function (event) {

        //         alert('Poc');

        //         event.preventDefault();
        //         const formArray = [];

        //        $('.nested-card').each(function () {
        //            // const pocitemElement = $(this).find('#pocitem-input')[0];
        //            // const pocitemAttributeValue = pocitemElement.getAttribute('data-pocitem');

        //            const pocitemAttributeValue = $(this).find('.pocitem-input').attr('data-pocitem');

        //            //  console.log('mitem:john', pocitemAttributeValue);

        //             const us1Value = $(this).find('.us-input-1').val();

        //             const formData = {
        //                 'pocitemAttributeValue': pocitemAttributeValue,
        //                'us1': us1Value,
        //            };

        //     // Check if any required field is empty, skip pushing incomplete data
        //           if (!(pocitemAttributeValue && us1Value)) {
        //                console.log('Incomplete data, skipping push for this element.');
        //                 return true; // Continue to the next iteration without pushing incomplete data
        //          }

        //            formArray.push(formData);
        // });


        //         // Now formArray contains all data, excluding incomplete elements
        //         console.log(formArray);



        //         // Sample output of formArray
        //         const Id = $('#poc').val();
        //         // Sending formArray to PHP via AJAX
        //          $.ajax({
        //              url: 'PendingWip/pocsegement_pending.php',
        //            type: 'POST',
        //            data: {
        //                formDataArray: formArray,
        //                Id: Id
        //            },
        //            success: function (response) {
        //                console.log('response', response);
        //                Swal.fire({
        //                    title: 'Success!',
        //                    text: 'Inserted Successfully. Response: ' + response,
        //                    icon: 'success',
        //                    confirmButtonText: 'OK'
        //                }).then(function () {
        //                    $('.us-input-1').val('');
        //                });
        //            },
        //            error: function (jqXHR, textStatus, errorThrown) {
        //                console.error('Error:', errorThrown);
        //                // Handle error response
        //            }
        //        });
        //    });


        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("Error:", errorThrown);
        },
    });
});
