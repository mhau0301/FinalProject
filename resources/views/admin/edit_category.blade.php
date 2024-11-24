<!DOCTYPE html>
<html>
  <head> 
    @include('admin/css')

    <style type="text/css">
        .div_deg{
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 60px;
        }

        input[type='text']{
            width: 400px;
            height: 40px;
        }

    </style>

  </head>
  <body>
    @include('admin.header')
    @include('admin.sidebar')
      <!-- Sidebar Navigation end-->
      <div class="page-content">
        <div class="page-header">
          <div class="container-fluid">

          <h1 style="color: white; text-align: center;">Update Category</h1>

          @if(session()->has('message'))
            <div class="alert alert-success">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
              {{session()->get('message')}}
            </div>
            @endif
          <div class="div_deg">
            <form action="{{url('update_category',$data->id)}}" method="post">
                @csrf
                <input type="text" name="category" value="{{$data->category_name}}">
                <input class="btn btn-primary" type="submit" value="Update Category">
            </form>
          </div>
                
      </div>
    </div>
    @include('admin.js')

  </body>
</html>