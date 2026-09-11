<?php
namespace Core;

use Config\Database as DBConfig;
use PDO;

abstract class Database {
    protected PDO $db;

    public function __construct() {
        $this->db = DBConfig::getConnection();
    }
}
