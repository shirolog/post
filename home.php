<?php 
session_start();
require('./connect.php');

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';
    header('Location: ./join/index.php');
    exit();
}


if(isset($_GET['res'])){
    $res_id = $_GET['res'];

    $select_posts = $conn->prepare("SELECT * FROM `posts` WHERE id=?");
    $select_posts->execute(array($res_id));
    $fetch_posts = $select_posts->fetch(PDO::FETCH_ASSOC);

    $select_members = $conn->prepare("SELECT * FROM `members` WHERE id= ?");
    $select_members->execute(array($fetch_posts['member_id']));
    $fetch_members = $select_members->fetch(PDO::FETCH_ASSOC); 

    $comment = '@'. $fetch_members['name']. ' '. $fetch_posts['message'];

}else{
    $res_id = '';
    $comment = '';
}


function makeLinksClickable($text) {
    return preg_replace(
        '/(https?:\/\/[^\s]+)/',
        '<a href="$1" target="_blank">$1</a>',
        $text
    );
}



if(isset($_POST['submit'])){

    $message = $_POST['message'];
    $message = filter_var($message, FILTER_SANITIZE_STRING);
    $message = makeLinksClickable($message);

    $insert_posts = $conn->prepare("INSERT INTO `posts` (message, member_id, reply_posts_id ,created) VALUES
    (?, ?, ?, NOW())");
    $insert_posts->execute(array($message, $user_id, $res_id));
    header('Location: ./home.php');
    exit();
}




if(isset($_GET['delete_id'])){
    $delete_id = $_GET['delete_id'];
    $delete_posts = $conn->prepare("DELETE FROM `posts` WHERE id= ?");
    $delete_posts->execute(array($delete_id));
    header('Location:./home.php');
    exit();
}else{
    $delete_id = '';
}


if(isset($_GET['page'])){
    $result_perpage = 5;
    $page = $_GET['page'];
    $page = max(1, $page);

    $select_posts = $conn->prepare("SELECT * FROM `posts`");
    $select_posts->execute();
    $count_page = $select_posts->rowCount();

    $start = ($page - 1) * $result_perpage;
    $max_page = ceil($count_page / $result_perpage);

}else{
    $page = 1;
    $start = 1;
    $result_perpage = 5;

    $select_posts = $conn->prepare("SELECT * FROM `posts`");
    $select_posts->execute();
    $count_page = $select_posts->rowCount();

    $start = ($page - 1) * $result_perpage;
    $max_page = ceil($count_page / $result_perpage);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>
    <link rel="stylesheet" href="./join/css/style.css">
</head>
<body style=" background: rgb(187, 187, 249);">
    <section class="header" style="text-align: right; font-size:1.8rem;"><a href="./logout.php" 
    onclick="return confirm('ログアウトしますか？');">ログアウト</a></section>

    <section class="form-container">


    <form action="" method="post">
            <div>
                <?php 
                    $select_members = $conn->prepare("SELECT * FROM `members` WHERE id= ?");
                    $select_members->execute(array($user_id));
                    $fetch_members = $select_members->fetch(PDO::FETCH_ASSOC);
                ?>
                <p class="title" style="font-size: 1.5rem; font-weight:bold;"><?= $fetch_members['name']; ?>さん、メッセージを一言どうぞ</p>
                <textarea name="message" required class="box" cols="30" rows="5"><?= $comment. "\n"; ?><?php if(isset($_GET['res']))
                {echo '>>';}; ?></textarea>
            </div>
            <input type="submit" name="submit" class="btn" value="投稿する" style="margin-bottom: 5rem;">
            
                <?php 
                $select_posts = $conn->prepare("SELECT * FROM `posts`
                ORDER BY created DESC LIMIT $start, $result_perpage");
                $select_posts->execute();
                if($select_posts->rowCount() > 0){
                    while($fetch_posts = $select_posts->fetch(PDO::FETCH_ASSOC)){
                    $member_id = $fetch_posts['member_id'];
                                    
                    $select_members = $conn->prepare("SELECT * FROM `members` WHERE id= ?");
                    $select_members->execute(array($member_id));
                    $fetch_members = $select_members->fetch(PDO::FETCH_ASSOC);
                ?>
                <div class="msg">
                    <img src="./join/member_picture/<?= $fetch_members['picture']; ?>" height="48" width="48" alt="">
                    <div>
                        <p style="margin: 0;"><?= nl2br($fetch_posts['message']); ?> (<?= $fetch_members['name']; ?>)
                        <a style="text-decoration: underline;" href="./home.php?res=<?= $fetch_posts['id']; ?>">[Re]</a></p>
                 
                        <div class="flex">
                            <p style="font-size: 1.4rem;">
                                <a href="./view.php?p_id=<?= $fetch_posts['id']; ?>"><?= $fetch_posts['created']; ?></a>
                                <?php 
                                if($fetch_posts['reply_posts_id'] > 0){
                                ?>
                                    <a href="./view.php?p_id=<?= $fetch_posts['id']; ?>">返信のメッセージがあります。</a>
                                <?php
                                }
                                ?>

                                <?php
                                   if($fetch_members['id'] == $user_id){
                                ?>
                                    <a style="color: red;" href="./home.php?delete_id=<?= $fetch_posts['id']; ?>"
                                    onclick="return confirm('このメッセージを削除しますか?');">削除</a>
                                <?php 
                                 }
                                ?>    
                            </p>
                        </div>
                    </div>
                </div>
                <?php 
                }
                }
                ?>
                
                <div class="flex-page">
                    <?php if ($page > 1){ 
                    ?>
                        <a href="./home.php?page=<?= $page - 1 ?>">前のページへ</a>
                    <?php 
                    } 
                    ?>

                    <?php if ($page < $max_page){
                     ?>
                        <a href="./home.php?page=<?= $page + 1 ?>">次のページへ</a>
                    <?php 
                    }
                    ?>
                </div>

    </form>
    
</section>


</body>
</html>