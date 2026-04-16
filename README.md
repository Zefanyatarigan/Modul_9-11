# ZEFANYA BRANA TERTIUS TARIGAN 
# 2311102028

# Laporan Praktikum Laravel + AJAX
## Menampilkan Data Mahasiswa dari File JSON Tanpa Database

## 1. Tujuan Praktikum
Praktikum ini bertujuan untuk membuat aplikasi Laravel sederhana yang dapat menampilkan data mahasiswa dari file JSON lokal menggunakan AJAX tanpa reload halaman.

---

## 2. Deskripsi Program
Program ini dibuat menggunakan Laravel dengan tampilan halaman utama berupa:

- judul **Data Mahasiswa**
- tombol **Tampilkan Data**
- tabel hasil data mahasiswa

Data mahasiswa tidak disimpan di database, melainkan di file JSON lokal.  
Ketika tombol **Tampilkan Data** diklik, data diambil menggunakan AJAX lalu ditampilkan ke halaman dalam bentuk tabel tanpa refresh.

---

## 3. Lokasi Folder Project
Project Laravel disimpan pada folder:

```text
E:\Kuliah\Semester 6\praktikum abp\Modul_9-11
```

---

## 4. Perintah CMD yang Digunakan

### Masuk ke folder project
```bash
E:
cd "E:\Kuliah\Semester 6\praktikum abp\Modul_9-11"
```

### Menjalankan server Laravel
```bash
php artisan serve
```

### Membuka project di browser Chrome
```bash
start chrome http://127.0.0.1:8000
```

### Urutan lengkap perintah CMD
```bash
E:
cd "E:\Kuliah\Semester 6\praktikum abp\Modul_9-11"
php artisan serve
start chrome http://127.0.0.1:8000
```

---

## 5. File yang Ditambahkan
Berikut file yang ditambahkan pada project:

### 1. File JSON
```text
public/data/mahasiswa.json
```

File ini digunakan untuk menyimpan data mahasiswa secara lokal.

### 2. File Controller
```text
app/Http/Controllers/MahasiswaController.php
```

File ini digunakan untuk membaca file JSON lalu mengembalikan data dalam format JSON.

### 3. File View Blade
```text
resources/views/home.blade.php
```

File ini digunakan untuk menampilkan halaman utama beserta tombol dan tabel hasil data.

---

## 6. File yang Diedit

### File routing
```text
routes/web.php
```

File ini diedit untuk menambahkan route halaman utama dan route untuk mengambil data mahasiswa.

---

## 7. Isi Kode Program

## A. File JSON
Lokasi file:

```text
public/data/mahasiswa.json
```

Isi file:

```json
[
    {
        "nama": "Zefanya Brana Tertius Tarigan",
        "nim": "2311102028",
        "kelas": "SI1F-11-04",
        "prodi": "Teknik Informatika"
    },
    {
        "nama": "Imu-sama",
        "nim": "231121298199",
        "kelas": "SI1F-11-04",
        "prodi": "One piece"
    },
    {
        "nama": "Citra Lestari",
        "nim": "220100929989",
        "kelas": "SI1F-11-04",
        "prodi": "Teknik Industri"
    }
]
```

### Penjelasan
File JSON ini berfungsi sebagai sumber data utama. Karena pada tugas ini tidak diperbolehkan menggunakan database, maka data mahasiswa disimpan dalam file JSON lokal.

---

## B. File Controller
Lokasi file:

```text
app/Http/Controllers/MahasiswaController.php
```

Isi file:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index()
    {
        $path = public_path('data/mahasiswa.json');
        $data = json_decode(file_get_contents($path), true);

        return response()->json($data);
    }
}
```

### Penjelasan
- `public_path('data/mahasiswa.json')` digunakan untuk mengambil lokasi file JSON
- `file_get_contents($path)` digunakan untuk membaca isi file JSON
- `json_decode(..., true)` digunakan untuk mengubah isi JSON menjadi array
- `response()->json($data)` digunakan untuk mengirim data ke browser dalam format JSON

---

## C. File Route
Lokasi file:

```text
routes/web.php
```

Isi file:

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;

Route::get('/', function () {
    return view('home');
});

Route::get('/data-mahasiswa', [MahasiswaController::class, 'index']);
```

### Penjelasan
- Route `/` digunakan untuk menampilkan halaman utama
- Route `/data-mahasiswa` digunakan untuk mengambil data mahasiswa dari controller dalam format JSON

---

## D. File Blade
Lokasi file:

```text
resources/views/home.blade.php
```

Isi file:

```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 32px;
        }

        h1 {
            margin-bottom: 20px;
        }

        button {
            background-color: #0d6efd;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 16px;
        }

        button:hover {
            background-color: #0b5ed7;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid #bfbfbf;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <h1>Data Mahasiswa</h1>

    <button id="btnTampil">Tampilkan Data</button>

    <div id="hasil"></div>

    <script>
        document.getElementById('btnTampil').addEventListener('click', function () {
            fetch('/data-mahasiswa')
                .then(response => response.json())
                .then(data => {
                    let output = `
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>NIM</th>
                                    <th>Kelas</th>
                                    <th>Prodi</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;

                    data.forEach((item, index) => {
                        output += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${item.nama}</td>
                                <td>${item.nim}</td>
                                <td>${item.kelas}</td>
                                <td>${item.prodi}</td>
                            </tr>
                        `;
                    });

                    output += `
                            </tbody>
                        </table>
                    `;

                    document.getElementById('hasil').innerHTML = output;
                })
                .catch(error => {
                    document.getElementById('hasil').innerHTML = '<p>Terjadi kesalahan saat mengambil data.</p>';
                    console.error(error);
                });
        });
    </script>
</body>
</html>
```

### Penjelasan
Pada file Blade ini terdapat:

- judul halaman **Data Mahasiswa**
- tombol **Tampilkan Data**
- area hasil data
- script AJAX menggunakan `fetch()`

Saat tombol diklik, JavaScript mengirim permintaan ke route `/data-mahasiswa`.  
Setelah data diterima, program menampilkan data ke dalam tabel dengan kolom:

- No
- Nama
- NIM
- Kelas
- Prodi

Data ditampilkan tanpa reload halaman.

---

## 8. Alur Kerja Program
Alur kerja aplikasi adalah sebagai berikut:

1. User membuka halaman utama Laravel
2. Halaman menampilkan judul **Data Mahasiswa** dan tombol **Tampilkan Data**
3. Saat tombol diklik, AJAX `fetch()` dijalankan
4. Request dikirim ke route `/data-mahasiswa`
5. Route memanggil `MahasiswaController`
6. Controller membaca file `mahasiswa.json`
7. Data dikirim kembali ke browser dalam format JSON
8. JavaScript menerima data tersebut
9. Data ditampilkan ke dalam tabel tanpa reload halaman

---

## 9. Cara Menjalankan Program
Langkah-langkah menjalankan project:

### 1. Buka CMD
Masuk ke drive dan folder project:

```bash
E:
cd "E:\Kuliah\Semester 6\praktikum abp\Modul_9-11"
```

### 2. Jalankan Laravel
```bash
php artisan serve
```

### 3. Buka browser
Akses alamat berikut:

```text
http://127.0.0.1:8000
```

Atau langsung dari CMD:

```bash
start chrome http://127.0.0.1:8000
```

### 4. Tampilkan data
Klik tombol **Tampilkan Data**, maka data mahasiswa akan muncul dalam bentuk tabel.

---

## 10. Hasil Output Program
Output program menampilkan halaman dengan judul:

```text
Data Mahasiswa
```

Lalu terdapat tombol:

```text
Tampilkan Data
```

Setelah tombol ditekan, akan muncul tabel data mahasiswa dengan isi seperti berikut:

| No | Nama                           | NIM          | Kelas      | Prodi                |
|----|--------------------------------|--------------|------------|----------------------|
| 1  | Zefanya Brana Tertius Tarigan | 2311102028   | SI1F-11-04 | Teknik Informatika   |
| 2  | Imu-sama                      | 231121298199 | SI1F-11-04 | One piece            |
| 3  | Citra Lestari                 | 220100929989 | SI1F-11-04 | Teknik Industri      |

---

## 11. Struktur File Project
Struktur file yang digunakan pada project ini adalah:

```text
Modul_9-11/
├── app/
│   └── Http/
│       └── Controllers/
│           └── MahasiswaController.php
├── public/
│   └── data/
│       └── mahasiswa.json
├── resources/
│   └── views/
│       └── home.blade.php
└── routes/
    └── web.php
```

---

## 12. Kesimpulan
Berdasarkan praktikum yang telah dilakukan, dapat disimpulkan bahwa Laravel dapat digunakan untuk membuat aplikasi sederhana tanpa database dengan memanfaatkan file JSON sebagai sumber data. Dengan bantuan AJAX, data mahasiswa dapat ditampilkan secara dinamis tanpa reload halaman. Praktikum ini membantu memahami penggunaan Blade, route, controller, file JSON, dan AJAX dalam satu aplikasi Laravel.

