<!DOCTYPE html>
<html>
<head>
    @include('admin.css')

    <style type="text/css">
        .center {
            margin: 0 auto;
            width: 100%;
            border: 2px solid white;
            text-align: center;
            margin-top: 40px;
            border-collapse: collapse;
            color: black;
        }

        .font_size {
            text-align: center;
            font-size: 40px;
            padding-top: 20px;
        }

        .img_size {
            width: 150px;
            height: 150px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #3c763d;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:nth-child(odd) {
            background-color: #ffffff;
        }

        tr:hover {
            background-color: #add8e6;
        }

        .btn-spacing {
            margin-bottom: 10px;
        }

        .status-bar {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f0f0f0;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .status-bar div {
            flex: 1;
            text-align: center;
            padding: 10px 15px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            border-radius: 5px;
        }

        .status-bar div.active {
            background-color: #007bff;
            color: white;
        }

        .status-bar div:not(:last-child) {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    @include('admin.header')
    @include('admin.sidebar')

    <!-- Page Content -->
    <div class="page-content">
        <div class="container-fluid">

            <form action="{{url('product_search')}}" method="get">
                @csrf
                <input type="search" name="search">
                <input type="submit" class="btn btn-secondary" value="Search">
            </form>

            <!-- Status Bar -->
            <div class="status-bar">
                <div>
                    <a href="{{ route('filter.products', 'all') }}" class="{{ request()->is('products/all') ? 'active' : '' }}">All</a>
                </div>
                <div>
                    <a href="{{ route('filter.products', 'Xe số') }}" class="{{ request()->is('products/Xe số') ? 'active' : '' }}">Xe số</a>
                </div>
                <div>
                    <a href="{{ route('filter.products', 'Xe tay ga') }}" class="{{ request()->is('products/Xe tay ga') ? 'active' : '' }}">Xe tay ga</a>
                </div>
                <div>
                    <a href="{{ route('filter.products', 'Xe máy điện') }}" class="{{ request()->is('products/Xe máy điện') ? 'active' : '' }}">Xe máy điện</a>
                </div>
                <div>
                    <a href="{{ route('filter.products', 'Xe đạp điện') }}" class="{{ request()->is('products/Xe đạp điện') ? 'active' : '' }}">Xe đạp điện</a>
                </div>
                <div>
                    <a href="{{ route('filter.products', 'Xe đạp') }}" class="{{ request()->is('products/Xe đạp') ? 'active' : '' }}">Xe đạp</a>
                </div>
            </div>

            <!-- Table -->
            <table class="center">
                <tr>
                    <th>Product Title</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Discount Price</th>
                    <th>Product Image</th>
                    <th>Delete</th>
                    <th>Edit</th>
                </tr>

                @foreach($product as $product)
                <tr>
                    <td>{{ $product->title }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->category }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->discount_price }}</td>
                    <td><img class="img_size" src="/products/{{ $product->image }}" alt="product image"></td>
                    <td><a class="btn btn-danger" href="{{ url('delete_product', $product->id) }}">Delete</a></td>
                    <td><a class="btn btn-success" href="{{ url('update_product', $product->id) }}">Edit</a></td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>

    <script>
 // Hàm để lọc đơn hàng hoặc sản phẩm theo trạng thái đã chọn
        function filterOrders(status) {
            const rows = document.querySelectorAll('.order-row'); // Chọn tất cả các dòng trong bảng đơn hàng
            let hasVisibleRow = false;

            // Lọc các hàng trong bảng dựa trên trạng thái
            rows.forEach(row => {
                const orderStatus = row.dataset.status.toLowerCase(); // Lấy trạng thái của đơn hàng
                if (status === 'all' || orderStatus === status) {
                    row.style.display = ''; // Hiển thị hàng nếu trạng thái khớp
                    hasVisibleRow = true;
                } else {
                    row.style.display = 'none'; // Ẩn hàng nếu trạng thái không khớp
                }
            });

            // Cập nhật trạng thái active
            document.querySelectorAll('.status-bar div').forEach(div => div.classList.remove('active'));
            document.querySelector(`.status-bar div[onclick="filterOrders('${status}')"]`).classList.add('active');
        }

        // Chạy hàm khi trang tải
        window.addEventListener('load', () => {
            const status = new URLSearchParams(window.location.search).get('status') || 'all'; // Lấy trạng thái từ URL nếu có
            filterOrders(status);
        });

        // Xử lý sự kiện popstate khi người dùng điều hướng lại
        window.addEventListener('popstate', event => {
            const status = new URLSearchParams(window.location.search).get('status') || 'all';
            if (event.state) {
                filterOrders(status);
            }
        });

    </script>

    @include('admin.js')


</body>
</html>
