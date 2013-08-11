<?php

abstract class Model {

    public function __construct() {
    }

    public function __toString() {
        return json_encode($this);
    }

    /**
     * Add the instance to the database by inserting the data in it.
     * @param db    PDO handle
     * $return id created after insertion or error code with '#'
     */
    public function add($db) {
        $table = $this->getTableName();

        $attrs = get_class_vars(get_class($this));
        unset($attrs['id']);
        $attrs = array_keys($attrs);

        $cols = implode(',', $attrs);

        $placeholders = '?';
        for ($i = 1; $i < count($attrs); $i++) {
            $placeholders .= ',?';
        }

        $stmt = $db->prepare("INSERT INTO $table ($cols) VALUES ($placeholders)");

        $index = 1;
        foreach ($attrs as $attr) {
            $stmt->bindParam($index++, $this->$attr);
        }

        $stmt->execute();

        $this->id = $db->lastInsertId();

        return $this->id;
    }

    /**
     * Save this instance to the database by updating the row with the matched id.
     *
     * @param db    PDO handle
     * @return  True: saved successfully, False: couldn't find a row with the id
     */
    public function save($db) {
        $table = $this->getTableName();

        $attrs = get_class_vars(get_class($this));
        unset($attrs['id']);
        $attrs = array_keys($attrs);

        $placeholders = implode('=?,', $attrs);
        $placeholders .= '=?';

        $stmt = $db->prepare("UPDATE $table SET $placeholders WHERE id = ?");

        $index = 1;
        foreach ($attrs as $attr) {
            $stmt->bindParam($index++, $this->$attr);
        }
        $stmt->bindParam($index, $this->id);

        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            return True;
        } else {
            return False;
        }
    }

    /**
     * Delete this instance from the database.
     *
     * @param db    PDO handle
     * @return  True: deleted successfully, False: the model doesn't exist in the database
     */
    public function delete($db) {
        $table = $this->getTableName();

        $stmt = $db->prepare("DELETE FROM $table WHERE id = :id");

        $stmt->bindParam(':id', $this->id);

        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            return True;
        } else {
            return False;
        }
    }

    /**
     * Delete all instances in the database.
     *
     * @param db    PDO handle
     * @return  the number of instances deleted
     */
    public static function delete_all() {
        $db = sr_pdo();

        $called_class = get_called_class();

        $table = $called_class::getTableName();

        $stmt = $db->prepare("TRUNCATE $table");

        $stmt->execute();

        return $stmt->rowCount();
    }

    /**
     * Reordering the auto increment values 'id'.
     *
     * @param db    PDO handle
     * @return Null 
     */
    public static function reorder_id() {
        $db = sr_pdo();

        $called_class = get_called_class();

        $table = $called_class::getTableName();

        $stmt = $db->query("ALTER TABLE $table AUTO_INCREMENT=1");
        $stmt = $db->query("SET @CNT=0");
        $stmt = $db->query("UPDATE $table SET $table.id=@CNT:=@CNT+1");

        return Null;
    }

    /**
     * Returns the number of records of the table associated with this model.
     *
     * @param db    PDO handle
     * @return  the number of records 
     */
    public static function getRecordNum() {
        $db = sr_pdo();

        $called_class = get_called_class();

        $table = $called_class::getTableName();

        $stmt = $db->prepare("SELECT COUNT(*) FROM $table");

        $stmt->execute();

        $number_of_records = $stmt->fetch();

        return $number_of_records['COUNT(*)'];
    }

    /**
     * Returns the database table name associated with this model. The default table name
     * is the lowercased class name.
     * 
     * @return  the table name that is associated with the model
     */
    public static function getTableName() {
        return strtolower(get_called_class());
    }

    /**
     * Get the current time.
     *
     * @return  current time string
     */
    public static function getCurrentTime() {
        return date('Y-m-d H:i:s');
    }

    /**
     * Generate unique id.
     *
     * @return  generated unique id (13 character + length($prefix))
     */
    public static function getUniqueId($prefix = "") {
        return uniqid($prefix);
    }

}

?>
