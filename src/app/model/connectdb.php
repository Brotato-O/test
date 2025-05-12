<?php

function get_connect()
{
    try {
        $conn = new PDO("mysql:host=localhost;dbname=da1;charset=utf8", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (Exception $e) {
        echo 'Kết nối thất bại: ' . $e->getMessage();
        return null;
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
    if (!$conn) return;

    try {
        $stmt = $conn->prepare($sql);

        // Kiểm tra xem có tham số nào là mảng không
        foreach ($thamso as $index => $val) {
            if (is_array($val)) {
                throw new Exception("Lỗi: Tham số tại vị trí $index là một mảng. Các tham số truyền vào SQL phải là giá trị đơn.");
            }
        }

        // Đảm bảo số lượng tham số khớp với số dấu ?
        $expectedParams = substr_count($sql, '?');
        if ($expectedParams !== count($thamso)) {
            throw new Exception("Lỗi: Số lượng dấu '?' ($expectedParams) không khớp với số tham số truyền vào (" . count($thamso) . ").");
        }

        $stmt->execute($thamso);
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
    if (!$conn) return [];

    try {
        $stmt = $conn->prepare($sql);

        // Kiểm tra mảng và số lượng tham số
        foreach ($thamso as $index => $val) {
            if (is_array($val)) {
                throw new Exception("Lỗi: Tham số tại vị trí $index là một mảng.");
            }
        }

        if (substr_count($sql, '?') !== count($thamso)) {
            throw new Exception("Lỗi: Số lượng dấu '?' không khớp với số tham số.");
        }

        $stmt->execute($thamso);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo 'Thao tác thất bại: ' . $e->getMessage();
        return [];
    } finally {
        unset($conn);
    }
}

function pdo_query_one($sql)
{
    $thamso = array_slice(func_get_args(), 1);
    $conn = get_connect();
    if (!$conn) return null;

    try {
        $stmt = $conn->prepare($sql);

        // Kiểm tra mảng và số lượng tham số
        foreach ($thamso as $index => $val) {
            if (is_array($val)) {
                throw new Exception("Lỗi: Tham số tại vị trí $index là một mảng.");
            }
        }

        if (substr_count($sql, '?') !== count($thamso)) {
            throw new Exception("Lỗi: Số lượng dấu '?' không khớp với số tham số.");
        }

        $stmt->execute($thamso);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo 'Thao tác thất bại: ' . $e->getMessage();
        return null;
    } finally {
        unset($conn);
    }
}
?>
