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
            z-index: 1030;
            position: relative;
        }

        .modal {
            z-index: 1055 !important;
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
            text-decoration: none;
        }

        .total-value-container {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin: 10px 0;
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

            @foreach($cart as $item)
            <tr>
                <td>{{$item->product->title}}</td>
                <td>{{$item->product->price}} vnd/day</td>
                <td>{{$item->quantity}}</td>
                <td>
                    <img width="150px" src="/products/{{$item->product->image}}" alt="">
                </td>
                <td>
                    <a class="btn btn-danger" onclick="return confirm('Are you sure to remove this product?')"
                        href="{{url('remove_cart', $item->id)}}">Remove</a>
                </td>
            </tr>
            <?php 
                $days = 1; // Giá trị mặc định nếu không nhập days
                $value += $item->product->price * $days * $item->quantity; // Nhân giá với số ngày thuê và số lượng            
            ?>
            @endforeach
        </table>
    </div>

    <div class="footer">
        <div style="display: flex; justify-content: center; align-items: center;">
            <label for="daysInput" style="margin-right: 10px;">Days:</label>
            <input type="number" id="daysInput" name="days" min="1" value="1" style="width: 80px; margin-right: 10px;" required>
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
                        <textarea name="address" required>{{ Auth::user()->address }}</textarea>

                        <label for="phone">Receiver Phone:</label>
                        <input type="text" name="phone" value="{{Auth::user()->phone}}" required>

                        <p class="total-value-container"><strong>Total Value:</strong> <span id="modalTotalValue">0</span></p>
                        <input type="hidden" name="days" value="1" id="hiddenDays">
                        <input type="hidden" name="total_value" id="hiddenTotalValue" value="">

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

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const daysInput = document.getElementById("daysInput");
        const modalTotalValue = document.getElementById("modalTotalValue");
        const hiddenTotalValue = document.getElementById("hiddenTotalValue");
        const hiddenDays = document.getElementById("hiddenDays");
        const placeButton = document.querySelector("[data-bs-target='#orderModal']");

        // Chuyển dữ liệu giỏ hàng từ backend
        const cartItems = @json($cart->map(fn($item) => [
            'price' => $item->product->price,
            'quantity' => $item->quantity,
        ]));

        function calculateTotalValue() {
            const days = parseInt(daysInput.value) || 1; // Số ngày thuê
            let totalValue = 0;

            cartItems.forEach(item => {
                totalValue += item.price * item.quantity * days;
            });

            return totalValue;
        }

        placeButton.addEventListener("click", function () {
            const totalValue = calculateTotalValue();
            modalTotalValue.textContent = totalValue.toLocaleString() + " vnđ";
            hiddenTotalValue.value = totalValue;
            hiddenDays.value = daysInput.value;
        });
    });
</script>

</html>
