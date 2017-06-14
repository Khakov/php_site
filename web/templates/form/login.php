<h1>Вход</h1>
<form method="post" enctype="multipart/form-data">
    <label for="email" style="padding-right: 31pt">e-mail: </label>
    <input type="email" name="login" required value="<?=isset($data['login'])?$data['login']:false?>"><br>
    <label for="password" style="padding-right: 20pt">Пароль: </label>
    <input type="password" name="password" required pattern="\w{4,10}"><br>
    <input type="submit" value="войти">
    <span class="error" style="color: red"><?=isset($data['error'])?$data['error']:false?></span><br>
</form>