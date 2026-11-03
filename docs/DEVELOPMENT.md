# DEVELOPMENT GUIDE — WEBSITE KEDAI KOPI IRAMA SANTRI

**Versi:** 1.1  
**Status:** Draft — siap review  
**Berdasarkan:** `ARCHITECTURE.md` 1.1, `DATABASE.md` 1.1, dan `PRD.md` 1.0  
**Terakhir diperbarui:** 4 November 2026  
**Bahasa:** Indonesia

---

## 1. Tujuan dan Batas

Panduan ini menjelaskan setup lokal, pengembangan, build aset, Git, dan alur deployment yang direncanakan. Panduan ini tidak menggantikan `ARCHITECTURE.md`, `DATABASE.md`, atau `AGENTS.md`.

Repository saat ini adalah scaffold WordPress: kode theme dan plugin tersedia, tetapi WordPress Core dan database lokal belum disertakan. Konfigurasi Pantheon, domain, dan sinkronisasi GitHub–Pantheon juga belum diverifikasi. Ikuti langkah setup terlebih dahulu sebelum membuka situs lokal.

## 2. Prasyarat

| Tool | Versi/profil proyek | Kegunaan |
|---|---|---|
| Docker Desktop | Versi stabil; WSL2 backend di Windows | Runtime container DDEV |
| DDEV | 1.23+ | Web server, database, dan WP-CLI lokal |
| PHP | 8.3 di konfigurasi DDEV saat ini | WordPress dan plugin |
| Node.js | 20+ | Build Tailwind CSS |
| npm | 10+ | Dependency build |
| Git | 2.40+ | Version control |
| VS Code | Opsional | Editor |

Periksa instalasi:

```bash
docker --version
ddev version
node --version
npm --version
git --version
```

Di Windows, pastikan Docker Desktop berjalan dengan backend WSL2 dan DDEV sudah dikonfigurasi untuk WSL2.

## 3. Bentuk Repository

```text
kopisantrie/
├── .ddev/config.yaml
├── docs/
├── package.json
├── wp-content/
│   ├── themes/irama-santri-theme/
│   └── plugins/irama-santri-core/
└── AGENTS.md
```

WordPress Core belum dilacak di repository. `.gitignore` mengabaikan berkas Core selama fase scaffold, konfigurasi lokal, uploads, dependency, dan secret. Jangan mengubah strategi ini untuk deployment sebelum struktur repository Pantheon diputuskan.

## 4. Setup Lokal Pertama

### 4.1 Ambil Repository

Gunakan URL private repository yang diberikan pemilik proyek:

```bash
git clone <url-github-private> kopisantrie
cd kopisantrie
git status --short --branch
```

Branch dasar aktif saat panduan ini disusun adalah `master`. Buat branch perubahan dari `master`, kecuali repository kemudian secara eksplisit dipindahkan ke `main`.

### 4.2 Siapkan DDEV

File `.ddev/config.yaml` sudah ada. Periksa bahwa project type adalah WordPress, PHP 8.3, dan document root mengarah ke root repository setelah WordPress Core dipasang.

Jika document root belum sesuai, konfigurasi ulang:

```bash
ddev config --project-type=wordpress --docroot=. --php-version=8.3
ddev start
```

Jika sudah sesuai, cukup:

```bash
ddev start
```

Jangan commit `config.local.yaml` atau `.ddev/.env`.

### 4.3 Pasang Dependency CSS

`package-lock.json` belum tersedia pada scaffold yang diperiksa. Pada checkout pertama, jalankan `npm install` untuk membuat lockfile dan memasang dependency; review lalu commit `package-lock.json`. Setelah lockfile tersedia, gunakan `npm ci` untuk instalasi yang dapat direproduksi.

```bash
npm install
npm run build
```

Build membuat `wp-content/themes/irama-santri-theme/assets/css/app.css`. Output ini harus di-commit karena Pantheon tidak menjalankan build Node saat deploy. Jangan mengedit output CSS secara manual.

### 4.4 Unduh dan Pasang WordPress Lokal

Pastikan DDEV aktif, lalu jalankan:

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

Gunakan password lokal yang unik; jangan menyalin kredensial produksi. `wp-config.php` tidak di-commit.

### 4.5 Aktifkan Theme dan Plugin

```bash
ddev wp theme activate irama-santri-theme
ddev wp plugin activate irama-santri-core
ddev wp rewrite structure '/%postname%/' --hard
ddev wp rewrite flush --hard
```

### 4.6 Buat Halaman Dasar

Buat halaman yang diperlukan oleh sitemap:

```bash
ddev wp post create --post_type=page --post_title="Home" --post_name="home" --post_status=publish
ddev wp post create --post_type=page --post_title="About" --post_name="about" --post_status=publish
ddev wp post create --post_type=page --post_title="Menu" --post_name="menu" --post_status=publish
ddev wp post create --post_type=page --post_title="Our Space" --post_name="our-space" --post_status=publish
ddev wp post create --post_type=page --post_title="Gallery" --post_name="gallery" --post_status=publish
ddev wp post create --post_type=page --post_title="Contact" --post_name="contact" --post_status=publish
ddev wp post list --post_type=page --fields=ID,post_title,post_name
```

Gunakan ID halaman Home dari hasil daftar untuk menetapkan homepage:

```bash
ddev wp option update show_on_front page
ddev wp option update page_on_front <ID_HOME>
```

Pilih halaman Menu dan Contact pada **Irama Santri → Info Kedai**. Template menggunakan slug halaman yang dijelaskan di `ARCHITECTURE.md`.

### 4.7 Buka Situs Lokal

```bash
ddev launch
```

## 5. Perintah Harian

| Kebutuhan | Perintah |
|---|---|
| Menyalakan/mematikan lokal | `ddev start` / `ddev stop` |
| Membuka situs | `ddev launch` |
| WP-CLI | `ddev wp <perintah>` |
| Shell web container | `ddev ssh` |
| Build CSS produksi | `npm run build` |
| Watch CSS | `npm run dev` |
| Periksa PHP | `ddev exec php -l wp-content/.../file.php` |
| Log DDEV | `ddev logs -f` |

## 6. Alur Perubahan dan Git

### 6.1 Branch

Branch dasar aktif adalah `master`. Gunakan branch terfokus:

```text
feat/<nama>
fix/<nama>
docs/<nama>
chore/<nama>
```

Contoh:

```bash
git switch master
git pull
git switch -c docs/development-guide
```

Jangan bekerja langsung di branch dasar untuk perubahan besar. Satu pull request sebaiknya memuat satu tujuan dan menjelaskan perubahan serta verifikasinya.

### 6.2 Commit

Gunakan pesan commit singkat dan terarah:

```text
docs(database): selaraskan aturan query featured
chore(build): tambahkan lockfile npm
feat(catalog): tambah pengelolaan harga varian
```

Sebelum commit, periksa `git status` dan pastikan tidak ada secret, `node_modules/`, uploads, database dump, atau konfigurasi lokal.

## 7. Build Tailwind

- Source: `wp-content/themes/irama-santri-theme/src/css/app.css`
- Output: `wp-content/themes/irama-santri-theme/assets/css/app.css`
- Watch: `npm run dev`
- Build produksi: `npm run build`

Tailwind Play CDN tidak digunakan. Jika template PHP baru memakai utility class, pastikan file tersebut tercakup oleh source scanning Tailwind, kemudian build ulang. Commit hasil CSS bersama perubahan source.

## 8. Konvensi Kode

### PHP

- Ikuti WordPress Coding Standards dan `AGENTS.md`.
- Fungsi global memakai prefix `irama_santri_`; konstanta memakai `IRAMA_SANTRI_`.
- Plugin menyimpan data; theme hanya membaca data lewat Public API plugin.
- Periksa capability dan nonce; panggil `wp_unslash()` sebelum sanitasi; escape output sesuai konteks.
- Jangan mengedit WordPress Core atau menambah tabel kustom.

### Frontend

- Classic Theme dengan template PHP; layout tidak dibangun melalui page builder.
- Gunakan utility Tailwind dan JavaScript minimal.
- Pertahankan semantic HTML, fokus keyboard, dan responsive desktop/mobile.
- Design tokens masih sementara sampai design system disetujui.

### Dokumentasi

- Dokumen berbahasa Indonesia; identifier kode berbahasa Inggris.
- Perubahan model data dicatat di `DATABASE.md`.
- Perubahan arsitektur dicatat di `ARCHITECTURE.md`.
- Perubahan build, tooling, atau deployment dicatat di dokumen ini.

## 9. Checklist Penyelesaian Perubahan

Sebelum menganggap perubahan siap direview:

- [ ] Perilaku sesuai BRIEF, PRD, dan keputusan arsitektur.
- [ ] Tidak menambah fitur di luar ruang lingkup.
- [ ] Input tervalidasi dan output di-escape.
- [ ] Layout responsif dan dapat digunakan dengan keyboard.
- [ ] Build CSS diperbarui jika template/class Tailwind berubah.
- [ ] Sintaks PHP bersih untuk file PHP yang diubah.
- [ ] Dokumentasi terkait diperbarui.
- [ ] Tidak ada secret, uploads, database dump, atau `node_modules/` yang ikut di-commit.

## 10. Deployment Pantheon

Integrasi GitHub–Pantheon, struktur upstream, dan site Pantheon belum diverifikasi. Jangan menganggap push GitHub otomatis men-deploy ke Pantheon.

Alur tujuan setelah site dan integrasi diverifikasi:

```text
Local → Pull Request → GitHub → Pantheon Dev → Pantheon Test → Pantheon Live
```

Sebelum deployment pertama, konfirmasi plan Pantheon, repository/upstream, docroot, metode promosi kode dan database, domain/DNS, HTTPS, serta strategi backup. Jangan push langsung ke Live, jangan edit file produksi melalui server, dan jangan menyimpan kredensial produksi di Git.

## 11. Backup dan Restore

Sebelum produksi:

- Tetapkan backup mingguan database dan file.
- Buat backup sebelum perubahan besar.
- Tentukan salinan eksternal, retensi, dan siapa yang dapat memulihkan.
- Uji pemulihan backup; keberadaan arsip saja belum membuktikan backup dapat dipakai.

Rincian layanan dan lokasi backup masih menunggu keputusan infrastruktur.

## 12. Troubleshooting

| Gejala | Periksa |
|---|---|
| `ddev start` gagal | Docker Desktop/WSL2, status DDEV, lalu `ddev logs` |
| 404 pada detail produk | Permalink dan rewrite rules; jalankan `ddev wp rewrite flush --hard` |
| Perubahan CSS tidak terlihat | Jalankan `npm run build`, lalu bersihkan cache browser |
| Class Tailwind tidak muncul | Periksa path source scanner di `src/css/app.css` dan ulangi build |
| Menu kosong | Periksa produk berstatus publish dan kategori produk |
| Admin plugin tidak tampil | Pastikan plugin aktif dan akun punya capability administrator |
| Gambar gagal tampil | Periksa Media Library, attachment ID, dan ukuran gambar |

## 13. Verifikasi Sebelum Produksi

Checklist QA rinci ada di `ARCHITECTURE.md` dan acceptance criteria di `PRD.md`. Verifikasi fungsional, responsive, aksesibilitas, keamanan, SEO, backup/restore, dan deployment dilakukan pada environment lokal dan Pantheon Test sebelum promosi ke Live.

Jangan menjanjikan skor Lighthouse tertentu sebelum pengukuran pada environment produksi yang representatif.

## 14. Keputusan yang Masih Menunggu

1. Pembuatan site dan konfigurasi repository Pantheon.
2. Sinkronisasi GitHub–Pantheon dan nama branch deploy.
3. Versi WordPress final sesuai Pantheon.
4. Domain, DNS, dan SSL.
5. Backup eksternal dan retensi.
6. Linting/CI dan aturan proteksi branch.
7. Design tokens dan aset final.

**Status dokumen: Draft 1.1 — menunggu review.**
