# 🏷️ Sangihe Trip

Website Sangihe Trip. Dirancang untuk membantu wisatawan mengatur itinerary wisata secara efisien.

## ✨ Fitur

- 🧑‍💼 Multi-role Login (Admin, Petugas)
- 👤 Manajemen Pengguna (CRUD User)
- 📇 Manajemen Kategori Produk (CRUD Product Category)
- 📦 Manajemen Produk (CRUD Product)
- 📰 Manajemen Artikel (CRUD Article)
- 📊 Dashboard Admin dan Statistik

## ⚙️ Teknologi

- Laravel 12
- PHP 8.3
- Tailwind CSS
- Alpine.js
- MySQL
- Bootstrap Icon
- LangCommon
- Sluggable
- Ibnux Data Indonesia

## 🛠️ Instalasi & Setup

1. Clone repository:

    ```bash
    git clone https://github.com/theowongkar/sangihe-trip.git
    cd sangihe-trip
    ```

2. Install dependency:

    ```bash
    composer install
    npm install && npm run build
    ```

3. Salin file `.env`:

    ```bash
    cp .env.example .env
    ```

4. Atur konfigurasi `.env` (database, mail, dsb)

5. Generate key dan migrasi database:

    ```bash
    php artisan key:generate
    php artisan storage:link
    php artisan migrate:fresh --seed
    ```

6. Jalankan server lokal:

    ```bash
    php artisan serve
    ```

7. Buka browser dan akses http://127.0.0.1:8000

## 👥 Role & Akses

| Role       | Akses                                              |
| ---------- | -------------------------------------------------- |
| Admin      | CRUD data user, product category, product, article |
| Pengunjung | CRU data user, product, article, review            |

## 📎 Catatan Tambahan

- Pastikan folder `storage` dan `bootstrap/cache` writable.
