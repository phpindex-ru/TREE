<?php

class Tree {
 
    private $_db = null;
    private $_category_arr = array();
 
    public function __construct() {
        $this->_db = new PDO("mysql:dbname=phpindex;charset=utf8;host=localhost", "homestead", "secret");
        $this->_category_arr = $this->_getCategory();
    }

    private function _getCategory() {
        $query = $this->_db->prepare("SELECT * FROM `tree`"); 
        $query->execute(); 
        $result = $query->fetchAll(PDO::FETCH_OBJ);
        $return = array();
        foreach ($result as $value) { 
            $return[$value->parent_id][] = $value;
        }
        return $return;
    }

    public function outTree($parent_id, $level) {
        if (isset($this->_category_arr[$parent_id])) { 
            foreach ($this->_category_arr[$parent_id] as $value) { 
                echo "<div style='margin-left:" . ($level * 25) . "px;'>" . $value->name . "</div>";
                $level++; 
                $this->outTree($value->id, $level);
                $level--; 
            }
        }
    }
}
$tree = new Tree();
$tree->outTree(0, 0); 
?>