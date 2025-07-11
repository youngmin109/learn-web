<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
  </head>
  <body>
    <?
    if($_GET['bar'] > 10)
      echo "<h1 style='color: red;'>hello</h1>";
    else
      echo "<h1 style='color: blue;'>hello</h1>"
    ?>
  </body>
</html>
