<?php
/**
 * Created by PhpStorm.
 * User: khan
 * Date: 22.05.17
 * Time: 18:16
 */
function get_data($comments, $depth)
{
    foreach ($comments as $key=> $comment) {
        echo "<br>";
        for ($i = 0; $i<$depth*3; $i++){
            echo "_";
        }
        echo $comment->getCommentText()."  -  ";
        echo $comment->getUser()->getEmail();
        echo "<div class='reply'><a href='#reply' id ='".$comment->getId().
        "' onclick='return comment_show_reply_form(".$comment->getId().")'>ответить</a><div class='form_ask'></div></div>";
        if (count($comment->getChilds() > 0)) {
           get_data($comment->getChilds(), $depth+1);
        }
    }
}
echo $data["post"]->getTheme()."\n";
echo $data["post"]->getText()."\n";
echo $data["post"]->getTime()."\n";
echo $data["post"]->getUser()->getEmail()."\n";
get_data($data["post"]->getComments(),0);
    ?>
<!--    <form method="post">-->
<!--        text:<textarea style="margin-left: 12pt" name="text" maxlength="100"></textarea>-->
<!--        <input type="hidden" name="parentId" value="--><?//=isset($data['guest'])?$data['guest']:false?><!--">-->
<!--        <input type="submit" value="Отправить">-->
<!--        <span class="error" style="color: red">--><?//= isset($data['textError']) ? $data['textError'] : false ?><!--</span><br>-->
<!--    </form>-->
<script type="application/javascript">
    function comment_show_reply_form(id){
        var elements = Array.prototype.slice.call(document.getElementsByClassName("form_ask"),0);
        elements.forEach(function (element, i, elements) {
            element.innerHTML="";
        });
        var div = document.createElement('div');
        var form_elem = "<form method='post'><input name='parent_id' type='hidden' value='"+
            id+"'><textarea name='text' maxlength='100'></textarea><input type='submit' value='отправить'></form>";
        div.innerHTML = form_elem;
        document.getElementById(id).parentNode.lastChild.appendChild(div);
        return true;
    }
</script>