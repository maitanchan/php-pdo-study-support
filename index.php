<?php

require 'db.php';

class RequestManager
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function addSupportRequest($nameProject, $completionTime, $fee, $contact, $schedule, $studyRequest, $files)
    {
        try {
            if (empty($nameProject) || empty($completionTime) || empty($fee) || empty($contact) || empty($schedule)) {
                throw new Exception("Vui lòng điền đầy đủ thông tin.");
            }

            $uploadDirectory = 'uploads/';

            // Mảng để lưu trữ đường dẫn của tất cả các tệp tin
            $filePaths = [];

            // Lặp qua mảng các tệp tin
            foreach ($files['name'] as $key => $fileName) {
                // Tạo đường dẫn cho mỗi tệp tin
                $uploadedFile = $uploadDirectory . basename($fileName);

                // Kiểm tra định dạng của tệp tin
                $allowedFormats = ['pdf', 'xls', 'xlsx', 'doc', 'docx'];
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                if (!in_array($fileExtension, $allowedFormats)) {
                    throw new Exception("Định dạng tệp không được hỗ trợ.");
                }

                // Kiểm tra và xử lý việc tải lên
                if (move_uploaded_file($files['tmp_name'][$key], $uploadedFile)) {
                    // Thêm đường dẫn vào mảng
                    $filePaths[] = $uploadedFile;
                } else {
                    throw new Exception("Có lỗi xảy ra khi tải lên file.");
                }
            }

            $sql = 'INSERT INTO `support-request` (nameProject, completionTime, fee, contact, schedule, studyRequest, filePath) VALUES(:nameProject, :completionTime, :fee, :contact, :schedule, :studyRequest, :filePath)';
            $statement = $this->connection->prepare($sql);

            // Tạo một chuỗi đường dẫn từ mảng
            $filePathsString = implode(', ', $filePaths);

            $statement->bindParam(':nameProject', $nameProject);
            $statement->bindParam(':completionTime', $completionTime);
            $statement->bindParam(':fee', $fee);
            $statement->bindParam(':contact', $contact);
            $statement->bindParam(':schedule', $schedule);
            $statement->bindParam(':studyRequest', $studyRequest);
            $statement->bindParam(':filePath', $filePathsString);
            $statement->execute();

            $_SESSION['success_message'] = "Gửi yêu cầu thành công";
            return true;
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        } catch (Exception $e) {
            echo '<script>alert("' . $e->getMessage() . '");</script>';
            return false;
        }
    }
}

if (isset($_POST['submit'])) {
    $nameProject = $_POST['nameProject'];
    $completionTime = $_POST['completionTime'];
    $fee = $_POST['fee'];
    $contact = $_POST['contact'];
    $schedule = $_POST['schedule'];
    $studyRequest = $_POST['studyRequest'];

    $requestManager = new RequestManager($connection);

    if ($requestManager->addSupportRequest($nameProject, $completionTime, $fee, $contact, $schedule, $studyRequest, $_FILES['filePath'])) {
        echo '<script>alert("Gửi yêu cầu thành công");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en" title="Coding design">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SupHere - Thông tin hỗ trợ</title>
</head>

<div class="formbold-main-wrapper">
    <div class="formbold-form-wrapper" style="max-width: 750px;">

        <div class="formbold-event-wrapper">
            <span>SupHere</span>
            <h3>Thông Tin Hỗ Trợ</h3>
            <rect width="490" height="215" rx="5" fill="url(#pattern0)" />
            <defs>
        </div>

        <form action="" method="POST" enctype="multipart/form-data">
            <div id="real-time-clock">
            </div>
            <div class="formbold-input-flex">
                <div>
                    <label for="name_project" class="formbold-form-label">
                        Tên dự án <span style="color:red">*</span>
                    </label>
                    <input type="text" name="nameProject" id="nameProject" required class="formbold-form-input" placeholder="VD: SQL, Python, Toán,..." />
                </div>
                <div>
                    <label for="date" class="formbold-form-label"> Thời gian hoàn thành <span style="color:red">*</span>
                    </label>
                    <input type="text" name="completionTime" id="completionTime" required class="formbold-form-input" placeholder="VD: Trước 12h 1/12/2023" />
                </div>
            </div>

            <div class="formbold-input-flex">
                <div>
                    <label for="fee" class="formbold-form-label"> Phí đề xuất (VNĐ) <span style="color:red">*</span></label>
                    <input type="number" name="fee" id="fee" required class="formbold-form-input" placeholder="VD: 50.000, 100.000,..." />
                </div>
                <div>
                    <label for="contact" class="formbold-form-label"> Thông tin liên lạc <span style="color:red">*</span></label>
                    <input type="text" name="contact" id="contact" required class="formbold-form-input" placeholder="Facebook, Zalo,... (link/số điện thoại)" />
                </div>
            </div>

            <div class="formbold-input-flex">
                <div>
                    <label for="schedule" class="formbold-form-label"> Đặt lịch làm việc <span style="color:red">*</span></label>
                    <input type="text" name="schedule" id="schedule" required class="formbold-form-input" placeholder="VD: 12h 1/12/2023,..." />
                </div>
                <div>
                    <label for="requirements" class="formbold-form-label">Yêu cầu giảng dậy </label>
                    <input type="text" name="studyRequest" id="studyRequest" placeholder="VD: Tiếng Trung, Toán,..." class="formbold-form-input" />
                </div>
            </div>

            <div>
                <label for="files" class="formbold-form-label">File đính kèm (PDF, Excel, Excel Spreadsheet, Word)
                </label>
                <input type="file" type="file" name="filePath[]" multiple id="filePath" class="formbold-form-input" />
            </div>



            <button type="submit" name="submit" class="formbold-btn">Submit </button>
            <br>
            <p style="margin-top:10px; margin-left:100px">
                --- ❤️ Chúng tôi sẽ liên hệ để biết thêm chi tiết sau 1 giờ ❤️ ---
            </p>
        </form>




    </div>
    <div style="position: relative;bottom:103px">

        <div class="formbold-form-wrapper">

            <div>

                <h3>Quy tắc làm việc</h3>

                <p class="formbold-policy">
                    1. Không nhận cọc
                </p>
                <p class="formbold-policy">
                    2. Đảm bảo chất lượng, yêu cầu
                </p>
                <p class="formbold-policy">
                    3. Quy trình: Liên hệ xác nhận và trao đổi - Hoàn thành - Check (hình ảnh) - Thanh toán - Chuyển bài
                </p>
                <p class="formbold-policy">
                    4. Chính sách bảo hành thêm/ sửa miễn phí sau khi nhận bài
                </p>
            </div>


        </div>



        <div class="formbold-event-details">
            <h5>Thông tin khiếu nại</h5>

            <ul>
                <li>
                    <svg style="color:#6a64f1 ;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                        <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951" />
                    </svg>
                    <a style="text-decoration: none; color:#6a64f1" target="_blank" href="https://www.facebook.com/profile.php?id=100064104764238">Huy Nguyễn</a>
                </li>
                <li>
                    <svg style="color:#000 ;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                    </svg>
                    <a style="text-decoration: none;color:#000; " href="">0373954586</a>
                </li>
            </ul>
        </div>

    </div>
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
        color: #000;
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
        font-size: 12px;
        /* You can set the desired font size */
        color: #999;
        /* You can set the desired color */
    }

    .formbold-form-input {
        text-align: center;
        width: 100%;
        padding: 13px 22px;
        border-radius: 5px;
        border: 2px solid #a6a4a4;
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
        color: #a6a4a4;
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