# 🩺 SIPEGI – Sistem Penilaian Gizi Anak

**Website:** [https://dev.sipegi.app](https://dev.sipegi.app)

Sipegi adalah aplikasi berbasis web yang dirancang untuk mendukung **penilaian status gizi balita** di **Desa Selorejo, Lampung Timur**. Aplikasi ini membantu kader posyandu, perangkat desa, dan tenaga kesehatan dalam melakukan pengukuran serta menghitung status gizi anak berdasarkan standar **WHO Child Growth Standards 2006**.

---

## 🎯 Tujuan Aplikasi

-   Memberikan **penilaian status gizi** anak secara **akurat dan cepat**.
-   Membantu tim **Rumah Desa Sehat (RDS)** dalam menentukan anak dengan risiko **gizi buruk atau stunting**.
-   Menyediakan rekap data gizi anak yang **terpusat dan terdigitalisasi**.

---

## ⚙️ Fitur Utama

-   📊 **Input Data Antropometri**: tinggi badan, berat badan, lingkar kepala, IMT, umur, dan jenis kelamin.
-   🧮 **Kalkulasi Z-Score otomatis** menggunakan parameter LMS standar WHO.
-   📈 **Penentuan status gizi**: Normal, Gizi Kurang, Gizi Buruk, Stunting, Wasting, Obesitas, dll.
-   🗂️ **Manajemen Data Anak**: tambah, ubah, dan lihat riwayat pengukuran, dll.
-   📍 **Manajemen Laporan** untuk pelaporan yang lebih akurat.
-   👤 **Role-based Access Control**

---

## 🔑 Akses Akun Demo

Coba langsung aplikasinya di:

**🌐 URL**: [https://dev.sipegi.app](https://dev.sipegi.app)

**Super Admin**
**Username**: `superadmin`  
**Password**: `adminsuper`

**Kader Posyandu**
**Username**: `melati`  
**Password**: `melati123`

---

## ⚠️ Alur Penggunaan Singkat

Sebelum melakukan pengukuran, ikuti urutan berikut:

1. **Input Data Orang Tua**
2. **Input Data Balita** (terhubung ke orang tua)
3. **Lakukan Pengukuran** (tinggi/berat badan)

👉 **Urutannya:** Orang Tua → Balita → Pengukuran  
💡 _Jika data orang tua dan balita sudah tersedia, Anda bisa langsung melakukan pengukuran._

## 🧑‍🏫 Cara Cepat Menggunakan Aplikasi

1. **Login ke Akun Demo**
2. **Tambah Orang Tua** melalui menu _Data Orang Tua_  
   _(Lewati jika data sudah ada)_
3. **Tambah Balita** di menu _Data Balita_  
   _(Lewati jika data sudah ada)_
4. **Masukkan Pengukuran** di menu _Pengukuran Gizi_
5. **Lihat Hasil & Grafik**
6. **Cetak Laporan** jika dibutuhkan

---

## 🖼️ Tampilan Aplikasi

### 📌 Dashboard Pengguna

> Statistik rekap data anak, jumlah pengukuran, dan status gizi terkini.

![Dashboard Screenshot](screenshots/dashboard.png)

---

### 📌 Form Pengukuran Gizi

> Masukkan data antropometri anak dan dapatkan hasil status gizi secara real-time.

![Form Pengukuran Screenshot](screenshots/form-pengukuran.png)

---

### 📌 Hasil Penilaian Gizi

> Status gizi langsung ditampilkan berdasarkan perhitungan Z-Score WHO.

![Hasil Gizi Screenshot](screenshots/hasil-gizi.png)

---

## 📚 Referensi Standar

-   [WHO Child Growth Standards 2006](https://www.who.int/tools/child-growth-standards/standards)
-   [WHO Z-Score Computation Guide (PDF)](https://cdn.who.int/media/docs/default-source/child-growth/growth-reference-5-19-years/computation.pdf)

---

## 🚀 Teknologi yang Digunakan

-   🧩 **Backend**: Laravel 10
-   🎨 **Frontend**: Bootstrap 5
-   🗄️ **Database**: MySQL (utama) dan integrasi MSSQL untuk data keuangan
-   🌐 **Hosting**: Hostinger + GitHub (CI manual)

---

## 🛠️ Status Pengembangan

-   ✅ Sudah diuji coba dan di gunakan oleh kader posyandu dan admin desa.
-   🚧 Dalam tahap penyempurnaan untuk diimplementasikan di seluruh posyandu Desa Selorejo.

---

## 📬 Kontak

Untuk pertanyaan, saran, atau kontribusi:  
**Nama**: Yohanes Tedy K  
**Email**: yohanestedy52b@gmail.com
