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
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $requestManager = new RequestManager($connection);
    if ($requestManager->deleteRequest($id)) {
        echo '<script>alert("Request deleted successfully.");</script>';
        header("Location: admin.php");
    }
}
