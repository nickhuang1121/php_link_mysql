


<?php

    
    $db_host = "localhost";
    $db_username = "root";
    $db_password = "1234";
    $db_name = "phpboard";

    $db_link = new mysqli($db_host,$db_username,$db_password,$db_name);

    if($db_link->connect_error != ""){
        echo "FAIL";
    }else{
        echo "連結成功";
    }

    $pageRow_records = 5;
    $num_pages = 1;

    if(isset($_GET['page'])){ //isset() 檢測變數，是否有。$_GET['page'] 取得網址的 page 變數。
        $num_pages =$_GET['page'];
    }else{
        echo "無page變數";
    };

    $startRow_records = ($num_pages -1) * $pageRow_records;
    

    $query_RecBoard = "SELECT * FROM board ORDER BY boardtime DESC";

    
    $query_limit_RecBoard = $query_RecBoard." LIMIT {$startRow_records}, {$pageRow_records}";


    $RecBoard = $db_link->query($query_limit_RecBoard);
    $all_RecBoard = $db_link->query($query_RecBoard);

    $total_records = $all_RecBoard->num_rows;
    $total_pages = ceil($total_records/$pageRow_records);
       
?>



<html>
<head>
<title>訪客留言版</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>


<?php	while($row_RecBoard=$RecBoard->fetch_assoc()){ ?>
    <div class="msgContent">
        <div>暱稱：<span><?php echo $row_RecBoard["boardname"];?></span></div>
        <div>標題：<span><?php echo $row_RecBoard["boardsubject"];?></span></div>
        <div>內容：<span><?php echo $row_RecBoard["boardcontent"];?></span></div>
        <?php if($row_RecBoard["boardmail"]!=""){?>
            <div>EMAIL：
                <span>
                    <a href="mailto:<?php echo $row_RecBoard["boardmail"];?>">MAIL</a>
                </span>
            </div>            	  
        <?php }?>
        <?php if($row_RecBoard["boardweb"]!=""){?>
            <div>連結：
                <span>
                    <a href="<?php echo $row_RecBoard["boardweb"];?>" target="_blank" >連結</a>
            </div>            	  
        <?php }?>
        <div>日期：
            <span><?php echo $row_RecBoard["boardtime"];?></span>
            || 序號：
            <span><?php echo $row_RecBoard["boardid"];?></span>
        </div>
    </div>
<?php }?>
<?php if ($num_pages > 1) { // 若不是第一頁則顯示 ?>
    <a href="?page=1">第一頁</a> | <a href="?page=<?php echo $num_pages-1;?>">上一頁</a> |
<?php }?>
<?php if ($num_pages < $total_pages) { // 若不是最後一頁則顯示 ?>
    <a href="?page=<?php echo $num_pages+1;?>">下一頁</a> | <a href="?page=<?php echo $total_pages;?>">最末頁</a>
<?php }?>


</body>
</html>

<?php
$db_link->close();
?>


