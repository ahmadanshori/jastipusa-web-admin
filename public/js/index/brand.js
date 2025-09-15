$("#show-table").DataTable({
    pageLength: 25,
    processing: true,
    serverSide: true,
    language: {
        paginate: {
            previous: "<i class='fas fa-angle-left'>",
            next: "<i class='fas fa-angle-right'>"
        }
    },
    order: [[0, "desc"]],
    ajax: {
        url: "/ajax-brand",
        dataType: "json",
        type: "GET"
    },
    columns: [
       
        {
            data: "id"
        },
        {
            data: "name"
        },
         {
            data: "code"
        },
        {
            data: "actions",
            name: "actions",
            orderable: false,
            searchable: false
        }
    ]
});
