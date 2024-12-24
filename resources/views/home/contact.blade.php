<!DOCTYPE html>
<html>

<head>
    @include('home.css')
</head>

<body>
  <div class="hero_area">
        @include('home.header')
  </div>
<br>
<br>
    @if(session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

  <section class="contact_section ">
    <div class="container px-0">
      <div class="heading_container ">
        <h2 class="">
          Contact Us
        </h2>
      </div>
    </div>
    <div class="container container-bg">
      <div class="row">
        <div class="col-lg-7 col-md-6 px-0">
          <div class="map_container">
            <div class="map-responsive">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3645.945101899452!2d108.25065207490204!3d15.975260284690663!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3142108997dc971f%3A0x1295cb3d313469c9!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBDw7RuZyBuZ2jhu4cgVGjDtG5nIHRpbiB2w6AgVHJ1eeG7gW4gdGjDtG5nIFZp4buHdCAtIEjDoG4sIMSQ4bqhaSBo4buNYyDEkMOgIE7hurVuZw!5e1!3m2!1svi!2s!4v1732464492481!5m2!1svi!2s" width="600" height="450" style="border:0; width: 100%; height:100%" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-5 px-0">
        <form action="{{ route('sendEmail') }}" method="POST">
          @csrf
          <div>
              <input type="text" name="name" placeholder="Name" required />
          </div>
          <div>
              <input type="email" name="email" placeholder="Email" required />
          </div>
          <div>
              <textarea name="message" class="message-box" placeholder="Message" required></textarea>
          </div>
          <div class="d-flex">
              <button type="submit">SEND</button>
          </div>
      </form>

        </div>
      </div>
    </div>
  </section>

  <br><br><br>    
</body>

</html>
