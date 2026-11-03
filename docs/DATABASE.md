# DATABASE DESIGN — WEBSITE KEDAI KOPI IRAMA SANTRI

**Versi:** 1.0  
**Status:** Draft — siap review  
**Berdasarkan:** `ARCHITECTURE.md` 1.1 dan `PRD.md` 1.0  
**Terakhir diperbarui:** 3 November 2026  
**Bahasa:** Indonesia

---

## 1. Tujuan Dokumen

Dokumen ini menetapkan struktur data Website Kedai Kopi Irama Santri menggunakan API WordPress.

Prinsip:

- Tidak ada tabel database kustom pada versi pertama.
- Data produk menggunakan Custom Post Type, taxonomy, dan post meta.
- Data fasilitas menggunakan Custom Post Type.
- Data galeri dan info kedai menggunakan option.
- Harga disimpan sebagai integer rupiah.
- Semua input divalidasi dan disanitasi sebelum disimpan.
- Semua output di-escape sesuai konteks.

---

## 2. Ringkasan Penyimpanan

| Data | Media | Nama | Tipe |
|---|---|---|---|
| Produk | Post type | `product` | CPT |
| Kategori produk | Taxonomy | `product_category` | Hierarchical taxonomy |
| Harga dasar | Post meta | `_is_base_price` | Integer |
| Varian | Post meta | `_is_variants` | JSON string |
| Add-on | Post meta | `_is_addons` | JSON string |
| Ketersediaan | Post meta | `_is_available` | Boolean |
| Featured | Post meta | `_is_featured` | Boolean |
| Urutan produk | Core field | `menu_order` | Integer |
| Fasilitas | Post type | `facility` | CPT |
| Galeri | Option | `irama_santri_gallery_ids` | Array integer |
| Info kedai | Option | `irama_santri_business_info` | Array |
| Pemetaan halaman | Option | `irama_santri_page_map` | Array |
| Versi skema | Option | `irama_santri_schema_version` | Integer |

Tidak ada data bisnis inti yang disimpan di Theme.

---

## 3. Konvensi Penamaan

| Objek | Aturan | Contoh |
|---|---|---|
| Fungsi | Prefix `irama_santri_` | `irama_santri_get_products()` |
| Konstanta | Prefix `IRAMA_SANTRI_` | `IRAMA_SANTRI_VERSION` |
| Post meta | Prefix `_is_` | `_is_base_price` |
| Option | Prefix `irama_santri_` | `irama_santri_business_info` |
| Nonce action | Prefix `irama_santri_` | `irama_santri_product_meta` |
| Text domain | `irama-santri` | `__( 'Menu', 'irama-santri' )` |

Post meta memakai underscore di depan agar diperlakukan sebagai protected meta dan tidak muncul di Custom Fields biasa.

---

## 4. CPT `product`

### 4.1 Definisi

| Properti | Nilai |
|---|---|
| `label` | Produk |
| `singular` | Produk |
| `public` | `true` |
| `show_ui` | `true` |
| `show_in_rest` | `true` |
| `rest_base` | `products` |
| `has_archive` | `false` |
| `rewrite` | `array( 'slug' => 'menu', 'with_front' => false )` |
| `supports` | `title`, `editor`, `excerpt`, `thumbnail`, `page-attributes` |
| `menu_icon` | `dashicons-coffee` |
| `capability_type` | `post` |
| `map_meta_cap` | `true` |
| `hierarchical` | `false` |

### 4.2 Field Inti WordPress

| Field | Penggunaan |
|---|---|
| Title | Nama produk |
| Editor | Deskripsi lengkap pada halaman detail |
| Excerpt | Deskripsi singkat pada kartu produk |
| Featured image | Foto utama produk |
| `menu_order` | Urutan tampilan dalam kategori |
| Status | Draft, published, trash |

### 4.3 URL

- Single produk: `/menu/{slug}/`
- Tidak ada arsip CPT.
- Halaman `/menu/` adalah WordPress Page dengan template `page-menu.php`.
- Taxonomy tidak memiliki arsip publik pada versi pertama.

### 4.4 Aturan Penghapusan

- Produk dihapus permanen hanya oleh administrator.
- Theme tidak menyimpan referensi produk di luar WordPress.
- Menghapus produk tidak memengaruhi fasilitas, galeri, atau info kedai.

---

## 5. Taxonomy `product_category`

| Properti | Nilai |
|---|---|
| `label` | Kategori Produk |
| `hierarchical` | `true` |
| `public` | `false` |
| `publicly_queryable` | `false` |
| `show_ui` | `true` |
| `show_admin_column` | `true` |
| `show_in_rest` | `true` |
| `rewrite` | `false` |
| Object type | `product` |

### 5.1 Term Awal

Dibuat saat aktivasi plugin jika belum ada:

| Nama | Slug | Urutan tampilan |
|---|---|---:|
| Coffee | `coffee` | 1 |
| Non-Coffee | `non-coffee` | 2 |
| Snacks | `snacks` | 3 |
| Dessert / Pastry / Bakery | `dessert-pastry` | 4 |

Urutan kategori ditentukan oleh daftar slug di plugin. Kategori tambahan ditampilkan setelah kategori tetap, diurutkan berdasarkan nama.

### 5.2 Aturan

- Satu produk minimal memiliki satu kategori untuk tampil di halaman Menu.
- Produk tanpa kategori masuk ke grup "Lainnya" pada halaman Menu.
- Menghapus term tidak menghapus produk.

---

## 6. Meta Produk

Semua meta didaftarkan dengan `register_post_meta()`.

### 6.1 `_is_base_price`

| Properti | Nilai |
|---|---|
| Tipe | `integer` |
| Single | `true` |
| Default | `0` |
| Sanitasi | `absint`, minimum `0` |
| Auth callback | `current_user_can( 'edit_post', $post_id )` |
| REST | `show_in_rest => true` |

Aturan:

- Disimpan dalam rupiah penuh, tanpa desimal dan tanpa pemisah ribuan.
- `18000` berarti Rp18.000.
- `0` berarti harga belum diisi.
- Nilai negatif diubah menjadi `0`.

### 6.2 `_is_variants`

| Properti | Nilai |
|---|---|
| Tipe | `string` (JSON) |
| Single | `true` |
| Default | `'[]'` |
| Sanitasi | Lihat §6.6 |
| REST | `show_in_rest => true` |

Contoh nilai:

```json
[
  { "label": "Regular", "price": 18000 },
  { "label": "Large", "price": 22000 }
]
```

Aturan:

- Maksimal 20 varian.
- `label` wajib, maksimal 60 karakter.
- `price` integer rupiah, minimal 0.
- Baris tanpa label diabaikan.
- Label duplikat (case-insensitive) diabaikan setelah kemunculan pertama.
- Urutan array adalah urutan tampilan.
- Produk tanpa varian menyimpan `[]`.

### 6.3 `_is_addons`

| Properti | Nilai |
|---|---|
| Tipe | `string` (JSON) |
| Single | `true` |
| Default | `'[]'` |
| Sanitasi | Lihat §6.6 |
| REST | `show_in_rest => true` |

Contoh nilai:

```json
[
  { "label": "Extra Shot", "price": 5000 },
  { "label": "Oat Milk", "price": 7000 }
]
```

Aturan sama dengan varian. Add-on tidak mengubah harga dasar; harga add-on ditampilkan terpisah.

### 6.4 `_is_available`

| Properti | Nilai |
|---|---|
| Tipe | `boolean` |
| Single | `true` |
| Default | `true` |
| Sanitasi | `rest_sanitize_boolean` |
| REST | `show_in_rest => true` |

Aturan:

- `true` = tersedia.
- `false` = tidak tersedia.
- Produk tidak tersedia tetap tampil dengan badge "Tidak tersedia".

### 6.5 `_is_featured`

| Properti | Nilai |
|---|---|
| Tipe | `boolean` |
| Single | `true` |
| Default | `false` |
| Sanitasi | `rest_sanitize_boolean` |
| REST | `show_in_rest => true` |

Aturan:

- Hanya produk featured yang tersedia yang tampil di homepage.
- Jumlah maksimal yang ditampilkan: 4.
- Jika tidak ada, bagian featured disembunyikan.

### 6.6 Sanitasi JSON Varian dan Add-on

Alur sanitasi:

1. Terima string JSON atau array.
2. Decode jika string; jika gagal, kembalikan `'[]'`.
3. Pastikan hasil berupa array.
4. Iterasi setiap item; hanya proses item bertipe array.
5. Ambil `label` dan `price`.
6. `label` disanitasi dengan `sanitize_text_field()`, dipotong 60 karakter.
7. `price` diubah dengan `absint()`.
8. Lewati item dengan label kosong.
9. Lewati label duplikat.
10. Batasi maksimal 20 item.
11. Encode ulang dengan `wp_json_encode()`.

Nilai selalu disimpan sebagai JSON string yang valid.

---

## 7. Perhitungan Harga

### 7.1 Sumber Harga

1. Jika `_is_variants` berisi data valid, harga produk dihitung dari varian.
2. Jika tidak ada varian, harga dihitung dari `_is_base_price`.
3. Jika keduanya kosong, harga dianggap belum tersedia.

### 7.2 Rentang Harga

```text
price_min = nilai terendah dari varian, atau base_price
price_max = nilai tertinggi dari varian, atau base_price
has_variants = jumlah varian > 0
```

### 7.3 Format Tampilan

| Kondisi | Tampilan |
|---|---|
| `price_min` dan `price_max` sama, tanpa varian | `Rp 18.000` |
| `price_min` dan `price_max` sama, dengan varian | `Rp 18.000` pada daftar varian |
| `price_min` berbeda dari `price_max` | `Mulai dari Rp 18.000` pada kartu |
| Harga belum diisi | `Harga belum tersedia` |
| Add-on | `Extra Shot +Rp 5.000` |

Format angka menggunakan `number_format_i18n( $amount, 0 )` dengan prefiks `Rp `.

---

## 8. CPT `facility`

| Properti | Nilai |
|---|---|
| `label` | Fasilitas |
| `singular` | Fasilitas |
| `public` | `false` |
| `show_ui` | `true` |
| `show_in_rest` | `true` |
| `has_archive` | `false` |
| `exclude_from_search` | `true` |
| `supports` | `title`, `editor`, `thumbnail`, `page-attributes` |
| `menu_icon` | `dashicons-building` |

Field:

- Title — nama fasilitas.
- Editor — deskripsi.
- Featured image — foto fasilitas.
- `menu_order` — urutan tampilan.

Aturan:

- Fasilitas tidak memiliki halaman publik sendiri pada versi pertama.
- Fasilitas ditampilkan pada halaman Our Space dan preview homepage.
- Foto fasilitas menggunakan ukuran gambar Theme.
- Menghapus fasilitas tidak memengaruhi produk.

---

## 9. Option

### 9.1 `irama_santri_business_info`

```php
array(
    'address' => 'Jln. Rawa Kelem Blok S. No. 72, Klayan, Gunungjati, Cirebon.',
    'hours'   => 'Setiap hari, 10.00–22.00 WIB',
)
```

Aturan:

- `address` disanitasi dengan `sanitize_textarea_field()`.
- `hours` disanitasi dengan `sanitize_text_field()`.
- Jika option belum ada, gunakan nilai default di atas.
- Tidak menyimpan nomor WhatsApp atau tautan media sosial.

### 9.2 `irama_santri_page_map`

```php
array(
    'menu_page_id'    => 0,
    'contact_page_id' => 0,
)
```

Aturan:

- Nilai berupa ID halaman WordPress.
- Disanitasi dengan `absint()`.
- ID divalidasi terhadap post type `page` saat dibaca.
- Jika kosong atau tidak valid, `irama_santri_get_page_url()` mengembalikan `home_url( '/' )`.

### 9.3 `irama_santri_gallery_ids`

```php
array( 101, 102, 103 )
```

Aturan:

- Berisi attachment ID dari Media Library.
- Urutan array adalah urutan tampilan.
- Disanitasi dengan `absint()` dan `array_unique()`.
- Attachment yang sudah tidak ada dilewati saat render.
- Maksimal 60 gambar.

### 9.4 `irama_santri_schema_version`

| Properti | Nilai |
|---|---|
| Tipe | `integer` |
| Default | `1` |

Digunakan untuk migrasi data di masa depan. Pada setiap rilis yang mengubah struktur, versi dinaikkan dan routine migrasi dijalankan sekali.

---

## 10. Siklus Hidup Data

### 10.1 Aktivasi Plugin

1. Registrasikan CPT dan taxonomy.
2. Buat term kategori awal jika belum ada.
3. Set option default jika belum ada.
4. Set `irama_santri_schema_version` ke versi saat ini.
5. Flush rewrite rules.

### 10.2 Deaktivasi Plugin

- Flush rewrite rules.
- Tidak menghapus data.
- Tidak menghapus option.

### 10.3 Uninstall

- Data tidak dihapus secara default.
- Penghapusan data hanya dilakukan jika konstanta `IRAMA_SANTRI_REMOVE_DATA_ON_UNINSTALL` bernilai `true`.
- Jika diaktifkan, hapus:
  - semua post type `product` dan `facility`;
  - semua term `product_category`;
  - semua post meta `_is_*`;
  - semua option `irama_santri_*`.

### 10.4 Migrasi

- Bandingkan `irama_santri_schema_version` dengan versi kode.
- Jalankan migrasi pada hook admin atau `plugins_loaded` setelah semua plugin dimuat.
- Migrasi harus idempoten.
- Perubahan format data wajib dicatat di dokumen ini.

---

## 11. Query dan Performa

### 11.1 Query Produk

```php
$args = array(
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => array(
        'menu_order' => 'ASC',
        'title'      => 'ASC',
    ),
);
```

### 11.2 Query Featured

```php
$args = array(
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => 4,
    'meta_query'     => array(
        'relation' => 'AND',
        array(
            'key'   => '_is_featured',
            'value' => '1',
        ),
        array(
            'key'     => '_is_available',
            'value'   => '1',
            'compare' => '!=',
        ),
    ),
);
```

Catatan:

- Katalog diperkirakan berisi puluhan produk, sehingga `meta_query` masih wajar.
- Jika katalog tumbuh besar, pertimbangkan taxonomy khusus atau index tambahan.
- Jangan menggunakan `query_posts()`.
- Selalu panggil `wp_reset_postdata()` setelah custom loop.

---

## 12. Pemetaan Admin

| Kebutuhan PRD | Field | Kontrol admin | Validasi |
|---|---|---|---|
| Nama produk | Title | Input teks | Wajib |
| Deskripsi lengkap | Editor | Editor WordPress | Bebas |
| Deskripsi singkat | Excerpt | Textarea | Bebas |
| Foto produk | Featured image | Media Library | Attachment ID |
| Kategori | `product_category` | Checklist term | Minimal satu untuk tampil |
| Harga dasar | `_is_base_price` | Number | Integer ≥ 0 |
| Varian | `_is_variants` | Repeater label + harga | Maks 20, label wajib |
| Add-on | `_is_addons` | Repeater label + harga | Maks 20, label wajib |
| Ketersediaan | `_is_available` | Checkbox | Boolean |
| Featured | `_is_featured` | Checkbox | Boolean |
| Urutan | `menu_order` | Number | Integer |
| Fasilitas | `facility` | CPT | Judul wajib |
| Galeri | `irama_santri_gallery_ids` | Media picker + urutan | Attachment ID valid |
| Alamat | `business_info.address` | Textarea | Teks |
| Jam operasional | `business_info.hours` | Input teks | Teks |
| Halaman Menu | `page_map.menu_page_id` | Dropdown Pages | ID valid |
| Halaman Contact | `page_map.contact_page_id` | Dropdown Pages | ID valid |

Catatan implementasi:

- Repeater varian dan add-on membutuhkan JavaScript admin sederhana.
- Media picker galeri menggunakan `wp.media`.
- Semua form memakai nonce dan pemeriksaan capability.
- Semua field memiliki label yang terhubung.

---

## 13. Keamanan Data

- Meta didaftarkan dengan `auth_callback`.
- Simpan data hanya setelah `wp_verify_nonce()` dan `current_user_can()`.
- Jangan menerima data mentah dari `$_POST` tanpa `wp_unslash()` dan sanitasi.
- Escape saat render: `esc_html()`, `esc_attr()`, `esc_url()`, `wp_kses_post()`.
- JSON divalidasi sebelum disimpan; jangan menyimpan string yang tidak dapat di-decode.
- Attachment ID divalidasi dengan `get_post_type( $id ) === 'attachment'`.
- Jangan mengekspos option melalui REST publik.
- Jangan menyimpan secret di post meta atau option.

---

## 14. Contoh Data

### 14.1 Produk Tanpa Varian

```text
Title: Americano
Category: Coffee
Base Price: 15000
Variants: []
Add-ons: [{"label":"Extra Shot","price":5000}]
Available: true
Featured: true
```

Tampilan kartu: `Rp 15.000`  
Tampilan detail: `Rp 15.000`, add-on `Extra Shot +Rp 5.000`.

### 14.2 Produk Dengan Varian

```text
Title: Latte
Category: Coffee
Base Price: 0
Variants: [{"label":"Regular","price":18000},{"label":"Large","price":22000}]
Add-ons: []
Available: true
Featured: true
```

Tampilan kartu: `Mulai dari Rp 18.000`  
Tampilan detail: `Regular Rp 18.000`, `Large Rp 22.000`.

### 14.3 Produk Tidak Tersedia

```text
Title: Matcha
Category: Non-Coffee
Base Price: 20000
Variants: []
Add-ons: []
Available: false
Featured: false
```

Tampilan: kartu tetap muncul dengan badge `Tidak tersedia`.

---

## 15. Hal yang Belum Final

1. Jumlah maksimal produk dan kategori final.
2. Apakah produk membutuhkan galeri foto tambahan pada versi pertama.
3. Format jam operasional terstruktur (jam buka/tutup per hari) atau teks bebas.
4. Kebutuhan pencarian atau filter katalog.
5. Kebutuhan schema markup produk.
6. Strategi migrasi jika katalog tumbuh besar.
7. Kebutuhan impor/ekspor data produk.

**Status dokumen: Draft 1.0 — menunggu review.**
