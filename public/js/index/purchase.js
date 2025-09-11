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
            render: function (data, type, row) {
                if (type === "display" && data) {
                    const date = new Date(data);
                    const months = [
                        "Januari",
                        "Februari",
                        "Maret",
                        "April",
                        "Mei",
                        "Juni",
                        "Juli",
                        "Agustus",
                        "September",
                        "Oktober",
                        "November",
                        "Desember",
                    ];
                    const day = date.getDate();
                    const month = months[date.getMonth()];
                    const year = date.getFullYear();
                    return `${day} ${month} ${year}`;
                }
                return data;
            },
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
