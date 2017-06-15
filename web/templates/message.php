<?php
/**
 * Created by PhpStorm.
 * User: khan
 * Date: 22.05.17
 * Time: 18:16
 */
function get_data($comments, $depth, $id)
{
    foreach ($comments as $key=> $comment) {
        echo "<br>";
        for ($i = 0; $i<$depth*3; $i++){
            echo "_";
        }
        echo $comment->getCommentText()."  -  ";
        echo $comment->getUser()->getEmail();
        echo "<div class='reply'><a href='#reply' id ='".$comment->getId().
        "' onclick='return comment_show_reply_form(".($comment->getId()).",".$id.")'>ответить</a><div class='form_ask'></div></div>";
        if (count($comment->getChilds() > 0)) {
           get_data($comment->getChilds(), $depth+1, $id);
        }
    }
}
echo $data["post"]->getTheme()."\n";
echo $data["post"]->getText()."\n";
echo $data["post"]->getTime()."\n";
echo $data["post"]->getUser()->getEmail()."\n";
if(count($data["post"]->getComments())) {
    get_data($data["post"]->getComments(), 0, $data["post"]->getId());
}else{
echo "<form method='post'>";
echo "text:<textarea style='margin-left: 12pt' name='text' maxlength='100'></textarea>";
echo "<input type='hidden' name='post_id' value=". $data["post"]->getId() ."><input type='submit'></form>";
}
?>
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