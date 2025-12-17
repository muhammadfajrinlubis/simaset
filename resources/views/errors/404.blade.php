<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>

    {{-- SweetAlert CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background: #f4f6f9;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            text-align: center;
        }

        .box {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
            max-width: 400px;
        }

        h1 {
            font-size: 80px;
            font-weight: bold;
            margin: 0;
            color: #ff4d4d;
        }

        h2 {
            margin-top: -10px;
            color: #333;
        }

        p {
            color: #666;
        }

        .btn-home {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background: #007bff;
            color: white;
            border-radius: 8px;
            text-decoration: none;
        }

        .btn-home:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

    <div class="box">
        <h1>404</h1>
        <h2>Halaman Tidak Ditemukan</h2>
        <p>Anda tidak memiliki izin untuk mengakses halaman ini.</p>

        <a href="{{ url('/') }}" class="btn-home">Kembali ke Dashboard</a>
    </div>

    <script>
        Swal.fire({
            icon: 'error',
            title: 'Akses Ditolak!',
            text: 'Anda tidak bisa mengakses halaman milik admin lain.',
            timer: 2500,
            showConfirmButton: false
        });
    </script>

</body>
</html>
