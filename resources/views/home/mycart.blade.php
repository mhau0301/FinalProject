<!DOCTYPE html>
<html>

<head>
    @include('home.css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style type="text/css">
        .div_deg {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 60px;
        }

        table {
            border: 2px solid black;
            text-align: center;
            width: 800px;
        }

        th {
            border: 2px solid black;
            text-align: center;
            color: white;
            font: 20px;
            font-weight: bold;
            background-color: black;
        }

        td {
            border: 1px solid skyblue;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            text-align: center;
            background-color: #333;
            color: white;
            padding: 10px;
        }

        .hero_area {
            z-index: 1030; /* Đặt z-index nhỏ hơn modal */
            position: relative; /* Đảm bảo header không bị cố định cứng */
        }
        .modal {
             z-index: 1055 !important; /* Đảm bảo modal nằm trên header */
        }

        .modal-body input,
        .modal-body textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        a {
    text-decoration: none; /* Loại bỏ gạch chân khỏi tất cả các liên kết */
}

    </style>
</head>

<body>

    <div class="hero_area">
        @include('home.header')
    </div>

    @if(session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="text-align: center">
            {{ session()->get('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif



    <div class="div_deg">
        <table>
            <tr>
                <th>Product Title</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Image</th>
                <th>Remove</th>
            </tr>

            <?php $value = 0; ?>

            @foreach($cart as $cart)
            <tr>
                <td>{{$cart->product->title}}</td>
                <td>{{$cart->product->price}}</td>
                <td>{{$cart->quantity}}</td>
                <td>
                    <img width="150px" src="/products/{{$cart->product->image}}" alt="">
                </td>
                <td>
                    <a class="btn btn-danger" onclick="return confirm('Are you sure to remove this product?')"
                        href="{{url('remove_cart', $cart->id)}}">Remove</a>
                </td>
            </tr>
            <?php $value += $cart->product->price; ?>
            @endforeach
        </table>
    </div>

    <div class="footer">
        <div>
            <h3>Total Value: {{$value}} vnđ</h3>
        </div>
        <div>
            <!-- Nút để mở modal -->
            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#orderModal">Place</button>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderModalLabel">Order Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{url('confirm_order')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <label for="name">Receiver Name:</label>
                        <input type="text" name="name" value="{{Auth::user()->name}}" required>

                        <label for="address">Receiver Address:</label>
                        <textarea name="address" required>{{Auth::user()->address}}</textarea>

                        <label for="phone">Receiver Phone:</label>
                        <input type="text" name="phone" value="{{Auth::user()->phone}}" required>

                        <p><strong>Total Value:</strong> {{$value}} vnđ</p>
                        <input type="hidden" name="total_value" value="{{$value}}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Confirm Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>
