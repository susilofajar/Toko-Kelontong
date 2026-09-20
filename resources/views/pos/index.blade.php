@extends('layouts.app')
@section('title', 'Kasir (POS)')

@push('styles')
    <style>
        .pos-container {
            display: flex;
            gap: 1.5rem;
            height: calc(100vh - 160px);
        }

        .product-grid {
            flex: 1;
            overflow-y: auto;
        }

        .cart-panel {
            width: 380px;
            display: flex;
            flex-direction: column;
            min-height: 0;
        }

        .cart-panel .card {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 0;
            overflow: hidden;
        }

        .product-card-pos {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem 1rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-align: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .product-card-pos:hover {
            border-color: var(--primary);
            transform: translateY(-4px);
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.15);
        }

        .product-card-pos .icon-wrapper {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: rgba(99, 102, 241, 0.1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.75rem;
            transition: all 0.3s;
        }

        .product-card-pos:hover .icon-wrapper {
            background: var(--primary);
        }

        .product-card-pos:hover .icon-wrapper i {
            color: white !important;
        }

        .product-card-pos .p-name {
            font-size: 0.85rem;
            font-weight: 600;
            line-height: 1.3;
        }

        .product-card-pos .p-price {
            font-size: 0.85rem;
            color: var(--success);
            font-weight: 700;
            margin-top: 0.4rem;
        }

        .product-card-pos .p-stock {
            font-size: 0.7rem;
            color: var(--text-muted);
            margin-top: 0.2rem;
        }

        .cart-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.8rem 1rem;
            border-bottom: 1px dashed var(--border-color);
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item .item-name {
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 0.1rem;
        }

        .cart-item .item-price {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .qty-control {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--bg-body);
            padding: 0.2rem;
            border-radius: 10px;
            border: 1px solid var(--border-color);
        }

        .qty-control button {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            border: none;
            background: var(--bg-card);
            color: var(--text-primary);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            transition: 0.2s;
        }

        .qty-control button:hover {
            background: rgba(99, 102, 241, 0.1);
            color: var(--primary);
        }

        .qty-control span {
            font-weight: 700;
            min-width: 20px;
            text-align: center;
            font-size: 0.85rem;
        }

        .cart-payment-section {
            padding: 1.25rem 1.5rem;
            flex-shrink: 0;
            background: var(--bg-body);
            border-top: 1px solid var(--border-color);
            border-bottom-left-radius: 16px;
            border-bottom-right-radius: 16px;
        }

        .cart-payment-section .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 0.4rem;
        }

        .cart-payment-section .form-control,
        .cart-payment-section .form-select {
            border-radius: 10px;
            font-size: 0.9rem;
            padding: 0.6rem 1rem;
            border-color: var(--input-border);
            background-color: var(--input-bg);
            color: var(--text-primary);
        }

        .cart-payment-section .form-control:focus,
        .cart-payment-section .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            align-items: center;
        }

        .total-row .label {
            color: var(--text-muted);
            font-size: 0.85rem;
            font-weight: 500;
        }

        .total-row .value {
            font-weight: 700;
            font-size: 0.95rem;
        }

        .total-row.grand {
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px dashed var(--border-color);
        }

        .total-row.grand .label {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .total-row.grand .value {
            font-size: 1.5rem;
            color: var(--success);
        }

        .search-bar-wrapper {
            position: relative;
            margin-bottom: 1.25rem;
        }

        .search-bar-wrapper .form-control {
            padding-left: 2.75rem;
            border-radius: 12px;
            height: 48px;
            border: 1px solid var(--border-color);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
            font-size: 0.9rem;
        }

        .search-bar-wrapper .form-control:focus {
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.1);
            border-color: var(--primary);
        }

        .search-bar-wrapper .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 1.1rem;
        }

        @media(max-width: 991.98px) {
            .pos-container {
                flex-direction: column;
                height: auto;
                padding-bottom: 6rem;
            }

            /* Extra padding so FAB doesn't cover checkout button */
            .product-grid {
                overflow-y: visible;
            }

            .cart-panel {
                width: 100%;
                margin-top: 1rem;
            }

            .cart-panel .card {
                min-height: 500px;
                border-radius: 16px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08) !important;
            }
        }
    </style>
@endpush

@section('content')
    <div class="pos-container">
        <!-- Product Grid -->
        <div class="product-grid">
            <div class="search-bar-wrapper">
                <i class="bi bi-search search-icon"></i>
                <input type="text" class="form-control" id="searchProduct" placeholder="Cari produk atau scan barcode..."
                    autofocus>
            </div>
            <div class="row g-3" id="productGrid">
                @foreach($products as $product)
                    <div class="col-6 col-md-4 col-lg-3 product-item" data-name="{{ strtolower($product->name) }}"
                        data-barcode="{{ $product->barcode }}">
                        <div class="product-card-pos" onclick="addToCart({{ json_encode($product) }})">
                            <div class="icon-wrapper">
                                <i class="bi bi-box-seam" style="color:var(--primary-light); font-size:1.25rem;"></i>
                            </div>
                            <div class="p-name">{{ $product->name }}</div>
                            <div class="p-price">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</div>
                            <div class="p-stock">Stok: {{ $product->stock }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Cart Panel -->
        <div class="cart-panel" id="cartSection">
            <div class="card shadow-md border-0" style="border-radius: 16px;">
                <div class="card-header d-flex justify-content-between align-items-center"
                    style="padding:1rem 1.25rem;flex-shrink:0; border-bottom: 1px solid var(--border-color); background: var(--bg-card); border-top-left-radius: 16px; border-top-right-radius: 16px;">
                    <span style="font-weight: 700; font-size: 1.1rem;"><i class="bi bi-cart3 me-2"
                            style="color:var(--primary);"></i>Keranjang</span>
                    <button
                        class="btn btn-outline-danger btn-sm rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 32px; height: 32px; padding: 0;" onclick="clearCart()" title="Kosongkan Keranjang"><i
                            class="bi bi-trash"></i></button>
                </div>
                <div class="card-body p-0" style="flex:1;overflow-y:auto;min-height:0; background: var(--bg-body);"
                    id="cartItems">
                    <div class="text-center py-4 text-muted" id="emptyCart">
                        <i class="bi bi-cart-x" style="font-size:2rem;opacity:0.5;"></i>
                        <p class="mt-1" style="font-size:0.8rem;">Keranjang kosong</p>
                    </div>
                </div>
                <div class="cart-payment-section">
                    <div class="total-row grand mb-2">
                        <span class="label">Total</span>
                        <span class="value" id="grandTotal">Rp 0</span>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Pelanggan (opsional)</label>
                        <select class="form-select form-select-sm" id="customerId" onchange="toggleKasbon()">
                            <option value="">Umum</option>
                            @foreach($customers as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Metode Pembayaran</label>
                        <select class="form-select form-select-sm" id="paymentMethod" onchange="toggleKasbon()">
                            <option value="tunai">Tunai</option>
                            <option value="kasbon" disabled>Kasbon (Pilih Pelanggan)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Bayar</label>
                        <div class="input-group">
                            <span class="input-group-text border-end-0 bg-transparent text-muted"
                                style="border-radius: 10px 0 0 10px; border-color: var(--input-border);">Rp</span>
                            <input type="number" class="form-control border-start-0 ps-0" id="paymentAmount" min="0"
                                oninput="calcChange()">
                        </div>
                    </div>
                    <div class="total-row mb-2">
                        <span class="label">Kembalian</span>
                        <span class="value" id="changeAmount" style="color:var(--info);">Rp 0</span>
                    </div>
                    <button class="btn btn-primary w-100 py-2.5 mt-2" onclick="processCheckout()" id="checkoutBtn" disabled
                        style="font-weight: 600; border-radius: 10px; font-size: 0.95rem;">
                        <i class="bi bi-check-circle me-2"></i>Bayar Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile View Cart Button -->
    <div class="d-lg-none position-fixed w-100 z-3"
        style="bottom: 0; left: 0; padding: 1rem; background: linear-gradient(to top, var(--bg-body) 60%, transparent);">
        <button class="btn btn-primary w-100 shadow-lg" style="border-radius: 14px; font-weight: 600; padding: 0.8rem;"
            onclick="document.getElementById('cartSection').scrollIntoView({behavior: 'smooth'})">
            <i class="bi bi-cart3 me-2"></i>Lihat Keranjang (<span id="mobileCartCount">0</span>)
        </button>
    </div>
@endsection

@push('scripts')
    <script>
        let cart = [];

        function addToCart(product) {
            const existing = cart.find(i => i.product_id === product.id);
            const isLight = document.body.classList.contains('theme-light');

            if (existing) {
                if (existing.quantity >= product.stock) {
                    Swal.fire({ icon: 'warning', title: 'Stok habis!', text: `Stok ${product.name} hanya ${product.stock}`, background: isLight ? '#ffffff' : '#1e293b', color: isLight ? '#0f172a' : '#f8fafc' });
                    return;
                }
                existing.quantity++;
            } else {
                cart.push({ product_id: product.id, name: product.name, price: parseFloat(product.selling_price), quantity: 1, stock: product.stock });
            }
            renderCart();
        }

        function removeFromCart(productId) {
            cart = cart.filter(i => i.product_id !== productId);
            renderCart();
        }

        function updateQty(productId, delta) {
            const item = cart.find(i => i.product_id === productId);
            if (!item) return;
            item.quantity += delta;
            if (item.quantity <= 0) { removeFromCart(productId); return; }

            const isLight = document.body.classList.contains('theme-light');
            if (item.quantity > item.stock) {
                item.quantity = item.stock;
                Swal.fire({ icon: 'warning', title: 'Stok maksimal!', background: isLight ? '#ffffff' : '#1e293b', color: isLight ? '#0f172a' : '#f8fafc', timer: 1500, showConfirmButton: false });
            }
            renderCart();
        }

        function clearCart() { cart = []; renderCart(); }

        function renderCart() {
            const container = document.getElementById('cartItems');
            const emptyEl = document.getElementById('emptyCart');
            if (cart.length === 0) {
                container.innerHTML = '<div class="text-center py-4 text-muted" id="emptyCart"><i class="bi bi-cart-x" style="font-size:2rem;opacity:0.5;"></i><p class="mt-1" style="font-size:0.8rem;">Keranjang kosong</p></div>';
                document.getElementById('grandTotal').textContent = 'Rp 0';
                document.getElementById('checkoutBtn').disabled = true;
                calcChange();
                if (document.getElementById('mobileCartCount')) document.getElementById('mobileCartCount').textContent = 0;
                return;
            }
            let html = '';
            let total = 0;
            cart.forEach(item => {
                const subtotal = item.price * item.quantity;
                total += subtotal;
                html += `<div class="cart-item">
                    <div>
                        <div class="item-name">${item.name}</div>
                        <div class="item-price">Rp ${item.price.toLocaleString('id-ID')} &times; ${item.quantity} = <strong style="color:var(--text-primary);">Rp ${subtotal.toLocaleString('id-ID')}</strong></div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="qty-control">
                            <button onclick="updateQty(${item.product_id}, -1)"><i class="bi bi-dash"></i></button>
                            <span>${item.quantity}</span>
                            <button onclick="updateQty(${item.product_id}, 1)"><i class="bi bi-plus"></i></button>
                        </div>
                        <button onclick="removeFromCart(${item.product_id})" class="btn p-0 text-danger" style="opacity:0.7; transition:0.2s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.7'"><i class="bi bi-x-circle-fill fs-5"></i></button>
                    </div>
                </div>`;
            });
            container.innerHTML = html;
            document.getElementById('grandTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('checkoutBtn').disabled = false;
            calcChange();
            if (document.getElementById('mobileCartCount')) document.getElementById('mobileCartCount').textContent = cart.length;
        }

        function calcChange() {
            const total = cart.reduce((sum, i) => sum + i.price * i.quantity, 0);
            const payment = parseFloat(document.getElementById('paymentAmount').value) || 0;
            const method = document.getElementById('paymentMethod').value;

            if (method === 'kasbon') {
                const debt = total - payment;
                document.getElementById('changeAmount').textContent = debt > 0 ? '(Hutang: Rp ' + debt.toLocaleString('id-ID') + ')' : 'Rp ' + Math.max(0, payment - total).toLocaleString('id-ID');
                document.getElementById('changeAmount').style.color = debt > 0 ? 'var(--warning)' : 'var(--info)';
            } else {
                const change = payment - total;
                document.getElementById('changeAmount').textContent = 'Rp ' + Math.max(0, change).toLocaleString('id-ID');
                document.getElementById('changeAmount').style.color = 'var(--info)';
            }
        }

        function toggleKasbon() {
            const custId = document.getElementById('customerId').value;
            const methodSelect = document.getElementById('paymentMethod');

            if (!custId) {
                methodSelect.value = 'tunai';
                methodSelect.options[1].disabled = true;
                methodSelect.options[1].text = 'Kasbon (Pilih Pelanggan)';
            } else {
                methodSelect.options[1].disabled = false;
                methodSelect.options[1].text = 'Kasbon';
            }
            calcChange();
        }

        function processCheckout() {
            const total = cart.reduce((sum, i) => sum + i.price * i.quantity, 0);
            const payment = parseFloat(document.getElementById('paymentAmount').value) || 0;
            const method = document.getElementById('paymentMethod').value;
            const isLight = document.body.classList.contains('theme-light');

            if (method === 'tunai' && payment < total) {
                Swal.fire({ icon: 'error', title: 'Pembayaran kurang!', text: `Total: Rp ${total.toLocaleString('id-ID')}`, background: isLight ? '#ffffff' : '#1e293b', color: isLight ? '#0f172a' : '#f8fafc' });
                return;
            }

            document.getElementById('checkoutBtn').disabled = true;
            fetch('{{ route("pos.checkout") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                body: JSON.stringify({ items: cart.map(i => ({ product_id: i.product_id, quantity: i.quantity })), payment_amount: payment, customer_id: document.getElementById('customerId').value || null, payment_method: method })
            })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success', title: 'Transaksi Berhasil!', text: `No: ${data.invoice_number}`, background: isLight ? '#ffffff' : '#1e293b', color: isLight ? '#0f172a' : '#f8fafc',
                            showCancelButton: true, confirmButtonText: 'Cetak Struk', cancelButtonText: 'Selesai',
                            confirmButtonColor: '#6366f1'
                        }).then((result) => {
                            if (result.isConfirmed) { window.open('/pos/receipt/' + data.sale_id, '_blank'); }
                            cart = []; renderCart(); document.getElementById('paymentAmount').value = '';
                            location.reload();
                        });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Gagal!', text: data.message, background: isLight ? '#ffffff' : '#1e293b', color: isLight ? '#0f172a' : '#f8fafc' });
                        document.getElementById('checkoutBtn').disabled = false;
                    }
                })
                .catch(err => {
                    Swal.fire({ icon: 'error', title: 'Error!', text: 'Terjadi kesalahan pada server', background: isLight ? '#ffffff' : '#1e293b', color: isLight ? '#0f172a' : '#f8fafc' });
                    document.getElementById('checkoutBtn').disabled = false;
                });
        }

        // Product search and Barcode Scanner handler
        const searchInput = document.getElementById('searchProduct');
        searchInput.addEventListener('input', function () {
            const q = this.value.toLowerCase();
            document.querySelectorAll('.product-item').forEach(el => {
                const name = el.dataset.name;
                const barcode = el.dataset.barcode || '';
                if (q === '') {
                    el.style.display = '';
                } else {
                    el.style.display = (name.includes(q) || barcode.includes(q)) ? '' : 'none';
                }
            });
        });

        searchInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const q = this.value.toLowerCase();
                if (!q) return;

                let exactMatch = null;
                let visibleCount = 0;

                document.querySelectorAll('.product-item').forEach(el => {
                    const name = el.dataset.name;
                    const barcode = el.dataset.barcode || '';
                    const productData = JSON.parse(el.querySelector('.product-card-pos').getAttribute('onclick').match(/addToCart\((.*)\)/)[1]);

                    if (barcode === q || name === q) {
                        exactMatch = productData;
                    }
                    if (el.style.display !== 'none') {
                        visibleCount++;
                    }
                });

                if (exactMatch) {
                    addToCart(exactMatch);
                    this.value = '';
                    this.dispatchEvent(new Event('input')); // Reset list
                } else if (visibleCount === 1) {
                    // If exactly one fuzzy match, add it
                    const singleEl = document.querySelector('.product-item:not([style*="display: none"]) .product-card-pos');
                    if (singleEl) {
                        singleEl.click();
                        this.value = '';
                        this.dispatchEvent(new Event('input')); // Reset list
                    }
                }
            }
        });
    </script>
@endpush