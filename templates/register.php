<?php if (empty($errors)):?>
        <div class="errors">
            <p>Account could not be created,
                Please check the following 
            </p>
            <ul>
                <?php foreach($errors as $error): ?>
                    <li><?=$error?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>
<form action="" method="post">
    <label for="email">Your email</label>
    <input type="text" name="author[email]" id="email" value="<?=$author['email'] ?? ''?>">
    
    <label for="text">Your name</label>
    <input type="text" name="author[name]" id="name" value="<?=$author['name']?> ?? ''">
    
    <label for="email">Your password</label>
    <input type="password" name="author[password]" id="password" value="<?=$author['password']?> ?? ''">

    <input type="submit" name="submit" value="Register account" >

</form>