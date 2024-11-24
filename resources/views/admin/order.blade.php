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
    </style>
  </head>
  <body>
    @include('admin.header')
    @include('admin.sidebar')
      <!-- Sidebar Navigation end-->
    <div class="page-content">
            <div class="container-fluid">

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
                        <tr>
                            <td>{{$data->name}}</td>
                            <td>{{$data->rec_address}}</td>
                            <td>{{$data->phone}}</td>
                            <td>{{$data->product->title}}</td>
                            <td>{{$data->product->price}}</td>
                            <td>
                                <img width="150" src="products/{{$data->product->image}}">
                            </td>
                            <td>{{$data->status}}</td>
                            <td>
                                <a class="btn btn-primary" href="{{url('on_the_way',$data->id)}}">On the way</a>
                                <a class="btn btn-success" href="{{url('delivered',$data->id)}}">Delivered</a>
                                <a class="btn btn-warning" href="{{url('in_progress',$data->id)}}">In progress</a>

                            </td>
                        </tr>
                        @endforeach
                    </table>
            
            </div>
        </div>
    </div>
    @include('admin.js')

   
  </body>
</html>