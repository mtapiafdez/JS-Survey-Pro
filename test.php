<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Tester</title>
</head>

<body onload="pageReloadOnTimer();">
    <?php
    //* THIS SCRIPT ALLOWS ME TO TEST THE STATE OF THE SESSION 
    session_name("Survey");
    session_start();

    echo "<h3>Page 1</h3>";
    echo var_dump($_SESSION["PAGE1"]);

    echo "<hr>";

    echo "<h3>Page 2</h3>";
    echo var_dump($_SESSION["PAGE2"]);

    echo "<hr>";

    echo "<h3>Page 3</h3>";
    echo var_dump($_SESSION["PAGE3"]);

    echo "<hr>";

    echo "<h3>Page 4</h3>";
    echo var_dump($_SESSION["PAGE4"]);

    echo "<hr>";

    echo "<h3>Page 5</h3>";
    echo var_dump($_SESSION["PAGE5"]);
    ?>

    <script src="./js/main.js"></script>
</body>

</html>