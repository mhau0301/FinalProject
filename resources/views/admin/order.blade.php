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


            <!-- Status Bar -->
            <div class="status-bar">
                <div onclick="filterOrders('all')" class="active">All</div>
                <div onclick="filterOrders('in_progress')">In Progress</div>
                <div onclick="filterOrders('on_the_way')">On The Way</div>
                <div onclick="filterOrders('delivered')">Delivered</div>
                <div onclick="filterOrders('returned')">Returned</div>
                <div onclick="filterOrders('canceled')">Canceled</div>
            </div>

            <!-- Table -->
            <table class="center">
                <tr>
                    <th>Customer name</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Product title</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Change Status</th>
                </tr>

                @foreach($data as $data)
                <tr class="order-row" data-status="{{ Str::snake(strtolower($data->status)) }}">
                    <td>{{$data->name}}</td>
                    <td>{{$data->rec_address}}</td>
                    <td>{{$data->phone}}</td>
                    <td>{{$data->product->title}}</td>
                    <td>{{$data->product->price}}</td>
                    <td>
                        <img class="img_size" src="{{ asset('products/' . $data->product->image) }}">
                    </td>
                    <td>{{$data->status}}</td>
                    <td>
                        @if($data->status === 'in progress')
                            <a class="btn btn-primary btn-spacing" href="{{url('on_the_way',$data->id)}}">On The Way</a>
                            <a class="btn btn-success btn-spacing" href="{{url('delivered',$data->id)}}">Delivered</a>
                            <a class="btn btn-secondary btn-spacing" href="{{url('returned',$data->id)}}">Returned</a>
                            <a class="btn btn-danger btn-spacing" href="{{url('canceled',$data->id)}}">Canceled</a>
                        @elseif($data->status === 'On the Way')
                            <a class="btn btn-success btn-spacing" href="{{url('delivered',$data->id)}}">Delivered</a>
                            <a class="btn btn-secondary btn-spacing" href="{{url('returned',$data->id)}}">Returned</a>
                            <a class="btn btn-danger btn-spacing" href="{{url('canceled',$data->id)}}">Canceled</a>
                        @elseif($data->status === 'Delivered')
                            <a class="btn btn-secondary btn-spacing" href="{{url('returned',$data->id)}}">Returned</a>
                        @elseif($data->status === 'returned' || $data->status === 'Canceled')
                            <!-- Không hiển thị nút nào thêm khi đã trả xe hoặc hủy -->
                        @endif
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>

    @include('admin.js')

    <!-- JavaScript for filtering -->
    <script>
        function filterOrders(status) {
            const rows = document.querySelectorAll('.order-row');
            let hasVisibleRow = false;

            rows.forEach(row => {
                const orderStatus = row.dataset.status.toLowerCase();
                if (status === 'all' || orderStatus === status) {
                    row.style.display = '';
                    hasVisibleRow = true;
                } else {
                    row.style.display = 'none';
                }
            });

            // Cập nhật trạng thái active
            document.querySelectorAll('.status-bar div').forEach(div => div.classList.remove('active'));
            document.querySelector(`.status-bar div[onclick="filterOrders('${status}')"]`).classList.add('active');

            // Cập nhật URL mà không tải lại trang
            const newUrl = window.location.pathname + '?status=' + status;
            history.pushState({ status: status }, '', newUrl);
        }

        window.addEventListener('load', () => {
            const status = new URLSearchParams(window.location.search).get('status') || 'all';
            filterOrders(status);
        });

        window.addEventListener('popstate', event => {
            const status = new URLSearchParams(window.location.search).get('status') || 'all';
            if (event.state) {
                filterOrders(status);
            }
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
