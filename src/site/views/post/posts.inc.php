<?php

/**
 * Created by PhpStorm.
 * User: khan
 * Date: 06.06.17
 * Time: 22:56
 */
echo 'всего постов: ' . $data["count"]."<br>";
if (isset($data["posts"])) {
    foreach ($data["posts"] as $key => $post) {
        $time = new DateTime();
        $time->setTimestamp($post->getTime());
        echo "<div class='navbar'>";
        echo "Автор: ". "<a href='/profile/". $post->getUser()->getId()."'>";
        echo $post->getUser()->getNickname();
        echo "</a>". " Дата:".$time->format('Y-m-d H:i:s')."<br>";
        echo "Тема: "."<a href='/post/" . $post->getId() . "'>"
            . $post->getTheme(). "</a>"."<br>";
        echo $post->getText();
        echo "</div>";
    }
}
?>
<div>
    <ul class="pagination">
        <?php if ($data["page"]-2>0){?>
        <li><a href='/posts?page=<?php echo ($data["page"]-2) . "'>" .
                ($data["page"]-2) . "</a></li>";}?>
        <?php if ($data["page"]-1>0){?>
        <li><a href='/posts?page=<?php echo ($data["page"]-1) . "'>" .
                ($data["page"]-1) . "</a></li>";}?>
        <li class="active"><a href="#"><?=$data["page"]?></a></li>
        <?php if ($data["page"]+1 <= ($data["count"] - 1)/10 + 1){?>
        <li><a href='/posts?page=<?php echo ($data["page"]+1) . "'>" .
    ($data["page"]+1) . "</a></li>";}?>
                <?php if ($data["page"]+2 <= ($data["count"] - 1)/10 + 1){?>
        <li><a href='/posts?<?php echo ($data["page"]+2) ."'>".
                ($data["page"]+2) . "</a></li>";}?>

    </ul>
</div>
<?php