<?php

namespace App\Helpers;

use App\Libraries\Database;

class DBInstaller
{
    /**
     * @return bool
     */
    public static function isInstalled()
    {
        try {
            $sql = "SHOW COLUMNS FROM `users`";
            $result = Database::execute($sql);
            return true;
        }
        catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @return bool
     */
    public static function install()
    {
        $isInstalled = static::isInstalled();

        if($isInstalled)
            return false;

        $sql = "
            CREATE TABLE `roles` (
              `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
              `name` varchar(100) NOT NULL,
              `created_at` timestamp NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
            
            INSERT INTO `roles` (`id`, `name`, `created_at`) VALUES
            (1, 'admin', '2018-12-26 17:00:00'),
            (2, 'member', '2018-12-26 17:00:00'); 
              
            CREATE TABLE `users` (
              `id` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
              `username` varchar(255) NOT NULL,
              `password` varchar(255) NOT NULL,
              `firstname` varchar(255) NOT NULL,
              `lastname` varchar(255) NOT NULL,
              `token` varchar(255) DEFAULT NULL,
              `role_id` int(11) NOT NULL,
              `created_at` timestamp NOT NULL,
                UNIQUE(username),
                FOREIGN KEY fk_roles(role_id)
               REFERENCES roles(id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
            
                  
            CREATE TABLE `permissions` (
              `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
              `name` varchar(255) NOT NULL,
              `created_at` timestamp NOT NULL,
                UNIQUE(name)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            INSERT INTO `permissions` (`id`, `name`, `created_at`) VALUES
            (1, 'delete_guestbook_entry', '2018-12-26 20:30:00'),
            (2, 'validate_guestbook_entry', '2018-12-26 20:30:00'),
            (3, 'edit_guestbook_entry', '2018-12-26 20:30:00');
            
            
            CREATE TABLE `role_permission` (
              `role_id` int(11) NOT NULL,
              `permission_id` int(11) NOT NULL,
               PRIMARY KEY (role_id, permission_id), 
               FOREIGN KEY fk_roles(role_id)
               REFERENCES roles(id),
               FOREIGN KEY fk_permissions(permission_id)
               REFERENCES permissions(id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
            
            INSERT INTO `role_permission` (`role_id`, `permission_id`) VALUES
            (1, 1),
            (1, 2),
            (1, 3);
            
          
            CREATE TABLE `guestbook_entries` (
              `id` int(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
              `user_id` int(11) UNSIGNED NOT NULL,
              `text` text,
              `image_url` varchar(255) DEFAULT NULL,
              `is_validated` tinyint(1) NOT NULL DEFAULT '0',
              `created_at` timestamp NOT NULL,
              `updated_at` timestamp NOT NULL,
               FOREIGN KEY fk_users(user_id)
               REFERENCES users(id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        
        ";

        $result = Database::execute($sql);

        return $result;
    }
}