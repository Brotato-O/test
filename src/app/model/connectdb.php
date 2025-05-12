<?php

function get_connect()
{
    try {
        $conn = new PDO("mysql:host=localhost;dbname=da1;charset=utf8", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (Exception $e) {
        echo 'Kết nối thất bại: ' . $e->getMessage();
        return null; // Trả về null nếu kết nối thất bại
    }
}

function pdo_lastInsertId() {
    $conn = get_connect();
    if ($conn) {
        return $conn->lastInsertId();
    }
    return null;
}

function pdo_execute($sql)
{
    $thamso = array_slice(func_get_args(), 1);
    $conn = get_connect();
    if (!$conn) return; // Kiểm tra kết nối

    try {
        $exe = $conn->prepare($sql);
        $exe->execute($thamso);
    } catch (Exception $e) {
        echo 'Thao tác thất bại: ' . $e->getMessage();
    } finally {
        unset($conn);
    }
}

function pdo_queryall($sql)
{
    $thamso = array_slice(func_get_args(), 1);
    $conn = get_connect();
    if (!$conn) return []; // Trả về mảng rỗng nếu thất bại

    try {
        $exe = $conn->prepare($sql);
        $exe->execute($thamso);
        return $exe->fetchAll(PDO::FETCH_ASSOC); // Trả về mảng liên kết
    } catch (Exception $e) {
        echo 'Thao tác thất bại: ' . $e->getMessage();
    } finally {
        unset($conn);
    }
}

function pdo_query_one($sql)
{
    $thamso = array_slice(func_get_args(), 1);
    $conn = get_connect();
    if (!$conn) return null; // Trả về null nếu thất bại

    try {
        $exe = $conn->prepare($sql);
        $exe->execute($thamso);
        return $exe->fetch(PDO::FETCH_ASSOC); // Trả về mảng liên kết
    } catch (Exception $e) {
        echo 'Thao tác thất bại: ' . $e->getMessage();
    } finally {
        unset($conn);
    }
}
?>