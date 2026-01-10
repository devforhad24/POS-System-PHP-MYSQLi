<?php
require '../config/function.php';

$paraResultId = checkParamId('id');

if (is_numeric($paraResultId)) {

    $productId = validate($paraResultId);

    // Get product by ID
    $product = getById('products', $productId);

    if ($product['status'] == 200) {

        // Delete product from database
        $response = delete('products', $productId);

        if ($response) {

            // Delete product image
            $deleteImage = "../" . $product['data']['image'];
            if (!empty($product['data']['image']) && file_exists($deleteImage)) {
                unlink($deleteImage);
            }

            redirect('products.php', 'Product Deleted Successfully');

        } else {
            redirect('products.php', 'Failed to delete product');
        }

    } else {
        redirect('products.php', $product['message']);
    }

} else {
    redirect('products.php', 'Invalid Product ID');
}
?>
