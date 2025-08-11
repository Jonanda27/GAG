<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grow Garden Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            z-index: 1000;
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

        /* Keranjang belanja mengambang di kanan */
        #cartSidebar {
            width: 300px;
            background: #f8f9fa;
            position: fixed;
            top: 0;
            right: -300px;
            height: 100vh;
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.3);
            transition: right 0.3s ease;
            z-index: 1100;
            overflow-y: auto;
        }

        #cartSidebar.open {
            right: 0;
        }
    </style>
</head>

<body>

    <!-- Sidebar kiri -->
    <div id="sidebar">
        <h4 class="text-center py-3">Grow Garden Shop</h4>
        @if($testis->count() > 0)
            <div style="width: 225px; height: 225px; overflow: hidden; margin: 0 auto;">
                <img id="testiImage" src="{{ asset('storage/' . $testis[0]->gambar) }}" alt="Testimoni"
                    style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
            </div>
        @else
            <p class="text-light p-2">Belum ada testimoni</p>
        @endif
    </div>

    <!-- Konten utama -->
    <div id="content">
        <button class="btn btn-primary mb-3" id="toggleSidebar">☰</button>
        <button class="btn btn-warning mb-3 float-end" id="toggleCart">🛒 Keranjang</button>
        <h1>Dashboard</h1>
        <p>Selamat datang di toko item Grow a Garden!</p>

        <!-- List item dari database -->
        <div class="row">
            @foreach($pets as $pet)
                <div class="col-md-3 mb-3 d-flex">
                    <div class="card h-100 w-100">
                        <img src="{{ asset('storage/' . $pet->gambar) }}" class="card-img-top" alt="{{ $pet->nama }}"
                            style="height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $pet->nama }}</h5>
                            <p class="card-text">Harga: {{ number_format($pet->harga, 0, ',', '.') }} Rupiah</p>
                            <!-- Tambahan stok -->
                            <p class="card-text text-muted">Stok: {{ $pet->stok }}</p>

                            <div class="mb-2">
                                <label for="qty_{{ $pet->id }}" class="form-label">Jumlah</label>
                                <input type="number" id="qty_{{ $pet->id }}" name="qty" class="form-control" value="1"
                                    min="1" max="{{ $pet->stok }}">
                            </div>

                            <button class="btn btn-success mt-auto beli-btn" data-id="{{ $pet->id }}"
                                data-nama="{{ $pet->nama }}" data-harga="{{ $pet->harga }}">
                                Beli
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>


        <!-- Keranjang Belanja Mengambang -->
        <div id="cartSidebar">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Keranjang Belanja</h5>
                <!-- Icon X untuk menutup keranjang -->
                <button class="btn btn-sm btn-light" id="closeCart">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="cartItems" class="p-3">
                <p class="text-muted">Keranjang masih kosong</p>
            </div>
            <div class="cart-footer">
                <button id="checkoutBtn" class="btn btn-success w-100">
                    Checkout via WhatsApp
                </button>
            </div>
        </div>

        <script>
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            const toggleBtn = document.getElementById('toggleSidebar');
            const cartSidebar = document.getElementById('cartSidebar');
            const toggleCartBtn = document.getElementById('toggleCart');
            const cartItems = document.getElementById('cartItems');

            let cart = [];

            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('hidden');
                content.classList.toggle('full');
            });

            toggleCartBtn.addEventListener('click', () => {
                cartSidebar.classList.toggle('open');
            });

            document.getElementById('closeCart').addEventListener('click', () => {
                cartSidebar.classList.remove('open');
            });

            // Fungsi tambah item ke keranjang
            document.querySelectorAll('.beli-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const id = this.dataset.id;
                    const nama = this.dataset.nama;
                    const harga = parseInt(this.dataset.harga);
                    const qty = parseInt(document.getElementById('qty_' + id).value);

                    cart.push({ id, nama, harga, qty });
                    renderCart();
                    cartSidebar.classList.add('open'); // otomatis buka keranjang
                });
            });

            function renderCart() {
                if (cart.length === 0) {
                    cartItems.innerHTML = `<p class="text-muted">Keranjang masih kosong</p>`;
                    return;
                }

                let html = '<ul class="list-group">';
                cart.forEach((item, index) => {
                    html += `
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>${item.nama} x${item.qty}</div>
                <div>
                    <span class="me-2">${item.harga * item.qty}p</span>
                    <!-- Icon X untuk hapus item -->
                    <button class="btn btn-sm btn-danger" onclick="removeFromCart(${index})">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </li>`;
                });
                html += '</ul>';
                cartItems.innerHTML = html;
            }

            // Hapus item dari keranjang berdasarkan index
            function removeFromCart(index) {
                cart.splice(index, 1);
                renderCart();
            }

            document.getElementById('checkoutBtn').addEventListener('click', function () {
                let nomorWa = '6282360579753'; // Ganti 0 di depan jadi 62
                let pesan = 'Halo, saya ingin membeli pet berikut:%0A';

                cart.forEach((item, index) => {
                    pesan += `${index + 1}. ${item.nama} - ${item.harga} (${item.qty} pcs)%0A`;
                });

                let url = `https://wa.me/${nomorWa}?text=${pesan}`;
                window.open(url, '_blank');

                // ✅ Kosongkan keranjang dan update tampilan
                cart = [];
                renderCart();
            });

            document.addEventListener("DOMContentLoaded", function () {
                @if($testis->count() > 0)
                                const testiImages = {!! json_encode($testis->map(function ($t) {
                        return asset('storage/' . $t->gambar);
                    })) !!};
                                let testiIndex = 0;
                                const testiImgTag = document.getElementById('testiImage');

                                setInterval(() => {
                                    testiIndex = (testiIndex + 1) % testiImages.length;
                                    testiImgTag.src = testiImages[testiIndex];
                                }, 2000);
                @endif
});

        </script>

</body>

</html>