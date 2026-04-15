<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }

        h1 {
            margin-bottom: 20px;
        }

        button {
            padding: 10px 16px;
            background-color: #0d6efd;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 6px;
        }

        button:hover {
            background-color: #0b5ed7;
        }

        #hasil {
            margin-top: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 15px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .loading, .error {
            margin-top: 15px;
            font-weight: bold;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>

    <h1>Data Mahasiswa</h1>

    <button id="btnTampilkan">Tampilkan Data</button>

    <div id="hasil"></div>

    <script>
        document.getElementById('btnTampilkan').addEventListener('click', function () {
            const hasil = document.getElementById('hasil');
            hasil.innerHTML = '<p class="loading">Memuat data...</p>';

            fetch('/data-mahasiswa')
                .then(response => response.json())
                .then(data => {
                    if (!Array.isArray(data) || data.length === 0) {
                        hasil.innerHTML = '<p class="error">Data tidak tersedia.</p>';
                        return;
                    }

                    let html = `
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

                    data.forEach((mhs, index) => {
                        html += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${mhs.nama}</td>
                                <td>${mhs.nim}</td>
                                <td>${mhs.kelas}</td>
                                <td>${mhs.prodi}</td>
                            </tr>
                        `;
                    });

                    html += `
                            </tbody>
                        </table>
                    `;

                    hasil.innerHTML = html;
                })
                .catch(error => {
                    hasil.innerHTML = '<p class="error">Gagal mengambil data.</p>';
                    console.error(error);
                });
        });
    </script>

</body>
</html>