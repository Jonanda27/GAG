<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grow Garden Shop</title>
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
        <h4 class="text-center py-3">Grow Garden Shop</h4>
        <ul>
            <li>Kategori: Buah</li>
            <li>Kategori: Hewan</li>
            <li>Kategori: Dekorasi</li>
        </ul>
    </div>

    <!-- Content -->
    <div id="content">
        <button class="btn btn-primary mb-3" id="toggleSidebar">☰</button>
        <h1>Dashboard</h1>
        <p>Selamat datang di toko item Grow a Garden!</p>

        <!-- List item dari database -->
        <div class="row">
            @foreach($pets as $pet)
                <div class="col-md-3 mb-3">
                    <div class="card">
                        <img src="{{ asset('storage/' . $pet->gambar) }}" class="card-img-top" alt="{{ $pet->nama }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $pet->nama }}</h5>
                            <p class="card-text">Harga: {{ $pet->harga }}p</p>
                            <a href="#" class="btn btn-success">Beli</a>
                        </div>
                    </div>
                </div>
            @endforeach
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