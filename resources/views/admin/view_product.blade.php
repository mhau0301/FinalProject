<!DOCTYPE html>
<html>
  <head> 
    @include('admin/css')
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

        input[type='search'] {
            width: 500px;
            height: 60px;
            margin-left: 50px;
        }

    </style>
  </head>
  <body>
    @include('admin.header')
    @include('admin.sidebar')
      <!-- Sidebar Navigation end-->
      <div class="page-content">
          <div class="container-fluid">

          <form action="{{url('product_search')}}" method="get">
            @csrf
            <input type="search" name="search">
            <input type="submit" class="btn btn-secondary" value="Search">
          </form>

          @if(session()->has('message'))
            <div class="alert alert-success">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
              {{session()->get('message')}}
            </div>
            @endif

            <h2 class="font_size">All Products</h2>

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
                        <td>{{$product->title}}</td>
                        <td>{{$product->description}}</td>
                        <td>{{$product->quantity}}</td>
                        <td>{{$product->category}}</td>
                        <td>{{$product->price}}</td>
                        <td>{{$product->discount_price}}</td>
                        <td>
                            <img class="img_size" src="/products/{{$product->image}}" alt="">
                        </td>

                        <td>
                            <a class="btn btn-danger" onclick="return confirm('Are you sure to Delete this?')" href="{{url('delete_product',$product->id)}}">Delete</a>
                        </td>
                        <td>
                            <a class="btn btn-success" href="{{url('update_product', $product->id)}}">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>

          </div>
        </div>
    </div>
    @include('admin.js')

   
  </body>
</html>