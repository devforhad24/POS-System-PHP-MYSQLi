<?php include 'includes/header.php'; ?>

<div class="container-fluid px-4">

    <div class="card mt-4 shadow">
        <div class="card-header">
            <h4 class="mb-0">Edit Admin
                <a href="admins.php" class="btn btn-danger float-end">Back</a>
            </h4>

        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="code.php" method="POST">
                <?php
                if (isset(($_GET['id']))) {
                    if ($_GET['id'] != '') {
                        $adminId = $_GET['id'];
                    } else {
                        echo '<h5>No Id Found</h5>';
                        return false;
                    }
                } else {
                    echo '<h5>No Id given in params</h5>';
                    return false;
                }
                $adminData = getById('admins', $adminId);
                if ($adminData) {
                    if ($adminData['status'] == 200) {
                ?>

                        <input type="hidden" name="adminId" value="<?= $adminData['data']['id']; ?>">

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="">Name *</label>
                                <input type="text" class="form-control" value="<?= $adminData['data']['name'] ?>" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Email *</label>
                                <input type="email" class="form-control" value="<?= $adminData['data']['email'] ?>" id="email" name="email" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Password *</label>
                                <input type="password" class="form-control" id="email" name="password">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="phone">Phone Number *</label>
                                <input type="number" class="form-control" value="<?= $adminData['data']['phone'] ?>" id="phone" name="phone">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Is Ban *</label>
                                <br>
                                <input type="checkbox" name="is_ban" value="<?= $adminData['data']['is_ban'] == true ? 'checked' : ''; ?>" style="width: 30px; height: 30px;">
                            </div>
                            <div class="col-md-12 mb-3 text-end">
                                <button type="submit" name="updateAdmin" class="btn btn-primary">Update Admin</button>
                            </div>
                        </div>
                <?php
                    } else {
                        echo '<h5>' . $adminData['message'] . '</h5>';
                    }
                } else {
                    echo 'Something went wrong';
                    return false;
                }
                ?>


            </form>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>