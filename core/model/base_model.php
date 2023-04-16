<?php

namespace core\Model;
use core\Db\DbConnection;

class BaseModel
{

    public $dbConn;

    public function __construct()
    {
        $this->dbConn = DbConnection::getConnection();
    }

}