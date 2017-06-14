<form method="post">
    <input name="a" type="text" placeholder="first number">
    <select name="oper">
        <option value="plus">+</option>
        <option value="minus">-</option>
        <option value="div">/</option>
        <option value="mult">*</option>
    </select>
    <input name="b" type="text" placeholder="second number">
    <input type="submit" value="посчитать">
</form>
<?php
if(isset($data['res'])){
    echo 'Result: '.$data['res'];

}
//
//if (!filter_has_var(INPUT_GET, 'email') || $_REQUEST['email']){
//    $errors['email'] = 'invalid e-mail';
//}else{
//    $data['email'] = $_GET["email"];
//}
//if (!filter_has_var(INPUT_GET, 'text')){
//    $errors['text'] = 'empty text';
//}
//else{
//    $data['email'] = $_GET["email"];
//}
//if (!filter_has_var(INPUT_GET, 'password1')){
//    $errors['password1'] = 'empty password';
//}
//if (!filter_has_var(INPUT_GET, 'password2')){
//    $errors['password2'] = 'empty confirm password';
//}
//if (!filter_has_var(INPUT_GET, 'color')){
//    $errors['color'] = 'invalid color';
//}
//if (!filter_has_var(INPUT_GET, 'range')){
//    $errors['range'] = 'invalid range';
//}
//if (!filter_has_var(INPUT_GET, 'radio')){
//    $errors['radio'] = 'select radio';
//}
//if (!filter_has_var(INPUT_GET, 'tel')){
//    $errors['tel'] = 'invalid tel';
//}
//if (!filter_has_var(INPUT_GET, 'email')){
//    $errors['checkbox'] = 'select checkbox';
//}
//showTemplate($data, 'templates/form/form');