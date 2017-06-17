<?php
/**
 * Created by PhpStorm.
 * User: khan
 * Date: 22.05.17
 * Time: 18:16
 */
function get_data($comments, $depth, $id)
{?>
    <div style="margin-left: 50px">
    <?php
    foreach ($comments as $key=> $comment){
        $time = new DateTime();
        $time->setTimestamp($comment->getTime());
        ?>
        </><br><?=$comment->getCommentText();?><br>Автор: <a href="/profile/
        <?=$comment->getUser()->getId();?>">
            <?=$comment->getUser()->getNickname();?></a>
        Время: <?=$time->format('Y-m-d H:i:s')?>
        <div class='reply'><a href='#' id ='<?=$comment->getId();?>'
        onclick='return comment_show_reply_form(<?=($comment->getId())?>,<?=$id?>)'>ответить
            </a><div class='form_ask'></div></div><hr><?php
        if (count($comment->getChilds()) > 0) {
           get_data($comment->getChilds(), $depth+1, $id);
        }
    }?>
    </div>
<?php
}
$time = new DateTime();
$time->setTimestamp($data["post"]->getTime());
?>
<div class='navbar'>
Автор: <a href='/profile/<?=$data["post"]->getUser()->getId()?>'>
        <?=$data["post"]->getUser()->getNickname();?></a>
    Дата:<?=$time->format('Y-m-d H:i:s')?><br>
Тема: <a href='/post/<?=$data["post"]->getId()?>'>
    <?=$data["post"]->getTheme()?>
    </a><br><?=$data["post"]->getText()?></div>
<hr>
Комментарии:
<div style="margin-left: -50px">
<?php if(count($data["post"]->getComments())) {
    get_data($data["post"]->getComments(), 0, $data["post"]->getId());
}?>
<form method='post'>
Комментарий:<br><textarea style='margin-left: 12pt' name='text' maxlength='100'></textarea>
<input type='hidden' name='post_id' value="<?=$data["post"]->getId()?>"><br>
    <input type='submit' value="отправить"></form>
</div>
<span class="error" style="color: red"><?= isset($data['error']) ? $data['error'] : false ?></span><br>
<script type="application/javascript">
    function comment_show_reply_form(id, post_id){
        var elements = Array.prototype.slice.call(document.getElementsByClassName("form_ask"),0);
        elements.forEach(function (element, i, elements) {
            element.innerHTML="";
        });
        var div = document.createElement('div');
        var form_elem = "<form method='post'><input name='parent_id' type='hidden' value='"+
            id+"'><input name='post_id' type='hidden' value='"+ post_id+"'>" +
            "<textarea name='text' maxlength='100'></textarea>" +
            "<input type='submit' value='отправить'></form>";
        div.innerHTML = form_elem;
        document.getElementById(id).parentNode.lastChild.appendChild(div);
        return true;
    }
</script>