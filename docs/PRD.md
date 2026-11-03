# PRODUCT REQUIREMENTS DOCUMENT (PRD)
## Website Kedai Kopi Irama Santri

**Versi:** 1.0  
**Status:** Draft — Menunggu Persetujuan  
**Platform:** WordPress  
**Domain:** kopisantrie.com  
**Development Approach:** Custom Theme + Custom Plugin

---

# 1. Product Overview

## 1.1 Deskripsi Produk

Website Kedai Kopi Irama Santri adalah website profil bisnis dan katalog produk berbasis WordPress.

Website menyediakan informasi mengenai brand, menu, fasilitas, galeri, dan lokasi kedai.

Pengunjung dapat melihat informasi produk dan harga, tetapi tidak dapat melakukan transaksi melalui website.

Pemilik kedai mengelola seluruh konten melalui dashboard WordPress.

## 1.2 Product Goals

- Membangun kehadiran digital resmi.
- Memperkuat brand awareness.
- Mempermudah pengunjung menemukan informasi menu.
- Memperkenalkan fasilitas dan suasana kedai.
- Mendorong kunjungan langsung ke lokasi.

## 1.3 User Types

### A. Visitor

Pengunjung website tanpa akun.

Hak akses:
- Melihat homepage.
- Membaca cerita kedai.
- Melihat katalog menu.
- Melihat detail produk.
- Melihat fasilitas.
- Melihat galeri.
- Melihat alamat dan jam operasional.

### B. Owner / Administrator

Pemilik kedai yang memiliki akses administrator.

Hak akses:
- Mengelola produk.
- Mengelola kategori.
- Mengelola harga dan variasi produk.
- Mengelola foto.
- Mengelola fasilitas.
- Mengelola galeri.
- Mengelola informasi kedai.
- Mengelola pilihan menu unggulan homepage.

Tidak ada akun khusus untuk pengunjung.

---

# 2. Sitemap dan Information Architecture

Struktur halaman:

```text
Website Irama Santri
│
├── Homepage
│
├── About
│   └── Cerita Kedai
│
├── Menu
│   ├── Kategori Coffee
│   ├── Kategori Non-Coffee
│   ├── Kategori Snacks
│   ├── Kategori Dessert / Pastry
│   └── Detail Menu
│
├── Our Space
│   └── Informasi Fasilitas
│
├── Gallery
│
└── Contact & Location
    ├── Alamat
    └── Jam Operasional
```

## 2.1 Navigasi Utama

Menu navigasi:

- Home
- About
- Menu
- Our Space
- Gallery
- Contact

Navigasi harus konsisten pada desktop dan mobile.

---

# 3. Functional Requirements

## 3.1 Homepage

### Tujuan
Memperkenalkan brand, konsep kedai, produk unggulan, dan fasilitas.

### Komponen

1. Header dan navigasi.
2. Hero section.
3. Headline dan deskripsi brand.
4. CTA Lihat Menu.
5. CTA Kunjungi Kedai.
6. Pengenalan konsep kedai.
7. Featured Menu.
8. Preview fasilitas.
9. Preview galeri.
10. Informasi alamat dan jam operasional.
11. Footer.

### Hero Section

Visual menggunakan kombinasi foto interior kedai dan foto produk.

CTA:
- Lihat Menu.
- Kunjungi Kedai.

### Featured Menu

Sistem harus menyediakan pilihan produk unggulan yang dapat dikelola administrator.

### Homepage Content Management

Administrator dapat:
- Memilih produk unggulan.
- Mengatur foto yang ditampilkan pada bagian tertentu.
- Mengubah tujuan CTA sesuai kebutuhan halaman yang tersedia.

Struktur layout dan komposisi visual dikendalikan melalui theme, bukan editor layout bebas.

---

## 3.2 About / Cerita Kedai

### Tujuan
Menyampaikan identitas, cerita, konsep, dan nilai brand.

### Komponen
- Judul halaman.
- Cerita kedai.
- Konsep Community Space.
- Nilai dan karakter brand.
- Foto pendukung.

Konten harus dapat diedit melalui dashboard WordPress.

---

## 3.3 Menu / Katalog Produk

### Tujuan
Menampilkan seluruh produk yang tersedia beserta harga dan informasi variasinya.

### Kategori

1. Coffee.
2. Non-Coffee.
3. Snacks / Light Bites.
4. Dessert / Pastry / Bakery.

### Product Card

Setiap produk menampilkan:

- Foto produk.
- Nama produk.
- Kategori.
- Harga dasar atau informasi rentang harga jika memiliki variasi.
- Deskripsi singkat.
- Penanda Featured jika dipilih.
- Status ketersediaan.

### Fitur Katalog

- Menampilkan produk berdasarkan kategori.
- Menampilkan seluruh produk.
- Mengakses halaman detail produk.
- Menampilkan produk unggulan.
- Menampilkan status tersedia atau tidak tersedia.

Filter atau pencarian katalog dapat ditambahkan apabila hasil evaluasi desain menunjukkan kebutuhan yang jelas. Fitur ini belum menjadi kewajiban pada versi pertama.

Tidak ada tombol beli, keranjang, checkout, maupun pembayaran.

---

## 3.4 Detail Menu

### Tujuan
Memberikan informasi lebih lengkap mengenai suatu produk.

### Data yang Ditampilkan

- Nama produk.
- Foto produk.
- Deskripsi lengkap.
- Kategori.
- Harga.
- Variasi ukuran.
- Variasi rasa.
- Add-on.
- Status ketersediaan.

Variasi yang tidak dimiliki produk tidak perlu ditampilkan.

Harga harus mudah dipahami dan tidak menimbulkan asumsi bahwa semua variasi memiliki harga yang sama.

---

## 3.5 Our Space / Fasilitas

### Fasilitas yang Ditampilkan

1. Wi-Fi.
2. Area outdoor.
3. Ruang diskusi.

### Data Fasilitas

- Nama fasilitas.
- Deskripsi.
- Foto.
- Urutan tampilan.

Administrator dapat mengelola informasi dan foto fasilitas.

---

## 3.6 Gallery

### Tujuan
Menampilkan suasana dan aktivitas visual kedai.

### Fitur

- Menampilkan koleksi foto.
- Mengunggah foto.
- Mengubah foto.
- Menghapus foto.
- Mengatur urutan tampilan.

Galeri menggunakan WordPress Media Library.

Tidak ada kebutuhan video gallery khusus pada versi pertama.

---

## 3.7 Contact & Location

### Informasi

**Alamat:**

Jln. Rawa Kelem Blok S. No. 72, Klayan, Gunungjati, Cirebon.

**Jam operasional:**

Setiap hari, 10.00–22.00 WIB.

### Ketentuan

- Alamat ditampilkan dalam bentuk teks.
- Jam operasional ditampilkan dengan jelas.
- Informasi dapat dikelola administrator.

Tidak ada formulir kontak, WhatsApp, Google Maps, atau peta interaktif.

---

# 4. WordPress Admin Requirements

## 4.1 Administrator

Pemilik kedai menjadi satu-satunya administrator konten.

Dashboard harus dibuat sesederhana mungkin.

Fokus UX dashboard:
- Navigasi jelas.
- Label menggunakan Bahasa Indonesia.
- Form input sederhana.
- Validasi input.
- Pesan sukses dan kesalahan yang jelas.
- Menghindari pengaturan teknis yang tidak diperlukan pemilik.

## 4.2 Product Management

Administrator dapat:

| Fitur | Kebutuhan |
|---|---|
| Tambah produk | Wajib |
| Edit nama produk | Wajib |
| Edit deskripsi | Wajib |
| Mengubah harga | Wajib |
| Mengelola harga variasi | Wajib |
| Upload foto | Wajib |
| Mengelola ukuran | Wajib |
| Mengelola rasa | Wajib |
| Mengelola add-on | Wajib |
| Mengatur ketersediaan | Wajib |
| Menandai featured | Wajib |
| Mengelola kategori | Wajib |
| Menghapus produk | Wajib |

### Struktur Data Produk

Rekomendasi struktur:

- Product ID.
- Product Name.
- Slug.
- Description.
- Main Image.
- Gallery Images jika diperlukan.
- Category.
- Base Price.
- Variants.
- Add-ons.
- Availability Status.
- Featured Status.
- Display Order.
- Created Date.
- Modified Date.

Struktur variasi harga harus mendukung produk yang memiliki harga berbeda berdasarkan ukuran atau opsi lain.

Nilai harga disimpan sebagai angka, bukan teks berformat mata uang.

Format rupiah diterapkan pada tampilan frontend.

## 4.3 Facility Management

Administrator dapat:
- Menambah fasilitas.
- Mengedit nama fasilitas.
- Mengedit deskripsi.
- Mengunggah foto.
- Menghapus fasilitas.
- Mengatur urutan tampilan.

## 4.4 Gallery Management

Administrator dapat:
- Mengunggah foto.
- Mengubah foto.
- Menghapus foto.
- Mengatur urutan foto.

## 4.5 Business Information Management

Administrator dapat mengelola:

- Alamat kedai.
- Jam operasional.

Nomor WhatsApp dan integrasi media sosial tidak menjadi bagian dari fitur versi pertama.

---

# 5. Technical Architecture

## 5.1 Technology Stack

| Layer | Teknologi |
|---|---|
| CMS | WordPress |
| Backend | PHP |
| Frontend | HTML |
| CSS Framework | Tailwind CSS |
| Interaction | Vanilla JavaScript |
| Database | Database yang dikelola Pantheon |
| Local Environment | DDEV |
| Code Editor | VS Code |
| Version Control | Git |
| Repository | GitHub Private |
| Hosting | Pantheon |

Versi PHP, WordPress, Node.js, dan Tailwind CSS akan ditetapkan berdasarkan kompatibilitas saat implementasi.

## 5.2 Architecture Approach

Menggunakan dua komponen utama:

### A. Custom WordPress Theme

Tanggung jawab:
- Struktur tampilan.
- Layout halaman.
- Komponen UI.
- Navigasi.
- Responsive design.
- Template katalog.
- Template detail produk.
- Integrasi data WordPress.

Theme tidak menjadi tempat penyimpanan utama logika bisnis katalog.

### B. Custom WordPress Plugin

Nama sementara:

`irama-santri-catalog`

Tanggung jawab:
- Registrasi Custom Post Type Produk.
- Registrasi Custom Taxonomy Kategori.
- Registrasi Custom Fields.
- Pengelolaan variasi produk.
- Pengelolaan add-on.
- Pengaturan status produk.
- Penanda featured.
- Pengelolaan fasilitas jika diperlukan.

Tujuannya menjaga data dan logika katalog tetap tersedia ketika theme diganti.

## 5.3 Data Architecture

### Product

Menggunakan Custom Post Type:

`product`

### Product Category

Menggunakan Custom Taxonomy:

`product_category`

Kategori awal:
- Coffee.
- Non-Coffee.
- Snacks.
- Dessert / Pastry / Bakery.

### Product Metadata

Rekomendasi metadata:

- Base Price.
- Variant Data.
- Add-on Data.
- Availability.
- Featured.
- Display Order.

### Facility

Dapat menggunakan Custom Post Type tersendiri jika kebutuhan pengelolaan fasilitas membutuhkan struktur data independen.

### Gallery

Menggunakan WordPress Media Library dan mekanisme pengelolaan urutan gambar.

Detail implementasi field dan format penyimpanan akan ditetapkan pada tahap technical design.

---

# 6. Proposed Project Structure

Struktur awal yang direkomendasikan:

```text
kopisantrie/
│
├── AGENTS.md
├── README.md
├── .gitignore
│
├── docs/
│   ├── BRIEF.md
│   ├── PRD.md
│   ├── ARCHITECTURE.md
│   └── DATABASE.md
│
├── wp-content/
│   │
│   ├── themes/
│   │   └── irama-santri-theme/
│   │       ├── assets/
│   │       │   ├── css/
│   │       │   ├── js/
│   │       │   └── images/
│   │       ├── inc/
│   │       ├── template-parts/
│   │       ├── templates/
│   │       ├── functions.php
│   │       ├── style.css
│   │       └── theme.json
│   │
│   └── plugins/
│       └── irama-santri-catalog/
│           ├── includes/
│           ├── admin/
│           ├── assets/
│           └── irama-santri-catalog.php
│
└── package.json
```

Struktur ini merupakan rancangan awal. Penyesuaian akan dilakukan mengikuti struktur proyek WordPress dan konfigurasi DDEV/Pantheon.

Folder proyek dan file konfigurasi DDEV akan disiapkan saat inisialisasi repository.

---

# 7. Design Requirements

## 7.1 Design Direction

Konsep:

**Warm & Cozy Modern Coffee Shop**

Karakter:
- Warm.
- Clean.
- Modern.
- Cozy.
- Inclusive.
- Community-oriented.

## 7.2 Color Direction

Rekomendasi:
- Cream / Beige sebagai warna dasar.
- Brown sebagai warna pendukung.
- Accent color menyesuaikan logo.

Nilai warna final belum ditetapkan dan harus melalui persetujuan design system.

## 7.3 Typography

Menggunakan kombinasi tipografi:
- Heading yang memiliki karakter.
- Body text yang mudah dibaca.
- Skala tipografi konsisten.

Font final ditentukan pada tahap design system.

## 7.4 Responsive Design

Desktop dan mobile memiliki prioritas yang sama.

Breakpoints akan ditentukan saat implementasi.

Persyaratan:
- Tidak ada horizontal overflow.
- Navigasi mudah digunakan.
- Foto tidak terdistorsi.
- Teks tetap terbaca.
- Tombol memiliki area interaksi yang memadai.
- Komponen katalog menyesuaikan lebar layar.

## 7.5 Design Workflow

Menggunakan pendekatan Hybrid:

1. Wireframe.
2. Design System.
3. Visual Design.
4. Review dan approval.
5. Frontend implementation.
6. Visual QA.

Tidak ada coding frontend sebelum arah wireframe dan design system disetujui.

---

# 8. SEO Requirements

Target: Basic SEO.

Persyaratan:

- SEO title.
- Meta description.
- Heading hierarchy H1–H3.
- Semantic HTML.
- SEO-friendly permalink.
- XML sitemap.
- robots.txt.
- Image alt text.
- Image optimization.
- Internal linking yang relevan.

SEO schema khusus dan strategi konten jangka panjang belum menjadi bagian versi pertama.

---

# 9. Performance Requirements

Target: Optimal.

Implementasi:

- Tailwind CSS dikompilasi menjadi CSS produksi.
- Tidak menggunakan Tailwind Play CDN pada production.
- CSS dan JavaScript diminifikasi.
- Gambar dikompresi.
- WebP/AVIF digunakan jika kompatibel.
- Lazy loading untuk gambar non-kritis.
- Caching sesuai lingkungan Pantheon.
- Menghindari plugin berlebihan.
- Memperhatikan Core Web Vitals.

Pengujian dilakukan menggunakan Google Lighthouse pada desktop dan mobile.

Targetnya meningkatkan performa secara terukur, bukan menjanjikan skor tertentu sebelum pengujian.

---

# 10. Security Requirements

Target: Standard Managed Security.

Persyaratan:

- SSL/HTTPS.
- Password administrator kuat.
- Pembatasan akses administrator.
- Proteksi percobaan login.
- Pembaruan WordPress.
- Pembaruan theme dan plugin.
- Validasi dan sanitasi input.
- Escape output.
- Nonce untuk aksi administratif yang relevan.
- Penggunaan WordPress API sesuai standar.
- Menghindari plugin yang tidak diperlukan.

Tidak menyimpan kredensial, password, atau API key dalam repository GitHub.

---

# 11. Backup Requirements

Kebijakan backup:

1. Backup database setiap minggu.
2. Backup file website setiap minggu.
3. Backup tambahan sebelum perubahan besar.
4. Backup harus dapat dipulihkan.
5. Salinan backup eksternal direkomendasikan.

Mekanisme backup perlu disesuaikan dengan kemampuan dan kebijakan Pantheon.

Lokasi penyimpanan eksternal, retensi, serta prosedur restore akan ditetapkan saat konfigurasi infrastruktur.

---

# 12. Development and Deployment Workflow

## 12.1 Local Development

Tools:
- DDEV.
- Docker.
- VS Code.
- Git.
- Node.js untuk build Tailwind CSS.

Tahapan:
- Membuat proyek WordPress lokal.
- Menyiapkan custom theme.
- Menyiapkan custom plugin.
- Mengembangkan dan menguji fitur.
- Mengelola perubahan menggunakan Git.

## 12.2 Pantheon Workflow

Alur pengembangan:

```text
Local Development
       |
       v
Pantheon Dev
       |
       v
Pantheon Test
       |
       v
Pantheon Live
```

### Local

Tempat pengembangan dan pengujian awal.

### Dev

Tempat integrasi kode dan pengujian awal pada Pantheon.

### Test

Tempat pengujian sebelum publikasi.

### Live

Lingkungan produksi yang digunakan pengunjung.

## 12.3 GitHub

Repository menggunakan private visibility.

Tujuan:
- Version control.
- Riwayat perubahan.
- Backup kode sumber.
- Pengelolaan branch.
- Review perubahan.

GitHub dan Pantheon memiliki alur repository masing-masing. Mekanisme sinkronisasi atau deployment harus dikonfigurasi dan diverifikasi saat implementasi, bukan diasumsikan otomatis.

---

# 13. Acceptance Criteria

## 13.1 Homepage

- [ ] Hero menampilkan foto kedai dan produk.
- [ ] Headline memperkenalkan brand.
- [ ] CTA Lihat Menu berfungsi.
- [ ] CTA Kunjungi Kedai mengarah ke informasi lokasi.
- [ ] Featured menu dapat dikelola administrator.
- [ ] Informasi fasilitas tampil.
- [ ] Homepage responsif.

## 13.2 Katalog

- [ ] Produk dapat ditambahkan.
- [ ] Produk dapat diedit.
- [ ] Produk dapat dihapus.
- [ ] Kategori dapat dikelola.
- [ ] Harga dapat diperbarui.
- [ ] Variasi harga dapat dikelola.
- [ ] Add-on dapat dikelola.
- [ ] Status ketersediaan dapat diubah.
- [ ] Featured dapat diatur.
- [ ] Detail produk dapat dibuka.

## 13.3 Fasilitas dan Galeri

- [ ] Informasi fasilitas dapat dikelola.
- [ ] Foto fasilitas dapat diunggah.
- [ ] Foto galeri dapat ditambah.
- [ ] Foto galeri dapat diedit atau dihapus.
- [ ] Urutan foto dapat diatur.

## 13.4 Informasi Kedai

- [ ] Alamat tampil benar.
- [ ] Jam operasional tampil benar.
- [ ] Informasi dapat diperbarui administrator.

## 13.5 Responsive and Performance

- [ ] Tidak ada horizontal overflow.
- [ ] Tampilan desktop sesuai design system.
- [ ] Tampilan mobile sesuai design system.
- [ ] Gambar teroptimasi.
- [ ] CSS/JS produksi terkompilasi.
- [ ] Pengujian Lighthouse dilakukan.

## 13.6 Security and Deployment

- [ ] HTTPS aktif.
- [ ] Akses administrator terlindungi.
- [ ] Input administratif tervalidasi.
- [ ] Backup berjalan sesuai kebijakan.
- [ ] Website lulus pengujian di Pantheon Test.
- [ ] Deployment Live dilakukan setelah persetujuan.

---

# 14. Out of Scope

Fitur berikut tidak termasuk dalam versi pertama:

- E-commerce.
- Online ordering.
- Cart dan checkout.
- Payment gateway.
- Delivery management.
- Table reservation.
- WhatsApp integration.
- Contact form.
- Newsletter.
- Customer account.
- Customer database.
- Social media feed/integration.
- Google Maps integration.
- Community & Events.
- Journal / Blog.

Penambahan fitur memerlukan evaluasi ruang lingkup dan persetujuan terpisah.

---

# 15. Risks and Dependencies

| Risiko / Ketergantungan | Penanganan |
|---|---|
| WordPress belum dibuat di Pantheon | Membuat site sebelum integrasi deployment |
| Domain belum diverifikasi ke Pantheon | Memeriksa DNS dan konfigurasi domain |
| Aset foto belum lengkap | Memeriksa kualitas dan kelengkapan aset |
| Brand guideline belum tersedia | Membuat design system berdasarkan logo dan arah visual |
| Tailwind build belum disiapkan | Menyiapkan pipeline build CSS |
| Backup eksternal belum ditentukan | Memilih lokasi dan mekanisme backup |
| Perbedaan local dan Pantheon | Menggunakan DDEV dan melakukan pengujian pada Dev/Test |

---

# 16. Open Decisions

Hal-hal berikut belum boleh dianggap final:

1. Tagline resmi brand.
2. Warna dan font final design system.
3. Detail field variasi produk dan add-on.
4. Mekanisme penyimpanan backup eksternal.
5. Konfigurasi DNS dan domain Pantheon.
6. Mekanisme sinkronisasi GitHub dan Pantheon.
7. Detail konfigurasi caching.
8. Ketersediaan dan kelengkapan foto final.

Keputusan ini akan diselesaikan pada tahap desain atau technical planning sesuai konteksnya.

---

# 17. Project Phases

Tahapan proyek yang direkomendasikan:

### Phase 1 — Discovery & Documentation
- BRIEF.md.
- PRD.md.
- Review dan approval.

### Phase 2 — Technical Planning
- ARCHITECTURE.md.
- DATABASE.md.
- AGENTS.md.
- Setup repository.
- Setup DDEV.

### Phase 3 — UI/UX Design
- Wireframe.
- Design System.
- High-Fidelity Design.
- Design Review.

### Phase 4 — WordPress Foundation
- Instalasi WordPress.
- Custom Theme.
- Custom Plugin.
- Integrasi Tailwind CSS.

### Phase 5 — Feature Development
- Homepage.
- Halaman informasi.
- Katalog.
- Detail produk.
- Dashboard admin.
- Fasilitas dan galeri.

### Phase 6 — QA & Optimization
- Functional testing.
- Responsive testing.
- Security checks.
- SEO checks.
- Performance optimization.

### Phase 7 — Deployment
- Pantheon Dev.
- Pantheon Test.
- Pantheon Live.
- Final verification.

---

**Akhir Dokumen PRD.md**
