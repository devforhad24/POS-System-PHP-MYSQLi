<?php
require '../config/function.php';

$paraResultId = checkParamId('id');

if(is_numeric($paraResultId)){
    $customerId = validate($paraResultId);

    $customer = getById('customers', $customerId);

    if($customer['status'] == 200){
        $response = delete('customers', $customerId);
        if($response){
            redirect('customers.php', 'Customer Deleted Successfully');
        }else{
            redirect('customers.php', 'Something went wrong');
        }
    }else{
        redirect('customers.php', $customer['message']);
    }
}else{
redirect('customers.php', 'Something went wrong');
}

?>