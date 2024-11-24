<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        @include('home.css')
        <style type="text/css">
        .center {
            margin: auto;
            width: 80%; /* Chiều rộng bảng */
            border: 2px solid white;
            text-align: center;
            margin-top: 40px;
            border-collapse: collapse; /* Gộp viền */
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
            border: 1px solid black; /* Viền bảng */
        }

        th, td {
            padding: 10px; /* Khoảng cách nội dung */
            text-align: center; /* Canh giữa văn bản */
        }

        /* Đổi màu cho dòng tiêu đề */
        th {
            background-color: #cbd2a4; /* Màu nền */
            color: white; /* Màu chữ trắng */
        }

        /* Màu nền xen kẽ cho các dòng */
        tr:nth-child(even) {
            background-color: #f2f2f2; /* Xám nhạt */
        }

        tr:nth-child(odd) {
            background-color: #ffffff; /* Trắng */
        }

        /* Hiệu ứng hover */
        tr:hover {
            background-color: #d5e8ff; /* Màu xanh nhạt khi hover */
        }
    </style>
    </head>
    <body>

        <div class="hero_area">
            @include('home.header')

            <table class="center">
                        <tr>
                            <th>Product name</th>
                            <th>Price</th>
                            <th>Image</th>
                            <th>Delivery Status</th>
                        </tr>

                        @foreach($order as $order)
                        <tr>
                            <td>{{$order->product->title}}</td>
                            <td>{{$order->product->price}}</td>
                            <td>
                                <img width="150" src="products/{{$order->product->image}}">
                            </td>
                            <td>{{$order->status}}</td>
                        </tr>
                        @endforeach
                    </table>
        </div>

    </body>
</html>