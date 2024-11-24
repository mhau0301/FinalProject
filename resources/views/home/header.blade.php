<header class="header_section">
      <nav class="navbar navbar-expand-lg custom_nav-container ">
        <a class="navbar-brand" href="{{url('/')}}">
          <span>
            Rental
          </span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class=""></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav  ">
            <li class="nav-item active">
              <a class="nav-link" href="{{url('/')}}">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('view_products') }}">
                Shop
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('why') }}">
                Why Us
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('testimonial') }}">
                Testimonial
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{url('contact')}}">Contact Us</a>
            </li>
          </ul>
          <div class="user_option">


          @if (Route::has('login'))

            @auth

          <a href="{{url('myorders')}}">
            My Orders                  
          </a>
            
          <a href="{{url('mycart')}}">
              <i class="fa fa-shopping-bag" aria-hidden="true"></i>
              {{$count}}
          </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="margin-left: 20px;" class="btn btn-danger">Logout</button>
            </form>

            @else

            <a href="{{url('/login')}}">
              <i class="fa fa-user"  style="margin-left: 20px;" aria-hidden="true"></i>
              <span>
                Login
              </span>
            </a>

            <a href="{{url('/register')}}">
              <i class="fa fa-vcard" aria-hidden="true"></i>
              <span>
                Register
              </span>
            </a>
            @endauth

            @endif
            
          </div>
        </div>
      </nav>
    </header>
    <!-- end header section -->
    
