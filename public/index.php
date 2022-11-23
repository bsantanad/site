<?php require_once '../src/manager.php'; ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title> bsantanad </title>
  <meta name="viewport" content="width=device-width, inital-scale=1.0">

  <link href='./static/style.css' rel='stylesheet' type='text/css'/>
</head>
<body>
<header>
  <h1>bsantanad</h1>
  <nav>
    <ul>
      <li><a href='./index.php' style='color: #ffcc00;'><img width='38em' src='static/images/folder.svg'>home</a></li>
      <li><a href='./blog.html'><img src='static/images/'>blog</a></li>
      <li><a href='./illustration.html'><img src='static/images/'>illustrations</a></li>
      <li><a href='./'><img src='static/images/'>about</a></li>
    </ul>
  </nav>
</header>
<main>
    <p> software developer, </p>
    <p> unix enthusiast, </p>
    <p> works with <span style='color: <?= $color ?>'><?= $word ?></span>,</p>
</main>
</body>
</html>
