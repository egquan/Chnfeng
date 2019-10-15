<?php
/**
 * Index 控制器
 * Index 动作 的视图演示文件
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<h1><?=$data?></h1>
<br>
<h1>测试数据</h1>
<h3>----------------------------------------------------------------</h3>
<?php foreach ($datas as $key => $value) { ?>
    <h3>ID：<?=$value['id']?> USERNAME：<?=$value['username']?> PASSWD：<?=$value['passwd']?></h3>
    <h3>----------------------------------------------------------------</h3>
<?php }?>
</body>
</html>