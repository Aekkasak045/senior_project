<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $url = 'http://52.221.67.113/smartlift/get_status_redis.php?lift_id=2'; // แทนที่ URL_API ด้วย URL ของ API
    $response = file_get_contents($url);
    $data = json_decode($response, true);
    if ($data === null) {
        echo 'Failed to fetch API data';
        exit;
    }
    foreach ($data as $item) {
        $value = $item['car_status']; // เปลี่ยน 'yourValue' เป็นชื่อสมาชิกที่คุณต้องการใช้
    
        if ($value === '00') {
            $background = 'red'; // สีพื้นหลังที่คุณต้องการให้เป็น
        } else {
            $background = 'green'; // สีพื้นหลังที่คุณต้องการให้เป็นในกรณีอื่น ๆ
        }
    
        // สร้างแถว <tr> และกำหนดสีพื้นหลัง
        echo '<tr style="background-color: ' . $background . ';">';
        echo '<td>' . $item['column1'] . '</td>';
        echo '<td>' . $item['column2'] . '</td>';
        // สร้างคอลัมน์อื่น ๆ ตามต้องการ
        echo '</tr>';
    }
    
    ?>
</body>
</html>