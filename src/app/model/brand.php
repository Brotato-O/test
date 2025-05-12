<?php

function query_allbrand(){
        $sql = "select * from thuong_hieu order by id asc";
        $result = pdo_queryall($sql);
        return $result;
    }
function insert_brand($brand_name,$mo_ta) {
        $sql = "insert into thuong_hieu (ten_thuong_hieu,mo_ta) VALUES ('$brand_name','$mo_ta')";
        pdo_execute($sql);
        
    }
function deletebrand($id){
        $sql = "delete from thuong_hieu where id = $id";
        pdo_execute($sql);
    }
function queryonebrand($id){
        $sql= "select * from thuong_hieu where id = $id";
        $result = pdo_query_one($sql);
        return $result;
    }
function updatebrd($ten,$mo_ta,$id){
        $sql = "update thuong_hieu set ten_thuong_hieu = '$ten',mo_ta = '$mo_ta' where id = $id";
        pdo_execute($sql);
    }
?>