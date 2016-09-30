var customers_table = $('#customers_table').DataTable( {
    "dom": 'frtip',
    "buttons": [
        {
            extend: 'collection',
            text: 'Export',
            buttons: [ 'pdfHtml5', 'csvHtml5', 'copyHtml5', 'excelHtml5' ]
        }
    ],
    "cache": true,
    "processing": true,
    "serverSide": true,
    "deferRender": true,
    "language": {
        "url": base_url + 'assets/global/plugins/datatables/i18n/Swedish.json'
    },
    "ajax": {
        "url": ajax_url,
        "type": "POST"
    },
    "aoColumns": [
            { mData: 'id' },
            { mData: 'company_name' },
            { mData: 'company_postal_address' },
            { mData: 'contact_person' },
            { mData: 'company_email' },
            { mData: 'company_phone' }                
    ],
    "columnDefs": [ 
        {targets:1, className:"company_name"},
        {targets:6, data:null, defaultContent:""}            
    ],
    "rowCallback": function( nRow, mData, iDisplayIndex ) {
        $(nRow).attr('data-id', mData.id);
        $('td:eq(0)', nRow).html(iDisplayIndex + 1);
        return nRow;
    }
} );