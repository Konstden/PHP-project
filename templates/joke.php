

<?php foreach ($variables['jokes'] as $joke): ?>
    <blockquote>
        <p>
            <?=htmlspecialchars($joke['joketext'], ENT_QUOTES);?>
            (by <a href="mailto:<?php echo htmlspecialchars($joke['email'], ENT_QUOTES)?>">
            <?=htmlspecialchars($joke['name'], ENT_QUOTES)?></a>)
            <a href="index.php?route=joke/edit&<?=$joke['id']?>">EDIT</a>
            <?php
                $date = new DateTime($joke['jokedate']);

                echo $date->format('jS F Y')
            ?>
            <form action="index.php?route=joke/delete&" method="post">
                <input type="hidden" name="id" value="<?=$joke['id']?>">
                <input type="submit" value="Delete" name=>    
            </form>
        </p>
    </blockquote>
<?php endforeach; ?>
