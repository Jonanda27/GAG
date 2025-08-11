<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pet - Grow Garden Shop</title>
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
                <a href="{{ route('admin.pet.create') }}" class="btn btn-success w-100 mt-3">+ Tambah Pet</a>
            </li>
            <li>
                <a href="{{ route('admin.testi.create') }}" class="btn btn-info w-100 mt-3">+ Tambah Testi</a>
            </li>
        </ul>
    </div>

    <!-- Content -->
    <div id="content">
        <button class="btn btn-primary mb-3" id="toggleSidebar">☰</button>
        <h1>Edit Pet</h1>
        <p>Ubah data pet yang sudah ada.</p>

        <!-- Form Edit -->
        <div class="container">
            <form action="{{ route('admin.pet.update', $pet->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" value="{{ $pet->nama }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="number" name="harga" class="form-control" value="{{ $pet->harga }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" class="form-control" value="{{ $pet->stok }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Gambar (Kosongkan jika tidak diganti)</label>
                    <input type="file" name="gambar" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.app') }}" class="btn btn-secondary">Kembali</a>
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
