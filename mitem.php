
<div class="card position-relative scroller col-lg-12">

    <div class="card-body card-new">

        <div class="card nested-card mb-2">


            <div class="card-header">

                
            </div>

            <div class="card-body">


            </div>


        </div>

        </div>
    </div>


</div>
<button type="submit">asdasd</button>

<script>
    $(document).ready(function () {
        var jsonFields = {}
// Function to render input fields
function renderInputFields(jsonFields) {
    const container = document.getElementById('oasisextradata');

    jsonFields.forEach(item => {
        const groupLabel = document.createElement('label');
        groupLabel.textContent = item.fields[0].group;
        container.appendChild(groupLabel);

        item.fields.forEach(field => {
            field.tags.forEach(tag => {
                const fieldDiv = document.createElement('div');

                const inputLabel = document.createElement('label');
                inputLabel.textContent = tag.label;
                fieldDiv.appendChild(inputLabel);

                let inputField;

                switch (tag.type) {
                    case 'text':
                        inputField = document.createElement('input');
                        inputField.setAttribute('type', 'text');
                        inputField.setAttribute('value', tag.value || ''); // Set default value if provided
                        break;
                    case 'checkbox':
                        inputField = document.createElement('input');
                        inputField.setAttribute('type', 'checkbox');
                        inputField.checked = tag.checked || false; // Set checked state if provided
                        break;
                    case 'select':
                        inputField = document.createElement('select');
                        tag.options.forEach(option => {
                            const optionElement = document.createElement('option');
                            optionElement.textContent = option;
                            if (tag.value && tag.value === option) {
                                optionElement.selected = true; // Set default selected option if provided
                            }
                            inputField.appendChild(optionElement);
                        });
                        break;
                    case 'textarea':
                        inputField = document.createElement('textarea');
                        inputField.textContent = tag.value || ''; // Set default value if provided
                        break;
                    default:
                        inputField = document.createElement('input');
                        inputField.setAttribute('type', 'text');
                }

                inputField.setAttribute('name', tag.name);
                inputField.setAttribute('placeholder', tag.placeholder);
                if (tag.maxlength) {
                    inputField.setAttribute('maxlength', tag.maxlength);
                }

                // Set class attribute if provided
                if (tag.class) {
                    inputField.classList.add(tag.class);
                }

                fieldDiv.appendChild(inputField);
                container.appendChild(fieldDiv);
            });
        });
    });
}



// Call the renderInputFields function


// Function to gather form values
function gatherFormValues() {
    const formData = [];

    jsonFields.forEach(fieldGroup => {
        const groupData = {
            mitem: fieldGroup.mitem,
            mitem_type: fieldGroup.mitem_type,
            fields: []
        };

        fieldGroup.fields.forEach(field => {
            const fieldData = {
                group: field.group,
                tags: []
            };

            field.tags.forEach(tag => {
                const inputField = document.querySelector(`[name="${tag.name}"]`);
                if (inputField) {
                    const value = inputField.type === 'checkbox' ? inputField.checked : inputField.value;
                    tag.value = value;
                    fieldData.tags.push(tag);
                }
            });

            groupData.fields.push(fieldData);
        });

        formData.push(groupData);
    });

    return formData;
}

// Function to handle form submission
function handleSubmit(event) {
    event.preventDefault();
    const formData = gatherFormValues();
    console.log(formData);
 
    $.ajax({
            url: "ggmitem/ggmitem_insert.php?action=insert",  
            type: "POST",
            data: {
                formData:formData
            },
            success: function (response) {

                console.log(response);



                // Parse the JSON string into a JavaScript object
                // const jsonData = response;
                // renderInputFields(jsonData.map((item) => JSON.parse(item)));
                // jsonFields = jsonData.map((item) => JSON.parse(item))
                // formContainer.html(generateForm(jsonData));
            },
            error: function (error) {
                console.error("Error fetching data:", error);
            }
        });
}

// Attach submit event listener to the form
const form = document.getElementById('inputContainer');
form.addEventListener('submit', handleSubmit);

     

        // AJAX call to retrieve JSON data from server
        $.ajax({
            url: "Assign/ggmitem.php?action=filter",  
            type: "GET",
            dataType: "json",
            success: function (response) {
                // Parse the JSON string into a JavaScript object
                const jsonData = response;
                renderInputFields(jsonData.map((item) => JSON.parse(item)));
                jsonFields = jsonData.map((item) => JSON.parse(item))
                formContainer.html(generateForm(jsonData));
            },
            error: function (error) {
                console.error("Error fetching data:", error);
            }
        });
    });
</script>
