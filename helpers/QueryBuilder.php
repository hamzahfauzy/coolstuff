<?php

class QueryBuilder{
    
    public $sql = "";
    private $conn;
    
    function __construct(){
        require_once '../config/database.php';
        $this->conn = $conn;  
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

    function exec(){
        $query = sqlsrv_query( $this->conn, $this->sql );

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

        $datas = array();
        while($r = sqlsrv_fetch_array( $query, SQLSRV_FETCH_ASSOC)) {
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