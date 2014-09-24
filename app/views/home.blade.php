<!doctype html>
<html>
    <head>
      <title>Golden Ticket Distribution</title>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    </head>
    <body>
      <div class="container">
        <h1>Golden Ticket Distribution</h1>
        <form method="POST">
          <input type="text" name="name" placeholder="Name" />
          <input type="text" name="phone_num" placeholder="Phone Number" />
          <input type="submit" name="submit" value="Send" />
        </form>
        @if(Session::has('alert'))
            <div class="alert alert-info">
                <h2>{{ Session::get('alert') }}</h2>
            </div>
        @endif
      </div>
    </body>
</html>
