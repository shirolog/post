<?php 
session_start();
require('../connect.php');


$error['name'] = '';
$error['email'] = '';
$error['pass'] = '';
$name = '';
$email = '';
$pass = '';




if(isset($_POST['submit'])){

    
        if($_POST['name'] == ''){
            $error['name'] = 'blank';
        }else{
            $name = $_POST['name'];
            $name = filter_var($name, FILTER_SANITIZE_STRING);
        }
        
    
        if($_POST['email'] == ''){
            $error['email'] = 'blank';
        }else{
            $email = $_POST['email'];
            $email = filter_var($email, FILTER_SANITIZE_STRING);
        }
    
    
        if($_POST['pass'] == ''){
            $error['pass'] = 'blank';
        }else{
            $pass = sha1($_POST['pass']);
            $pass = filter_var($pass, FILTER_SANITIZE_STRING);
        }
        
        
        if(strlen($_POST['pass']) < 4){
            $error['pass'] = 'length';
        }    
        
        $image = $_FILES['image']['name'];
        $ext_image = date('YmdHis'). $image;
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = './member_picture/'. $ext_image;
    
        if(!empty($image)){
            if(!empty($error)){
                move_uploaded_file($image_tmp_name, $image_folder);
                $_SESSION['join'] = $_POST;
                $_SESSION['join']['image'] = $ext_image;
                header('Location: ./check.php');
                exit();
            }
        }
        
            if(empty($error)){
                $_SESSION['join'] = $_POST;
                header('Location: ./check.php');
                exit();
            }
}



if(isset($_GET['action']) == 'rewrite'){
    $name = $_SESSION['join']['name'];
    $email = $_SESSION['join']['email'];
    $pass =  $_SESSION['join']['pass'];
    $image = $_SESSION['join']['image'];
    $error['rewrite'] = true;
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
            <h3>次のフォームに入力してください。</h3>
                <div>
                    <p    class="title">ニックネーム<span>必須</span></p>
                    <input type="text" name="name" value="<?= $name; ?>" class="box" 
                    size="35" maxlength="255" required>
                    <?php 
                        if($error['email'] = 'blank'){
                    ?>
                        <div class="empty">* ニックネームを入力してください。</div>
                    <?php 
                    }
                    ?>
                </div>
    
                <div>
                    <p   class="title">メールアドレス<span>必須</span></p>
                    <input type="email" name="email" value="<?= $email; ?>"
                    class="box" size="35" maxlength="255" required>
                    <?php 
                        if($error['email'] == 'blank'){
                    ?>
                        <div class="empty">* メールアドレスを入力してください。</div>
                    <?php 
                    }
                    ?>

                    <?php 
                        $select_members = $conn->prepare("SELECT * FROM `members` WHERE email= ?");
                        $select_members->execute(array($email));
                        if($select_members->rowCount() > 0 ){
                    ?>
                        <div class="empty">* 指定されたメールアドレスは既に登録されています。</div>
                    <?php 
                    }
                    ?>
                </div>
    
                <div>
                    <p  class="title">パスワード<span>必須</span></p>
                    <input type="password" name="pass" value="<?= $pass; ?>"
                    class="box" size="10" maxlength="255" required>
                    <?php 
                        if($error['pass'] == 'blank'){
                    ?>
                        <div class="empty">* パスワードを入力してください。</div>
                    <?php 
                    }
                    ?>
                    <?php 
                        if($error['pass'] == 'length'){
                    ?>
                        <div class="empty">* パスワードは4文字以上入力してください。</div>
                    <?php 
                    }
                    ?>


                </div>
    
                <div>
                    <p class="title">写真など</p>
                    <input type="file" name="image" size="35" accept="image/png,
                    image/jpg, image/jpeg" >
                    <?php 
                        if(!empty($error)){
                    ?>
                        <div class="empty">恐れ入りますが、改めて画像を選択してください。</div>
                    <?php 
                    }
                    ?>
                </div>
                <input type="submit" name="submit" class="btn" value="入力内容を確認する">
        </form>
    </section>
</body>
</html>
