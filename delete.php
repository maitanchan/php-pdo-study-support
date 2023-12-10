<?php
require 'db.php';

class RequestManager
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function deleteRequest($id)
    {
        $sql = 'DELETE FROM `support-request` WHERE id=:id';
        $statement = $this->connection->prepare($sql);
        return $statement->execute([':id' => $id]);
    }

    public function getUserPassword($username)
    {
        $sql = 'SELECT password FROM `users` WHERE username=:username';
        $statement = $this->connection->prepare($sql);
        $statement->execute([':username' => $username]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result['password'];
    }
}

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id']) && isset($_GET['password'])) {
    $id = $_GET['id'];
    $enteredPassword = $_GET['password'];
    $username = $_SESSION['username'];

    $requestManager = new RequestManager($connection);

    $userPassword = $requestManager->getUserPassword($username);

    if ($enteredPassword === $userPassword) {
        if ($requestManager->deleteRequest($id)) {
            echo '<script>alert("Xóa thành công");</script>';
            header("Location: admin.php");
        } else {
            echo '<script>alert("Xóa thất bại");</script>';
            header("Location: admin.php");
        }
    } else {
        echo '<script>alert("Sai mật khẩu");</script>';
    }
}
