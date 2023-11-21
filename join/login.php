<?php 
session_start();
require('../connect.php');

$email= '';
$pass= '';
$error['login'] = '';
$error['pass'] = '';



if(isset($_POST['login'])){
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    if($pass != ''){
        $select_members = $conn->prepare("SELECT * FROM `members` WHERE email= ? 
        AND password= ?");
        $select_members->execute(array($email, $pass));
        if($select_members->rowCount() > 0){
            $fetch_members= $select_members->fetch(PDO::FETCH_ASSOC);
            $old_pass = $fetch_members['password'];
            $id = $fetch_members['id'];
            $_SESSION['user_id'] = $id;
            $_SESSION['time'] = time();
        if($_POST['save'] == 'on'){
            setcookie('email', $email, time()+ 60*60*24*14, '/');
            setcookie('pass', $pass, time()+ 60*60*24*14, '/');
            }
            header('Location:../home.php');
            exit();
        }else{
            $error['login'] = 'failed';
        }
    }




}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login.php</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>

    <section class="form-container">

        <form action="" method="post">
            <h3>メールアドレスとパスワードを記入してログインしてください。</h3>
            <p style="font-weight:bolder; font-size:1.5rem;">入会手続きがまだの方はこちらからどうぞ。</p>
            <p style="line-height: .5;">&raquo;<a href="./index.php" style="text-decoration: underline;">入会手続きをする</a></p>
                <?php 
                     if($error['login'] == 'failed' ){
                    ?>
                        <div class="empty"> メールアドレスまたはパスワードが間違っています。</div>
                    <?php 
                     }
                    ?>
                <div>
                    <p class="title">メールアドレス</p>
                    <input type="email" name="email" value="<?= $email; ?>"
                    class="box" size="35" maxlength="255" required>
                    <?php 
                     if($error['login'] == 'failed' ){
                    ?>
                        <div class="empty"> メールアドレスとパスワードを入力してください。</div>
                    <?php 
                     }
                    ?>
                </div>
    
                <div>
                    <p class="title">パスワード</p>
                    <input type="password" name="pass" value="<?= $pass; ?>"
                    class="box" size="10" maxlength="255" required>
                    </div>
                </div>

                <div>
                    <p class="title">ログイン情報の記録</p>
                    <input type="checkbox" name="save" value="on" 
                    id="save"><label for="save" style="font-size: 1.5rem;">次回からは自動的にログインする</label>
                </div>
    
         
                <input type="submit" name="login" class="btn" value="ログインする">
        </form>
    </section>
</body>
</html>
