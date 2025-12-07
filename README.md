# Pengajuan Izin Siswa

Aplikasi berbasis web untuk mengelola pengajuan izin siswa secara digital.  
Dibuat menggunakan Laravel 12, Bootstrap 5, HTML, CSS, JavaScript, dan PHP.

---

## Fitur Utama

-   Login, Register, dan Lupa Password (Siswa dan Admin)  
    Pengguna dapat login, membuat akun baru, dan mengatur ulang password jika lupa.

-   Ajukan Izin (Siswa)  
    Siswa dapat mengajukan izin dengan mengisi form berisi nama, kelas, tanggal izin, alasan, dan bukti (foto/PDF).  
    Setiap siswa hanya dapat melihat, mengedit, menghapus, dan mengelola izin miliknya sendiri tanpa bisa mengakses data izin siswa lain.

-   Kalender (Catatan Pribadi Siswa)  
    Setiap siswa memiliki catatan pribadi yang hanya bisa diakses oleh dirinya sendiri.  
    Admin tidak bisa melihat catatan siswa lain karena sistem dirancang privat per pengguna.

-   My Profile  
    Pengguna dapat melihat dan mengubah data pribadinya.  
    Fitur ini menggunakan relasi satu ke satu antara tabel users dan profiles, jadi setiap user hanya memiliki satu profil.

-   Data Izin Siswa (Admin)  
    Admin dapat melihat seluruh pengajuan izin yang dibuat oleh siswa.  
    Halaman ini dilengkapi dengan form pencarian, filter berdasarkan nama, kelas, tanggal, dan status.  
    Data izin ditampilkan dalam tabel yang dilengkapi tombol untuk mengubah status, melihat file bukti, dan menambahkan catatan guru.  
    Admin juga dapat mengekspor data ke format Excel atau PDF untuk keperluan arsip.  
    Intinya, fitur ini digunakan admin untuk mengubah status izin siswa menjadi disetujui atau ditolak.

-   Manajemen User (Admin)  
    Menampilkan data seluruh pengguna (Admin dan Siswa).  
    Dilengkapi dengan fitur pencarian, filter berdasarkan role, tambah user baru, edit, hapus, serta export ke Excel dan PDF.

---

## Akun Login Demo

Gunakan akun berikut untuk mencoba aplikasi:

| Role  | Email           | Password  |
| ----- | --------------- | --------- |
| Admin | admin@gmail.com | 123123123 |
| Siswa | mutia@gmail.com | 123123123 |

---

## Alur Kerja Sistem

Alur kerja sistem menggambarkan jalannya proses pengajuan izin dari awal sampai akhir:

1. Siswa Login ke Sistem
Siswa masuk menggunakan akun masing-masing dan diarahkan ke dashboard untuk melihat ringkasan status izin.

2. Siswa Mengajukan Izin
Siswa membuka fitur Ajukan Izin Siswa, lalu mengklik tombol +Ajukan Izin untuk mengisi form yang berisi nama, kelas, tanggal izin, alasan, serta bukti (foto/PDF).
Setelah dikirim, status izin akan berubah menjadi Menunggu.

3. Guru / Admin Melakukan Verifikasi
Guru atau admin login terlebih dahulu, kemudian memeriksa data yang diajukan melalui menu Data Izin Siswa.
Setelah diperiksa, guru atau admin memberikan keputusan Disetujui atau Ditolak.

4. Status Izin Diperbarui
Sistem secara otomatis memperbarui status izin sesuai hasil verifikasi.
Siswa dapat melihat hasilnya melalui Dashboard atau halaman Ajukan Izin Siswa.

5. Pengelolaan Data oleh Admin
Admin dapat melakukan pencarian, filter data, serta export data untuk dokumentasi sekolah.
Selain itu, admin juga dapat mengelola akun pengguna melalui menu Manajemen User.