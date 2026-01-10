<?php include 'includes/header.php'; ?>

<div class="container-fluid px-4">

    <div class="card mt-4 shadow">
        <div class="card-header">
            <h4 class="mb-0">Add Category
                <a href="categories.php" class="btn btn-primary float-end">Back</a>
            </h4>

        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="code.php" method="POST">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="">Name *</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="">Descriiption</label>
                        <textarea  name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Status (Unchacked=Visible, Checked=Hidden)</label>
                        <br>
                        <input type="checkbox" style="width: 30px;height: 30px;" name="status">
                    </div>
                    <div class="col-md-12 mb-3 text-end">
                        <button type="submit" name="saveCategroy" class="btn btn-primary">Save</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>