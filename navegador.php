
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>SAOG - GEOPE SE/BSB</title>
    <link rel="shortcut icon" href="http://correios.com.br/++theme++correios.site.tema/images/favicon.ico" type="image/x-icon">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">  
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/style.css" rel="stylesheet">
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>  
  <script src="js/script.js"></script>
 
    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">
  </head>
<?php
$navegador = $_SERVER['HTTP_USER_AGENT'];
$ie = strpos( $navegador, 'MSIE' );
if(!$ie){
echo "<script>window.location.href='index.php'</script>";
}

?>
  <body class="text-center">

  <div class="container">


<hr>
<h1>Utilize um dos navegadores:</h1><br><br>
<h1><span class="fa fa-firefox"></span> Mozilla Firefox</h1>
<br>
<h1><span class="fa fa-chrome"></span> Google Chrome</h1>
<hr>

</div>
</body>
</html>
