<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    @include('home.css')
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .header-nav {
            display: flex;
            justify-content: space-around;
            background-color: #f8f8f8;
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }
        .header-nav a {
            text-decoration: none;
            color: #333;
            padding: 10px 20px;
            border-radius: 4px;
        }
        .header-nav a.active {
            background-color: #007bff;
            color: white;
        }

        .status-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 20px auto;
            max-width: 900px;
            padding: 10px;
            border-radius: 8px;
            background-color: #f0f0f0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .status-bar div {
            flex: 1;
            text-align: center;
            padding: 10px 0;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
        }
        .status-bar div.active {
            background-color: #007bff;
            color: white;
            border-radius: 8px;
        }
        .status-bar div:not(:last-child) {
            border-right: 1px solid #ddd;
        }

        .order-container {
            max-width: 900px;
            margin: 20px auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #f1f1f1;
        }
        .order-item:last-child {
            border-bottom: none;
        }
        .order-image {
            margin-right: 20px;
        }
        .order-image img {
            width: 100px;
            height: 100px;
            border-radius: 8px;
            object-fit: cover;
        }
        .order-details {
            flex: 1;
        }
        .order-details h4 {
            margin: 0;
            color: #333;
            font-size: 16px;
        }
        .order-details p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }
        .action-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .total-price {
            font-size: 18px;
            color: #007bff;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .btn-cancel {
            text-decoration: none;
            background-color: #dc3545;
            color: white;
            padding: 8px 15px;
            border-radius: 4px;
            font-size: 14px;
            text-align: center;
        }
        .btn-cancel:hover {
            background-color: #a71d2a;
        }

        .alert {
            padding: 15px;
            margin: 10px 0;
            border-radius: 4px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

    </style>
</head>
<body>
    <div class="hero_area">
        @include('home.header')

        <div class="header-nav">
            <a href="#" onclick="filterOrders('all')" class="active">Tất cả</a>
            <a href="#" onclick="filterOrders('in_progress')">Đang chuẩn bị</a>
            <a href="#" onclick="filterOrders('on_the_way')">Vận chuyển</a>
            <a href="#" onclick="filterOrders('delivered')">Đã nhận hàng</a>
            <a href="#" onclick="filterOrders('returned')">Đã trả xe</a>
            <a href="#" onclick="filterOrders('canceled')">Đã hủy</a>
        </div>

        <div class="status-bar">
            <div onclick="filterOrders('in_progress')">In Progress</div>
            <div onclick="filterOrders('on_the_way')">On The Way</div>
            <div onclick="filterOrders('delivered')">Delivered</div>
            <div onclick="filterOrders('returned')">Returned</div>
            <div onclick="filterOrders('canceled')">Canceled</div>
        </div>

        @if(session()->has('message'))
        <div class="alert alert-success alert-dismissible" id="alert-message">
            <button type="button" class="close" aria-hidden="true" onclick="closeAlert()">&times;</button>
            {{ session()->get('message') }}
        </div>
    @endif

        <div class="order-container">
        @foreach($order as $order)
            <div class="order-item" data-status="{{ Str::snake(strtolower($order->status)) }}">
                <div class="order-image">
                    <img src="/products/{{ $order->product->image }}" alt="{{ $order->product->title }}">
                </div>

                <div class="order-details">
                    <h4>Product: {{ $order->product->title }}</h4>
                    <p>Days: {{ $order->days }}</p>
                    <p>Status: {{ $order->status }}</p>
                </div>

                <div class="action-container">
                    <div class="total-price">
                        {{ number_format($order->total_value, 0, ',', '.') }}.000 VND
                    </div>

                    @if(!in_array(strtolower($order->status), ['on the way', 'delivered', 'canceled', 'returned']))
                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-cancel">Cancel Order</button>
                    </form>
                    @endif

                    @if(strtolower($order->status) === 'on the way')
                    <form action="{{ route('orders.markAsDelivered', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-cancel" style="background-color: #28a745;">Đã nhận được hàng</button>
                    </form>
                    @endif

                    @if(strtolower($order->status) === 'delivered')
                    <form action="{{ route('orders.return', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-cancel" style="background-color: #28a745;">Return Vehicle</button>
                    </form>
                    @endif
                </div>

            </div>
        @endforeach
        </div>
    </div>

    <script>
        function filterOrders(status) {
            const items = document.querySelectorAll('.order-item');
            items.forEach(item => {
                const orderStatus = item.dataset.status.toLowerCase();
                if (status === 'all' || orderStatus === status) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });

            document.querySelectorAll('.header-nav a, .status-bar div').forEach(element => {
                element.classList.remove('active');
            });
            const navElement = document.querySelector(`.header-nav a[onclick="filterOrders('${status}')"]`);
            const statusBarElement = document.querySelector(`.status-bar div[onclick="filterOrders('${status}')"]`);
            if (navElement) navElement.classList.add('active');
            if (statusBarElement) statusBarElement.classList.add('active');

            const newUrl = window.location.pathname + '?status=' + status;
            history.pushState({ status: status }, '', newUrl);
        }

        window.addEventListener('popstate', function(event) {
            const status = new URLSearchParams(window.location.search).get('status') || 'all';
            filterOrders(status);
        });

        window.addEventListener('load', function() {
            const status = new URLSearchParams(window.location.search).get('status') || 'all';
            filterOrders(status);
        });

    </script>

</body>
</html>
