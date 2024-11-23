let jquery_datatable = $("#table1").DataTable({
    responsive: true
})
let customized_datatable = $("#table2").DataTable({
    responsive: true,
    pagingType: 'simple',
    dom:
		"<'row'<'col-3'l><'col-9'f>>" +
		"<'row dt-row'<'col-sm-12'tr>>" +
		"<'row'<'col-4'i><'col-8'p>>",
    "language": {
        "info": "Page _PAGE_ of _PAGES_",
        "lengthMenu": "_MENU_ ",
        "search": "",
        "searchPlaceholder": "Search.."
    }
})
let customized_datatable1 = $("#tableUser").DataTable({
    responsive: true,
    info: false,
    pagingType: 'simple',
    order: [[3, 'asc']],
    columnDefs: [

        { orderable: false, targets: 4 } // Nonaktifkan sorting di kolom lainnya
    ],
    dom:
		"<'row'<'col-3'l><'col-9'f>>" +
		"<'row dt-row'<'col-sm-12'tr>>" +
		"<'row'<'col-4'i><'col-8'p>>",
    "language": {
        "lengthMenu": "_MENU_ ",
        "search": "",
        "searchPlaceholder": "Search.."
    }
})
let customized_datatable2 = $("#tableOrtu").DataTable({
    responsive: true,
    info: false,
    pagingType: 'simple',
    order: [
        [2, 'desc'],  // Kolom Dusun, urut descending
        [1, 'asc'],  // Kolom Nama, urut ascending
    ],
    columnDefs: [

        { orderable: false, targets: [0, 4, 5] } // Nonaktifkan sorting di kolom lainnya
    ],
    dom:
		"<'row'<'col-3'l><'col-9'f>>" +
		"<'row dt-row'<'col-sm-12'tr>>" +
		"<'row'<'col-4'i><'col-8'p>>",
    "language": {
        "lengthMenu": "_MENU_ ",
        "search": "",
        "searchPlaceholder": "Search.."
    }
})
let customized_datatable3 = $("#tableBalita").DataTable({
    responsive: true,
    info: false,
    pagingType: 'simple',
    order: [
        [1, 'asc'],  // Kolom Dusun, urut descending
    ],
    columnDefs: [

        { orderable: false, targets: [0,2,3,4,5,6,7] } // Nonaktifkan sorting di kolom lainnya
    ],
    dom:
		"<'row'<'col-3'l><'col-9'f>>" +
		"<'row dt-row'<'col-sm-12'tr>>" +
		"<'row'<'col-4'i><'col-8'p>>",
    "language": {
        "lengthMenu": "_MENU_ ",
        "search": "",
        "searchPlaceholder": "Ketik nama.."
    }
})
let customized_datatable5 = $("#tableBalitaUkur").DataTable({
    responsive: true,
    info: false,
    paging: false,
    searching: false,
    pagingType: 'simple',
    order: [
        [1, 'desc'],  // Kolom Dusun, urut descending
    ],
    columnDefs: [

        { orderable: false, targets: [0,2,3,4,5,6,7,8,9,10,11,12,13,14] } // Nonaktifkan sorting di kolom lainnya
    ],
    dom:
		"<'row'<'col-3'l><'col-9'f>>" +
		"<'row dt-row'<'col-sm-12'tr>>" +
		"<'row'<'col-4'i><'col-8'p>>",
    "language": {
        "lengthMenu": "_MENU_ ",
        "search": "",
        "searchPlaceholder": "Ketik nama.."
    }
})
let customized_datatable4 = $("#tablePosyandu").DataTable({
    responsive: true,
    info: false,
    paging: false,
    searching: false,
    pagingType: 'simple',
    // order: [
    //     [1, 'asc'],  // Kolom Dusun, urut descending
    // ],
    columnDefs: [

        { orderable: false, targets: [0,1,2,3] } // Nonaktifkan sorting di semua kolom
    ],
    dom:
		"<'row'<'col-3'l><'col-9'f>>" +
		"<'row dt-row'<'col-sm-12'tr>>" +
		"<'row'<'col-4'i><'col-8'p>>",
    "language": {
        "lengthMenu": "_MENU_ ",
        "search": "",
        "searchPlaceholder": "Ketik nama.."
    }
})

const setTableColor = () => {
    document.querySelectorAll('.dataTables_paginate .pagination').forEach(dt => {
        dt.classList.add('pagination-primary')
    })
}
setTableColor()
jquery_datatable.on('draw', setTableColor)
