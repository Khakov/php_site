<?php
if (isset($data['guests'])) {
    foreach ($data['guests'] as $key => $guest) {
        echo "<h3>".$guest['name']."</h1>";
        echo "<img src=".$guest['avatar']." width = '150pt'>";
        echo $guest['text'];
    }
}?>
<form method="post">
    e-mail<input name="email" type="email" required><br>
    text:<textarea style="margin-left: 12pt" name="text" maxlength="100"></textarea><br>
    <input type="hidden" name="guest" value="<?=isset($data['guest'])?$data['guest']:false?>">
    <input type="submit" value="Отправить">
    <span class="error" style="color: red"><?=isset($data['emailError'])?$data['emailError']:false?></span><br>
    <span class="error" style="color: red"><?=isset($data['textError'])?$data['textError']:false?></span><br>
</form>
