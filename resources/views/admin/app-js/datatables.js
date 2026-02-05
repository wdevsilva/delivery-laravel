var datatable_buttons = [{
        extend: 'csv',
        className: 'btn-sm',
        text: '<i class="fa fa-file-code-o"></i> <span class="hidden-xs-down">CSV</span>'
    },
    {
        extend: 'excel',
        className: 'btn-sm',
        text: '<i class="fa fa-file-excel-o"></i> <span class="hidden-xs-down">Excel</span>'
    },
    {
        extend: 'pdf',
        footer: true, // Inclui o footer no PDF
        className: 'btn-sm',
        text: '<i class="fa fa-file-pdf-o"></i> <span class="hidden-xs-down">PDF</span>',
        exportOptions: {
            //columns: ':visible',
            /*
            format: {
                body: function (data, row, column, node) {
                    if (node.className == 'd-print-none') {
                        return ''
                    }
                    return node.innerText;
                }
            }*/
        },
        customize: function(win) {
            //$('#datatable').DataTable().columns('.d-print-none').visible(false);
            //console.log($('#datatable').DataTable().columns('.d-print-none'))
        }
    },
    {
        extend: 'print',
        className: 'btn-sm',
        exportOptions: {
            //columns: ':visible',
            //stripHtml: false
        },
        text: '<i class="fa fa-print"></i> <span class="hidden-xs-down">Imprimir</span>',
        customize: function(win) {
            $(win.document.body).find('table').addClass('compact').css('font-size', 'inherit');
        }
    }
];

var lang = {
    "sEmptyTable": "Nenhum registro encontrado",
    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
    "sInfoPostFix": "",
    "sInfoThousands": ".",
    "sLengthMenu": "_MENU_ <small class='text-muted'>itens por página</small>",
    "sLoadingRecords": "Carregando...",
    "sProcessing": "Processando...",
    "sZeroRecords": "Nenhum registro encontrado",
    "sSearch": "",
    "oPaginate": {
        "sNext": "Próximo",
        "sPrevious": "Anterior",
        "sFirst": "Primeiro",
        "sLast": "Último"
    },
    "oAria": {
        "sSortAscending": ": Ordenar colunas de forma ascendente",
        "sSortDescending": ": Ordenar colunas de forma descendente"
    }
}

function draw_buttons() {
    $('.dataTables_filter LABEL').css('margin-right', '0px').css('font-weight', 'bold').css('color', '#333');
    $('.dataTables_filter INPUT').css('margin-left', '0px');
    $('.dataTables_filter INPUT').css('padding-left', '0px');
    $('[data-toggle="tooltip"]').tooltip();
}

$.fn.dataTable.Buttons.defaults.dom.button.className = 'btn btn-primary btn-spacer btn-min-w-60';