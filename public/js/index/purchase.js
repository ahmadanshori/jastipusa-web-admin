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
    order: [],
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
            data: "created_at",
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
