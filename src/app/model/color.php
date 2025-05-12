<?php
    function query_allcolor(){
        $sql = "select * from color order by color_id desc";
        $result = pdo_queryall($sql);
        return $result;
    }
    function query_allcolor1(){
        $sql = "select * from color order by color_id asc";
        $result = pdo_queryall($sql);
        return $result;
    }
    function query_onecolor($id){
        $sql = "select * from color where color_id = $id";
        // printf($sql);
        // die;
        $result = pdo_query_one($sql);
        return $result;
    }
    function insert_color($color_name,$color_ma) {
        $sql = "insert into color (color_name,color_ma) VALUES ('$color_name','$color_ma')";
        pdo_execute($sql);
        
    }
    function deletecolor($id){
        $sql = "delete from color where color_id = $id";
        pdo_execute($sql);
    }
    
?>