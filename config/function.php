<?php
session_start();
require 'dbcon.php';

// Input field validation function
function validate($inputData)
{
    global $conn;
    $validateData = mysqli_real_escape_string($conn, $inputData);
    return trim($validateData);
}
// redirect from 1 page to another page with message (status)
function redirect($url, $status)
{
    $_SESSION['status'] = $status;
    header("Location: " . $url);
    exit(0);
}

// display message or status after any process
function alertMessage()
{
    if (isset($_SESSION['status'])) {
        echo "<div class='alert alert-info alert-dismissible fade show' role='alert'>
                    <strong>" . $_SESSION['status'] . "</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
        unset($_SESSION['status']);
    }
}

// insert record using this function
function insert($tableName, $data)
{
    global $conn;
    $table = validate($tableName);
    $columns = array_keys($data);
    $values = array_values($data);

    $findColumns = implode(", ", $columns);
    $findValues = "'" . implode("', '", $values) . "'";

    $query = "INSERT INTO $table ($findColumns) VALUES ($findValues)";
    $result = mysqli_query($conn, $query);
    return $result;
}

// update data usigng this function
function update($tableName, $id, $data)
{
    global $conn;
    $table = validate($tableName);
    $id = validate($id);

    $updateDataString = "";
    foreach ($data as $column => $value) {
        $updateDataString .= "$column='$value', ";
    }
    $finalUpdateData = substr($updateDataString, 0, -1); // remove last comma and space

    $query = "UPDATE $table SET $finalUpdateData WHERE id='$id' ";
    $result = mysqli_query($conn, $query);
    return $result;
}

// get record using this function
function getAll($tableName, $status = NULL)
{
    global $conn;
    $table = validate($tableName);

    if ($status == 'status') {
        $query = "SELECT * FROM $table WHERE status='0' ";
    } else {
        $query = "SELECT * FROM $table ";
    }
    return mysqli_query($conn, $query);
}
// get single record using this function
function getById($tableName, $id)
{
    global $conn;
    $table = validate($tableName);
    $id = validate($id);

    $query = "SELECT * FROM $table WHERE id='$id' LIMIT 1 ";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_array($result);
                $response = [
                'status' => 200,
                'data' => $row,
                'message' => 'Data Found.',
            ];
            return $response;
        } else {
            $response = [
                'status' => 404,
                'message' => 'No Data Found.'
            ];
            return $response;
        }
    } else {
        $response = [
            'status' => 500,
            'message' => 'Something went wrong.'
        ];
        return $response;
    }
}

// delete record using this function
function delete($tableName, $id)
{
    global $conn;
    $table = validate($tableName);
    $id = validate($id);

    $query = "DELETE FROM $table WHERE id='$id' LIMIT 1";
    $result = mysqli_query($conn, $query);
    return $result;
}