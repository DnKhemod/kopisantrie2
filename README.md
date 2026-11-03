# Kedai Kopi Irama Santri — Website

Website profil bisnis dan katalog produk Kedai Kopi Irama Santri.

- Domain: https://kopisantrie.com
- CMS: WordPress
- Theme: `irama-santri-theme` (classic theme)
- Plugin: `irama-santri-core`
- Frontend: Tailwind CSS + vanilla JavaScript
- Hosting: Pantheon

## Status

Tahap **arsitektur dan fondasi**. Dokumen arsitektur sudah diperbaiki, struktur repository sudah dibangun, dan data layer dasar sudah tersedia. Desain visual dan template halaman final menunggu persetujuan design system.

## Dokumentasi

| Dokumen | Isi |
|---|---|
| [`docs/BRIEF.md`](docs/BRIEF.md) | Latar belakang bisnis dan ruang lingkup |
| [`docs/PRD.md`](docs/PRD.md) | Kebutuhan produk dan kriteria penerimaan |
| [`docs/ARCHITECTURE.md`](docs/ARCHITECTURE.md) | Arsitektur teknis, kontrak Theme–Plugin, deployment |
| [`docs/DATABASE.md`](docs/DATABASE.md) | Struktur data produk, fasilitas, galeri, info kedai |
| [`docs/DEVELOPMENT.md`](docs/DEVELOPMENT.md) | Setup lokal, build, Git, deployment, QA |
| [`AGENTS.md`](AGENTS.md) | Aturan kerja untuk kontributor dan AI agent |

## Struktur

```text
kopisantrie/
├── docs/
├── wp-content/
│   ├── themes/irama-santri-theme/
│   └── plugins/irama-santri-core/
├── package.json
└── .ddev/
```

## Mulai Cepat

```bash
ddev start
ddev wp core download --locale=id_ID
ddev wp config create --dbname=db --dbuser=db --dbpass=db --dbhost=db --skip-check
ddev wp core install --url=https://kopisantrie.ddev.site --title="Kedai Kopi Irama Santri" --admin_user=admin --admin_password="<password-lokal>" --admin_email="<email-lokal>"
ddev wp theme activate irama-santri-theme
ddev wp plugin activate irama-santri-core
ddev wp rewrite structure '/%postname%/' --hard
npm ci
npm run build
ddev launch
```

Panduan lengkap: [`docs/DEVELOPMENT.md`](docs/DEVELOPMENT.md).

## Perintah Build

```bash
npm run dev      # watch Tailwind
npm run build    # CSS produksi (minify)
```

Output build di-commit ke `wp-content/themes/irama-santri-theme/assets/css/app.css`.

## Ruang Lingkup

Termasuk: profil bisnis, katalog menu, detail produk, fasilitas, galeri, lokasi, SEO dasar, responsive design.

Tidak termasuk: online ordering, cart, checkout, pembayaran, reservasi, formulir, WhatsApp, peta interaktif, akun pelanggan, blog.
