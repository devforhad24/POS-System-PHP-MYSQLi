<?php
include('../config/function.php');

if(!isset($_SESSION['productItems'])){
    $_SESSION['productItems'] = [];
}
if(!isset($_SESSION['productItemIds'])){
    $_SESSION['productItemIds'] = [];
}

if (isset($_POST['addItem'])) {

    $productId = validate($_POST['product_id']);
    $quantity  = validate($_POST['quantity']);

    $checkProduct = mysqli_query($conn, "SELECT * FROM products WHERE id='$productId' LIMIT 1");

    if ($checkProduct) {
        if (mysqli_num_rows($checkProduct) > 0) {

            $row = mysqli_fetch_assoc($checkProduct);

            if ($row['quantity'] < $quantity) {
                redirect('order-create.php', 'Only '.$row['quantity'].' quantity available');
            }

            $productData = [
                'product_id' => $row['id'],
                'name'       => $row['name'],
                'image'      => $row['image'],
                'price'      => $row['price'],
                'quantity'   => $quantity,
            ];

            if (!in_array($row['id'], $_SESSION['productItemIds'])) {

                $_SESSION['productItemIds'][] = $row['id'];
                $_SESSION['productItems'][]   = $productData;

            } else {

                foreach ($_SESSION['productItems'] as $key => $prodSessionItem) {
                    if ($prodSessionItem['product_id'] == $row['id']) {

                        $newQuantity = $prodSessionItem['quantity'] + $quantity;

                        $_SESSION['productItems'][$key]['quantity'] = $newQuantity;
                    }
                }
            }

            redirect('order-create.php', 'Item Added: '.$row['name']);

        } else {
            redirect('order-create.php', 'No such product found!');
        }
    } else {
        redirect('order-create.php', 'Something went wrong!');
    }
}

if (isset($_POST['productIncDec'])) {

    $productId = validate($_POST['product_id']);
    $quantity  = validate($_POST['quantity']);

    $flag = false;
    $total = 0;

    foreach ($_SESSION['productItems'] as $key => $item) {

        if ($item['product_id'] == $productId) {

            $flag = true;
            $_SESSION['productItems'][$key]['quantity'] = $quantity;

            $price = $_SESSION['productItems'][$key]['price'];
            $total = $price * $quantity;
            break;
        }
    }

    if ($flag) {
        echo json_encode([
            'status' => 200,
            'message' => 'Quantity updated',
            'total' => $total
        ]);
        exit;
    } else {
        echo json_encode([
            'status' => 500,
            'message' => 'Something went wrong. Please Refresh'
        ]);
        exit;
    }
}
