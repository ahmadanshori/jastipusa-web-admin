$("#show-table").DataTable({
    pageLength: 25,
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
        url: "/ajax-purchase",
        dataType: "json",
        type: "GET",
    },
    columns: [
        {
            data: "no_invoice",
        },
        {
            data: "nama",
        },
        {
            data: "no_telp",
        },
        {
            data: "alamat",
        },
        {
            data: "email",
        },
        {
            data: "actions",
            name: "actions",
            orderable: false,
            searchable: false,
        },
    ],
});
