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
$id = $_POST['id'];
//查询所有的帖子
$sql = "SELECT * FROM `thread` where `parent_id`={$id} ORDER BY `id`";
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


//将结果返回
$res = array('success' => true,'thread' => $all_str);
$res_json = json_encode($res);
exit($res_json);

?>