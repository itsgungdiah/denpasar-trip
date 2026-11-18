
# AGENTS.md — DenpasarTrip

## 1. Project Overview

DenpasarTrip adalah sistem informasi pariwisata berbasis website
yang menyediakan informasi destinasi wisata di Kabupaten Denpasar
dan membantu wisatawan menyusun itinerary perjalanan secara manual.

Tujuan utama sistem:
- Menyediakan informasi destinasi wisata.
- Membantu pengguna menemukan destinasi berdasarkan minat.
- Memberikan rekomendasi destinasi menggunakan rule-based
  recommendation.
- Membantu pengguna menyusun, menyimpan, dan melihat kembali
  itinerary perjalanan.

Stakeholders:
- Wisatawan
- Admin

Jadikan System Brief DenpasarTrip sebagai acuan utama
perilaku dan batasan fungsional sistem.

## 2. Technology Stack

Gunakan teknologi yang sudah digunakan repository:

- Backend: Laravel 13
- Programming Language: PHP 8.3+
- Database: MySQL
- Frontend: Laravel Blade
- CSS Framework: Tailwind CSS 4
- JavaScript Build Tool: Vite 8
- Version Control: Git
- Code Editor: Visual Studio Code

Jangan mengganti framework, database, atau teknologi utama
tanpa persetujuan pengguna.

Jangan mengasumsikan versi dependency berdasarkan dokumentasi
terbaru. Periksa composer.json, composer.lock, package.json,
dan package-lock.json terlebih dahulu.

## 3. System Scope

### 3.1 User Features

Fitur pengguna yang termasuk dalam scope:

1. Home
   - Menampilkan informasi umum DenpasarTrip.
   - Menampilkan preview destinasi populer.
   - Menampilkan kategori destinasi.
   - Mengarahkan pengguna ke Explore dan Trip Planner.

2. Explore
   - Menampilkan daftar destinasi.
   - Mencari destinasi berdasarkan nama.
   - Memfilter destinasi berdasarkan kategori.
   - Mendukung pemilihan beberapa kategori.
   - Membuka detail destinasi.

3. Destination Details
   - Menampilkan informasi destinasi.
   - Menampilkan deskripsi.
   - Menampilkan gambar.
   - Menampilkan jam operasional.
   - Menampilkan biaya masuk dan estimasi pengeluaran.
   - Menyediakan tautan Google Maps.

4. Trip Planner
   - Step 1: Trip Details.
   - Step 2: Preferences.
   - Step 3: Discover Places.
   - Menentukan nama trip.
   - Menentukan tanggal mulai dan selesai.
   - Memilih satu atau beberapa kategori.
   - Menampilkan rekomendasi destinasi.
   - Menambahkan destinasi pilihan ke itinerary.
   - Mengatur tanggal, waktu mulai, durasi, urutan,
     dan catatan itinerary.

5. My Trip
   - Menampilkan daftar trip milik pengguna.
   - Melihat detail trip.
   - Melihat itinerary yang sudah disusun.

6. Profile
   - Menampilkan informasi akun.
   - Menyediakan fungsi logout.

### 3.2 Admin Features

Admin bertanggung jawab mengelola data sistem, terutama:

- Dashboard admin.
- Pengelolaan data destinasi.
- Pengelolaan kategori destinasi jika diperlukan.
- Pengelolaan data sesuai hak akses admin.

Pertahankan implementasi admin yang sudah tersedia
dan periksa terlebih dahulu sebelum melakukan perubahan.

## 4. Destination Categories

Sistem menggunakan lima kategori destinasi:

1. Culture
   Budaya, sejarah, dan identitas Denpasar.

2. Culinary
   Tempat makan dan kuliner.

3. Shopping
   Tempat berbelanja.

4. Nature
   Destinasi alam.

5. Art
   Destinasi seni.

Gunakan nama kategori secara konsisten pada database,
backend, dan frontend.

## 5. Business Rules

### 5.1 Recommendation System

- Gunakan rule-based recommendation.
- Input berupa kategori yang dipilih pengguna.
- Sistem mencocokkan kategori pilihan dengan kategori destinasi.
- Output berupa daftar destinasi yang sesuai.
- Pengguna dapat memilih lebih dari satu kategori.
- Preferensi dapat diubah pada halaman Discover Places.

Jangan menggunakan machine learning, AI recommendation,
rating, atau histori kunjungan sebagai dasar rekomendasi.

### 5.2 Trip Planner

- Pengguna menentukan sendiri destinasi yang ingin dikunjungi.
- Pengguna menentukan tanggal perjalanan.
- Pengguna menentukan waktu mulai.
- Pengguna menentukan durasi.
- Pengguna menentukan urutan destinasi.
- Pengguna dapat menambahkan catatan.
- Perubahan preference tidak boleh menghapus itinerary
  yang sudah dibuat.

### 5.3 Itinerary Rules

- Itinerary disusun secara manual oleh pengguna.
- Sistem tidak menentukan jadwal perjalanan otomatis.
- Sistem tidak melakukan optimasi rute.
- Sistem tidak mengatur urutan destinasi secara otomatis.

### 5.4 Trip Status

- Status trip ditentukan berdasarkan tanggal perjalanan.
- Past Trip berarti tanggal trip telah berlalu.
- Past Trip tidak berarti pengguna benar-benar telah
  mengunjungi destinasi.

## 6. System Restrictions

DenpasarTrip TIDAK menyediakan:

- Booking tiket atau tempat wisata.
- Pembayaran.
- Pemesanan hotel atau akomodasi.
- Review destinasi.
- Rating pengguna.
- User album.
- Check-in atau visited tracking.
- GPS tracking.
- Navigasi atau routing.
- Automatic itinerary generation.
- Automatic schedule generation.
- Route optimization.

Jangan menambahkan fitur-fitur tersebut tanpa persetujuan
pengguna dan perubahan scope proyek.

Catatan:
System Brief juga menyebut Save Destination pada bagian Explore.
Namun, kebutuhan penyimpanan destinasi perlu diperiksa kembali
terhadap rancangan database sebelum diimplementasikan.

## 7. Database Guidelines

Database utama menggunakan MySQL.

Entitas utama berdasarkan System Brief:

- users
- categories
- destinations
- destination_categories
- trips
- trip_preferences
- itineraries

Ketentuan:
- Periksa migration dan model sebelum membuat perubahan.
- Pertahankan foreign key dan relasi yang sudah ada.
- Gunakan Eloquent ORM sesuai kebutuhan.
- Gunakan migration untuk perubahan struktur database.
- Jangan menghapus tabel atau data yang sudah ada sembarangan.
- Jangan menggunakan migrate:fresh atau db:wipe
  tanpa persetujuan eksplisit pengguna.
- Jangan menjalankan seeder pada database yang berisi data
  tanpa memastikan dampaknya terlebih dahulu.
- Jangan menyimpan kredensial database dalam source code.
- Jangan menampilkan isi file .env dalam laporan.

## 8. Development Guidelines

Sebelum mengerjakan setiap tugas:

1. Baca AGENTS.md.
2. Periksa file yang berhubungan dengan tugas.
3. Pahami implementasi yang sudah tersedia.
4. Identifikasi dampak perubahan terhadap fitur lain.
5. Gunakan struktur dan pola kode repository yang sudah ada.

Ketentuan implementasi:

- Hindari duplikasi kode.
- Gunakan controller untuk menangani request.
- Gunakan model untuk interaksi database.
- Gunakan Blade untuk tampilan.
- Gunakan validasi server-side.
- Terapkan authentication dan authorization.
- Pastikan pengguna hanya dapat mengakses data trip miliknya.
- Gunakan CSRF protection.
- Tangani error dan validasi dengan jelas.
- Gunakan penamaan variabel, method, dan file yang konsisten.

Jangan melakukan refactoring besar tanpa alasan teknis
dan persetujuan pengguna.

## 9. UI/UX Guidelines

- Jadikan desain UI DenpasarTrip yang sudah disetujui
  sebagai referensi implementasi.
- Pertahankan konsistensi layout antarhalaman.
- Gunakan komponen Blade yang dapat digunakan kembali
  jika sesuai dengan struktur repository.
- Gunakan Tailwind CSS sesuai versi project.
- Pastikan tampilan responsif.
- Jangan mengganti desain secara sepihak.
- Jangan menambahkan elemen atau fitur yang tidak
  terdapat dalam rancangan tanpa konfirmasi.

## 10. Testing Guidelines

Setelah implementasi:

- Periksa route terkait.
- Periksa validasi form.
- Periksa authorization.
- Periksa relasi database.
- Jalankan pengujian yang relevan jika memungkinkan.
- Periksa hasil perubahan pada browser.
- Pastikan tidak merusak fitur yang sudah tersedia.

Jangan mengklaim fitur berhasil jika belum diuji.

## 11. Git and Change Management

- Jangan menghapus perubahan lokal pengguna.
- Jangan melakukan git reset --hard.
- Jangan melakukan git clean tanpa persetujuan.
- Jangan melakukan force push.
- Jangan mengubah atau menghapus file yang tidak
  berhubungan dengan tugas.
- Periksa git status sebelum dan sesudah pekerjaan.
- Jelaskan file yang dibuat, diubah, dan dihapus.
- Laporkan error atau pekerjaan yang belum selesai.

## 12. Working Instructions for Codex

Kerjakan tugas secara bertahap sesuai instruksi pengguna.

Sebelum implementasi:
- Jelaskan pemahaman terhadap tugas.
- Identifikasi file yang akan terdampak.
- Sampaikan risiko perubahan jika ada.

Setelah implementasi:
- Berikan ringkasan perubahan.
- Sebutkan file yang diubah.
- Jelaskan cara pengujian.
- Laporkan hasil pengujian.
- Sebutkan masalah yang masih tersisa.

Jangan mengerjakan fitur tambahan di luar permintaan.

Jika requirement ambigu atau bertentangan dengan System Brief,
hentikan bagian yang ambigu dan tanyakan kepada pengguna.

Prioritas utama adalah menjaga konsistensi implementasi
dengan System Brief, desain UI, dan kebutuhan DenpasarTrip.
