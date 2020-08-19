<?php


class Db_object
{
    // Instance of object
    public static function instance($result) {
        $calling_class = get_called_class(); // late static binding
        $the_object = new $calling_class;

        foreach ($result as $attribute => $value) {
            if ($the_object->has_the_attribute($attribute)) {
                $the_object->$attribute = $value;
            }
        }

        return $the_object;
    }

    // Attribute
    protected function has_the_attribute($attribute) {
        $object_properties = get_object_vars($this);

        return array_key_exists($attribute, $object_properties);
    }

    // Query
    public static function find_this_query($sql) {
        global $database;

        $result = $database->query($sql);
        $the_object_array = array();

        while ($row = mysqli_fetch_array($result)) {
            $the_object_array[] = static::instance($row);
        }

        return $the_object_array;
    }

    // Find all in table
    public static function find_all() {
        return static::find_this_query("SELECT * FROM " . static::$db_table . ";");
    }

    // Find by id in table
    public static function find_by_id($id) {
        $result = static::find_this_query("SELECT * FROM " . static::$db_table . " WHERE id = id LIMIT 1");

        /*if (!empty($result)) {
            return array_shift($result);
        } else {
            return false;
        }*/
        return !empty($result) ? array_shift($result) : false;
    }

    // Create new row
    public function create() {
        global $database;
        $properties = $this->clean_properties();

        $sql = "INSERT INTO " . static::$db_table . " (" . implode(",", array_keys($properties)) . ")
                VALUES ('" . implode("','", array_values($properties)) . "'
                        );";

        if ($database->query($sql)) {
            $this->id = $database->insert_id();
            return true;
        } else {
            return false;
        }

        $database->query($sql);
    }

    // Update row by id
    public function update() {
        global $database;
        $properties = $this->clean_properties();
        $properties_assoc = array();

        foreach ($properties as $key => $value) {
            $properties_assoc[] = "{$key}='{$value}'";
        }

        $sql = "UPDATE " . static::$db_table . " SET " . implode(',', $properties_assoc) . " WHERE id = " . $database->escape_string($this->id);

        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }

    // Delete row by id
    public function delete() {
        global $database;

        $sql = "DELETE FROM " . static::$db_table . " 
                WHERE id = " . $database->escape_string($this->id) . " 
                LIMIT 1;";

        $database->query($sql);
        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }

    // Save input: either new row or update by id
    public function save() {
        return isset($this->id) ? $this->update() : $this->create();
    }

    // Properties
    protected function properties() {
        // return get_object_vars($this);
        $properties = array();
        foreach(static::$db_table_fields as $db_field) {
            if (property_exists($this, $db_field)) {
                $properties[$db_field] = $this->$db_field;
            }
        }

        return $properties;
    }

    // Cleaning up properties
    protected function clean_properties() {
        global $database;
        $clean_properties = array();

        foreach ($this->properties() as $key => $value) {
            $clean_properties[$key] = $database->escape_string($value);
        }

        return $clean_properties;
    }

    public static function count_all(){
        global $database;
        $sql = "SELECT COUNT(*) FROM " . static::$db_table;
        $result_set = $database->query($sql);
        $row = mysqli_fetch_array($result_set);

        return array_shift($row);
    }
}