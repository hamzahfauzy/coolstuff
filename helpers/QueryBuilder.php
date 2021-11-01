<?php

class QueryBuilder{
    
    public $sql = "";
    private $conn;
    
    function __construct(){
        $this->conn = conn();  
    }

    function select($tbl,$columns = "*"){

        $this->sql = "select $columns from $tbl";

        return $this;
    }

    function where($key,$value, $operator = '='){
        if(stringContains($this->sql,"where")){
            $this->sql .= " and $key $operator '$value' ";
        }else{
            $this->sql .= " where $key $operator '$value' ";
        }


        return $this;
    }

    function join($tbl,$key,$value){
        $this->sql .= " join $tbl on $key=$value ";

        return $this;
    }

    function andJoin($key,$value){
        $this->sql .= " and $key=$value ";

        return $this;
    }

    function leftJoin($tbl,$key,$value){
        $this->sql .= " left join $tbl on $key=$value ";

        return $this;
    }

    function innerJoin($tbl,$key,$value){
        $this->sql .= " inner join $tbl on $key=$value ";

        return $this;
    }
    
    function orWhere($key,$value,$operator = '='){
        $this->sql .= " or $key $operator '$value' ";

        return $this;
    }

    function orderBy($val,$type = "asc"){
        $this->sql .= " order by $val $type";

        return $this;
    }

    function groupBy($val){
        $this->sql .= " group by $val ";

        return $this;
    }

    function exec($params = []){
        $query = sqlsrv_query( $this->conn, $this->sql ,$params);

        return $query;
    }

    function first(){

        $query = $this->exec();
       
        $data = array();
        while($r = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
            $data = $r;
            break;
        }

        return $data;
    }

    function get(){

        $query = $this->exec();

        if( $query === false ) {
            die( print_r( sqlsrv_errors(), true));
        }

        $datas = array();
        while($r = sqlsrv_fetch_array( $query, SQLSRV_FETCH_ASSOC)) {
            $datas[] = $r;
        }

        return $datas;
    }

    
    function count($tbl,$column){

        $this->sql = "select count($column) as count from $tbl";

        $query = $this->exec();

        $result = 0;
        while($r = sqlsrv_fetch_array( $query, SQLSRV_FETCH_ASSOC)) {
            $result = $r['count'];
        }


        return $result;
    }

    function create($tbl,$values){
    
        $columns = "";
        $vals = "";

        $i = 0;
        foreach($values as $key => $val){
            
            if($i == count($values)-1){
                $columns .= " $key ";
                $vals .= " '$val' ";
            }else{
                $columns .= " $key, ";
                $vals .= " '$val', ";
            }

            $i++;
        }

        
        $this->sql = "INSERT INTO $tbl ($columns) VALUES ($vals)";

        return $this;

    }

    function update($tbl,$values){
        $vals = "";

        $i = 0;
        foreach($values as $key => $val){
            
            if($i == count($values)-1){
                $vals .= " $key='$val' ";
            }else{
                $vals .= " $key='$val', ";
            }

            $i++;
        }

        
        $this->sql = "UPDATE $tbl SET $vals";

        return $this;

    }

    function delete($tbl){

        $this->sql = "DELETE FROM $tbl";

        return $this;

    }

    function rawQuery($sql){
        $this->sql = $sql;

        return $this;
    }

    function columns($table,$column = false, $is_in = false){
        $this->sql = "SELECT data_type,column_name,character_maximum_length FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table'";

        $query = $this->exec();

        $datas = [];
        while($r = sqlsrv_fetch_array( $query, SQLSRV_FETCH_ASSOC)) { 
            
            if($column){
                if($is_in){
                    if(stringContains($column, $r['column_name'])){
                        continue;
                    }
                }else if(!stringContains($column, $r['column_name'])){
                    continue;
                }
            }

            if($r['data_type'] == 'nvarchar'){
                $r['data_type'] = 'text';
            }

            if($r['data_type'] == 'numeric'){
                $r['data_type'] = 'number';
            }

            if(strtolower($r['column_name']) == 'password'){
                $r['data_type'] = 'password';
            }

            $datas[] = $r;
        }

        return $datas;
    }

    function paginate($limit = 10){

        $this->sql .= " limit $limit ";

        $query = $this->exec();

        $datas = array();

        $i = 0;

        while($r = sqlsrv_fetch_array( $query, SQLSRV_FETCH_ASSOC)) {
            $datas[] = $r;
            $i += 10;
        }

        return $datas;
    }

}