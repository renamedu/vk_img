<?php

session_start();

$owner_id = $_SESSION["owner_id"] ?? "";
$album_id = $_SESSION["album_id"] ?? "";
$count = $_SESSION["count"] ?? "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>vk img sort</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div>
        <form action="https://oauth.vk.com/authorize?client_id=51674008&display=page&redirect_uri=https://oauth.vk.com/blank&scope=photos&response_type=token&v=5.131" method="POST">
            <!-- <input type="hidden" name="id" value=""> -->
            <button type="submit" class="get-token-btn">Get access token</button>
        </form>
    </div>
    <div class="token-input-form">
        <form action="getImg.php" method="POST">
            <label for="owner_id">Profile id: </label>
            <input name="owner_id" id="owner_id" type="text" placeholder="123456789" size="11" value="<?= $owner_id ?>">
            <br>
            <label for="album_id">Album id: </label>
            <input name="album_id" id="album_id" type="text" placeholder="123456789" size="11" value="<?= $album_id ?>">
            <br>
            <label for="count">Number of images: </label>
            <input name="count" id="count" type="text" placeholder="50" size="11" value="<?= $count ?>">
            <br>
            <label for="token">Access token: </label>
            <input name="token" id="token" type="text" placeholder="vk1.a.LlbFH059idYI3K8mR0yz9tv5XCsC4FEASG...hTKN8g6GMAjm_nRo" size="220"
            value="">
            <br>
            <label for="rev">Order/Сортировка</label>
            <input name="rev" id="rev" type="checkbox" checked>
            <br>
            <button type="submit" class="send-token-btn">Get Images</button>
        </form>
    </div>
    <p>
        <?php

        // echo '<pre>';
        // var_dump($_SESSION);
        // echo '</pre>';
        $images = [];

        if (isset($_SESSION["items"])) {
            $items = ($_SESSION["items"]);

            foreach ($items as $item) {
                $max_width = 0;
                $max_height = 0;
                $max_size_url = "";
                
                $img_id = $item -> id;

                foreach ($item -> sizes as $size) {
    
                    if ($size -> height > $max_height) {
                        $max_width = $size -> width;
                        $max_height = $size -> height;
                        $max_size_url = $size -> url;
                    }
                    if ($size -> type == "p") {
                        $preview_img_url = $size -> url;
                    }
                }

                $images[] = [
                    "full_img" => $max_size_url,
                    "width" => $max_width,
                    "height" => $max_height,
                    "preview_img" => $preview_img_url,
                    "id" => $img_id,
                ];

                // echo $item -> id;
                // echo "<img src='$max_size_url'>";
            }

            echo '<pre>';
            var_dump($images);
            echo '</pre>';

        }

        ?>
    </p>

</body>

</html>