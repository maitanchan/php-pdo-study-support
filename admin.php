<?php

session_start();

require 'db.php';

class RequestManager
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function getRequests($page = 1, $recordsPerPage = 10)
    {
        $offset = ($page - 1) * $recordsPerPage;

        $sql = 'SELECT * FROM `support-request` LIMIT :limit OFFSET :offset';
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':limit', $recordsPerPage, PDO::PARAM_INT);
        $statement->bindParam(':offset', $offset, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_OBJ);
    }
}

$recordsPerPage = 9;

$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$requestManager = new RequestManager($connection);
$requests = $requestManager->getRequests($current_page, $recordsPerPage);

foreach ($requests as $request) :
endforeach;

$totalPages = ceil($connection->query("SELECT COUNT(*) FROM `support-request`")->fetchColumn() / $recordsPerPage);


?>
<?php

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en" title="Coding design">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SupHere - Admin</title>
</head>

<body>
    <main class="table">
        <section class="table__header">

            <h1 style="display:flex; align-items:center"><a style="text-decoration: none; color:#000" href="admin.php">
                    Danh sách
                    DatSup
                </a>
            </h1>
            <h3>Xin chào, <?php echo $_SESSION['username']; ?>!</h3>
            <a href="?logout=true">Đăng xuất</a>
        </section>
        <section class="table__body">
            <table>
                <div class="pagination">
                    <?php
                    for ($i = 1; $i <= $totalPages; $i++) {
                        echo "<a href='admin.php?page=$i'>$i</a> ";
                    }
                    ?>
                </div>
                <thead>
                    <tr>
                        <th> Id</th>
                        <th> Tên dự án </th>
                        <th> Deadline </th>
                        <th> Phí đề xuất </th>
                        <th> Thông tin liên lạc </th>
                        <th> Đặt lịch </th>
                        <th> Thời gian y/c </th>
                        <th> </th>
                        <th> File</th>
                        <th>Nhập người xử lý </th>
                        <th> Tên người xử lý </th>
                        <th> Hành động </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_POST['save'])) {
                        $handleActor = htmlspecialchars($_POST['handleActor']);
                        $id = $_POST['id'];

                        if (!empty($handleActor)) {
                            try {
                                $sql = "UPDATE `support-request` SET handleActor = :handleActor WHERE id = :id";
                                $stmt = $connection->prepare($sql);
                                $stmt->bindParam(':handleActor', $handleActor);
                                $stmt->bindParam(':id', $id);

                                $result = $stmt->execute();

                                if ($result) {
                                    echo "<script>alert('Lưu thành công')</script>";
                                    header("Location: admin.php");
                                } else {
                                    echo "<script>alert('Lưu thất bại')</script>";
                                }
                            } catch (PDOException $e) {
                                echo "Lỗi: " . $e->getMessage();
                            }
                        } else {
                            echo "<script>alert('Vui lòng nhập người xử lý trước khi lưu')</script>";
                        }
                    }


                    ?>
                    <?php foreach ($requests as $request) : ?>
                    <tr>
                        <td><?= htmlspecialchars($request->id); ?></td>
                        <td><?= htmlspecialchars($request->nameProject); ?></td>
                        <td><?= htmlspecialchars($request->completionTime); ?></td>
                        <td><?= htmlspecialchars($request->fee); ?></td>
                        <td><?= htmlspecialchars($request->contact); ?></td>
                        <td><?= htmlspecialchars($request->schedule); ?></td>
                        <td><?= htmlspecialchars(substr($request->timestamp, 0, 10)) ?></td>
                        <td>
                        <td>
                            <?php
                                $filePaths = explode(', ', $request->filePath);
                                foreach ($filePaths as $filePath) {
                                    $fileName = basename($filePath);
                                    echo '<a href="download_file.php?file=' . urlencode($filePath) . '" download>' . htmlspecialchars(substr($fileName, 0, 13)) . '</a><br>';
                                }
                                ?>
                        </td>
                        </td>

                        <form action="" method="POST">
                            <input type="hidden" name="id" value="<?= $request->id ?>">
                            <td>
                                <input type="text" name="handleActor" placeholder="Nhập người xử lý">
                            </td>
                            <td><?= htmlspecialchars($request->handleActor); ?></td>

                            <td style="display:flex; column-gap:10px">
                                <a href="javascript:void(0);" onclick="confirmAndDelete(<?= $request->id ?>)"
                                    style="text-decoration: none;">
                                    <p class="status cancelled">Xóa</p>
                                </a>
                                <a style="text-decoration: none;" href="detail.php?id=<?= $request->id ?>">
                                    <p class=" status delivered">Xem</p>
                                </a>
                                <button type="submit" name="save"
                                    style="border-radius:10px; border:none;cursor:pointer">
                                    <p class="status pending">Lưu</p>
                                </button>
                            </td>
                        </form>

                    </tr>
                    <?php endforeach; ?>

                </tbody>

            </table>

        </section>

    </main>

</body>


</html>

<script>
function confirmAndDelete(id) {
    if (confirm('Bạn có chắc xóa không?')) {
        let deletePass = prompt("Please enter your password:");
        if (deletePass == "XN22022003") {
            window.location.href = 'delete.php?id=' + id;
        } else {
            alert('Sai mật khẩu?')
        }
    }
}
</script>

<style>
* {
    margin: 0;
    padding: 0;

    box-sizing: border-box;
    font-family: sans-serif;
}

input {
    border-radius: 5px;
    padding: .6rem .1rem;
    outline: none;
    width: 150px;
    border: 1px solid #dde3ec;

}

body {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

body::before {
    content: "";
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-color: rgba(0, 0, 0, 0.6);
    z-index: -1;
}

body {
    background-image: url('bg-img.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    z-index: 0;
}

main.table {
    width: 92vw;
    height: 90vh;
    background-color: #ffff;
    backdrop-filter: blur(7px);
    box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;
    border-radius: 10px;

    overflow: hidden;
}

/* CSS cho phần pagination */
.pagination {
    display: flex;
    align-items: center;
    margin-top: 20px;
    margin-bottom: 10px;
}

.pagination a {
    color: #6a64f1;
    padding: 5px 10px;
    text-decoration: none;
    margin: 0 5px;
    border: 1px solid #6a64f1;
    border-radius: 4px;
}

.pagination a:hover {
    background-color: #6a64f1;
    color: #fff;
}



.pagination .active {
    background-color: #6a64f1;
    color: #fff;
}


.table__header {
    width: 100%;
    height: 10%;
    padding: .8rem 1rem;

    display: flex;
    justify-content: space-between;
    align-items: center;
}

.table__header .input-group {
    width: 35%;
    height: 100%;
    padding: 0 .8rem;

    display: flex;
    justify-content: center;
    align-items: center;

    transition: .2s;
}



thead tr th {
    font-size: 0.8rem;
    text-transform: none;
}

tbody tr td {
    font-size: 0.9rem;
}

.table__header .input-group:hover {
    width: 45%;
    background-color: #fff8;
    box-shadow: 0 .1rem .4rem #0002;
}

.table__header .input-group img {
    width: 1.2rem;
    height: 1.2rem;
}

.table__header .input-group input {
    width: 100%;
    padding: 0 .5rem 0 .3rem;
    background-color: transparent;
    border: none;
    outline: none;
}

.table__body {
    width: 95%;
    max-height: calc(89% - 1.6rem);
    background-color: #fffb;

    margin: .8rem auto;
    border-radius: .6rem;

    overflow: auto;
    overflow: overlay;
}

.table__body::-webkit-scrollbar {
    width: 0.5rem;
    height: 0.5rem;
}

.table__body::-webkit-scrollbar-thumb {
    border-radius: .5rem;
    background-color: #0004;
    visibility: hidden;
}

.table__body:hover::-webkit-scrollbar-thumb {
    visibility: visible;
}

table {
    width: 100%;
}

td img {
    width: 36px;
    height: 36px;
    margin-right: .5rem;
    border-radius: 50%;

    vertical-align: middle;
}

table,
th,
td {
    border-collapse: collapse;
    padding: 1rem;
    text-align: left;
}

thead th {
    position: sticky;
    top: 0;
    left: 0;
    color: #fff;
    background-color: #6a64f1;
    cursor: pointer;
    text-transform: capitalize;
}

tbody tr:nth-child(even) {
    background-color: #0000000b;
}

tbody tr {
    --delay: .1s;
    transition: .5s ease-in-out var(--delay), background-color 0s;
}

tbody tr.hide {
    opacity: 0;
    transform: translateX(100%);
}

tbody tr:hover {
    background-color: #fff6 !important;
}

tbody tr td,
tbody tr td p,
tbody tr td img {
    transition: .2s ease-in-out;
}

tbody tr.hide td,
tbody tr.hide td p {
    padding: 0;
    font: 0 / 0 sans-serif;
    transition: .2s ease-in-out .5s;
}

tbody tr.hide td img {
    width: 0;
    height: 0;
    transition: .2s ease-in-out .5s;
}

.status {
    padding: .5rem .5rem;
    border-radius: 10px;
    text-align: center;
}

.status.delivered {
    background-color: #86e49d;
    color: #006b21;
}

.status.cancelled {
    background-color: #d893a3;
    color: #b30021;
}

.status.pending {
    background-color: #ebc474;
}

.status.shipped {
    background-color: #6fcaea;
}


@media (max-width: 1000px) {
    td:not(:first-of-type) {
        min-width: 12.1rem;
    }
}

thead th span.icon-arrow {
    display: inline-block;
    width: 1.3rem;
    height: 1.3rem;
    border: 1.4px solid transparent;

    text-align: center;
    font-size: 0.1rem;

    margin-left: .5rem;
    transition: .2s ease-in-out;
}

thead th:hover span.icon-arrow {
    border: 1.4px solid #6a64f1;
}



thead th.active span.icon-arrow {
    background-color: #6a64f1;
    color: #fff;
}

thead th.asc span.icon-arrow {
    transform: rotate(180deg);
}

thead th.active,
tbody td.active {
    color: #6a64f1;
}

.export__file {
    position: relative;
}

.export__file .export__file-btn {
    display: inline-block;
    width: 2rem;
    height: 2rem;
    background: #fff6 url(images/export.png) center / 80% no-repeat;
    border-radius: 50%;
    transition: .2s ease-in-out;
}

.export__file .export__file-btn:hover {
    background-color: #fff;
    transform: scale(1.15);
    cursor: pointer;
}

.export__file input {
    display: none;
}

.export__file .export__file-options {
    position: absolute;
    right: 0;

    width: 12rem;
    border-radius: .5rem;
    overflow: hidden;
    text-align: center;

    opacity: 0;
    transform: scale(.8);
    transform-origin: top right;

    box-shadow: 0 .2rem .5rem #0004;

    transition: .2s;
}

.export__file input:checked+.export__file-options {
    opacity: 1;
    transform: scale(1);
    z-index: 100;
}

.export__file .export__file-options label {
    display: block;
    width: 100%;
    padding: .6rem 0;
    background-color: #f2f2f2;

    display: flex;
    justify-content: space-around;
    align-items: center;

    transition: .2s ease-in-out;
}

.export__file .export__file-options label:first-of-type {
    padding: 1rem 0;
    background-color: #86e49d !important;
}

.export__file .export__file-options label:hover {
    transform: scale(1.05);
    background-color: #fff;
    cursor: pointer;
}

.export__file .export__file-options img {
    width: 2rem;
    height: auto;
}
</style>