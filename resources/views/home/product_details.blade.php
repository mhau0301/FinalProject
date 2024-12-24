<!DOCTYPE html>
<html>

    <head>
        @include('home.css')

        <style type="text/css">
            .product-card {
                border: 1px solid #ddd;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                padding: 20px;
                margin-bottom: 20px;
                width: 120%;
                max-width: 1200px;
                margin: 20px auto;
                display: flex;
                justify-content: space-between;
            }

            .product-card .img-box {
                flex: 1;
            }

            .product-card .img-box img {
                max-width: 100%;
                height: auto;
                border-radius: 10px;
            }

            .product-card .details {
                flex: 1;
                margin-left: 30px;
            }

            .product-card h5 {
                font-size: 24px;
                font-weight: bold;
                color: #333;
                text-align: center;
            }

            .product-card h6 {
                color: #aaa;
            }

            .price-row {
                display: flex;
                align-items: center;
                gap: 10px;
                margin-top: 10px;
            }

            .product-card h6 {
                font-size: 18px;
                color: #555;
            }

            .product-card .old-price {
                text-decoration: line-through;
                color: #888;
            }

            .product-card .discount-price {
                color: #e74c3c;
                font-weight: bold;
            }

            .product-card .price {
                color: #e74c3c;
                font-weight: bold;
            }

            .product-info {
                display: flex;
                flex-direction: column; /* Căn chỉnh theo chiều dọc */
                gap: 10px; /* Khoảng cách giữa các dòng */
                margin-top: 15px;
                color: #666;
            }

            .product-info p {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin: 0; /* Loại bỏ khoảng cách mặc định */
            }

            .product-info .label {
                font-weight: bold; /* In đậm phần nhãn */
                font-size: 14px;
                color: #999; /* Màu xám nhạt cho nhãn */
                flex: 0 0 150px;
                text-align: left;
            }

            .product-info .value {
                font-weight: bold; /* Không in đậm */
                font-size: 18px;
                color: #333; /* Màu tối hơn cho giá trị */
                flex: 1;
                text-align: left;
            }

            .product-info h6 {
                margin: 0; /* Loại bỏ margin mặc định */
                color: #555;
            }


            .quantity-add-cart {
                display: flex;
                align-items: center;
                gap: 15px;
                margin-top: 20px;
            }

            .quantity-input {
                width: 80px;
                text-align: center;
                padding: 5px;
            }

            .quantity-container {
                width: 100%; /* Chiếm toàn bộ chiều rộng */
                text-align: center; /* Căn giữa ô nhập số lượng */
                margin-top: 25px; /* Thêm khoảng cách phía dưới */
            }

            .add-to-cart-container {
                width: 100%; /* Chiếm toàn bộ chiều rộng */
                text-align: center; /* Căn giữa nút Add to Cart */
                margin-top: 10px; /* Thêm khoảng cách phía trên */
            }


            .add-to-cart-btn {
                background-color: #3498db;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s ease;
                width: 200px;
            }

            .add-to-cart-btn:hover {
                background-color: #2980b9;
            }

        </style>
    </head>

    <body>
        <div class="hero_area">
            @include('home.header')
            @if(session()->has('message'))
            <div class="alert alert-success" style="text-align: center">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
                {{ session()->get('message') }}
            </div>
            @endif 
            <div class="container mt-5">
                <div class="row justify-content-center">
                <div class="col-md-10 col-lg-8">
                <div class="product-card">
        <!-- Image Section -->
        <div class="img-box">
            <img src="/products/{{$data->image}}" alt="">
        </div>

        <!-- Product Details -->
        <div class="details">
            <h5>{{$data->title}}</h5>

            <!-- Giá sản phẩm -->
            <div class="price-row">
                @if($data->discount_price != null)
                    <h5 class="discount-price">{{$data->discount_price}} vnd</h5>
                    <h7 class="old-price">{{$data->price}} vnđ</h7>
                @else
                    <h5 class="price">{{$data->price}} vnđ/24h</h5>
                @endif
            </div>

            <!-- Thông tin khác hiển thị theo cột -->
            <div class="product-info">
                <p>
                    <span class="label">Category:</span> 
                    <span class="value">{{$data->category}}</span>
                </p>
                <p>
                    <span class="label">Description:</span> 
                    <span class="value">{{$data->description}}</span>
                </p>
                <p>
                    <span class="label">Available Quantity:</span> 
                    <span class="value">{{$data->quantity}}</span>
                </p>
            </div>

            <!-- Kiểm tra nếu sản phẩm hết hàng -->
            @if($data->quantity == 0)
                <p class="out-of-stock">Sản phẩm đã hết hàng</p>
            @else
                <!-- Form nhập số lượng và nút "Add to Cart" -->
                <form action="{{url('add_cart', $data->id)}}" method="post">
                    @csrf
                    <div class="quantity-container">
                        Quantity: <input type="number" name="quantity" class="quantity-input" min="1" value="1">
                    </div>
                    <div class="add-to-cart-container">
                        <input type="submit" value="Add To Cart" class="add-to-cart-btn">
                    </div>
                </form>
            @endif

        </div>
    </div>


                  </div>
               </div>
            </div>
         </div>
<br><br><br><br><br><br>
    </body>

        @include('home.footer')

</html>