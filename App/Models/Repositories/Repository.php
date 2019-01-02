<?php
namespace App\Models\Repositories;

use App\Libraries\Database;

abstract class Repository
{
    public static $table = '';

    public static $fillables = [];

    protected static $modelClass = stdClass::class;

    /**
     * @param $id
     * @return null
     */
    public static function find($id)
    {
        $query = "SELECT * FROM `" . static::$table . "` WHERE id = :id";

        $params = ['id' => $id];

        $result = Database::query($query, $params, static::$modelClass);

        return self::first($result);
    }

    /**
     * @param $result
     * @return null
     */
    public static function first($result)
    {
        return count($result) ? $result[0] : null;
    }

    /**
     * @param $modelObject
     * @return mixed
     */
    public static function save($modelObject)
    {
        $query = '';
        $params = [];

        if($modelObject->id) {

            $query = "UPDATE `" . static::$table . "` SET ";

            foreach (static::$fillables as $field) {
                $query .= $field . "=";
                if ($field == 'updated_at') {
                    $query .= "NOW(),";
                }

                else {
                    $params[$field] = $modelObject->$field;
                    $query .= ":$field,";
                    $params[$field] = $modelObject->$field;
                }
            }
            $query = rtrim($query, ',');
            $query .= " WHERE id=:id";
            $params['id'] = $modelObject->id;
        }
        else
        {
            $query = "INSERT INTO `" . static::$table . "`";

            $queryFields = " (";
            $queryValues = " VALUES (";
            foreach (static::$fillables as $field) {
                if ($field == 'created_at' || $field == 'updated_at') {
                    $queryValues .= "NOW(),";
                }
                else {
                    $params[$field] = $modelObject->$field;
                    $queryValues .= ":$field,";
                }
                $queryFields .= "$field,";

            }
            $queryFields = rtrim($queryFields, ',') . ")";
            $queryValues = rtrim($queryValues, ',') . ")";
            $query .= $queryFields . $queryValues;

        }

        $result = Database::query($query, $params);
        return $result;
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function delete($id)
    {
        $query = "DELETE FROM `" . static::$table . "` WHERE id=:id";
        $params = ['id' => $id];

        $result = Database::query($query, $params);

        return $result;
    }

}