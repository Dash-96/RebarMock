<?php
mb_internal_encoding("UTF-8");
require_once BASE_PATH . "/services/product/getProduct.php";
require_once BASE_PATH . "/services/product/getIngredients.php";
$base_url = "http://localhost/rebarMock/";
$product = [];
$product = getProductById($product_id); //product_id is from the url route -- see webRouter.php
$ingredients = getIngredients();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/rebarMock/rebarClone.css">
    <link rel="stylesheet" href="/rebarMock/pages/product/productPage.css">
</head>

<body>
    <div class="scroll-wraper">
        <div class="page-wraper">
            <span class="product-title"><?= parseProductName($product['name']) ?></span>
            <img src="<?= $base_url . $product['image_uri'] ?>" alt="<?= $product['name'] ?> image">
            <div class="size-picker-container">
                <span class="size-container"><button onclick="upgradeSize(this)" class="shake-size-button"><span
                            class="shake-icon small-icon"></span></button> <label class="size-text">S</label></span>
                <span class="size-container"><button onclick="upgradeSize(this,5)" class="shake-size-button"><span
                            class="shake-icon medium-icon"></span></button><label class="size-text">M</label></span>
                <span class="size-container"><button onclick="upgradeSize(this,9)" class="shake-size-button"><span
                            class="shake-icon large-icon"></span></button><label class="size-text">L</label></span>
            </div>
            <span class="product-ingredients"><?= $product['ingredients'] ?></span>
            <div class="smoothie-base-container">
                <span class="base-option">
                    <label for="yogurt-option" class="base-option-text">יוגורט</label>
                    <input type="radio" id="yogurt-option" class="base-option-radio"
                        <?= containsYogurt($product['ingredients']) ? "checked" : "" ?>
                        onchange="changeSmoothieBase(this)">
                </span>
                <span class="base-option">
                    <label for="no-yogurt-option" class="base-option-text">ללא יוגורט</label>
                    <input type="radio" id="no-yogurt-option" class="base-option-radio"
                        onchange="changeSmoothieBase(this)"
                        <?= containsYogurt($product['ingredients']) ? "" : "checked" ?>>
                </span>
                <span class="base-option">
                    <label for="almonds-option" class="base-option-text">חלב שקדים</label>
                    <input type="radio" id="almonds-option" class="base-option-radio"
                        onchange="changeSmoothieBase(this)">
                </span>
                <span class="base-option">
                    <label for="soy-option" class="base-option-text">חלב סויה</label>
                    <input type="radio" id="soy-option" class="base-option-radio" onchange="changeSmoothieBase(this)">
                </span>
                <span class="base-option">
                    <label for="coconut-option" class="base-option-text">חלב קוקוס</label>
                    <input type="radio" id="coconut-option" class="base-option-radio"
                        onchange="changeSmoothieBase(this)">
                </span>
            </div>
            <div class="custom-change-container">
                <input data-ingredients='<?= json_encode($ingredients) ?>' class="custom-change-input" type="text"
                    id="custom-change-input" placeholder="הקלד שינויים כאן ובחר מהתפריט הנופל (3 שינויים)"
                    oninput="filterIngredients(this)">
                <div class="custom-change-result">
                </div>
                <div class="selected-change-items-container"></div>
            </div>

            <div class="action-buttons-container">
                <button class="action-button">AI יועץ </button>
                <button class="action-button" onclick="addProductToCart()"><span class="cart-icon"></span>הוספה
                    לסל</button>
                <button class="action-button">חזרה לתפריט</button>
            </div>
        </div>
    </div>
    <script>
        const product_id = <?php echo $product['id'] ?>;
        const productBasePrice = <?php echo $product['base_price'] ?>
    </script>
    <script src="/rebarMock/pages/product/productPage.js"> </script>
</body>

</html>

<?php
function parseProductName($name)
{
    $length = strlen($name);
    $parts = explode(' ', $name, 2);
    if (count($parts) == 1 && strpos($name, "re") !== false) {
        $first_half = substr($name, 0, 2);
        $second_half = substr($name, 2, $length);
    } else {
        $first_half = $parts[0] . " ";
        $second_half = $parts[1];
    }

    return "<span class='colored-word'>" . $first_half . "</span>" . "<span>" . $second_half . "</span>";
}

function containsYogurt($ingredients)
{
    return strpos($ingredients, "יוגורט");
}
