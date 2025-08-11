<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Testi - Grow Garden Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
        }

        #sidebar {
            width: 250px;
            background: #2c3e50;
            color: white;
            height: 100vh;
            position: fixed;
            transition: transform 0.3s ease;
        }

        #sidebar.hidden {
            transform: translateX(-250px);
        }

        #sidebar ul {
            list-style: none;
            padding: 0;
        }

        #sidebar ul li {
            padding: 15px;
            cursor: pointer;
        }

        #content {
            flex-grow: 1;
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        #content.full {
            margin-left: 0;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div id="sidebar">
        <h4 class="text-center py-3">Admin Panel</h4>
        <ul>
            <li>
                <a href="{{ route('admin.testi.create') }}" class="btn btn-info w-100 mt-3">+ Tambah Testi</a>
            </li>
            <a href="{{ url('/admin') }}" class="btn btn-warning mb-3">
                ← Kembali ke Dashboard
            </a>
        </ul>
    </div>

    <!-- Content -->
    <div id="content">
        <button class="btn btn-primary mb-3" id="toggleSidebar">☰</button>
        <h1>Tambah Testimoni</h1>
        <p>Upload gambar testimoni pembeli di toko.</p>

        <!-- Form Upload -->
        <form action="{{ route('admin.testi.store') }}" method="POST" enctype="multipart/form-data" class="mt-4">
            @csrf
            <div class="mb-3">
                <label for="gambar" class="form-label">Pilih Gambar</label>
                <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" required>
            </div>

            <button type="submit" class="btn btn-primary">Upload</button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');
        const toggleBtn = document.getElementById('toggleSidebar');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
            content.classList.toggle('full');
        });
    </script>

</body>

</html>