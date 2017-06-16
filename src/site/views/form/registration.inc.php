<h1>Регистрация</h1>
<form method="post" enctype="multipart/form-data">
    <label for="first-name" style="padding-right: 44pt">Имя</label>
    <input name="first-name" class="form-control" required pattern="[a-zA-ZА-Яа-яЁё\p]+" value="<?=isset($data['firstName'])?$data['firstName']:false?>"><br>
    <label for="last-name" style="padding-right: 10pt">Фамилия: </label>
    <input name="last-name" class="form-control" required pattern="[a-zA-ZА-Яа-яЁё\p]+" value="<?=isset($data['lastName'])?$data['lastName']:false?>"><br>
    <label for="nickname" style="padding-right: 10pt">Никнейм: </label>
    <input name="nickname" class="form-control" required pattern="\w{4,10}"  oninvalid="setCustomValidity('minimum 4 and max 10 character')"
           onchange="try{setCustomValidity('')}catch(e){}" value="<?=isset($data['nickname'])?$data['nickname']:false?>"><br>
    <label for="nickname" style="padding-right: 20pt">Пароль: </label>
    <input type="password" name="password1" class="form-control" required pattern="\w{4,10}"  oninvalid="setCustomValidity('minimum 4 and max 10 character')"
           onchange="try{setCustomValidity('')}catch(e){}"><br>
    <label for="nickname">Повторите: </label>
    <input type="password" name="password2" class="form-control" required pattern="\w{4,10}"  oninvalid="setCustomValidity('minimum 4 and max 10 character')"
           onchange="try{setCustomValidity('')}catch(e){}"><br>
    <label for="email" style="padding-right: 31pt">e-mail: </label>
    <input type="email" name="email" class="form-control" required value="<?=isset($data['email'])?$data['email']:false?>"><br>
    <label for="country" style="padding-right: 20pt">Страна: </label>
    <input name="country" class="form-control" required pattern="[a-zA-ZА-Яа-яЁё\p]+" value="<?=isset($data['country'])?$data['country']:false?>"><br>
    <label for="gender"style="padding-right: 40pt">Пол: </label>
    <select name="gender">
        <option value="m">мужской</option>
        <option value="w">женский</option>
    </select><br>
    <input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
    <input type="file" name="avatar"><br>
    <input type="checkbox" name="agreement" required <?=isset($agreement)?" checked":false?> > согласен с условиями соглашения <br>
    <input type="checkbox" name="news"> не согласен стать рабом<br>
    <input type="submit" value="зарегестрироваться">
    <span class="error" style="color: red"><?=isset($data['emailError'])?$data['emailError']:false?></span><br>
    <span class="error" style="color: red"><?=isset($data['firstNameError'])?$data['firstNameError']:false?></span><br>
    <span class="error" style="color: red"><?=isset($data['lastNameError'])?$data['lastNameError']:false?></span><br>
    <span class="error" style="color: red"><?=isset($data['nicknameError'])?$data['nicknameError']:false?></span><br>
    <span class="error" style="color: red"><?=isset($data['password1Error'])?$data['password1Error']:false?></span><br>
    <span class="error" style="color: red"><?=isset($data['password2Error'])?$data['password2Error']:false?></span><br>
    <span class="error" style="color: red"><?=isset($data['avatarError'])?$data['avatarError']:false?></span>
    <span class="error" style="color: red"><?=isset($data['agreementError'])?$data['agreementError']:false?></span><br>
    <span class="error" style="color: red"><?=isset($data['countryError'])?$data['countryError']:false?></span><br>
    <span class="error" style="color: red"><?=isset($data['genderError'])?$data['genderError']:false?></span><br>
</form>