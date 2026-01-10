<?php
include('../config/function.php');

if (isset($_POST['saveAdmin'])) {
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $phone = validate($_POST['phone']);
    $is_ban = validate($_POST['is_ban']) == true ? 1 : 0;

    if ($name != '' && $email != '' && $password != '') {
        $emailCheck = mysqli_query($conn, "SELECT * FROM admins WHERE email='$email'");
        if ($emailCheck) {
            if (mysqli_num_rows($emailCheck) > 0) {
                redirect('admins-create.php', 'Email Already used by another user.');
            }
        }
        $bcrypt_password = password_hash($password, PASSWORD_BCRYPT);
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $bcrypt_password,
            'phone' => $phone,
            'is_ban' => $is_ban,
        ];
        $result = insert('admins', $data);

        if ($result) {
            redirect('admins.php', 'Admin Created successfully!');
        } else {
            redirect('admins-create.php', 'Something went wrong!');
        }
    } else {
        redirect('admins-create.php', 'Please fill required fields.');
    }
}

if (isset($_POST['updateAdmin'])) {
    $adminId = validate($_POST['adminId']);

    $adminData = getById('admins', $adminId);

    if ($adminData['status'] != 200) {
        redirect('admins-edit.php?id=' . $adminId, 'Please fill required fields.');
    }

    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $phone = validate($_POST['phone']);
    $is_ban = isset($_POST['is_ban']) == true ? 1 : 0;

    if ($password != '') {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    } else {
        $hashedPassword = $adminData['data']['password'];
    }

    if ($name != '' && $email != '') {
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword,
            'phone' => $phone,
            'is_ban' => $is_ban,
        ];
        $result = update('admins', $adminId, $data);

        if ($result) {
            redirect('admins-edit.php?id=' . $adminId, 'Admin Updated successfully!');
        } else {
            redirect('admins-edit.php?id=' . $adminId, 'Something went wrong!');
        }
    } else {
        redirect('admins-create.php', 'Please fill required fields.');
    }
}

if (isset($_POST['saveCategroy'])) {
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $status = isset($_POST['status']) == true ? 1:0;

    $data = [
        'name' => $name,
        'description' => $description,
        'status' => $status,
    ];
    $result = insert('categories', $data);

    if ($result) {
        redirect('categories.php', 'Admin Created successfully!');
    } else {
        redirect('categories-create.php', 'Something went wrong!');
    }
}

if (isset($_POST['updateCategroy'])) {
    $categoryId = validate($_POST['categoryId']);

    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $status = isset($_POST['status']) == true ? 1:0;

    $data = [
        'name' => $name,
        'description' => $description,
        'status' => $status,
    ];
    $result = update('categories', $categoryId,$data);

    if ($result) {
        redirect('categories-edit.php?id='.$categoryId, 'Category Updated successfully!');
    } else {
        redirect('categories-edit.php?id='.$categoryId, 'Something went wrong!');
    }
}


