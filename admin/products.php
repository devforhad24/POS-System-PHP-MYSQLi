<?php include 'includes/header.php'; ?>

<div class="container-fluid px-4">

    <div class="card mt-4 shadow">
        <div class="card-header">
            <h4 class="mb-0">Products
                <a href="products-create.php" class="btn btn-primary float-end">Add Product</a>
            </h4>

        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <?php
            $products = getAll('products');
            if (!$products) {
                echo '<h4>Somethnig went wrong!</h4>';
                return false;
            }
            if (mysqli_num_rows($products) > 0) {
            ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($products as $item) : ?>
                                <tr>
                                    <td><?= $item['id'] ?></td>
                                    <td>
                                        <img src="../<?= $item['image']; ?>" style="width: 50px; height: 50px;" alt="">
                                    </td>
                                    <td><?= $item['name'] ?></td>
                                    <td>
                                        <span class="badge <?= $item['status'] ? 'bg-danger' : 'bg-success'; ?>">
                                            <?= $item['status'] ? 'Hidden' : 'Visible'; ?>
                                        </span>
                                    </td>

                                    <td>
                                        <a href="products-edit.php?id=<?= $item['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                        <a onclick="return confirm('Are you sure you want to delete this record?');" href="products-delete.php?id=<?= $item['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>


                        </tbody>

                    </table>
                </div>
            <?php
            } else {
            ?>
                <h4 class="mb-0">No Record Found</h4>
            <?php
            }
            ?>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>