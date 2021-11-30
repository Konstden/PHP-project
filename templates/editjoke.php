<form action="" method="post">
    <input type="hidden" name="joke[id]" value="
    <?=$joke['id'] ?? ''?>">
        
    <label for="joketext">Type joke here</label>
    <textarea name="joke[joketext]" 
        id="" cols="30" rows="10"><?=$joke['joketext'] ?? ''?></textarea>
    <input type="submit" value="Save">
</form>