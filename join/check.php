<?php 
session_start();
require('../connect.php');

if(!isset($_SESSION['join'])){
    header('Location:./index.php');
    exit();
}



if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $image = $_POST['image'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);

    $select_members = $conn->prepare("SELECT * FROM `members` WHERE email= ?");
    $select_members->execute(array($email));
    if($select_members->rowCount() > 0){
     $error['email'] = 'duplicate';
    }else{
        $insert_members = $conn->prepare("INSERT INTO members (name, email, password, picture, created) 
        VALUES (?, ?, ?, ?, NOW())");
        $insert_members->execute(array($name, $email, $pass, $image));
        header('Location:./thanks.php');
        exit();
    }
    
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index.php</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <section class="form-container">

        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="name" value="<?= $_SESSION['join']['name']; ?>">
            <input type="hidden" name="email" value="<?= $_SESSION['join']['email']; ?>">
            <input type="hidden" name="pass" value="<?= $_SESSION['join']['pass']; ?>">
            <input type="hidden" name="image" value="<?= $_SESSION['join']['image']; ?>">
            <h3>記入した内容を確認して、「登録する」ボタンをクリックしてください。</h3>
            <p>ニックネーム</p>
            <span><?= $_SESSION['join']['name']; ?></span>
            <p>メールアドレス</p>
            <span><?= $_SESSION['join']['email']; ?></span>
            <p>パスワード</p>
            <span>[表示されません]</span>
            <p>写真など</p>
            <img src="./member_picture/<?= $_SESSION['join']['image']; ?>" width="100" height="100" alt="">
            <div style="font-size: 1.7rem;">
                <a style="text-decoration:underline; margin-right:.7rem;" 
                href="index.php?action=rewrite">&laquo; 書き直す </a> |
                <input type="submit" name="submit" value="登録する" class="btn">
            </div>
        </form>
    </section>
</body>
</html>
