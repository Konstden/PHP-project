<form action="" method="post">
    <input type="hidden" name="jokeid" value="<?=$joke['id'];?>">
    <label for="joketext">Type joke here</label>
    <textarea name="joketext" name="joketext" 
        id="" cols="30" rows="10"><?=$joke['joketext'];?></textarea>
    <input type="submit" value="Save">
</form>