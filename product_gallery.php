<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Gallery</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1 style="text-align: center;">Product Gallery</h1>
    <div id="product-container">
        <?php
            // 商品データをPHPで定義
            $products = [
                ["title" => "Clancy Blue", "description" => "Description of Clancy Blue.", "image" => "image/Clancy_Blue.jpg"],
                ["title" => "Gary Black", "description" => "Description of Gary Black.", "image" => "image/Gary_Black.jpg"],
                ["title" => "Gary Tan", "description" => "Description of Gary Tan.", "image" => "image/Gary_Tan.jpg"],
                ["title" => "Heavenly Black", "description" => "Description of Heavenly Black.", "image" => "image/Heavenly_Black.jpg"],
                ["title" => "Sally Black", "description" => "Description of Sally Black.", "image" => "image/Sally_Black.jpg"],
                ["title" => "Sally Tan", "description" => "Description of Sally Tan.", "image" => "image/Sally_Tan.jpg"],            
                ["title" => "Work and Walk Chesnut", "description" => "Description of Work and Walk Chesnut.", "image" => "image/Work_and_Walk_Chesnut.jpg"]
            ];

            // 商品データをループで出力
            foreach ($products as $product) {
                echo '<div class="product">';
                echo '<img src="' . $product["image"] . '" alt="' . $product["title"] . '">';
                echo '<h2>' . $product["title"] . '</h2>';
                echo '<p>' . $product["description"] . '</p>';
                echo '</div>';
            }
        ?>
    </div>
</body>
</html>