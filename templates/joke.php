<?=$totaljokes?>

<?php foreach ($jokes as $joke): ?>
    <blockquote>
        <p>
            <?=htmlspecialchars($joke['joketext'], ENT_QUOTES);?>
            (by <a href="mailto:<?php echo htmlspecialchars($joke['email'], ENT_QUOTES)?>">
            <?=htmlspecialchars($joke['name'], ENT_QUOTES)?></a>)
            <a href="<?php echo '?edit';?>">EDIT</a>
            <?php
                $date = new DateTime($joke['jokedate']);

                echo $date->format('jS F Y')
            ?>
            <form action="/Book-Project/public/deletejoke.php" method="post">
                <input type="hidden" name="id" value="<?=$joke['id']?>">
                <input type="submit" value="Delete">    
            </form>
        </p>
    </blockquote>
<?php endforeach; ?>
