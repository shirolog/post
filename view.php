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


if(isset($_GET['p_id'])){
    $p_id = $_GET['p_id'];
}else{
    $p_id = '';
}



if(isset($_GET['delete_id'])){
    $delete_id = $_GET['delete_id'];
    $delete_posts = $conn->prepare("DELETE FROM `posts` WHERE id= ?");
    $delete_posts->execute(array($delete_id));
    
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>view.php</title>
    <link rel="stylesheet" href="./join/css/style.css">
</head>
<body>
    <section class="form-container">

        <form action="" method="post">


            <h3>『ひとこと掲示板。』</h3>
            <p style="font-size: 1.5rem;">&laquo;<a style="padding-left: .7rem;" href="./home.php">一覧に戻る</a></p>

            <?php 
             $select_posts = $conn->prepare("SELECT * FROM `posts` WHERE id= ? 
             ORDER BY created DESC");
             $select_posts->execute(array($p_id));
             if($select_posts->rowCount() > 0){
                 while($fetch_posts = $select_posts->fetch(PDO::FETCH_ASSOC)){
                 $member_id = $fetch_posts['member_id'];
                                 
                 $select_members = $conn->prepare("SELECT * FROM `members` WHERE id= ?");
                 $select_members->execute(array($member_id));
                 $fetch_members = $select_members->fetch(PDO::FETCH_ASSOC);
            ?>
            <img src="./join/member_picture/<?= $fetch_members['picture']; ?>" height="48"
             width="48" alt="<?= $fetch_members['name']; ?>">
            <p>メッセージ</p>
            <span style="overflow-x: hidden;"><?= nl2br($fetch_posts['message']); ?> (<?= $fetch_members['name']; ?>)</span>
            <p>投稿日時</p>
            <span><?= $fetch_members['created']; ?></span>
            <?php
                if($fetch_members['id'] == $user_id){
            ?>
            <a style="color: red; width:100%; font-size:1.5rem;" href="./view.php?delete_id=<?= $p_id; ?>"
            onclick="return confirm('このメッセージを削除しますか?');">削除</a>
            <?php 
            }
            ?>   
        </form>
        <?php 
        }
        }else{
        ?>

        <div class="empty"> その投稿は削除されたか、 URLが間違っています。</div>
        <?php 
        }
        ?>
    </section>
</body>
</html>
