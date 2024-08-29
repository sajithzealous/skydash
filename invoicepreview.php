<?php
  include('db/db-con.php');
  if(isset($_GET['invoice_id']))
  {
  
        $invoiceId = $_GET['invoice_id'];
        // echo $invoiceId;
        $sql = mysqli_query($conn, "SELECT * FROM invoice_data iv, agencydetail ag WHERE iv.id = '$invoiceId' AND iv.agent_id = ag.id");
        $getIn = mysqli_fetch_assoc($sql);

        $agencyDeatils = $getIn['agency_detail'];
        $agencyDeatils_array = json_decode($agencyDeatils);
        
        $SkypeData = $agencyDeatils_array->Skype;
        $SlackData = $agencyDeatils_array->Slack;
        $TeamsData = $agencyDeatils_array->Teams;
        $AmountData = $agencyDeatils_array->Amount;
        $SignalData = $agencyDeatils_array->Signal;
        $TwitterData = $agencyDeatils_array->Twitter;
        $FacebookData = $agencyDeatils_array->Facebook;
        $LinkedInData = $agencyDeatils_array->LinkedIn;
        $WhatsAppData = $agencyDeatils_array->WhatsApp;
        $ClientuidData = $agencyDeatils_array->Clientuid;
        $ClientnameData = $agencyDeatils_array->Clientname;
        $CompanyurlData = $agencyDeatils_array->Companyurl;
        $CompanynameData = $agencyDeatils_array->Companyname;
        $PaymentplanData = $agencyDeatils_array->Paymentplan;
        $BillingemailData = $agencyDeatils_array->Billingemail;
        $BillingphoneData = $agencyDeatils_array->Billingphone;
        $PrimaryemailData = $agencyDeatils_array->Primaryemail;
        $PrimaryphoneData = $agencyDeatils_array->Primaryphone;
        $BillingmethodData = $agencyDeatils_array->Billingmethod;
        $BillingperiodData = $agencyDeatils_array->Billingperiod;
        $InvoiceperiodData = $agencyDeatils_array->Invoiceperiod;
        $PaymentmethodData = $agencyDeatils_array->Paymentmethod;
        $BillingaddressData = $agencyDeatils_array->Billingaddress;
        $CompanyaddressData = $agencyDeatils_array->Companyaddress;
        $SecondaryemailData = $agencyDeatils_array->Secondaryemail;
        $SecondaryphoneData = $agencyDeatils_array->Secondaryphone;

  }
  else
  {
    header('Location: dashboard.php');
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- jsPDF library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.js" integrity="sha512-Bw9Zj8x4giJb3OmlMiMaGbNrFr0ERD2f9jL3en5FmcTXLhkI+fKyXVeyGyxKMIl1RfgcCBDprJJt4JvlglEb3A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <title>Invoice Document</title>
  <style>
    /* Resetting default margin and padding */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    /* Global styles */
    body {
      font-family: Arial, sans-serif;
      line-height: 1.6;
      background-color: #f7fafc;
      color: #374151;
      border: 1px solid black;
/*      background-image: url('Screenshot_1.png');
      background-repeat: no-repeat;*/
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
    }

    /* Header styles */
    .container .py-4 {
      margin-bottom: 20px;
    }

    .container .px-14 {
      padding-left: 28px;
      padding-right: 28px;
    }

    /* Table styles */
    table {
      width: 100%;
      margin-bottom: 20px;
    }

    .invoice-product-table {
      border: 1px solid black;
      border-collapse: collapse;
    }

    .invoice-product-table th,
    .invoice-product-table td {
      border: 1px solid black;
    }

    /* Remove borders from other tables */
    table:not(.invoice-product-table),
    table:not(.invoice-product-table) th,
    table:not(.invoice-product-table) td {
      border: none;
    }

    th,
    td {
      padding: 10px;
    }

    /* Image styles */
    .container img {
      height: 48px;
      width: auto;
    }

    /* Text styles */
    .text-sm {
      font-size: 0.875rem;
    }

    .text-main {
      color: #4b5563;
    }

    .text-slate-400 {
      color: #94a3b8;
    }

    .font-bold {
      font-weight: bold;
    }

    /* Background styles */
    .bg-slate-100 {
      background-color: #edf2f7;
    }

    .bg-main {
      background-color: #0D92EB;
    }

    /* Alignment styles */
    .align-top {
      vertical-align: top;
    }

    .text-right {
      text-align: right;
    }

    .text-center {
      text-align: center;
    }

    /* Footer styles */
    footer {
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
      background-color: #edf2f7;
      color: #94a3b8;
      font-size: 0.75rem;
      padding: 10px 0;
    }

    footer span {
      padding: 0 5px;
    }

    /* Notes section styles */
    .container .py-10 {
      padding-top: 20px;
      padding-bottom: 20px;
    }

    .container .italic {
      font-style: italic;
    }
  </style>
</head>

<body>
  <div class="conatiner m-3">
    <div class="card"style="width:22%;margin-left:900px;border-radius: 15px;">
      <div class="card-body" >
        <button class="btn btn-primary m-1"onclick="convert_pdf()">Download Invoice</button>
        <button class="btn btn-success m-1">Sent Invoice</button>
        <button class="btn btn-danger m-1"onclick="backpage()">Back</button>
      </div>
    </div>
    
  </div>
   
  <div class="container" id="invoicepdf">
    <div class="py-4" style="border:1px solid black">
      <div class="px-14 py-6">
        <table class="w-full border-collapse border-spacing-0">
          <tbody>
            <tr>
              <td class="w-full align-top">
                <div>
                  <img src="images/zcare-logo.png"style="height:10%">
                </div>
              </td>

              <td class="align-top">
                <div class="text-sm">
                  <table class="table">
                    <tbody>
                      <tr>
                        <td class="pr-4">
                          <div>
                            <p class="whitespace-nowrap text-slate-400 text-right">Date</p>
                            <p class="whitespace-nowrap font-bold text-main text-right"><?php echo $getIn['invoice_date'];?></p>
                          </div>
                        </td>
                        <td class="pl-4">
                          <div>
                            <p class="whitespace-nowrap text-slate-400 text-right">Invoice #</p>
                            <p class="whitespace-nowrap font-bold text-main text-right"><?php echo $getIn['invoice_no'];?></p>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="bg-slate-100 px-14 py-6 text-sm">
        <table class="w-full border-collapse border-spacing-0">
          <tbody>
            <tr>
              <td class="w-1/2 align-top">
                <div class="text-sm text-neutral-600">
                  <p class="font-bold">Zealous Health care</p>
                  <p>NRCS Tower, Nungambakkam</p>
                  <p>Chennai, Tamil Nadu</p>
                  <p>India</p>
                </div>
              </td>
              <td class="w-1/2 align-top text-right">
                <div class="text-sm text-neutral-600">
                  <p class="font-bold"><?php echo $CompanynameData;?></p>
                  <p><?php echo $CompanyaddressData;?></p>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="px-14 py-10 text-sm text-neutral-700">
        <table class="w-full border-collapse border-spacing-0 invoice-product-table">
          <thead>
            <tr>
              <td class="border-b-2 border-main pb-3 pl-3 font-bold text-main">#</td>
              <td class="border-b-2 border-main pb-3 pl-2 font-bold text-main">Product details</td>
              <td class="border-b-2 border-main pb-3 pl-2 text-right font-bold text-main">Price</td>
              <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main">Qty.</td>
              <!-- <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main">VAT</td> -->
              <td class="border-b-2 border-main pb-3 pl-2 text-right font-bold text-main">Subtotal</td>
              <!-- <td class="border-b-2 border-main pb-3 pl-2 pr-3 text-right font-bold text-main">Subtotal + VAT</td> -->
            </tr>
          </thead>
          <tbody>
            <?php
              $productDetails_array = json_decode($getIn['product_data']);

              $sno = 1;
              foreach($productDetails_array as $product)
              {
                $qty = $product->qty;
                $amount = $product->amount;
                $this_product = $product->product;
                $row_total_amount = $product->row_total_amount;

            ?>
            <tr>
              <td class="border-b py-3 pl-3"><?php echo $sno++;?></td>
              <td class="border-b py-3 pl-2"><?php echo $this_product;?></td>
              <td class="border-b text-right py-3 pl-2">$<?php echo $amount;?></td>
              <td class="border-b py-3 pl-2  text-center"><?php echo $qty;?></td>
              <td class="border-b py-3 pl-2 text-right">$<?php echo $row_total_amount;?></td>
            </tr>
            <?php
              }
            ?>
            <tr>
              <td colspan="7">
                <table class="">
                  <tbody>
                    <tr>
                      <td>
                        <table class="">
                          <tbody>
                            <tr>
                              <td class="border-b p-3">
                                <div class="whitespace-nowrap text-slate-400">Net total:</div>
                              </td>
                              <td class="border-b p-3 text-right">
                                <div class="whitespace-nowrap font-bold text-main">$<?php echo $getIn['total_amount'];?></div>
                              </td>
                            </tr>
                            <tr>
                              <td class="p-3">
                                <div class="whitespace-nowrap text-slate-400">VAT total:</div>
                              </td>
                              <td class="p-3 text-right">
                                <div class="whitespace-nowrap font-bold text-main">$<?php echo $getIn['tax_amount'];?></div>
                              </td>
                            </tr>
                            <tr>
                              <td class="bg-main p-3">
                                <div class="whitespace-nowrap font-bold " style="font-size: 25px; color: white;">Total:</div>
                              </td>
                              <td class="bg-main p-3 text-right">
                                <div class="whitespace-nowrap font-bold " style="font-size: 25px;color: white;">$<?php echo $getIn['final_amount'];?></div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="px-14 text-sm text-neutral-700">
        <p class="text-main font-bold">PAYMENT DETAILS</p>
        <p>Banks of Banks</p>
        <p>Bank/Sort Code: 1234567</p>
        <p>Account Number: 123456678</p>
        <p>Payment Reference: BRA-00335</p>
      </div>

      <div class="px-14 py-10 text-sm text-neutral-700">
        <p class="text-main font-bold">Notes</p>
        <p class="italic">This Invoice Generated by Computer.</p>



        <p><span class="fixed bottom-0 left-0 bg-slate-100 w-full text-neutral-600 text-center text-xs py-3">
          Zealous Health Care    </span>
          <span class="text-slate-300 px-2">|</span>
          business@zealoushealthcare.com
          <span class="text-slate-300 px-2">|</span>
          +1-202-000-0000 </p>
    
        </div>

      </div>
    </div>
  </div>
</body>
<script>
 
 function convert_pdf() {
  var element = document.getElementById("invoicepdf");
 
  var options = {
    margin: [0, 0, 0, 0], //[top, leaft, bottom, right]
    filename: "invoice.pdf",
    image: { type: "jpeg", quality: 1 },
    pagebreak: { avoid: "tr", mode: "css", before: "#nextpage1" },
    html2canvas: { scale: 2, useCORS: true, dpi: 192, letterRendering: true },
    jsPDF: { unit: "in", format: "a4", orientation: "portrait" },
  };

        // Generate PDF
        html2pdf()
            .from(element)
            .set(options)
            .save();
    }


function backpage() {
    window.location.href = "agencyinvoice.php";
}

</script>
</html>
