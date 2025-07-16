# SIPEGI – Sistem Penilaian Gizi Anak

**Website:** [https://dev.sipegi.app](https://dev.sipegi.app)

SIPEGI adalah aplikasi berbasis web yang dirancang untuk mendukung penilaian status gizi balita di Desa Selorejo, Lampung Timur. Aplikasi ini membantu kader posyandu, perangkat desa, dan tenaga kesehatan dalam melakukan pengukuran serta menghitung status gizi anak berdasarkan standar WHO Child Growth Standards 2006.

---

## Tujuan Aplikasi

-   Memberikan penilaian status gizi anak secara akurat dan cepat.
-   Membantu tim Rumah Desa Sehat (RDS) dalam menentukan anak dengan risiko gizi buruk atau stunting.
-   Menyediakan rekap data gizi anak yang terpusat dan terdigitalisasi.

---

## Fitur Utama

-   Input data antropometri: tinggi badan, berat badan, lingkar kepala, IMT, umur, dan jenis kelamin.
-   Kalkulasi Z-Score otomatis menggunakan parameter LMS standar WHO.
-   Penentuan status gizi: Normal, Gizi Kurang, Gizi Buruk, Stunting, Wasting, Obesitas, dan lainnya.
-   Manajemen data anak: tambah, ubah, dan lihat riwayat pengukuran.
-   Manajemen laporan untuk pelaporan yang lebih akurat.
-   Role-based access control.

---

## Akses Akun Demo

Website: [https://dev.sipegi.app](https://dev.sipegi.app)

### Super Admin

-   **Username**: `superadmin`
-   **Password**: `adminsuper`

### Kader Posyandu

-   **Username**: `melati`
-   **Password**: `melati123`

---

## Alur Penggunaan Singkat

Sebelum melakukan pengukuran, ikuti urutan berikut:

1. Input data orang tua
2. Input data balita (terhubung ke orang tua)
3. Lakukan pengukuran (tinggi/berat badan)

Urutannya: **Orang Tua → Balita → Pengukuran**  
Jika data orang tua dan balita sudah tersedia, Anda bisa langsung melakukan pengukuran.

---

## Cara Cepat Menggunakan Aplikasi

1. Login ke akun demo
2. Tambah orang tua melalui menu _Data Orang Tua_ (lewati jika data sudah ada)
3. Tambah balita di menu _Data Balita_ (lewati jika data sudah ada)
4. Masukkan pengukuran di menu _Pengukuran Gizi_
5. Lihat hasil & grafik pertumbuhan
6. Cetak laporan jika dibutuhkan

---

## Tampilan Aplikasi

### Dashboard Pengguna

Statistik rekap data anak, jumlah pengukuran, dan status gizi terkini.  
![Dashboard Screenshot](screenshots/dashboard.png)

### Form Pengukuran Gizi

Masukkan data antropometri anak dan dapatkan hasil status gizi secara real-time.  
![Form Pengukuran Screenshot](screenshots/form-pengukuran.png)

### Hasil Penilaian Gizi

Status gizi langsung ditampilkan berdasarkan perhitungan Z-Score WHO.  
![Hasil Gizi Screenshot](screenshots/hasil-gizi.png)

---

## Referensi Standar

-   [WHO Child Growth Standards 2006](https://www.who.int/tools/child-growth-standards/standards)
-   [WHO Z-Score Computation Guide (PDF)](https://cdn.who.int/media/docs/default-source/child-growth/growth-reference-5-19-years/computation.pdf)

---

## Teknologi yang Digunakan

-   **Backend**: Laravel 10
-   **Frontend**: Blade - Bootstrap 5
-   **Database**: MySQL

---

## Status Pengembangan

-   Sudah diuji coba dan digunakan oleh kader posyandu dan admin desa.
-   Dalam tahap penyempurnaan untuk diimplementasikan di seluruh posyandu Desa Selorejo.

---

## Kontak

Untuk pertanyaan, saran, atau kontribusi:

**Nama**: Yohanes Tedy K  
**Email**: yohanestedy52b@gmail.com
