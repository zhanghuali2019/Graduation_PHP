<?php
// 连接数据库
$conn = @mysqli_connect('localhost', 'root', '', 'bbs');
// 检测连接是否有错
if (mysqli_connect_errno() !== 0) {
    die(mysqli_connect_error());
}

$image = $_FILES['image'];
if($image['error'] === 0) {
    // 上传成功,保存文件
    $ext = pathinfo($image['name'], PATHINFO_EXTENSION); // 获取文件扩展名
    if(!in_array($ext, ['jpg', 'jpeg', 'png'])) {
        die('文件格式错误!');
    }
    $filename = "one"; // 根据当前时间生成新的文件名
    $image_url = './avatars/' . $filename . '.' . $ext;
    move_uploaded_file($image['tmp_name'], $image_url);

    // 缩放图片
    if($ext == 'jpg' || $ext == 'jpeg') {
        $source = imagecreatefromjpeg($image_url);
    } else if($ext == 'png') {
        $source = imagecreatefrompng($image_url);
    }

    // 获取原图尺寸
    list($width, $height) = getimagesize($image_url);

    $thumb = imagecreatetruecolor(200, 200);
    imagecopyresized($thumb, $source, 0, 0, 0, 0, 200, 200, $width, $height);

    $thumb_file = './avatars/' . $filename . '_thumb.' . $ext;
    if($ext == 'jpg' || $ext == 'jpeg') {
        imagejpeg($thumb, $thumb_file);
    } else if($ext == 'png') {
        imagepng($thumb, $thumb_file);
    }

    // 更新数据库
    $sql = "UPDATE `user` set `avatar` = '" . $thumb_file . "'";
    mysqli_query($conn, $sql);
    if(mysqli_errno($conn) !== 0) {
        die(mysqli_error($conn));
    }
    header('Location: ./');
} else {
    // 上传失败,报告错误
    switch ($image['error']) {
        case UPLOAD_ERR_INI_SIZE:
            $msg = '上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值。';
            break;
        case UPLOAD_ERR_FORM_SIZE:
            $msg = '上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值。';
            break;
        case UPLOAD_ERR_PARTIAL:
            $msg = '文件只有部分被上传。';
            break;
        case UPLOAD_ERR_NO_FILE:
            $msg = '没有文件被上传。';
            break;
        case UPLOAD_ERR_NO_TMP_DIR:
            $msg = '找不到临时文件夹。';
            break;
        case UPLOAD_ERR_CANT_WRITE:
            $msg = '文件写入失败。';
            break;
        default:
            $msg = '未知错误.';
            break;
    }

    die($msg);
}
?>
