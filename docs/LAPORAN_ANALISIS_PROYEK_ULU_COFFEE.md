# SISTEM E-COMMERCE DAN POINT OF SALE (POS) PEMESANAN KOPI BERBASIS WEB PADA ULU COFFEE UNTUK MENDUKUNG DIGITALISASI UMKM

**PROGRAM STUDI INFORMATIKA**  
**FAKULTAS TEKNIK DAN ILMU KOMPUTER**  
**UNIVERSITAS TEKNOKRAT INDONESIA**  
**2026**

---

> **Tautan Akses Sistem Web (Aktif):**
> - 🌐 **Website Utama Pelanggan:** [http://localhost/ulu-coffee-web/](http://localhost/ulu-coffee-web/) (atau via server PHP: [http://localhost:8000/](http://localhost:8000/))
> - 🛒 **Katalog Menu:** [http://localhost/ulu-coffee-web/products.php](http://localhost/ulu-coffee-web/products.php)
> - 💻 **Panel Kasir (Point of Sale / POS):** [http://localhost/ulu-coffee-web/admin/pos.php](http://localhost/ulu-coffee-web/admin/pos.php)
> - 🛡️ **Dashboard Admin:** [http://localhost/ulu-coffee-web/admin/](http://localhost/ulu-coffee-web/admin/) *(Login: `admin@toko.com` / `admin123`)*
> - 📄 **Dokumen Analisis Cetak (A4):** [http://localhost/ulu-coffee-web/laporan_analisis_ulu_coffee.html](http://localhost/ulu-coffee-web/laporan_analisis_ulu_coffee.html)

---

### Disusun Oleh (Kelompok 2):

| No | Nama Lengkap | NPM | Peran Kelompok |
|:--:|:---|:---:|:---|
| 1 | **Andika Wijaya** | 23312095 | Leader |
| 2 | **M. Fathoni Maksum** | 23312018 | Executor |
| 3 | **Agung Pedro Zeboa** | 24312098 | Communicator |
| 4 | **Aji Bagus Dewantara** | 21312085 | Communicator |
| 5 | **Richard Ornando Nicholas** | 24312047 | Analyst |
| 6 | **Fathuddin Zaki** | 24312106 | Analyst |

---

## A. IDENTITAS PROYEK

### A.1 Judul Proyek
**Sistem E-Commerce dan Point of Sale (POS) Pemesanan Kopi Berbasis Web pada Ulu Coffee untuk Mendukung Digitalisasi UMKM.**

### A.2 Deskripsi Proyek
Proyek ini merupakan rancangan dan pengembangan sistem informasi berbasis web yang mengintegrasikan layanan e-commerce pemesanan mandiri bagi pelanggan dengan modul kasir digital (*Point of Sale* / POS) serta panel administrasi terpadu untuk kedai kopi **Ulu Coffee**. 

Sistem ini dirancang untuk menyelesaikan tantangan operasional kedai kopi konvensional dengan memfasilitasi pelanggan dalam mengeksplorasi katalog produk (kopi olahan, minuman non-kopi, makanan utama, dan makanan ringan/snack), memeriksa ketersediaan stok secara transparan, melakukan pemesanan melalui keranjang belanja (*shopping cart*), hingga menyelesaikan proses *checkout* dan konfirmasi pembayaran secara mandiri. Di sisi operasional bisnis, sistem menyediakan modul kasir (POS) yang responsif dan cepat guna memproses transaksi pelanggan langsung di tempat (*dine-in* maupun *takeaway*), sekaligus memberikan kemudahan bagi pemilik atau admin kafe dalam mengelola data menu, inventaris stok bahan/produk, pemantauan status pesanan, serta rekapitulasi data penjualan secara terorganisasi dan *real-time*.

### A.3 Target Pengguna
| Target Pengguna | Peran dan Kebutuhan |
|:---|:---|
| **Pelanggan (*Customer*)** | Mengakses informasi katalog menu dan harga terkini, memfilter produk berdasarkan kategori, mengelola keranjang belanja, melakukan pemesanan secara mandiri, memilih metode pembayaran dan pengiriman, serta memantau riwayat transaksi pemesanan. |
| **Kasir / Barista** | Melayani pemesanan langsung di tempat secara cepat menggunakan sistem kasir digital (*Point of Sale* / POS), menghitung total tagihan otomatis, memproses transaksi tunai/non-tunai, dan memantau antrean pesanan yang harus disajikan. |
| **Admin / Pemilik Kafe (*Owner*)** | Mengelola master data produk (tambah, perbarui harga, foto, deskripsi, dan stok), mengelola akun pengguna, memverifikasi status pembayaran dan pesanan pelanggan, serta mengelola pesan komunikasi pelanggan. |

### A.4 Keterkaitan dengan SDG
Proyek ini berkontribusi langsung pada pencapaian **Tujuan Pembangunan Berkelanjutan (SDG) 8: Pekerjaan Layak dan Pertumbuhan Ekonomi (*Decent Work and Economic Growth*)**, khususnya pada Target 8.3 yang menitikberatkan pada promosi kebijakan yang berorientasi pembangunan untuk mendukung produktivitas, penciptaan lapangan kerja yang layak, kewirausahaan, serta mendorong formalisasi dan pertumbuhan usaha mikro, kecil, dan menengah (UMKM) melalui pemanfaatan dan akses terhadap teknologi informasi dan komunikasi digital.

---

## B. ANALISIS MASALAH

### B.1 Kondisi Saat Ini
Ulu Coffee merupakan unit usaha mikro (UMKM) kedai kopi yang menyediakan aneka minuman kopi pilihan, non-kopi, dan kudapan pendamping. Saat ini, interaksi pemesanan dan operasional masih didominasi oleh metode konvensional:
1. **Pemesanan Manual di Tempat:** Pelanggan yang datang langsung (*walk-in*) harus mengantre di kasir untuk membaca daftar menu cetak, memilih minuman, dan menunggu kasir mencatat pesanan secara manual atau melalui catatan terpisah.
2. **Pemesanan Jarak Jauh via Media Sosial / WhatsApp:** Pelanggan yang ingin memesan untuk dibawa pulang (*takeaway*) atau dikirim kerap menanyakan daftar menu, harga terbaru, dan ketersediaan stok melalui pesan instan WhatsApp ke nomor kontak kedai. Berdasarkan observasi, admin sering kali membutuhkan waktu respon yang lama (*slow response*) terutama saat jam-jam ramai (*peak hours*), sehingga pelanggan kehilangan minat untuk bertransaksi.
3. **Pencatatan Penjualan dan Stok Terpisah:** Tidak adanya integrasi antara penjualan di meja kasir dengan pesanan yang masuk melalui saluran lain menyebabkan potensi perbedaan pencatatan stok fisik minuman/makanan, risiko pesanan terlewat, serta menyulitkan pemilik dalam menghitung omzet harian secara akurat.

### B.2 Masalah Utama
Bagaimana merancang dan mengimplementasikan sistem web terintegrasi yang mampu mempermudah pelanggan dalam memperoleh informasi menu dan memesan kopi secara mandiri, sekaligus menyediakan sistem kasir (POS) dan pengelolaan inventaris yang efisien bagi pengelola Ulu Coffee demi meminimalkan waktu tunggu dan meningkatkan akurasi transaksi.

### B.3 Kemungkinan Penyebab
- Belum adanya platform web resmi yang menyajikan etalase produk dan harga secara terpusat dan dapat diakses kapan saja oleh pelanggan.
- Proses transaksi dan komunikasi konfirmasi pesanan masih bergantung pada saluran pesan chat personal yang rentan tertimbun.
- Kasir masih memerlukan waktu ekstra untuk menjelaskan varian produk kepada pelanggan yang ragu di depan meja kasir saat antrean menumpuk.
- Pembukuan inventaris dan rekapitulasi data penjualan belum otomatis tersimpan dalam satu basis data terpusat (*centralized database*).

### B.4 Kemungkinan Dampak
- Waktu pelayanan di kasir menjadi lebih lambat dan antrean pelanggan pada jam sibuk memanjang.
- Potensi hilangnya peluang penjualan (*lost sales*) akibat pelanggan enggan menunggu balasan chat manual mengenai daftar menu dan harga.
- Tingginya risiko kesalahan pencatatan pesanan (*human error*) oleh barista atau kasir.
- Selisih antara jumlah stok riil dengan pembukuan manual yang menyulitkan perencanaan pengadaan bahan baku kopi.

### B.5 Bukti Pendukung
| Bukti / Informasi | Status | Kegunaan dan Batasan |
|:---|:---|:---|
| **Pengalaman Pemesanan Manual via WhatsApp** | Pengalaman pribadi & observasi pelanggan | Mengonfirmasi perlunya pelanggan bertanya harga/menu dan lamanya jeda waktu tunggu balasan admin. |
| **Observasi Alur Transaksi Kasir Saat Jam Ramai** | Pengamatan langsung di lokasi kedai | Menunjukkan terjadinya penumpukan antrean ketika kasir harus melayani pencatatan manual sekaligus konsultasi menu. |
| **Pengujian Arsitektur Sistem Eksisting (Ulu Coffee Web)** | Pengujian teknis basis data & kode | Menunjukkan bahwa struktur database (`products`, `orders`, `users`) dan modul POS telah mampu menangani siklus transaksi terintegrasi secara cepat. |
| **Wawancara dengan Barista & Pemilik Ulu Coffee** | Wawancara awal (perlu diperdalam) | Mengonfirmasi kebutuhan alat kasir digital yang ringan serta fitur pembaruan stok otomatis. |
| **Referensi Target SDG 8 PBB** | Dokumen rujukan sekunder resmi | Memberikan landasan teoretis dan justifikasi sosial-ekonomi digitalisasi UMKM lokal. |

---

## C. TUJUAN PROYEK

1. **Mengidentifikasi alur proses bisnis pemesanan** pada Ulu Coffee serta memetakan kendala operasional yang dialami pelanggan, kasir, dan pengelola.
2. **Merancang sistem e-commerce berbasis web** yang menyediakan etalase katalog menu kopi, non-kopi, makanan, dan snack dengan informasi harga, deskripsi, dan ketersediaan stok yang transparan.
3. **Membangun fitur transaksi mandiri bagi pelanggan**, meliputi penambahan ke keranjang belanja (*cart*), pengisian data pengiriman/meja (*checkout*), kalkulasi biaya otomatis, dan pemilihan metode pembayaran.
4. **Membangun sistem kasir digital (*Point of Sale* / POS)** yang cepat dan mudah digunakan oleh barista/kasir untuk mempercepat proses pencatatan transaksi langsung di kedai.
5. **Merancang panel kendali (*Admin Dashboard*)** untuk manajemen katalog produk, penyesuaian stok, pemantauan status pesanan masuk (*pending, diproses, selesai*), manajemen data pengguna, dan pesan kontak pelanggan.
6. **Menganalisis kelayakan sistem** dari sudut pandang teknis, operasional, ekonomi, jadwal pengerjaan, dan sumber daya demi menjamin kesiapan adopsi sistem secara berkelanjutan.

---

## D. KEBUTUHAN PROYEK

### D.1 Kebutuhan Fungsional
| No. | Modul / Kebutuhan | Prioritas | Alasan & Deskripsi |
|:---:|:---|:---:|:---|
| 1 | **Katalog Produk & Filter Kategori** | **Utama** | Menampilkan daftar seluruh produk (Kopi, Non Kopi, Makanan, Snack) disertai harga, foto, dan filter pencarian nama produk. |
| 2 | **Detail Produk & Keterangan Bahan** | **Utama** | Menyajikan rincian komposisi, ukuran kemasan/berat, serta indikator stok produk kepada pelanggan. |
| 3 | **Keranjang Belanja (*Shopping Cart*)** | **Utama** | Memungkinkan pelanggan menambahkan menu, mengubah jumlah kuantitas, menghapus item, dan menghitung subtotal belanja otomatis. |
| 4 | **Proses Checkout & Pengiriman** | **Utama** | Formulir pemesanan untuk mencatat nama pelanggan, nomor telepon, alamat tujuan, estimasi biaya kirim, dan catatan pesanan. |
| 5 | **Sistem Kasir (*Point of Sale* / POS)** | **Utama** | Antarmuka kasir khusus bagi barista untuk memilih menu sekali klik, menghitung tagihan, menerima pembayaran tunai/transfer, dan mencatat transaksi langsung. |
| 6 | **Manajemen Produk & Stok (Admin)** | **Utama** | Fitur CRUD (*Create, Read, Update, Delete*) bagi admin untuk menambah produk baru, memperbarui stok, dan menyunting harga. |
| 7 | **Pengelolaan Status Pesanan (*Order Tracking*)** | **Utama** | Memungkinkan admin memperbarui status pesanan (*Pending, Processing, Completed, Cancelled*) dan pelanggan dapat melihat status pesanannya. |
| 8 | **Autentikasi Akun Pengguna & Profil** | **Pendukung** | Fasilitas registrasi, login, lupa kata sandi (*forgot password*), serta pengaturan data profil pelanggan dan admin. |
| 9 | **Layanan Pesan Kontak & Saran** | **Pendukung** | Formulir bagi pelanggan untuk menyampaikan kritik, saran, atau pertanyaan yang langsung masuk ke panel admin kedai. |

### D.2 Kebutuhan Nonfungsional
- **Kemudahan Penggunaan (*Usability*):** Tampilan antarmuka (*User Interface*) mengusung prinsip kesederhanaan, visual menarik bertema kopi (*warm coffee tone*), dan alur belanja yang intuitif sehingga mudah dipahami pengguna awam.
- **Kompatibilitas Responsif (*Responsive Design*):** Sistem dapat diakses dengan lancar melalui berbagai peramban web (*web browser*) modern baik pada perangkat ponsel pintar (*smartphone*), tablet, laptop, maupun monitor kasir.
- **Keamanan Sistem (*Security*):** Penerapan otentikasi berbasis sesi (*session-based authentication*), pemisahan hak akses peran (*role-based authorization: admin vs customer*), serta enkripsi kata sandi menggunakan fungsi hashing standar industri (`password_hash`).
- **Kinerja & Kecepatan Akses (*Performance*):** Waktu respon muat halaman yang cepat (< 2 detik) dan eksekusi transaksi yang ringan menggunakan query basis data teroptimasi.
- **Integritas & Keandalan Data (*Data Integrity*):** Konsistensi pembaruan kuantitas stok otomatis saat pesanan dikonfirmasi guna mencegah terjadinya pemesanan ganda di luar stok fisik (*overselling*).

### D.3 Batasan Ruang Lingkup
Ruang lingkup proyek dibatasi pada:
- Penyediaan katalog menu digital, keranjang belanja, modul checkout pemesanan, dan pelacakan transaksi berbasis web.
- Modul Point of Sale (POS) untuk operasional kasir kafe secara lokal/online.
- Panel pengelolaan data produk, stok, pesanan, dan akun pengguna oleh administrator.
- Penyimpanan data menggunakan basis data relasional MySQL/MariaDB dengan mekanisme fallback data JSON untuk portabilitas lokal.
- *Ruang lingkup di luar tahap awal ini:* Integrasi otomatis gerbang pembayaran perbankan (*automated payment gateway*) dan integrasi API kurir ojek online pihak ketiga merupakan fitur masa depan yang akan dikaji setelah evaluasi operasional tahap pertama selesai dilakukan.

---

## E. STAKEHOLDER

| Stakeholder | Peran dalam Proyek | Kebutuhan / Kepentingan Utama | Pengaruh |
|:---|:---|:---|:---:|
| **Pelanggan (*Customer*)** | Pengguna akhir eksternal | Kemudahan memilih menu kopi, transparansi harga, pemesanan cepat tanpa antre panjang. | **Tinggi** |
| **Kasir & Barista** | Pengguna operasional internal | Alat kasir (POS) yang cepat, sederhana, minim klik, serta mempermudah pengecekan daftar racikan minuman. | **Tinggi** |
| **Pemilik Ulu Coffee (*Owner*)** | Pemilik bisnis / pemangku keputusan | Efisiensi biaya operasional, peningkatan omzet penjualan, serta transparansi laporan data stok dan keuangan. | **Tinggi** |
| **Tim Mahasiswa Pengembang** | Perancang dan pengembang sistem | Memenuhi target luaran akademik proyek, mengimplementasikan teknologi yang tepat guna, dan memvalidasi kebutuhan klien. | **Tinggi** |
| **Dosen Pengampu** | Pembimbing dan evaluator akademik | Menilai ketajaman analisis masalah, kepatuhan metodologi, kualitas kode aplikasi, serta pembagian kontribusi anggota tim. | **Tinggi** |

---

## F. ANALISIS KELAYAKAN

### F.1 Kelayakan Teknis
Proyek pengembangan sistem e-commerce dan POS Ulu Coffee dinilai **sangat layak secara teknis**. Arsitektur aplikasi dibangun menggunakan bahasa pemrograman **PHP**, server basis data **MySQL / MariaDB**, serta peramban web standar berbasis HTML5, CSS3 kustom, dan JavaScript vanilla tanpa ketergantungan library yang rumit. Stack teknologi ini terbukti stabil, memiliki dokumentasi yang sangat luas, mudah dijalankan di lingkungan lokal (*XAMPP / Apache*) maupun server hosting murah, serta menyediakan fleksibilitas arsitektur yang tinggi untuk kebutuhan penyesuaian di masa depan.

### F.2 Kelayakan Operasional
Sistem dinilai **layak secara operasional**. Antarmuka modul kasir (POS) dirancang dengan tata letak tombol kartu produk berukuran besar dan ringkasan keranjang yang jelas, sehingga barista maupun staf kasir baru dapat mengoperasikannya tanpa memerlukan pelatihan teknis yang rumit. Bagi pelanggan, sistem pemesanan menyerupai e-commerce populer sehingga alur belanja sudah sangat akrab di kalangan masyarakat pengguna ponsel pintar.

### F.3 Kelayakan Ekonomi
Pengembangan sistem ini memberikan nilai ekonomis yang tinggi dengan investasi modal yang sangat minim bagi pemilik usaha:

| Komponen Biaya | Pertimbangan & Sumber Daya | Estimasi Biaya |
|:---|:---|:---:|
| **Perangkat Keras Pengembangan** | Memanfaatkan komputer jinjing (*laptop*) yang telah dimiliki anggota tim. | Rp 0,- |
| **Perangkat Lunak & Perkakas Kode** | Menggunakan piranti lunak bebas dan bersumber terbuka (*Visual Studio Code, Git, XAMPP, PHP, MySQL*). | Rp 0,- |
| **Infrastruktur Hosting & Domain** | Menggunakan paket *shared hosting* lokal murah atau server lokal (*local server*) kedai untuk fase operasional awal. | Rp 250.000 – Rp 400.000 / tahun |
| **Biaya Pemeliharaan (*Maintenance*)** | Dikelola secara mandiri oleh tim pengembang mahasiswa selama masa uji coba. | Rp 0,- |

*Secara ekonomi, sistem mampu menekan biaya cetak ulang buku menu fisik setiap kali ada perubahan harga, menghemat waktu rekapitulasi harian, serta mencegah kerugian akibat salah pencatatan stok bahan baku.*

### F.4 Kelayakan Jadwal
Proyek direncanakan berlangsung selama **satu hingga dua bulan**, dibagi ke dalam 6 fase kegiatan terstruktur yang disesuaikan dengan kalender akademik semester:

| Tahap | Rencana Kegiatan Utama | Durasi Target |
|:---:|:---|:---:|
| **1** | Observasi operasional kedai, identifikasi masalah, dan analisis kebutuhan pengguna. | Minggu 1 – 2 |
| **2** | Perancangan arsitektur sistem, pemodelan basis data (*ERD*), dan alur data (*DFD/Flowchart*). | Minggu 2 – 3 |
| **3** | Perancangan antarmuka pengguna (*UI/UX Wireframing*) untuk halaman publik dan panel admin. | Minggu 3 – 4 |
| **4** | Pengembangan kode modul inti (Katalog, Keranjang/Checkout, Modul POS, Panel Admin). | Minggu 4 – 6 |
| **5** | Pengujian fungsional sistem (*Blackbox Testing*), perbaikan *bug*, dan uji coba langsung kasir. | Minggu 6 – 7 |
| **6** | Evaluasi hasil implementasi, penyusunan laporan akhir, dan serah terima dokumentasi sistem. | Minggu 7 – 8 |

### F.5 Kelayakan Sumber Daya
Kelompok terdiri dari enam mahasiswa Program Studi Informatika Universitas Teknokrat Indonesia (Kelompok 2) dengan pembagian peran dan tanggung jawab yang terdefinisi dengan jelas:

| Nama Anggota | Peran Tim | Rencana Kontribusi & Tanggung Jawab |
|:---|:---:|:---|
| **Andika Wijaya** | *Leader* | Mengkoordinasikan seluruh tahapan proyek, memimpin pembagian tugas, memonitor jadwal, dan mengintegrasikan hasil kerja modul sistem. |
| **M. Fathoni Maksum** | *Executor* | Mengkaji kelayakan teknis implementasi backend PHP, konfigurasi basis data MySQL, pengembangan modul transaksi, dan integrasi modul kasir POS. |
| **Agung Pedro Zeboa** | *Communicator* | Menjalin komunikasi dengan pihak pemilik dan staf Ulu Coffee, mengumpulkan kebutuhan lapangan, dan mengkoordinasikan sesi uji coba pengguna. |
| **Aji Bagus Dewantara** | *Communicator* | Menghimpun umpan balik pengguna, mendokumentasikan interaksi pelanggan, serta menyusun materi komunikasi dan presentasi proyek. |
| **Richard Ornando Nicholas** | *Analyst* | Menganalisis kondisi operasional eksisting, merumuskan akar masalah, mengidentifikasi kemungkinan dampak, dan memvalidasi bukti pendukung. |
| **Fathuddin Zaki** | *Analyst* | Memetakan peran stakeholder, menganalisis spesifikasi kebutuhan fungsional & nonfungsional, serta mengkaji kelayakan teknis, ekonomi, dan jadwal. |

---

## G. KESIMPULAN

Berdasarkan seluruh rangkaian analisis yang telah dipaparkan, proyek **Sistem E-Commerce dan Point of Sale (POS) Pemesanan Kopi Berbasis Web pada Ulu Coffee untuk Mendukung Digitalisasi UMKM** dinyatakan **sangat layak untuk dilanjutkan ke tahap perancangan dan implementasi penuh**.

Sistem ini menawarkan solusi nyata yang seimbang antara kemudahan akses bagi pelanggan (*customer-facing e-commerce*) dan efisiensi operasional bagi pengelola kedai (*merchant-facing POS & dashboard*). Penerapan sistem ini tidak hanya mengatasi hambatan antrean kasir dan keterlambatan respon pemesanan via chat, tetapi juga secara konkret mewujudkan kontribusi terhadap **SDG 8** dalam mendorong modernisasi dan penguatan daya saing usaha mikro lokal di era ekonomi digital.

**Rekomendasi tindak lanjut:**
1. Menyegerakan uji coba lapangan modul Point of Sale (POS) langsung di meja kasir Ulu Coffee untuk mendapatkan umpan balik kecepatan transaksi.
2. Memprioritaskan kestabilan pengelolaan stok agar tidak terjadi inkonsistensi data antara pesanan online dan transaksi langsung di kedai.
3. Melanjutkan proses evaluasi bertahap untuk perencanaan integrasi otomatis *payment gateway* dan notifikasi status pesanan secara berkala.
