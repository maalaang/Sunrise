<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sunrise</title>

    <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/bootstrap.css" rel="stylesheet">
    <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/jumbotron.css" rel="stylesheet">
    <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/foot.css" rel="stylesheet">
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
        <hr/>
        <form>
            <fieldset>
                <table align="center">
                    <tr>
                        <td><label for="room_name">Room Name :</label></td>
                        <td><input id="room_name" type="text" placeholder="ex.Sunrise Meeting"/></td>
                    </tr>
                    <tr>
                        <td><label for="your_name">Your Name :</label></td>
                        <td><input id="your_name" type="text" placeholder="ex.Steve Kim"/></td>
                    </tr>
                </table>
                <p style="text-align:center; margin: 10px">
                    <button type="submit" class="btn btn-primary btn-large">Go to the Room!</button> 
                </p>
            </fieldset>
        </form>
      </div>

      <div class="body-content">
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

       <!-- <footer>
            <span><a href="#" class="foot_link"><ins>Privacy Policy</ins></a></span>
            <span><a href="#" class="foot_link"><ins>About Sunrise</ins></a></span>
            <span><a href="#" class="foot_link"><ins>Admin Page</ins></a></span>
            <span><a href="#" class="foot_link_right"><ins>Powered by Sunrise</ins></a></span>
        </footer>-->
      </div>

    </div> <!-- /container -->

    </body>

    <footer>
        <div class="container">
            <span><a href="#" class="foot_link"><ins>Privacy Policy</ins></a></span>
            <span><a href="#" class="foot_link"><ins>About Sunrise</ins></a></span>
            <span><a href="#" class="foot_link"><ins>Admin Page</ins></a></span>
            <span><a href="#" class="foot_link_right"><ins>Powered by Sunrise</ins></a></span>
        </div>
    </footer>
</html>
