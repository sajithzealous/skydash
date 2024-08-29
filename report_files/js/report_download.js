$(document).ready(function(){
 document.getElementById('download_excel').addEventListener('click', function () {
     var headers = Array.from(document.querySelectorAll("#head th")).slice(0, -3).map(function (th) {
         return th.textContent;
     });

     var rows = Array.from(document.querySelectorAll("#table_data tr")).map(function (row) {
        
         var cells = Array.from(row.querySelectorAll('td'));
         cells.splice(-3);   
         return cells.map(function (cell) {
             return cell.textContent;
         });
     });

     var data = [headers].concat(rows);

     var wb = XLSX.utils.book_new();
     var ws = XLSX.utils.aoa_to_sheet(data);
     XLSX.utils.book_append_sheet(wb, ws, "Sheet1");  
     XLSX.writeFile(wb, "Production-Report.xlsx");
 });


   });