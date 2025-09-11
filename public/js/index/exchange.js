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
        url: "/ajax-exchange",
        dataType: "json",
        type: "GET",
    },
    columns: [
        {
            data: "id",
        },
        {
            data: "name",
        },
        {
            data: "value",
        },
        {
            data: "actions",
            name: "actions",
            orderable: false,
            searchable: false,
        },
    ],
});
