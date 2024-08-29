$(document).ready(function () {
  inserData();
  Copydata();
  showData();

  $('body').on('click', '.generate_invoice', function(){
    var agency_id = $(this).data('agent_id');
    var agent_row_id = $(this).data('agent_row_id');
    var agancy_name = $(this).data('clientname');
    var agancy_company = $(this).data('companyname');

    $('#agancy_id').val(agency_id);
    $('#agancy_id').data('agent_row_id', agent_row_id);
    $('#agency_name').val(agancy_name);
    $('#agency_company').val(agancy_company);
    $('#invoiceModal').modal('show');

  });

  $('body').on('click', '.add_more', function(){
      $('.duplicate_prod').append(`
        <div class="row main_data">
          <div class="col-lg-3 poduct_sec">
              <div class="form-group">
                <label for="">Product</label>
                <select name="" class="form-control products">
                  <option value="">-- Choose Product --</option>
                  <option value="HC">HC Code</option>
                  <option value="dead">Dead COde</option>
                </select>
              </div>
          </div>
          <div class="col-lg-3 playplan_sec">
              <div class="form-group">
                <label for="">Payment Plan</label>
                <select name="" class="form-control pay_plan">
                  <option value="">-- Choose Type --</option>
                  <option value="one_time">One Time Charges</option>
                  <option value="per_file">Per File Charges</option>
                  <option value="per_seat">Per Seat Cost</option>
                  <option value="hourly_bill">Hourly Billing</option>
                  <option value="fixed_cost">Fixed Cost</option>
                </select>
              </div>
          </div>
          <div class="col-lg-1 qty_sec">
              <label for="">Qty</label>
              <div class="form-group">
                  <input type="number" class="form-control qty">
              </div>
          </div>
          <div class="col-lg-2 amnt_sec">
              <label for="">Amount</label>
              <div class="form-group">
                  <input type="number" class="form-control amount">
              </div>
          </div>
          <div class="col-lg-2">
              <label for="">Final Amount</label>
              <div class="form-group">
                  <input type="number" class="form-control final_amount">
              </div>
          </div>
          <div class="col-lg-1">
              <label for=""></label>
              <div class="form-group mt-3">
                  <button class="btn btn-danger btn-sm remove_row">-</button>
              </div>
          </div>
        </div>
      `);
    // $('#invoiceModal').modal('show');
  });
  $('body').on('click', '.remove_row', function(){
    $(this).closest('.main_data').remove();
  });

  $('body').on('change', '.pay_plan', function(){
      var pay_plan = $(this).val();
      var current_choose = $(this);
      if(pay_plan == "Per File Charges")
      {
        current_choose.closest('.main_data').find('.qty_sec label').html(`File Count`);
        current_choose.closest('.main_data').find('.amnt_sec label').html(`Cost of Per file`);
      }
      else if(pay_plan == "Per Seat Cost")
      {
        current_choose.closest('.main_data').find('.qty_sec label').html(`Seat Count`);
        current_choose.closest('.main_data').find('.amnt_sec label').html(`Cost of Per Seat`);
      }
      else if(pay_plan == "Hourly Billing")
      {
        current_choose.closest('.main_data').find('.qty_sec label').html(`Total Hours`);
        current_choose.closest('.main_data').find('.amnt_sec label').html(`Cost of Per Hour`);
      }
      else
      {
        current_choose.closest('.main_data').find('.qty_sec label').html(`Qty`);
        current_choose.closest('.main_data').find('.amnt_sec label').html(`Amount`);
      }
  });
  $('body').on('keyup', '.qty', function(){
      var qty_value = $(this).val();

      var amount = $(this).closest('.main_data').find('.amount').val();
      if(amount == "")
      {
        var amount = 0;
      }
      var total_amount = (parseInt(qty_value))*(parseInt(amount));

      $(this).closest('.main_data').find('.final_amount').val(total_amount);

  });
  $('body').on('keyup', '.amount', function(){
      $('.qty').trigger('keyup');
  });



  $('body').on('click', '.invoice_listpage', function() {
    var agency_id = $(this).data('agent_row_id');
    window.open('agencyinvoicelist.php?agent_id=' + agency_id);
});


});


//data inseration
function inserData() {
  $("#submitdata").on("click", function () {
    var Clientname = $("#Client_Name").val();
    var Companyname = $("#Company_Name").val();
    var Clientuid = $("#Client_Uid").val();
    var Companyaddress = $("#Company_Address").val();
    var Primaryphone = $("#Primary_Phone").val();
    var Secondaryphone = $("#Secondary_Phone").val();
    var Primaryemail = $("#Primary_Email").val();
    var Secondaryemail = $("#Secondary_Email").val();
    var Companyurl = $("#Company_URL").val();
    var LinkedIn = $("#LinkedIn").val();
    var Skype = $("#Skype").val();
    var WhatsApp = $("#WhatsApp").val();
    var Signal = $("#Signal").val();
    var Slack = $("#Slack").val();
    var Teams = $("#Teams").val();
    var Facebook = $("#Facebook").val();
    var Twitter = $("#Twitter").val();
    var Billingaddress = $("#Billing_Address").val();
    var Billingphone = $("#Billing_Phone").val();
    var Billingemail = $("#Billing_Email").val();
    var Billingmethod = $("#Billing_Method").val();
    var Paymentplan = $("#Payment_Plan").val();
    var Amount = $("#Amount").val();
    var Billingperiod = $("#Billing_Period").val();
    var Invoiceperiod = $("#Invoice_Period").val();
    var Payementmethod = $("#Payement_Method").val();

    if (Clientname === "") {
      Swal.fire({
        title: "Error!",
        text: "Please Enter Clientname",
        icon: "error",
      });
    } else if (Clientuid === "") {
      Swal.fire({
        title: "Error!",
        text: "Please Enter Clientuid",
        icon: "error",
      });
    }

    var inputData = {
      Clientname: Clientname,
      Companyname: Companyname,
      Clientuid: Clientuid,
      Companyaddress: Companyaddress,
      Primaryphone: Primaryphone,
      Secondaryphone: Secondaryphone,
      Primaryemail: Primaryemail,
      Secondaryemail: Secondaryemail,
      Companyurl: Companyurl,
      LinkedIn: LinkedIn,
      Skype: Skype,
      WhatsApp: WhatsApp,
      Signal: Signal,
      Slack: Slack,
      Teams: Teams,
      Facebook: Facebook,
      Twitter: Twitter,
      Billingaddress: Billingaddress,
      Billingphone: Billingphone,
      Billingemail: Billingemail,
      Billingmethod: Billingmethod,
      Paymentplan: Paymentplan,
      Amount: Amount,
      Billingperiod: Billingperiod,
      Invoiceperiod: Invoiceperiod,
      Paymentmethod: Payementmethod,
    };

    // Convert object to JSON string
    var jsonData = JSON.stringify(inputData);

    $.ajax({
      url: "Adminpanel/agencyinvoicedetail.php?action=insertdata",
      type: "POST",
      data: {
        jsonData: jsonData,
        Clientuid: Clientuid,
      },
      success: function (response) {
        var data = response;
        // console.log(data);

        if (data.success) {
          Swal.fire({
            title: "Success!",
            text: "Client Data Updated!",
            icon: "success",
          });
        } else {
          Swal.fire({
            title: "Error!",
            text: "Error Found!",
            icon: "error",
          });
        }
      },
    });
  });
}

//billing information copyin data function
function Copydata(){


        document.getElementById('SameAsContact').addEventListener('change', function() {
        var isChecked = this.checked;
        if (isChecked) {
            // Copy contact information to billing details
            document.getElementById('Billing_Address').value = document.getElementById('Company_Address').value;
            document.getElementById('Billing_Phone').value = document.getElementById('Primary_Phone').value;
            document.getElementById('Billing_Email').value = document.getElementById('Primary_Email').value;
        } else {
            // Clear billing details
            document.getElementById('Billing_Address').value = '';
            document.getElementById('Billing_Phone').value = '';
            document.getElementById('Billing_Email').value = '';
        }
    });


}

//showing inseration
function showData() {
    $.ajax({
        url: 'Adminpanel/agencyinvoicedetail.php?action=showdata',
        type: 'GET',
        success: function(response) {
            // Parse the JSON response
            var data = JSON.parse(response);

            // Get table reference
            var table = $('#data_table');

            // Clear existing table rows
            table.DataTable().clear();

            // Iterate over each data object and construct HTML for table rows
            data.forEach(function(row, index) {
                var rowData = JSON.parse(row.agency_detail);
                var html = '<tr>' +
                    '<td>' + (index + 1) + '</td>' +
                    '<td>' + row.agency_id + '</td>' +
                    '<td>' + rowData.Clientname + '</td>' +
                    '<td>' + rowData.Companyname + '</td>' +
                    '<td>' + rowData.Primaryemail + '</td>' +
                    '<td>' + rowData.Primaryphone + '</td>' +
                    '<td>' + rowData.Billingmethod + '</td>' +
                    '<td>' + rowData.Billingperiod + '</td>' +
                    '<td>' + rowData.Invoiceperiod + '</td>' +
                    '<td>' + rowData.Paymentmethod + '</td>' +
                    '<td>' + rowData.Amount + '</td>' +
                    '<td>' + row.status + '</td>' +
                    '<td><button class="btn btn-sm invoice_listpage btn-primary" data-agent_row_id="'+ row.Id +'">Invoice List</button></td>' +
                    '<td><button class="btn btn-sm generate_invoice btn-success" data-agent_id="'+ row.agency_id +'" data-agent_row_id="'+ row.Id +'" data-clientname="'+ rowData.Clientname +'" data-companyname="'+ rowData.Companyname +'">generate</button></td>' +

                    '</tr>';
                
                // Append row HTML to the table
                table.DataTable().row.add($(html)).draw();
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching data:', error);
        }
    });
}













