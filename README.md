# Dokumentasi API

## Informasi Umum

- Semua endpoint API diawali dengan `/api` sesuai dengan pengaturan routing API Laravel.
- Autentikasi diperlukan untuk semua endpoint, menggunakan `auth:sanctum`.

## Endpoint

### 1. Jenis Barang

- **GET /jenis-barang/**
    - Deskripsi: Menampilkan daftar semua jenis barang.
    - Respons: Array JSON dari jenis barang.

- **POST /jenis-barang/**
    - Deskripsi: Membuat jenis barang baru.
    - Body:
      ```json
      {
        "nama": "string"
      }
      ```
    - Respons: Objek JSON dari jenis barang yang dibuat.

- **PUT /jenis-barang/{id}**
    - Deskripsi: Memperbarui jenis barang yang ada.
    - Parameter:
        - `id` (wajib): ID dari jenis barang yang akan diperbarui.
    - Body:
      ```json
      {
        "nama": "string",
      }
      ```
    - Respons: Objek JSON dari jenis barang yang diperbarui.

- **DELETE /jenis-barang/{id}**
    - Deskripsi: Menghapus jenis barang.
    - Parameter:
        - `id` (wajib): ID dari jenis barang yang akan dihapus.
    - Respons: Status pemberitahuan berhasil atau gagal.

### 2. Barang

- **GET /barang/**
    - Deskripsi: Menampilkan daftar semua barang.
    - Respons: Array JSON dari barang.

- **POST /barang/**
    - Deskripsi: Menambahkan barang baru.
    - Body:
      ```json
      {
        "nama": "string",
        "jenis_id": "integer",
        "stok_barang": "integer"
      }
      ```
    - Respons: Objek JSON dari barang yang ditambahkan.

- **PUT /barang/{id}**
    - Deskripsi: Memperbarui barang yang ada.
    - Parameter:
        - `id` (wajib): ID dari barang yang akan diperbarui.
    - Body:
      ```json
      {
        "nama": "string",
        "jenis_id": "integer",
        "stok_barang": "integer"
      }
      ```
    - Respons: Objek JSON dari barang yang diperbarui.

- **DELETE /barang/{id}**
    - Deskripsi: Menghapus barang.
    - Parameter:
        - `id` (wajib): ID dari barang yang akan dihapus.
    - Respons: Status pemberitahuan berhasil atau gagal.

### 3. Transaksi

- **GET /transaksi/**
    - Deskripsi: Menampilkan daftar semua transaksi.
    - Respons: Array JSON dari transaksi.

- **GET /transaksi/compare**
    - Deskripsi: Membandingkan transaksi untuk analisis tertentu.
    - Respons: Objek JSON yang berisi hasil perbandingan.

- **POST /transaksi/**
    - Deskripsi: Menambahkan transaksi baru.
    - Body:
      ```json
      {
        "nama_barang": "string",
        "stok": "integer",
        "jumlah_terjual": "integer",
        "tanggal_transaksi": "date"
      }
      ```
    - Respons: Objek JSON dari transaksi yang ditambahkan.

- **PUT /transaksi/{id}**
    - Deskripsi: Memperbarui transaksi yang ada.
    - Parameter:
        - `id` (wajib): ID dari transaksi yang akan diperbarui.
    - Body:
      ```json
      {
        "nama_barang": "string",
        "stok": "integer",
        "jumlah_terjual": "integer",
        "tanggal_transaksi": "date"
      }
      ```
    - Respons: Objek JSON dari transaksi yang diperbarui.

- **DELETE /transaksi/{id}**
    - Deskripsi: Menghapus transaksi.
    - Parameter:
        - `id` (wajib): ID dari transaksi yang akan dihapus.
    - Respons: Status pemberitahuan berhasil atau gagal.
