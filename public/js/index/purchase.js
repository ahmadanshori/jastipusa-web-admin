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
        error: function (xhr, error, thrown) {
            console.error("DataTables AJAX error:", error, thrown);
            console.error("Response:", xhr.responseText);
        },
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
