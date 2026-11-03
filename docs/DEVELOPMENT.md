# DEVELOPMENT GUIDE — WEBSITE KEDAI KOPI IRAMA SANTRI

**Versi:** 1.0  
**Status:** Draft — siap review  
**Berdasarkan:** `ARCHITECTURE.md` 1.1  
**Terakhir diperbarui:** 3 November 2026  
**Bahasa:** Indonesia

---

## 1. Tujuan Dokumen

Panduan ini menjelaskan cara menyiapkan, menjalankan, membangun, dan men-deploy proyek.

Dokumen ini tidak menggantikan `ARCHITECTURE.md`. Jika ada konflik, `ARCHITECTURE.md` menjadi acuan.

---

## 2. Prasyarat

| Tool | Versi minimum | Catatan |
|---|---|---|
| Docker Desktop | Versi stabil terbaru | Wajib untuk DDEV di Windows/macOS |
| DDEV | 1.23+ | Menjalankan WordPress lokal |
| Node.js | 20 LTS atau lebih baru | Build Tailwind CSS |
| npm | 10+ | Termasuk Node.js |
| Git | 2.40+ | Version control |
| VS Code | Versi stabil | Editor yang disarankan |

Pemeriksaan:

```bash
docker --version
ddev version
node --version
npm --version
git --version
```

Di Windows, DDEV memerlukan WSL2. Pastikan Docker Desktop menggunakan WSL2 backend.

---

## 3. Struktur Repository

```text
kopisantrie/
├── docs/                         Dokumentasi proyek
├── wp-content/
│   ├── themes/irama-santri-theme/
│   └── plugins/irama-santri-core/
├── package.json                  Build Tailwind
├── .ddev/                        Konfigurasi lingkungan lokal
├── .gitignore
└── AGENTS.md
```

WordPress core belum disimpan di repository ini. Core akan disediakan saat site Pantheon dibuat atau diunduh untuk pengembangan lokal.

---

## 4. Setup Pertama

### 4.1 Clone Repository

```bash
git clone <url-github-private> kopisantrie
cd kopisantrie
```

### 4.2 Siapkan DDEV

```bash
ddev config --project-type=wordpress --docroot=. --php-version=8.3
ddev start
```

Jika `.ddev/config.yaml` sudah ada, cukup jalankan:

```bash
ddev start
```

### 4.3 Unduh dan Konfigurasi WordPress

```bash
ddev wp core download --locale=id_ID
ddev wp config create --dbname=db --dbuser=db --dbpass=db --dbhost=db --skip-check
ddev wp core install \
  --url=https://kopisantrie.ddev.site \
  --title="Kedai Kopi Irama Santri" \
  --admin_user=admin \
  --admin_password="<password-lokal-kuat>" \
  --admin_email="<email-lokal>"
```

Catatan:

- Jangan menggunakan password produksi di lingkungan lokal.
- `wp-config.php` tidak di-commit.
- Setelah core diunduh, file core akan muncul di root repository dan diabaikan oleh `.gitignore` selama fase scaffold.

### 4.4 Aktifkan Theme dan Plugin

```bash
ddev wp theme activate irama-santri-theme
ddev wp plugin activate irama-santri-core
```

### 4.5 Atur Permalink

```bash
ddev wp rewrite structure '/%postname%/' --hard
ddev wp rewrite flush --hard
```

### 4.6 Buat Halaman Awal

```bash
ddev wp post create --post_type=page --post_title="Home" --post_name="home" --post_status=publish
ddev wp post create --post_type=page --post_title="About" --post_name="about" --post_status=publish
ddev wp post create --post_type=page --post_title="Menu" --post_name="menu" --post_status=publish
ddev wp post create --post_type=page --post_title="Our Space" --post_name="our-space" --post_status=publish
ddev wp post create --post_type=page --post_title="Gallery" --post_name="gallery" --post_status=publish
ddev wp post create --post_type=page --post_title="Contact" --post_name="contact" --post_status=publish
```

Set homepage:

```bash
ddev wp option update show_on_front page
ddev wp option update page_on_front <ID_HOME>
```

Pemetaan halaman Menu dan Contact dilakukan melalui **Irama Santri → Info Kedai** di dashboard.

### 4.7 Build CSS

```bash
npm ci
npm run build
```

Buka site:

```bash
ddev launch
```

---

## 5. Perintah Harian

| Kebutuhan | Perintah |
|---|---|
| Menyalakan lingkungan | `ddev start` |
| Mematikan lingkungan | `ddev stop` |
| Membuka site | `ddev launch` |
| WP-CLI | `ddev wp <perintah>` |
| Shell container | `ddev ssh` |
| Build CSS produksi | `npm run build` |
| Watch CSS | `npm run dev` |
| Cek sintaks PHP | `ddev exec php -l wp-content/.../file.php` |
| Melihat log | `ddev logs -f` |
| Restart | `ddev restart` |

---

## 6. Alur Kerja Git

### 6.1 Branch

```text
main            → kondisi siap deploy
feat/<nama>     → fitur baru
fix/<nama>      → perbaikan
docs/<nama>     → dokumentasi
chore/<nama>    → tooling dan konfigurasi
```

Aturan:

- Jangan bekerja langsung di `main` untuk perubahan besar.
- Satu pull request sebaiknya fokus pada satu tujuan.
- Sertakan deskripsi perubahan dan cara pengujian.

### 6.2 Commit

Format yang disarankan:

```text
feat(catalog): tambah field harga varian
fix(theme): perbaiki enqueue CSS
docs(architecture): perjelas kontrak theme-plugin
chore(build): perbarui Tailwind
```

### 6.3 Sebelum Commit

- [ ] `npm run build` sudah dijalankan jika ada perubahan class Tailwind atau template.
- [ ] `ddev exec php -l` bersih untuk file PHP yang diubah.
- [ ] Tidak ada secret, `node_modules/`, atau file upload di staging.
- [ ] Perubahan data dicatat di `DATABASE.md` bila struktur berubah.
- [ ] Perubahan arsitektur dicatat di `ARCHITECTURE.md` bila keputusan berubah.

---

## 7. Build Tailwind

Source: `wp-content/themes/irama-santri-theme/src/css/app.css`  
Output: `wp-content/themes/irama-santri-theme/assets/css/app.css`

```bash
npm run dev      # watch
npm run build    # minify
```

Aturan:

- Output build di-commit.
- Jangan mengedit `assets/css/app.css` secara manual.
- Jangan menggunakan Tailwind Play CDN.
- Token warna dan font masih sementara sampai design system disetujui.
- Jika menambah file PHP baru di Theme, pastikan path `@source` mencakupnya.

---

## 8. Standar Kode

### 8.1 PHP

- Ikuti WordPress Coding Standards.
- Prefix semua fungsi global dengan `irama_santri_`.
- Gunakan text domain `irama-santri`.
- Escape output: `esc_html()`, `esc_attr()`, `esc_url()`, `wp_kses_post()`.
- Sanitasi input: `sanitize_text_field()`, `absint()`, `sanitize_textarea_field()`.
- Gunakan nonce dan capability untuk aksi admin.
- Jangan mengedit WordPress core.
- Jangan memanggil fungsi Theme dari Plugin.
- Jangan membaca meta mentah dari Theme; gunakan Public API Plugin.

### 8.2 CSS

- Gunakan utility Tailwind.
- Komponen berulang boleh memakai class di `app.css` dengan `@layer components`.
- Hindari `!important` kecuali untuk override yang terdokumentasi.
- Jangan menambahkan framework CSS lain.

### 8.3 JavaScript

- Vanilla JavaScript.
- Tanpa bundler pada versi pertama.
- Gunakan `defer` saat enqueue.
- Tidak ada dependency eksternal tanpa persetujuan.

### 8.4 Dokumentasi

- Dokumen dalam Bahasa Indonesia.
- Identifier kode dalam Bahasa Inggris.
- Label UI dalam Bahasa Indonesia.
- Setiap keputusan teknis baru dicatat di `ARCHITECTURE.md`.

---

## 9. Definition of Done

Sebuah perubahan dianggap selesai apabila:

- [ ] Fungsional sesuai kebutuhan PRD.
- [ ] Tidak menambah fitur di luar ruang lingkup.
- [ ] Input tervalidasi dan output ter-escape.
- [ ] Responsive pada desktop dan mobile.
- [ ] Tidak ada horizontal overflow.
- [ ] Navigasi keyboard berfungsi.
- [ ] Build CSS diperbarui.
- [ ] Tidak ada error PHP atau console error.
- [ ] Dokumentasi terkait diperbarui.
- [ ] Perubahan diuji di lingkungan lokal.

---

## 10. Deployment ke Pantheon

### 10.1 Sebelum Site Dibuat

Yang harus diverifikasi:

1. Plan Pantheon yang digunakan.
2. Dukungan integrasi GitHub.
3. Struktur upstream WordPress Pantheon.
4. Apakah core harus berada di repository.
5. Cara promosi Dev → Test → Live.

Jangan melakukan push pertama ke Pantheon sebelum poin di atas jelas.

### 10.2 Alur yang Direncanakan

```text
Local → Pull Request → GitHub main → Pantheon Dev → Pantheon Test → Pantheon Live
```

Langkah:

1. `npm run build`.
2. Commit output CSS.
3. Push branch ke GitHub.
4. Review dan merge ke `main`.
5. Deploy `main` ke Pantheon Dev.
6. Uji di Dev.
7. Promosikan ke Test.
8. QA dan persetujuan.
9. Promosikan ke Live.

### 10.3 Yang Tidak Boleh Dilakukan

- Push langsung ke Live tanpa melalui Test.
- Mengedit file langsung di server produksi.
- Meng-commit `wp-config.php` yang memuat secret.
- Meng-commit `wp-content/uploads/`.
- Mengandalkan build Node di Pantheon.

---

## 11. Backup dan Restore

Kebijakan minimum:

- Backup database mingguan.
- Backup file mingguan.
- Backup sebelum perubahan besar.
- Salinan eksternal di luar Pantheon.
- Uji restore, bukan hanya membuat backup.

Prosedur spesifik mengikuti kemampuan Pantheon dan ditetapkan sebelum produksi.

---

## 12. Troubleshooting

| Gejala | Kemungkinan penyebab | Tindakan |
|---|---|---|
| Halaman 404 setelah aktivasi plugin | Rewrite rules belum di-flush | `ddev wp rewrite flush --hard` |
| CSS tidak berubah | Build belum dijalankan atau cache | `npm run build`, hard refresh |
| Class Tailwind tidak terdeteksi | Path `@source` salah | Periksa `src/css/app.css` |
| Plugin aktif tetapi data kosong | Belum ada produk | Tambah produk di admin |
| Theme error setelah plugin nonaktif | Theme memanggil fungsi tanpa cek | Perbaiki dengan `function_exists()` |
| DDEV gagal start | Docker/WSL2 bermasalah | Restart Docker Desktop |
| Upload gagal | Permission atau ukuran file | Periksa log DDEV dan batas upload |

---

## 13. Checklist QA Manual

### Fungsional

- [ ] Homepage tampil.
- [ ] Navigasi desktop dan mobile berfungsi.
- [ ] Halaman Menu menampilkan produk per kategori.
- [ ] Detail produk menampilkan harga, varian, add-on, dan status.
- [ ] Produk tidak tersedia memiliki badge.
- [ ] Fasilitas tampil.
- [ ] Galeri tampil dan urutannya benar.
- [ ] Alamat dan jam operasional tampil.
- [ ] CTA mengarah ke halaman yang benar.

### Admin

- [ ] Produk dapat ditambah, diedit, dan dihapus.
- [ ] Harga dan varian dapat diubah.
- [ ] Add-on dapat diubah.
- [ ] Ketersediaan dan featured dapat diubah.
- [ ] Fasilitas dapat dikelola.
- [ ] Galeri dapat diurutkan.
- [ ] Info kedai dapat diperbarui.

### Nonfungsional

- [ ] Tidak ada horizontal overflow.
- [ ] Navigasi keyboard berfungsi.
- [ ] Kontras teks memadai.
- [ ] Gambar memiliki alt text.
- [ ] Lighthouse dijalankan pada desktop dan mobile.
- [ ] Tidak ada error PHP.
- [ ] Tidak ada console error.

---

## 14. Hal yang Belum Final

1. Versi PHP dan WordPress final mengikuti Pantheon.
2. Konfigurasi DDEV final setelah core tersedia.
3. Integrasi GitHub–Pantheon.
4. Strategi caching.
5. Backup eksternal dan retensi.
6. Alat linting dan CI.
7. Design tokens final.

**Status dokumen: Draft 1.0 — menunggu review.**
