<?php //Main Page 
include_once "control.php";?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
  

    <title>MySQLToObject </title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

  </head>

  <body>

    <div class="container">

      <form class="form-signin" action="#" method="post">
        <h2 class="form-signin-heading">MySQLToObject</h2>





        <label for="adress" class="sr-only">IP Adress</label>
        <input type="text" id="adress" class="form-control" placeholder="IP Adress" required autofocus value="127.0.0.1" name="adress">

        <label for="port" class="sr-only">Port</label>
        <input type="text" id="port" class="form-control" placeholder="Port(default)"  autofocus value="" name="port">


        <label for="db" class="sr-only">DataBase</label>
        <input type="text" id="db" class="form-control" placeholder="Data Base Name" required autofocus value="meow" name="db">

        <label for="user" class="sr-only">User</label>
        <input type="text" id="user" class="form-control" placeholder="User" required autofocus value="root" name="user">

              
        <label for="password" class="sr-only">Password</label>
        <input type="password" id="password" class="form-control" placeholder="Password" name="pass">


        <input class="btn btn-lg btn-primary btn-block" type="submit" id="load" value="Connect" name="load">
        <input class="btn btn-lg btn-primary btn-block" type="submit" id="done" value="Generate" name="done">
      

          




      </form>

    </div> <!-- /container -->


 
  
  </body>
</html>
