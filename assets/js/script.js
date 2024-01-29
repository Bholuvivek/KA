$(document).ready(function(row, type, set) {
   table = $('#example').DataTable({
       serverSide: true,
       pageLength: 10,
       lengthMenu: [10, 25, 50, 100],
       searching: true,

       ajax: {
           url: '../task/server_processing.php',
           type: 'POST',
           dataSrc: 'data',
           
       },
       
       
       columns: [
           { data: 'Lead_ID' },
           { data: 'Name' },
           { data: 'Mobile' },
           { data: 'Alternate_Mobile'},
           { data: 'Whatsapp' },
           { data: 'Email' },
           { data: 'Interested_In' },
           { data: 'Source' },
           { data: 'Status' },
           { data: 'DOR' },
           { data: 'Summary_Note' },
           { data: 'Caller' },
           { data: 'State' },
           { data: 'City' },      
       ],
       processing: true,
       serverSide: true,
       initComplete: function () {
           this.api().columns().every(function () {
               var that = this;

               $('input', this.footer()).on('keyup change', function () {
                   if (that.search() !== this.value) {
                       that
                           .search(this.value)
                           .draw();
                   }
               });
           });
       },
       destroy:true,
       ordering:false
   });
});
