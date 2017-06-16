<?php
/**
 * Created by PhpStorm.
 * User: khan
 * Date: 06.06.17
 * Time: 23:29
 */
$user = $data["user"];
$user->getFirstName();
?>
<div class="profile">
<div class="profile-avatar pull-left">
    <img src="<?=$user->getAvatar();?>" style="width: 300px">
</div>
    <div class="profile" style="margin-left: 400px">
        Фамилия: <?=$user->getFirstName();?><br>
        Имя: <?=$user->getLastName();?><br>
        Никнейм: <?=$user->getNickname();?><br>
        Страна: <?=$user->getCountry();?><br>
    </div>
</div>
<div style="margin-top: 100px">
Всего записей: <?=$data["count"];?>
<br><br>
<?php
if (isset($data["form"])){
    ?>
    Добавить новый пост:
    <form method="post">
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
foreach ($data["posts"] as $key => $post) {
    $time = new DateTime();
    $time->setTimestamp($post->getTime());
    echo "<div class='navbar'>";
    echo "Автор: ". "<a href='/profile/". $post->getUser()->getId()."'>";
    echo $post->getUser()->getFirstName();
    echo "</a>". " Дата:".$time->format('Y-m-d H:i:s')."<br>";
    echo "Тема: "."<a href='/post/" . $post->getId() . "'>"
        . $post->getTheme(). "</a>"."<br>";
    echo $post->getText();
    echo "</div>";
}
if (isset($data["page"])){?>

<div>
    <ul class="pagination">
        <?php if ($data["page"]-2>0){?>
    <li><a href='/profile/<?php echo ($data["user"]->getId())."/".($data["page"]-2) . "'>" .
        ($data["page"]-2) . "</a></li>";}?>
        <?php if ($data["page"]-1>0){?>
        <li><a href='/profile/<?php echo ($data["user"]->getId())."/".($data["page"]-1) . "'>" .
    ($data["page"]-1) . "</a></li>";}?>
    <li class="active"><a href=""><?=$data["page"]?></a></li>
<?php if ($data["page"]+1 <= ($data["count"] - 1)/10 + 1){?>
        <li><a href='/profile/<?php echo ($data["user"]->getId())."/".($data["page"]+1) . "'>" .
                ($data["page"]+1) . "</a></li>";}?>
                <?php if ($data["page"]+2 <= ($data["count"] - 1)/10 + 1){?>
        <li><a href='/profile/<?php echo ($data["user"]->getId())."/".($data["page"]+2) . "'>" .
                ($data["page"]+2) . "</a></li>";}}?>
    </ul>
    </div>

</div>