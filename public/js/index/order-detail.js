const customerId = window.location.pathname.split("/").pop();
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
        url: `/ajax-order-detail/${customerId}`,
        dataType: "json",
        type: "GET",
        error: function (xhr, error, thrown) {
            console.error("DataTables AJAX error:", error, thrown);
            console.error("Response:", xhr.responseText);
        },
    },
    columns: [
        {
            data: "no_po",
        },
        {
            data: "nama_barang",
        },
        {
            data: "estimasi_kg",
        },
        {
            data: "estimasi_harga",
            render: function (data, type, row) {
                return CurrencyUtils.formatRupiahForDataTable(data, type, row);
            },
        },
        {
            data: "jumlah_transfer",
            render: function (data, type, row) {
                return CurrencyUtils.formatRupiahForDataTable(data, type, row);
            },
        },
        {
            data: "dp",
            render: function (data, type, row) {
                return CurrencyUtils.formatRupiahForDataTable(data, type, row);
            },
        },
    ],
});
