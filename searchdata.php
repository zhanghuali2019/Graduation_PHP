<?php
header("Access-Control-Allow-Origin:http://localhost:8080");
header("Access-Control-Allow-Methods:GET, POST, OPTIONS, DELETE");
header("Access-Control-Allow-Headers:DNT,X-Mx-ReqToken,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type, Accept-Language, Origin, Accept-Encoding");
header('Content-Type:application/json; charset=utf-8');
// 连接数据库
$conn = @mysqli_connect('localhost', 'root', '', 'bbs');
// 检测连接是否有错
if (mysqli_connect_errno() !== 0) {
    die(mysqli_connect_error());
}

//查询所有的帖子
$sql = "SELECT * FROM `post` order by `id` desc";
$result = mysqli_query($conn, $sql);
if(mysqli_errno($conn) !== 0) {
    die(mysqli_error($conn));
}
$arr0 = array();
while ($all = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    $count0=count($all);//不能在循环语句中，由于每次删除 row数组长度都减小  
    for($i=0;$i<$count0;$i++){  
        unset($all[$i]);//删除冗余数据  
    }
    array_push($arr0,$all);
}
$all_str=json_encode($arr0);//将数组进行json编码

// 查询最新贴8条
$sql = "SELECT * FROM `post` ORDER BY `post_at` DESC LIMIT 8";
$result = mysqli_query($conn, $sql);
if(mysqli_errno($conn) !== 0) {
    die(mysqli_error($conn));
}
$arr1 = array();
while ($latest = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    $count1=count($latest);//不能在循环语句中，由于每次删除 row数组长度都减小  
    for($i=0;$i<$count1;$i++){  
        unset($latest[$i]);//删除冗余数据  
    }
    array_push($arr1,$latest);
}
$latest_str=json_encode($arr1);//将数组进行json编码

// 查询热帖贴8条
$sql = "SELECT * FROM `post` ORDER BY `replies` DESC LIMIT 8";
$result = mysqli_query($conn, $sql);
if(mysqli_errno($conn) !== 0) {
    die(mysqli_error($conn));
}
$arr2 = array();
while ($pops = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    $count2=count($pops);//不能在循环语句中，由于每次删除 row数组长度都减小  
    for($j=0;$j<$count2;$j++){  
        unset($pops[$j]);//删除冗余数据  
    }
    array_push($arr2,$pops);
}
$pops_str=json_encode($arr2);//将数组进行json编码

//将结果返回
$res = array('success' => true,'all_data' => $all_str, 'latest_data' => $latest_str, 'pops_data' => $pops_str);
$res_json = json_encode($res);
exit($res_json);

?>