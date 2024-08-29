<?php
  $agent_id = '';

  if(isset($_GET['agent_id']))
  {
    $agent_id = $_GET['agent_id'];
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agency Invoice</title>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="Adminpanel/css/usermanagement.css">
</head>
<style>
    .datalabel {
        font-size: 18px;
    }
    .datachecked {
        width: 0;
        height: 0;
        opacity: 0;
    }
    .checkmark {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 1px solid #aaa;
        border-radius: 3px;
        position: relative;
        overflow: hidden;
    }
    .checkmark:after {
        content: "\2713"; /* Unicode for checkmark character */
        font-size: 18px;
        color: transparent; /* Initially transparent */
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    .datachecked:checked + .checkmark:after {
        color: green; /* Change this to your desired color */
    }
</style>



<body>
    <div class="container-scroller">
        <!-- Navbar -->
        <?php include 'include_file/profile.php'; ?>

        <div class="container-fluid page-body-wrapper">
            <!-- Sidebar -->
            <?php include 'include_file/sidebar.php'; ?>
            <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

            <div class="main-panel">
                <div class="content-wrapper">

               <div class="card p-2">
                        <div class="card-header">
                            <h3>Agency Invoice List</h3>
<!-- 
                           <button type="button" class="btn btn-info mr-2 clk_2" data-toggle="modal"
                                    data-target="#clientinformation" style="float:right"> Create</button> -->
                            
                        </div>
                        <div class="card-body p-3 m-5">

                            <form>
                                <div class="card">
                                <div class="card-body">

                  <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12 custom-scroll table-responsive"
                                style="width:100%;">

                                <table id="data_table" class="display table">
                                    <thead>
                                        <tr class="headerrow">
                                            <th class="sorting">S.no</th>
                                            <th class="sorting"> Invoice ID</th>
                                            <th class="sorting">Invoice Date</th>
                                            <th class="sorting">Agent Name</th>
                                            <th class="sorting">Total Amount</th>
                                            <th class="sorting">Vat Amount</th>
                                            <th class="sorting">Final Amount</th>
                                            <th class="sorting">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                          $agent_idQuery;
                                          if($agent_id != '')
                                          {
                                              $agent_idQuery = "AND agent_id = '$agent_id'";
                                          }
                                          $count = 1;
                                          $sql = mysqli_query($conn, "SELECT * FROM invoice_data id, agencydetail ad WHERE id.status = 'Active' AND ad.id = id.agent_id $agent_idQuery ORDER BY id.invoice_date DESC");
                                          while($getInvoice = mysqli_fetch_assoc($sql))
                                          {
                                            $agentDetails = json_decode($getInvoice['agency_detail']);
                                            $agentName = $agentDetails->Clientname;
                                        ?>
                                          <tr>
                                            <td><?php echo $count++; ?></td>
                                            <td><?php echo $getInvoice['invoice_no']; ?></td>
                                            <td><?php echo $getInvoice['invoice_date']; ?></td>
                                            <td><?php echo $agentName ?></td>
                                            <td><?php echo $getInvoice['total_amount']; ?></td>
                                            <td><?php echo $getInvoice['tax_amount']; ?></td>
                                            <td><?php echo $getInvoice['final_amount']; ?></td>
                                            <td><button class="btn btn-sm btn-success viewInvoice" onclick="window.open('invoicepreview.php?invoice_id=<?php echo $getInvoice['id']; ?>')">view invoice</button></td>
                                          </tr>
                                        <?php
                                          }
                                          if($count == 1)
                                          {
                                            echo '<tr><td colspan="8" class="text-center"><h4>No Invoice Found!</h4></td></tr>';
                                          }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                
                                    
                                 </div>
                                   
                                
                    </div> 






                </div>
            </div>
        </div>
    </div>


 <div class="modal fade" id="clientinformation" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLongTitle">New User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <div class="card p-3">
                        <div class="card-header">

                            <h3>Client Registeration form</h3>
                            
                        </div>
                        <!-- <div class="card-body p-3 m-5">

                            <form>
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Basic Information</h4>

                                         </div>
                                        <div class="card-body">
                                   <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                      <label for="Client Name">Client name</label>
                                      <input type="text" class="form-control" id="Client_Name" placeholder="Client Name" value="" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                      <label for="Company Name">Company Name</label>
                                      <input type="text" class="form-control" id="Company_Name" placeholder="Company Name" value="" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                      <label for="Client UID">Client UID</label>
                                      <div class="input-group">
                                        <input type="text" class="form-control" id="Client_Uid" placeholder="Client UID" value="" required>
                                      </div>
                                    </div>
                                  </div>
                                    
                                 </div>
                                   
                                </div>
                                  

                                  <div class="card">
                                      <div class="card-header">
                                          <h4>Contact Information</h4>
                                      </div>
                                      <div class="card-body">
                                        <div class="form-row">
                                    <div class="col-md-6 mb-3">
                                      <label for="Company Address">Company Address</label>
                                      <input type="text" class="form-control" id="Company_Address" placeholder="Company Address" value="" >
                                    </div>
                                    <div class="col-md-3 mb-3">
                                      <label for="Primary Phone">Primary Phone</label>
                                      <input type="tel" class="form-control" id="Primary_Phone" placeholder="Primary Phone" value="" >
                                    </div>
                                    <div class="col-md-3 mb-3">
                                      <label for="Secondary Phone">Secondary Phone</label>
                                      <input type="tel" class="form-control" id="Secondary_Phone" placeholder="Secondary Phone" value="" >
                                    </div>
                                  </div>
                                  <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                      <label for="Primary Email">Primary Email</label>
                                      <input type="email" class="form-control" id="Primary_Email" placeholder="Primary Email" value="">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                      <label for="Secondary Email">Secondary Email</label>
                                      <input type="email" class="form-control" id="Secondary_Email" placeholder="Secondary Email" value="">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                      <label for="Company URL">Company URL</label>
                                      <input type="url" class="form-control" id="Company_URL" placeholder="Company URL" value="">
                                    </div>
 
                                  </div>
                                  <div class="form-row">
                                        <div class="col-md-3 mb-3">
                                          <label for="LinkedIn">LinkedIn</label>
                                          <input type="url" class="form-control" id="LinkedIn" placeholder="LinkedIn" value="">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                          <label for="Skype">Skype</label>
                                          <input type="url" class="form-control" id="Skype" placeholder="Skype" value="">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                          <label for="WhatsApp">WhatsApp</label>
                                          <input type="text" class="form-control" id="WhatsApp" placeholder="WhatsApp" value="">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                          <label for="Signal">Signal</label>
                                          <input type="text" class="form-control" id="Signal" placeholder="Signal" value="">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                          <label for="Slack">Slack</label>
                                          <input type="text" class="form-control" id="Slack" placeholder="Slack" value="">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                          <label for="Teams">Teams</label>
                                          <input type="text" class="form-control" id="Teams" placeholder="Teams" value="">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                          <label for="Facebook">Facebook</label>
                                          <input type="text" class="form-control" id="Facebook" placeholder="Facebook" value="">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                          <label for="Twitter">Twitter</label>
                                          <input type="text" class="form-control" id="Twitter" placeholder="Twitter" value="">
                                        </div>
     
                                  </div>

                                      </div>
                                  </div>




                                  <div class="form-row mt-3">
                                    <div class="col-md-4 mb-3">
 
                                      <label class="container datalabel" for="SameAsContact">Same as Contact Information
                                                            <input class="datachecked" type="checkbox" id="SameAsContact">
                                                            <div class="checkmark"></div>
                                       </label>

                                    </div>
                                   </div>

                                   <div class="card">
                                       <div class="card-header">
                                           <h4>Billing Information</h4>
                                       </div>
                                       <div class="card-body">
                                    <div class="form-row">
                                      <div class="col-md-4 mb-3">
                                          <label for="Billing Address">Billing Address</label>
                                          <input type="text" class="form-control" id="Billing_Address" placeholder="Billing Address" value="">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                          <label for="Billing Phone">Billing Phone</label>
                                          <input type="text" class="form-control" id="Billing_Phone" placeholder="Billing Phone" value="">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                          <label for="Billing Email">Billing Email</label>
                                          <input type="text" class="form-control" id="Billing_Email" placeholder="Billing Email" value="">
                                        </div>

                                   </div>
                                           
                                       </div>
                                   </div>
                               <div class="card">
                                       <div class="card-header">
                                           <h4>Payment Terms</h4>
                                       </div>
                                       <div class="card-body">
                                    <div class="form-row">
                                      <div class="col-md-2 mb-3">
                                                <label for="Billing Method">Billing Method</label>
                                                <select name="Billing Method" id="Billing_Method" class="form-control">
                                                     <option value="">Select</option>
                                                    <option value="Daily">Daily</option>
                                                    <option value="Weekly">Weekly</option>
                                                    <option value="Bi-Weekly">Bi-Weekly</option>
                                                    <option value="Monthly">Monthly</option>
                                                    <option value="Semi-Monthly">Semi-Monthly</option>
                                                    <option value="Quarterly">Quarterly</option>
                                                    <option value="Annually">Annually</option>
                                                </select>



                                                                                          
                                        </div>
                                        <div class="col-md-2 mb-3">
                                                <label for="Payment Plan">Payment Plan</label>
                                                <select name="Payment Plan" id="Payment_Plan" class="form-control">
                                                     <option value="">Select</option>
                                                    <option value="One Time Charges">One Time Charges</option>
                                                    <option value="Per File Charges">Per File Charges</option>
                                                    <option value="Per Seat Cost">Per Seat Cost</option>
                                                    <option value="Hourly Billing">Hourly Billing</option>
                                                    <option value="Fixed Cost">Fixed Cost</option>
                                                </select>



                                                                                          
                                        </div>
                                       <div class="col-md-2 mb-3">
                                          <label for="Amount">Amount</label>
                                          <input type="number" class="form-control" id="Amount" placeholder="Amount" value="">
                                        </div>
                                        <div class="col-md-2 mb-3">
                                          <label for="Billing Period">Billing Period</label>
                                          <input type="date" class="form-control" id="Billing_Period" placeholder="Billing Period" value="">
                                        </div>
                                        <div class="col-md-2 mb-3">
                                          <label for="Invoice Period">Invoice Period</label>
                                          <input type="date" class="form-control" id="Invoice_Period" placeholder="Invoice Period" value="">
                                        </div>
                                        <div class="col-md-2 mb-3">
                                          <label for="Payement Method">Payement Method</label>
                                          <input type="text" class="form-control" id="Payement_Method" placeholder="Payement Method" value="">
                                        </div>

                                   </div>
                                           
                                       </div>
                                   </div>

                                 
                            </form>
                            
                        </div> -->
                        <div class="card-footer" style="background-color: white;">
                             <button class="btn btn-primary" type="submit" style="float:right;" id="submitdata">Submit form</button>
                            
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div> 

<!-- Modal -->
<div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="invoiceModalLabel">Generate Invoice</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="row ">
              <div class="col-lg-12 pb-3">
                  <b>Agency Details</b>
              </div>
              <div class="col-lg-3">
                  <div class="form-group">
                    <label for="invoice_no">Invoice NO</label>
                    <input type="text" name="" id="invoice_no" class="form-control">
                  </div>
              </div>
              <div class="col-lg-2">
                  <div class="form-group">
                    <label for="invoice_date">Invoice Date</label>
                    <input type="date" name="" id="invoice_date" value="<?php echo date('Y-m-d');?>" class="form-control">
                  </div>
              </div>
              <div class="col-lg-2">
                  <div class="form-group">
                    <label for="agancy_id">Agency ID</label>
                    <input type="text" name="" id="agancy_id" class="form-control">
                  </div>
              </div>
              <div class="col-lg-2">
                  <div class="form-group">
                    <label for="agency_name">Agency Name</label>
                    <input type="text" name="" id="agency_name" class="form-control">
                  </div>
              </div>
              <div class="col-lg-2">
                  <div class="form-group">
                    <label for="agency_company">Agency Company</label>
                    <input type="text" name="" id="agency_company" class="form-control">
                  </div>
              </div>
              <div class="col-lg-12 py-3">
                  <h4>Product Details</h4>
              </div>
              <!-- <div class="col-lg-3">

              </div> -->
          </div>
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
                      <button class="btn btn-success btn-sm add_more">+</button>
                  </div>
              </div>
          </div>
          <div class="duplicate_prod">

          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="generate">Generate</button>
      </div>
    </div>
  </div>
</div>

<?php


$randomNumber=rand(0000,9999);

?>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
     <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="Adminpanel/js/agencyinvoice.js?<?php echo $randomNumber ?>"></script> -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
      $(document).ready(function(){
        $('body').on('click', '#generate', function(){
          var invoice_no = $('#invoice_no').val();
          var invoice_date = $('#invoice_date').val();
          var agancy_id = $('#agancy_id').data('agent_row_id');
         
          if(invoice_no == "")
          {
            toastr.error('Please Enter Invoice NO');
          }
          else if(invoice_date == "")
          {
            toastr.error('Please Enter Invoice Date');

          }
          else if(agancy_id == "")
          {
            toastr.error('Please Enter Invoice Agency ID');

          }
          else
          {
              var errorCode = 0;
              //Product
              var products = [];
              $('.products').each(function() {
                  var data = $(this).val();
                  products.push(data);
              });

              var payment_plan = [];
              $('.pay_plan').each(function() {
                  var data = $(this).val();
                  payment_plan.push(data);
              });

              var qty = [];
              $('.qty').each(function() {
                  var data = $(this).val();
                  qty.push(data);

              });

              var amount = [];
              $('.amount').each(function() {
                  var data = $(this).val();
                  amount.push(data);

              });

              var final_amount = [];
              $('.final_amount').each(function() {
                  var data = $(this).val();
                  final_amount.push(data);
              });

              // var products_arr = JSON.stringify(products);


          if(errorCode != 1)
          {

            $.ajax({
                url: "Adminpanel/agencyinvoicedetail.php?action=generateInvoice",
                type: "POST",
                data: {
                  invoice_no:invoice_no,
                  invoice_date:invoice_date,
                  agancy_id:agancy_id,
                  products: products,
                  payment_plan: payment_plan,
                  qty: qty,
                  amount: amount,
                  final_amount: final_amount
                },
                success: function (response) {
                  console.log(response);
                  var data = JSON.parse(response);

                  if (data.status == 'Ok') {
                      window.location.href="invoicepreview.php?invoice_id="+data.invoice;
                  } else {
                    Swal.fire({
                      title: "Error!",
                      text: "Error Found!",
                      icon: "error",
                    });
                  }
                },
              });
          }
          else
          {
            toastr.error('Please Fill All Fields');
          }
          }

        });
      });
    </script>
</body>

</html>