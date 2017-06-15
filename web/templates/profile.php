<?php
/**
 * Created by PhpStorm.
 * User: khan
 * Date: 06.06.17
 * Time: 23:29
 */
foreach ($data["posts"] as $key => $post) {
    $time = new DateTime();
    $time->setTimestamp($post->getTime());
    echo "<div class='navbar'>";
    echo "Автор: ". "<a href='/profile.php?id=". $post->getUser()->getId()."'>";
    echo $post->getUser()->getFirstName();
    echo "</a>". " Дата:".$time->format('Y-m-d H:i:s')."<br>";
    echo "Тема: "."<a href='/message.php?id=" . $post->getId() . "'>"
        . $post->getTheme(). "</a>"."<br>";
    echo $post->getText();
    echo "</div>";
}
if (isset($data["page"])){?>

<div>
    <ul class="pagination">
        <?php if ($data["page"]-2>0){?>
    <li><a href='/profile.php?page=<?php echo ($data["page"]-2)."&id=".($data["user"]->getId()) . "'>" .
        ($data["page"]-2) . "</a></li>";}?>
        <?php if ($data["page"]-1>0){?>
        <li><a href='/profile.php?page=<?php echo ($data["page"]-1)."&id=".($data["user"]->getId()) . "'>" .
    ($data["page"]-1) . "</a></li>";}?>
    <li class="active"><a href="#"><?=$data["page"]?></a></li>
<?php if ($data["page"]+1 <= ($data["count"] - 1)/10 + 1){?>
        <li><a href='/profile.php?page=<?php echo ($data["page"]+1)."&id=".($data["user"]->getId()) . "'>" .        ($data["page"]+1) . "</a></li>";}?>
                <?php if ($data["page"]+2 <= ($data["count"] - 1)/10 + 1){?>
<li><a href='/profile.php?page=<?php echo ($data["page"]+2)."&id=".($data["user"]->getId()) . "'>" .
        ($data["page"]+2) . "</a></li>";}}?>
    </ul>
    </div>
<?php
if (isset($data["form"])){
    ?><form method="post">
        Theme: <input type="text" name = "theme"><br>
        Text: <textarea name = "text" id="summernote"></textarea>
        <input type="submit" value="опубликовать">
    </form>
        <script>
            $('#summernote').summernote({
                height: 100,
                width: 600,
                focus: true
            });
        </script>
    <?php
}
