<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sunrise</title>

    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/jumbotron.css" rel="stylesheet">
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">Sunrise</a>
        <div class="nav-collapse collapse">
          <form class="navbar-form form-inline pull-right">
            <input type="text" placeholder="Email" class="form-control">
            <input type="password" placeholder="Password" class="form-control">
            <button type="submit" class="btn" id="btn_in">Sign In</button>
            <button type="submit" class="btn" id="btn_up">Sign Up</button>
          </form>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container">

      <div class="jumbotron">
        <h1>Welcome to Sunrise</h1>
        <p>Sunrise is an open video conference solution based on HTML5 WebRTC. You can use this software for online meeting at your company or for talking to your friends. Moreover, you may provide more enhanced customer service using video chat. Enjoy the next generation of the Web with Sunrise. It is an open source sofrware licensed under Apache License Version 2.0.</p>
        <div class="container">
            <span>Room Name:</span>
            <input type="text" placeholder="ex. Sunrise Meeting" class="form-control">
        </div>
        <p><a class="btn btn-primary btn-large">Go to the Room!</a></p>
      </div>

      <div class="body-content">

        <!-- Example row of columns -->
        <div class="row">
          <div class="col-lg-4">
            <h2>Custom Heading 1</h2>
            <p>Custom Message 1</p>
          </div>
          <div class="col-lg-4">
            <h2>Custom Heading 2</h2>
            <p>Custom Message 2</p>
          </div>
          <div class="col-lg-4">
            <h2>Custom Heading 3</h2>
            <p>Custom Message 3</p>
          </div>
        </div>

        <hr>

        <footer>
          <p>Footer</p>
        </footer>
      </div>

    </div> <!-- /container -->

    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
