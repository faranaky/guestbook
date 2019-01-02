<?php
namespace App\Models\Repositories;

use App\Libraries\Database;

class GuestbookEntry extends Repository
{
    public static $table = 'guestbook_entries';

    public static $fillables = ['user_id', 'text', 'image_url', 'is_validated', 'created_at', 'updated_at'];

    public static $modelClass = \App\Models\GuestbookEntry::class;

    /**
     * @param $pageSize
     * @param int $page
     * @param array $conditions
     * @return array
     */
    public static function paginate($pageSize, $page = 1, $conditions = [])
    {
        $whereClause = '';
        if(count($conditions)) {
            $whereClause = " WHERE ";
            foreach ($conditions as $key => $value) {
                $whereClause .= "$key=:$key AND";
            }
        }
        $whereClause = rtrim($whereClause, 'AND');

        $page = !empty($page) ? $page : 1;
        $query = "SELECT COUNT(" . static::$table . ".id) as count FROM " . static::$table .
            " INNER JOIN `users` ON user_id=`users`.id" . $whereClause;

        $result = Database::query($query, $conditions);
        $result = static::first($result);

        $count = (int) isset($result->count) ? $result->count : 0;

        $pages = (int) ceil($count / $pageSize);
        $offset = $pageSize * ($page - 1);

        $query = "SELECT " . static::$table . ".*, users.username FROM " . static::$table .
            " INNER JOIN `users` ON user_id=`users`.id" . $whereClause .
            " ORDER BY " . static::$table . ".created_at DESC" .
            " LIMIT " . $pageSize . " OFFSET " . $offset;

        $result = Database::query($query, $conditions, \App\Models\GuestbookEntry::class);

        $pagination = [
            'total_count' => $count,
            'current_page' => $page,
            'page_size' => $pageSize,
            'total_pages' => $pages,
            'data' => $result
        ];

        return $pagination;
    }

}