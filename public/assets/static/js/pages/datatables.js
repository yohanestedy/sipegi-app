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

let tableUser = $("#tableUse").DataTable({
    responsive: true,
    info: false,
    pagingType: 'simple',
    order: [[2, 'asc']],
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

let tableOrangTua = $("#tableOrtu").DataTable({

    responsive: true,
    lengthMenu: [
        [10, 25, 50, -1],
        [10, 25, 50, 'Semua']
    ],
    pageLength: -1,
    info: false,
    pagingType: 'simple',
    order: [
        // [3, 'desc'],  // Kolom Dusun, urut descending
        [1, 'asc'],  // Kolom Nama, urut ascending
    ],
    columnDefs: [

        { orderable: false, targets: [0, 2, 6] } // Nonaktifkan sorting di kolom lainnya
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

let tableBalita = $("#tableBalita").DataTable({
    responsive: true,
    lengthMenu: [
        [10, 25, 50, -1],
        [10, 25, 50, 'Semua']
    ],
    pageLength: -1,
    pagingType: 'simple',
    order: [
        [1, 'asc'],  // Kolom Dusun, urut descending
    ],
    columnDefs: [

        { orderable: false, targets: [0,2,4,6] } // Nonaktifkan sorting di kolom lainnya
    ],
    dom:
		"<'row'<'col-3'l><'col-9'f>>" +
		"<'row dt-row'<'col-sm-12'tr>>" +
		"<'row'<'col-4'i><'col-8'p>>",
    "language": {
        "info": "Hal _PAGE_ dari _PAGES_",
        "lengthMenu": "_MENU_ ",
        "search": "",
        "searchPlaceholder": "Cari Nama, Posyandu.."
    }
})

let tableRiwayatPengukuran = $("#tableBalitaUkur").DataTable({
    responsive: true,
    info: false,
    paging: false,
    searching: false,
    pagingType: 'simple',
    order: [
        [1, 'desc'],  // Kolom Dusun, urut descending
    ],
    columnDefs: [

        { orderable: false, targets: [0,2,3,4,5,6,7,8,9,10,11,12,13,14,15] } // Nonaktifkan sorting di kolom lainnya
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

let tablePengukuran = $("#tableDaftarBalitaDiukur").DataTable({
    responsive: true,

    searching: true,
    pagingType: 'simple',
    layout: {
        topStart: 'searchPanes'
    },
    lengthMenu: [
        [10, 25, 50, -1],
        [10, 25, 50, 'Semua']
    ],
    pageLength: -1,
    order: [
        [3, 'desc'],  // Kolom Tgl Ukur urut descending
    ],
    columnDefs: [

        { orderable: false, targets: [0,4,5,6,7,8,9,10,11,12,13,14,15] } // Nonaktifkan sorting di kolom lainnya
    ],

    dom:
		"<'row'<'col-3'l><'col-9'f>>" +
		"<'row dt-row'<'col-sm-12'tr>>" +
		"<'row'<'col-4'i><'col-8'p>>",
    "language": {
        "info": "Hal _PAGE_ dari _PAGES_",
        "lengthMenu": "_MENU_ ",
        "search": "",
        "searchPlaceholder": "Cari..."
    }
})

let tableBalitaNonaktif = $("#tableBalitaNonaktif").DataTable({
    responsive: true,
    lengthMenu: [
        [10, 25, 50, -1],
        [10, 25, 50, 'Semua']
    ],
    pageLength: -1,
    pagingType: 'simple',
    order: [
        [1, 'desc'],  // Kolom Dusun, urut descending
    ],
    columnDefs: [

        { orderable: false, targets: [0,2,4,6] } // Nonaktifkan sorting di kolom lainnya
    ],
    dom:
		"<'row'<'col-3'l><'col-9'f>>" +
		"<'row dt-row'<'col-sm-12'tr>>" +
		"<'row'<'col-4'i><'col-8'p>>",
    "language": {
        "info": "Hal _PAGE_ dari _PAGES_",
        "lengthMenu": "_MENU_ ",
        "search": "",
        "searchPlaceholder": "Cari Nama, Posyandu.."
    }
})

let tablePosyandu = $("#tablePosyandu").DataTable({
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

let tableIndeksStandar = $("#tableIndeksStandar").DataTable({
    responsive: true,
    info: false,
    paging: false,
    searching: false,
    pagingType: 'simple',
    // order: [
    //     [1, 'asc'],  // Kolom Dusun, urut descending
    // ],

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


// HELPER

// Event listener untuk dropdown filter
$('#filterPosyandu').on('change', function () {
    let selectedValue = $(this).val(); // Ambil nilai yang dipilih
    tableBalita.column(7) .search(selectedValue).draw();  // Tabel Balita
    tablePengukuran.column(20).search(selectedValue).draw();    //Tabel Pengukuran
    tableBalitaNonaktif.column(8).search(selectedValue).draw();    //Tabel Balita Lulus
    tableOrangTua.column(5).search(selectedValue).draw();

    // updateRowCount(tableOrangTua, 'rowCountDisplayPengukuran');
    // updateRowCount(tablePengukuran, 'rowCountDisplayPengukuran');


});

$('#filterBulanPengukuran').on('change', function () {
    let selectedValue = $(this).val();

    if (!selectedValue) { // Jika value kosong (reset)
        // Reset pencarian dan tampilkan semua data
        tablePengukuran.column(3).search('').draw();
        return;
    }

    let [month, year] = selectedValue.split('.');
    year = `20${year}`;

    // Daftar bulan dalam Bahasa Indonesia untuk konversi
    const bulanIndo = {
        '01': 'Januari',
        '02': 'Februari',
        '03': 'Maret',
        '04': 'April',
        '05': 'Mei',
        '06': 'Juni',
        '07': 'Juli',
        '08': 'Agustus',
        '09': 'September',
        '10': 'Oktober',
        '11': 'November',
        '12': 'Desember'
    };

    // Mengonversi nama bulan menjadi angka bulan
    let monthName = bulanIndo[month]; // Mendapatkan nama bulan (Januari, Februari, ...)

    let formattedDate = `${monthName} ${year}`; // Format menjadi "Bulan Tahun"

    console.log(formattedDate); // Debug untuk melihat hasil yang diformat

    // Filter berdasarkan bulan yang diformat
    tablePengukuran.column(3)
        .search(formattedDate)  // Pencocokan berdasarkan nama bulan dan tahun
        .draw();  // Refresh tabel


});
// Pencarian real-time berdasarkan input teks
$('#searchKeyword').on('keyup', function () {
    let searchValue = $(this).val(); // Ambil nilai input teks
    tablePengukuran.search(searchValue).draw(); // Terapkan filter global di tabel
    tableBalita.search(searchValue).draw(); // Terapkan filter global di tabel
});

// Fungsi generik untuk menghitung jumlah baris terlihat
function updateRowCount(table, displayElementId) {
    let rowCount = table.rows({ filter: 'applied' }).count();
    $(`#${displayElementId}`).text(`Jumlah data yang terlihat: ${rowCount}`);
}
// updateRowCount(tableOrangTua, 'rowCountDisplayPengukuran');


const setTableColor = () => {
    document.querySelectorAll('.dataTables_paginate .pagination').forEach(dt => {
        dt.classList.add('pagination-primary')
    })
}


setTableColor()
jquery_datatable.on('draw', setTableColor)
