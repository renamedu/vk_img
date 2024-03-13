<?php
session_start();

$_SESSION = [];

$owner_id = $_POST['owner_id'];
$album_id = $_POST['album_id'];
$token = $_POST['token'];
$count = $_POST['count'];
$rev = $_POST['rev'];

try {
    $request_params = array(
        'owner_id' => $owner_id,
        'album_id' => $album_id,
        'v' => '5.131',
        'access_token' => $token,
        'count' => $count,
        'rev' => $rev,
    );
    $get_params = http_build_query($request_params);
    $result = json_decode(file_get_contents('https://api.vk.com/method/photos.get?' . $get_params));

} catch (Throwable $ex)
{
    echo "Сообщение об ошибке: " . $ex->getMessage() . "<br>";
    echo "Файл: " . $ex->getFile() . "<br>";
    echo "Номер строки: " . $ex->getLine() . "<br>";
}

$_SESSION["owner_id"] = $owner_id;
$_SESSION["album_id"] = $album_id;
$_SESSION["count"] = $count;


$_SESSION["items"] = $result -> response -> items;

// echo '<pre>';
// var_dump($_SESSION["items"]);
// echo '</pre>';

header('location: index.php');

