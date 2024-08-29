$(document).ready(function() {
    // Fetch data and initialize DataTable after data is fetched
    datadisplaytable();
    savedata();
    // savenewSeconddata()
    addDateColumnFilter();

    // initializeDataTable();
});

// Function to fetch and display user data
function datadisplaytable() {
    fetch('Adminpanel/usersql.php')
        .then(response => response.json())
        .then(data => {
            // Populate table with fetched data
             initializeDataTable(data);
             userstatuschange();
             showdata();
            

           
        })  
        .catch(error => console.error('Error fetching data:', error));
}



function initializeDataTable(data) {
    const user_table = createDataTable(data);

    console.log(user_table);

    user_table.columns().every(function (index) {
        const column = this;
        if (index < user_table.columns().indexes().length - 1) {
            index === 6
                ? addDateColumnFilter(column)
                : addColumnFilter(column, index);
        }
    });

}
//function to create table and show data
function createDataTable(data) {
    // console.log(data);
    return $("#user_table").DataTable({
        lengthMenu: [
            [15, 25, 50, -1],
            [15, 25, 50, "All"],
        ],
        fixedHeader: true,
        data: data,
        columns: [
            { 
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1; // Render the row number as serial number
                }
            },
            { data: "user_name" },
            { data: "user_id" },
            { data: "user_role" },
            { data: "user_status" },
            { data: "created_date" },
            {
                data: null,
                render: function (data, type, row) {
                    var status = '';
                    if(data.user_status == "Active")
                    {
                        var status = 'Checked';
                    }
                    return (
                        '<div class="form-check"><label class="switch"><center><input type="checkbox" data-user_id="'+data.id+'"  data-emp_id="'+data.user_id+'"class="row-checkbox form-check-input fileCheck" data-index="' +
                        row.index_id +
                        'checked" '+status+'><span class="slider round"></span></center></label></div>'
                    );
                },
            },
        ],
        initComplete: function () {
            var table = $('#user_table');

            // Append input fields and a checkbox to the table header
            table.find('thead').append(
                '<tr>' +
                '<th class=""></th>' +
                '<th class="filterRow"></th>' +
                '<th class="filterRow"></th>' +
                '<th class="filterRow"></th>' +
                '<th class="filterRow"></th>' +
                '<th class="filterRow"></th>' +
                '</tr>'
            );


          
        },
    });
}
//function to add column filter to table
// function addColumnFilter(column, index) {
//   const select = $(
//       '<select class="form-control searchable-dropdown dropdown-select" data-index="' + index + '"><option value=""></option></select>'
//   )
//       .appendTo("#user_table th.filterRow:nth-child(" + (index + 1) + ")");

//   select.select2({
//       theme: "classic", // Adjust the theme as needed
//       width: "100%",
//       placeholder: "Search...",
//       allowClear: true
//   });

//   column
//       .data()
//       .unique()
//       .sort()
//       .each(function (d, j) {
//           select.append('<option value="' + d + '">' + d + '</option>');
//       });

//   // Trigger change event to apply initial filtering
//   select.on('change', function () {
//       const val = $.fn.dataTable.util.escapeRegex($(this).val());
//       column.search(val ? "^" + val + "$" : "", true, false).draw();
//   });
// }

function addColumnFilter(column, index) {
  const select = $(
      '<select class="form-control searchable-dropdown dropdown-select" multiple="multiple" data-index="' + index + '"><option value=""></option></select>'
  )
      .appendTo("#user_table th.filterRow:nth-child(" + (index + 1) + ")");

  select.select2({
      theme: "bootstrap", // Adjust the theme as needed
      width: "100%",
      height:"100%",
      placeholder: "Search...",
      allowClear: true
  });

  column
      .data()
      .unique()
      .sort()
      .each(function (d, j) {
          select.append('<option value="' + d + '">' + d + '</option>');
      });

  // Trigger change event to apply initial filtering
  select.on('change', function () {
      const vals = $(this).val() || [];
      const regex = vals.map(function(val) {
          return '^' + $.fn.dataTable.util.escapeRegex(val) + '$';
      }).join('|');
      column.search(regex, true, false).draw();
  });
}



 //function to add date filter to table
  function addDateColumnFilter(column) {
    const dateInput = $('<input type="date" class="">')
      .appendTo("user_table th.date")
      .on("input", function () {
        const val = $(this).val();
        const formattedDate = formatDate(val);
        column.search(formattedDate).draw();
      });
  }


//function to save new data
  function savedata(){

    $('body').on('click', '#newusersave', function(){
        var username = $('#textInputUser').val().trim();
        var password = $('#textInputpassword').val().trim();
        var emp_id = $('#textInputempid').val().trim();
        var user_role = $('#selectInputuserrole').val().trim();
        var user_org = $('#textInputOrganization').val().trim();
        var user_team =$('#selectInputTeam').val().trim();
        var user_status =$('#selectInputStatus').val().trim();
        var user_teamleader =$('#selectInputTeamleader').val().trim();
        var user_teammanager =$('#selectInputTeamManager').val().trim();
        var user_operationalmanager =$('#selectInputOperationalManager').val().trim();

        alert(user_team);


        if(username == "")
        {
            Swal.fire({
            title: "Empty field!",
            text: "Please Enter Username!",
            icon: "info"
          });
        }
        else if(password == "")
        {
            Swal.fire({
            title: "Empty field!",
            text: "Please Enter Password!",
            icon: "info"
          });
        }
        else if(emp_id == "")
        {
            Swal.fire({
            title: "Empty field!",
            text: "Please Enter emp_id!",
            icon: "info"
          });
        }
        else if(user_role == "")
        {
            Swal.fire({
            title: "Empty field!",
            text: "Please Enter user_role!",
            icon: "info"
          });
        }
        else if((user_role == "user" || user_role == "QA") && user_team == "")
          {
              Swal.fire({
                  title: "Empty field!",
                  text: "Please Select User Team!",
                  icon: "info"
              });
          }
          
        else
        {

          $.ajax({
            url: 'Adminpanel/create-user.php?action=create',
            type: 'get',
            data: {
              username:username,
              password:password,
              emp_id:emp_id,
              user_org:user_org,
              user_role:user_role,
              user_team:user_team,
              user_teamleader:user_teamleader,
              user_teammanager:user_teammanager,
              user_operationalmanager:user_operationalmanager,
              user_status:user_status

            },
            success: function(response){
              console.log(response);
              var data = JSON.parse(response);

              if(data.status == 'Ok')
              {
                Swal.fire({
                  title: "Success!",
                  text: "New User Created!",
                  icon: "success"
                }).then(function(){
                  location.reload();
                });
              }
              else if(data.status == 'Available')
              {
                Swal.fire({
                  title: "Duplicate!",
                  text: "This Emp ID Already Exist!",
                  icon: "info"
                });
                console.log('Already Available');

              }
              else
              {
                Swal.fire({
                  title: "Error!",
                  text: "Error Found!",
                  icon: "error"
                });
                console.log('Error');

              }
            }
          });
        }

      });


  }




  //function saving newuser data second

  // function savenewSeconddata(){

  //   $('#newusersavesecond').on("click",function(){


  //   var username=$('#textInputUser').val();
  //   var password =$('#textInputPassword').val();
  //   var empid=$('#textInputEmpId').val();
  //   var email =$('#textInputEmail').val();
  //   var gender =$('#selectInputUserGender').val();
  //   var role =$('#selectInputUserRole').val();
  //   var dob=$('#textInputDob').val();
  //   var organization=$('#textInputOrganization').val();
  //   var certification=$('#textInputCertification').val();
  //   var joiningdate=$('#textInputJoiningDate').val();
  //   var inputstatus=$('#selectInputStatus').val();
  //   var experience=$('#selectInputExperience').val();
  //   var team =$('#selectInputTeam').val();





  //   });



  // }
// function to change the status based on the user
  function userstatuschange(){ 
    
    $('body').on('change', '.row-checkbox', function(){
    var row_id = $(this).data('user_id');
    var user_id=$(this).data('emp_id')
    var this_checkbox = $(this);
    console.log(row_id);
    if (this_checkbox.prop('checked')) {
        var status = 'In-Active';
    } else {
        var status = 'Active';
    }

    $.ajax({
      url: 'Adminpanel/create-user.php?action=update_status',
      type: 'get',
      data: {
        row_id:row_id,
        status:status,
        user_id: user_id,
      },
      success: function(response){
        console.log(response);
        var data = JSON.parse(response);

        if(data.status == 'Ok')
        {
          Swal.fire({
            title: "Success!",
            text: "User Status Updated!",
            icon: "success"
          }).then(function(){
            location.reload();
          });
        }
        else
        {
          Swal.fire({
            title: "Error!",
            text: "Error Found!",
            icon: "error"
          });
          
        }
      }
    });
});

  }


  

//function to show the count of the users in the front panel
function showdata(){

    $.ajax({
        url: 'Adminpanel/create-user.php?action=get_active_count',
        type: 'get',
        data: {
          
        },
        success: function(response){
          console.log(response);
          var data = JSON.parse(response);

          console.log(data);

          if(data.status == 'Ok')
          {
            var total_count = data.data.total_user;
            var total_active = data.data.total_active;
            var total_inactive = data.data.total_inactive;
            console.log(total_count);
            // alert(total_count);

            $('.active_user_count').html(total_active);
            $('.inactive_user_count').html(total_inactive);
            $('.total_user_count').html(total_count);
          }
          else
          {
            
            
          }
        }
      });



}
   
   
    



