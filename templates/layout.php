<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="joke.css">
    <title><?=$title?></title>
</head>
<body>
    <header><h1><?=$title?></h1></header>
    <nav>
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="/joke/list">Jokes</a></li>
            <li><a href="/joke/edit">Add a new joke</a></li>
        </ul> 
    </nav>
    <main>
        <?=$output?>
    </main>

    <footer>
        <p>
            &copy; IJDB 2017
        </p>
    </footer>
</body>
</html>