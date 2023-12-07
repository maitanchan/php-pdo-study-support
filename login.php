<?php
session_start();

if (isset($_POST['submit'])) {
    require 'db.php';

    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    $sql = 'SELECT * FROM users WHERE username = :username AND password = :password';
    $statement = $connection->prepare($sql);
    $statement->bindParam(':username', $username);
    $statement->bindParam(':password', $password);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['username'] = $username;
        header('Location: admin.php');
        exit();
    } else {
        echo '<script>alert("Đăng nhập không thành công. Vui lòng kiểm tra tên đăng nhập và mật khẩu.");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en" title="Coding design">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SupHere - Chi tiết</title>
</head>
<div class="formbold-main-wrapper">
    <div class="formbold-form-wrapper">
        <div class="formbold-event-wrapper">
            <h3>Đăng nhập</h3>
            <rect width="490" height="215" rx="5" fill="url(#pattern0)" />
            <defs>
        </div>

        <form action="" method="POST">


            <div>
                <label for="files" class="formbold-form-label">Tên tài khoản:
                </label>
                <input type="text" name="username" class="formbold-form-input" placeholder="" />
            </div>
            <div>
                <label for="files" class="formbold-form-label">Mật khẩu:
                </label>
                <input type="password" name="password" class="formbold-form-input" placeholder="" />
            </div>


            <button class="formbold-btn" type="submit" name="submit">
                Login
            </button>


        </form>


    </div>
</div>


<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', sans-serif;
    }

    .formbold-main-wrapper {
        display: flex;
        background-repeat: no-repeat;
        align-items: center;
        justify-content: center;
        padding: 48px;
    }

    .formbold-form-wrapper {
        margin: 0 auto;
        max-width: 550px;
        width: 100%;
        background: white;
        border-radius: 10px;
        box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;
        padding: 20px;
    }

    .formbold-event-wrapper span {
        font-weight: 500;
        font-size: 16px;
        line-height: 24px;
        letter-spacing: 2.5px;
        color: #6a64f1;
        display: inline-block;
        margin-bottom: 12px;
    }

    .formbold-event-wrapper h3 {
        font-weight: 700;
        font-size: 28px;
        line-height: 34px;
        color: #07074d;
        width: 60%;
        margin-bottom: 15px;
    }

    .formbold-event-wrapper h4 {
        font-weight: 600;
        font-size: 20px;
        line-height: 24px;
        color: #07074d;
        width: 60%;
        margin: 25px 0 15px;
    }

    .formbold-event-wrapper p {
        font-size: 16px;
        line-height: 24px;
        color: #536387;
    }

    .formbold-event-details {
        background: #fafafa;
        border: 1px solid #dde3ec;
        border-radius: 5px;
        margin: 25px 0 30px;
    }

    .formbold-event-details h5 {
        color: #07074d;
        font-weight: 600;
        font-size: 18px;
        line-height: 24px;
        padding: 15px 25px;
    }

    .formbold-event-details ul {
        border-top: 1px solid #edeef2;
        padding: 25px;
        margin: 0;
        list-style: none;
        display: flex;
        flex-wrap: wrap;
        row-gap: 14px;
    }

    .formbold-event-details ul li {
        color: #536387;
        font-size: 16px;
        line-height: 24px;
        width: 50%;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .formbold-form-title {
        color: #07074d;
        font-weight: 600;
        font-size: 28px;
        line-height: 35px;
        width: 60%;
        margin-bottom: 30px;
    }

    .formbold-input-flex {
        display: flex;
        gap: 20px;
        margin-bottom: 15px;
        margin-top: 20px;
    }

    .formbold-input-flex>div {
        width: 50%;
    }

    input::placeholder {
        font-size: 15px;
        /* You can set the desired font size */
        color: #999;
        /* You can set the desired color */
    }

    .formbold-form-input {
        text-align: center;
        width: 100%;
        padding: 13px 22px;
        border-radius: 5px;
        border: 1px solid #dde3ec;
        background: #ffffff;
        font-weight: 500;
        font-size: 16px;
        color: #536387;
        outline: none;
        resize: none;
    }

    .formbold-form-input:focus {
        border-color: #6a64f1;
        box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.05);
    }

    .formbold-form-label {
        color: #536387;
        font-size: 14px;
        line-height: 24px;
        display: block;
        margin-bottom: 10px;
    }

    .formbold-policy {
        font-size: 14px;
        line-height: 24px;
        color: #536387;
        width: 70%;
        margin-top: 22px;
    }

    .formbold-policy a {
        color: #6a64f1;
    }

    .formbold-btn {
        text-align: center;
        width: 100%;
        font-size: 16px;
        border-radius: 5px;
        padding: 14px 25px;
        border: none;
        font-weight: 500;
        background-color: #6a64f1;
        color: white;
        cursor: pointer;
        margin-top: 25px;
    }

    .formbold-btn:hover {
        box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.05);
    }

    #real-time-clock {
        background-color: #fff;
        border-radius: 5px;
        display: inline-block;
    }

    #current-location {
        margin-top: 10px;
    }

    input[type=file]::file-selector-button {
        margin-right: 20px;
        border: none;
        background: #6a64f1;
        padding: 10px 20px;
        border-radius: 10px;
        color: #fff;
        cursor: pointer;
        transition: background .2s ease-in-out;
    }

    input[type=file]::file-selector-button:hover {
        background: #0d45a5;
    }
</style>