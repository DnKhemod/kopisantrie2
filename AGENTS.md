# AGENTS.md — Aturan Kerja Repository

Dokumen ini berlaku untuk kontributor manusia dan AI agent yang bekerja pada repository ini.

## 1. Baca Dulu

Sebelum mengubah kode:

1. `docs/ARCHITECTURE.md`
2. `docs/DATABASE.md`
3. `docs/DEVELOPMENT.md`
4. `docs/PRD.md`

Jika instruksi bertentangan dengan dokumen, tanyakan. Jangan mengubah arsitektur secara diam-diam.

## 2. Batas Ruang Lingkup

Jangan menambahkan:

- online ordering, cart, checkout, atau pembayaran;
- akun pelanggan atau database pelanggan;
- formulir kontak, newsletter, WhatsApp, atau integrasi media sosial;
- Google Maps atau peta interaktif;
- blog, journal, community, atau events;
- page builder atau editor layout bebas;
- plugin pihak ketiga tanpa persetujuan.

Fitur baru memerlukan persetujuan dan pembaruan dokumen.

## 3. Batas Arsitektur

- Theme hanya mengatur presentasi.
- Plugin hanya mengatur data dan logika konten terstruktur.
- Theme tidak boleh mendaftarkan CPT, taxonomy, atau meta.
- Theme tidak boleh membaca meta `_is_*` secara langsung. Gunakan Public API Plugin.
- Plugin tidak boleh memanggil fungsi Theme.
- Jangan mengedit WordPress core.
- Jangan menambah tabel database kustom.
- Jangan menggunakan Composer atau dependency runtime baru tanpa persetujuan.

## 4. Konvensi Kode

- PHP mengikuti WordPress Coding Standards.
- Prefix fungsi: `irama_santri_`.
- Prefix konstanta: `IRAMA_SANTRI_`.
- Prefix meta: `_is_`.
- Prefix option: `irama_santri_`.
- Text domain: `irama-santri`.
- Identifier kode dalam Bahasa Inggris.
- Label UI dan dokumentasi dalam Bahasa Indonesia.
- Gunakan tautan teks yang diterjemahkan, bukan string hardcode.

## 5. Keamanan

Setiap perubahan yang menyimpan data wajib:

- memeriksa capability;
- memverifikasi nonce;
- melakukan `wp_unslash()` sebelum sanitasi;
- menyanitasi input;
- meng-escape output sesuai konteks;
- tidak menulis secret ke repository.

Jangan menggunakan `$_POST`, `$_GET`, atau `$_REQUEST` mentah.

## 6. Frontend

- Gunakan Tailwind utility.
- Jangan menggunakan Tailwind Play CDN.
- Jangan mengedit `assets/css/app.css` secara manual; jalankan `npm run build`.
- Jangan menambahkan framework CSS atau JavaScript baru tanpa persetujuan.
- Pertahankan semantic HTML, hierarki heading, dan navigasi keyboard.
- Target aksesibilitas: WCAG 2.1 AA.
- Desain final belum disetujui. Jangan mengklaim tampilan sebagai final.

## 7. Alur Kerja

1. Buat branch dari `main`.
2. Lakukan perubahan kecil dan terfokus.
3. Jalankan `npm run build` jika mengubah Tailwind atau template.
4. Uji secara lokal.
5. Perbarui dokumentasi jika keputusan atau data berubah.
6. Ajukan pull request.

## 8. Verifikasi

Sebelum menyatakan pekerjaan selesai:

- [ ] `npm run build` berhasil.
- [ ] `php -l` bersih untuk file PHP yang diubah.
- [ ] Tidak ada error PHP atau console error.
- [ ] Tidak ada horizontal overflow pada desktop dan mobile.
- [ ] Navigasi keyboard berfungsi.
- [ ] Data admin tersimpan dan tampil dengan benar.
- [ ] Tidak ada file sensitif yang ikut ter-commit.

## 9. Dokumentasi

- Dokumentasi dalam Bahasa Indonesia.
- Setiap keputusan arsitektur baru dicatat di `docs/ARCHITECTURE.md`.
- Setiap perubahan struktur data dicatat di `docs/DATABASE.md`.
- Setiap perubahan tooling atau deployment dicatat di `docs/DEVELOPMENT.md`.
- Jangan menghapus riwayat keputusan tanpa alasan yang jelas.

## 10. Deployment

- Jangan push langsung ke produksi.
- Jangan mengedit file di server.
- Deployment mengikuti alur Local → Dev → Test → Live.
- Integrasi GitHub–Pantheon belum diverifikasi. Jangan menganggapnya otomatis.
