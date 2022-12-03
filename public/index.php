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
      <li><a href='./' style='color: #ffcc00;'><img width='38em' src='static/images/folder.svg'>home</a></li>
      <li><a href='./blog.html'><img width='30em' src='static/images/papers.svg'>blog</a></li>
      <li><a href='./illustrations.html'><img width='38em' src='static/images/frame.svg'>illustrations</a></li>
      <li><a href='./'><img width='30em' src='static/images/about.svg'>about</a></li>
    </ul>
  </nav>
</header>
<main>
    <p> software developer, </p>
    <p> unix enthusiast, </p>
    <p> works with <span style='color: <?= $color ?>'><?= $word ?></span>,</p>
</main>
<footer>
    powered with php and openbsd
</footer>
</body>
</html>
