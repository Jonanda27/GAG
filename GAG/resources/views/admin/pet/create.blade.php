<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pet - Grow Garden Shop</title>
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

        #sidebar ul li a {
            color: white;
            text-decoration: none;
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
        <h4 class="text-center py-3">Grow Garden Shop</h4>
        <ul>
            <li>Kategori: Buah</li>
            <li>Kategori: Hewan</li>
            <li>Kategori: Dekorasi</li>
            <li>
                <a href="{{ route('admin.pet.create') }}" class="btn btn-success w-100 mt-3">+ Tambah Pet</a>
                <a href="{{ url('/admin') }}" class="btn btn-warning mb-3">
                    ← Kembali ke Dashboard
                </a>
            </li>
        </ul>
    </div>

    <!-- Content -->
    <div id="content">
        <button class="btn btn-primary mb-3" id="toggleSidebar">☰</button>
        <h1>Tambah Pet</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card p-4">
            <form action="{{ route('admin.pet.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nama Pet</label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="number" step="0.01" name="harga" class="form-control" value="{{ old('harga') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" class="form-control" value="{{ old('stok') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Gambar</label>
                    <input type="file" name="gambar" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
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