<?php

require 'db.php';

class RequestManager
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function getRequest($id)
    {
        $sql = 'SELECT * FROM `support-request` WHERE id=:id';
        $statement = $this->connection->prepare($sql);
        $statement->execute([':id' => $id]);
        return $statement->fetch(PDO::FETCH_OBJ);
    }
}

$id = $_GET['id'];

$requestManager = new RequestManager($connection);
$request = $requestManager->getRequest($id);

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
            <h3>Xem thông tin chi tiết</h3>
            <rect width="490" height="215" rx="5" fill="url(#pattern0)" />
            <defs>
        </div>

        <form action="" method="POST" enctype="multipart/form-data">

            <div class="formbold-input-flex">
                <div>
                    <label for="name_project" class="formbold-form-label">
                        Tên dự án <span style="color:red">*</span>
                    </label>
                    <input type="text" name="nameProject" id="nameProject" class="formbold-form-input" placeholder="<?= $request->nameProject; ?>" readonly />
                </div>
                <div>
                    <label for="date" class="formbold-form-label"> Thời gian hoàn thành <span style="color:red">*</span>
                    </label>
                    <input type="text" name="completionTime" id="completionTime" class="formbold-form-input" placeholder="<?= $request->completionTime; ?>" readonly />
                </div>
            </div>

            <div class="formbold-input-flex">
                <div>
                    <label for="fee" class="formbold-form-label"> Phí đề xuất <span style="color:red">*</span></label>
                    <input type="number" name="fee" id="fee" class="formbold-form-input" placeholder="<?= $request->fee; ?>" readonly />
                </div>
                <div>
                    <label for="contact" class="formbold-form-label"> Thông tin liên lạc <span style="color:red">*</span></label>
                    <input type="text" name="contact" id="contact" class="formbold-form-input" placeholder="<?= $request->contact; ?>" readonly />
                </div>
            </div>

            <div class="formbold-input-flex">
                <div>
                    <label for="schedule" class="formbold-form-label"> Đặt lịch làm việc <span style="color:red">*</span></label>
                    <input type="text" name="schedule" id="schedule" class="formbold-form-input" placeholder="<?= $request->schedule; ?>" readonly />
                </div>
                <div>
                    <label for="requirements" class="formbold-form-label">Thời gian yêu cầu </label>
                    <input type="text" name="studyRequest" id="studyRequest" placeholder="<?= $request->timestamp; ?>" class="formbold-form-input" readonly />
                </div>
            </div>
            <div>
                <label for="files" class="formbold-form-label">Người xử lý
                </label>
                <input type="text" name="filePath" id="filePath" class="formbold-form-input" placeholder="<?= $request->filePath; ?>" readonly />
            </div>
            <div>
                <label for="files" class="formbold-form-label">Người xử lý
                </label>
                <input type="text" name="filePath" id="filePath" class="formbold-form-input" placeholder="<?= $request->handleActor; ?>" readonly />
            </div>




            <br>

        </form>
        <a href="admin.php" style="text-decoration: none;color:#fff"> <button class="formbold-btn">Trở
                về</button>
        </a>

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

<script>
    function updateRealTimeClock() {
        var now = new Date();
        var hours = now.getHours();
        var minutes = now.getMinutes();
        var seconds = now.getSeconds();
        var day = now.getDate();
        var month = now.getMonth() + 1;
        var year = now.getFullYear();

        var timeString = addZero(hours) + ":" + addZero(minutes) + ":" + addZero(seconds);
        var dateString = addZero(day) + "/" + addZero(month) + "/" + year;

        document.getElementById("real-time-clock").innerHTML = "" + dateString + "<br>" + timeString;

        setTimeout(updateRealTimeClock, 1000);
    }

    function addZero(number) {
        return (number < 10) ? "0" + number : number;
    }
    updateRealTimeClock();
</script>