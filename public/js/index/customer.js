$("#show-table").DataTable({
    pageLength: 10,
    processing: true,
    serverSide: true,
    language: {
        paginate: {
            previous: "<i class='fas fa-angle-left'>",
            next: "<i class='fas fa-angle-right'>",
        },
    },
    order: [[0, "desc"]],
    ajax: {
        url: "/ajax-customer",
        dataType: "json",
        type: "GET",
    },
    columns: [
        {
            data: "display_name",
        },
        {
            data: "whatsapp_number",
        },
        {
            data: "address",
        },
        {
            data: "email_address",
        },
        {
            data: "total_belanja",
        },
        {
            data: "total_order",
            render: function (data, type, row) {
                return CurrencyUtils.formatRupiahForDataTable(data, type, row);
            },
        },
        {
            data: "actions",
            name: "actions",
            orderable: false,
            searchable: false,
        },
    ],
});
