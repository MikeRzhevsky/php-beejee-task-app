<?php
namespace App\Models;

use App\DBConnection;
use App\Controllers\TasksController;

class Tasks
{
    /**
     * @param $sort
     * @return array
     */
    public static function getTasks($sort)
    {
        if (isset($sort)) {
            $sql = "SELECT * FROM tasks ORDER BY ". $sort ." LIMIT " . TasksController::$tasksOnPage;
        }
        else {
            $sql = "SELECT * FROM tasks LIMIT " . TasksController::$tasksOnPage;
        }
        return self::getTasksArrayByQuery($sql);

    }

    /**
     * @param $pageNumber
     * @param null $sort
     * @return array
     */
    public static function getTasksOnPage($pageNumber, $sort=null)
    {
        $offset = ($pageNumber - 1) * TasksController::$tasksOnPage;
        if (isset($sort)) {
            $sql = "SELECT * FROM tasks 
					ORDER BY ". $sort .
                " LIMIT " . TasksController::$tasksOnPage .
                " OFFSET " . $offset;
        }
        else {
            $sql = "SELECT * FROM tasks LIMIT " . TasksController::$tasksOnPage . " OFFSET " . $offset;
        }
        return self::getTasksArrayByQuery($sql);
    }

    /**
     * @param $sql
     * @return array
     */
    private static function getTasksArrayByQuery($sql)
    {
        $db = DBConnection::getConnection();
        $tasksList = array();
        $tasks = $db->query($sql);
        $i = 0;
        while($row = $tasks->fetch()) {
            $tasksList[$i]['id'] = $row['id'];
            $tasksList[$i]['username'] = $row['username'];
            $tasksList[$i]['email'] = $row['email'];
            $tasksList[$i]['description'] = $row['description'];
            $tasksList[$i]['picture'] = $row['picture'];
            $tasksList[$i]['status'] = $row['status'];
            $i++;
        }
        return $tasksList;
    }

    /**
     * @return float
     */
    public static function getNumberOfPages()
    {
        $db = DBConnection::getConnection();
        $numberOfTasks = $db->query('SELECT COUNT(*) as number FROM tasks');
        $numberOfTasks = $numberOfTasks->fetch();
        $numberOfPages = ceil( $numberOfTasks['number'] / TasksController::$tasksOnPage );
        return $numberOfPages;
    }

    /**
     * @param $post
     * @param $files
     */
    public static function addTaskToDB($post, $files)
    {
        $db = DBConnection::getConnection();
        $user_name = $db->quote($post['user_name']);
        $user_email = $db->quote($post['user_email']);
        $text = $db->quote($post['text']);
        $sql = "INSERT INTO tasks (username, email, description) VALUES (". $user_name .", ". $user_email .", ". $text .")";
        if(isset($files) && !empty($files) && $files['task_img']['tmp_name']) {
            $uploadfile = '/Uploads/' . uniqid() . ($files['task_img']['name']);
            $max_width = 320;
            $max_height = 240;
            list($orig_width, $orig_height) = getimagesize($files['task_img']['tmp_name']);
            $width = $orig_width;
            $height = $orig_height;
            # taller
            if ($height > $max_height) {
                $width = ($max_height / $height) * $width;
                $height = $max_height;
            }
            # wider
            if ($width > $max_width) {
                $height = ($max_width / $width) * $height;
                $width = $max_width;
            }
            $thumb = imagecreatetruecolor($width, $height);
            preg_match("'^(.*)(gif|jpe?g|png)$'i", $files['task_img']['type'], $ext);
            switch (strtolower($ext[2])) {
                case 'jpg' :
                case 'jpeg': $source = imagecreatefromjpeg($files['task_img']['tmp_name']);
                    imagecopyresized($thumb, $source, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);
                    imagejpeg($thumb, $files['task_img']['tmp_name']);
                    break;
                case 'gif' : $source = imagecreatefromgif($files['task_img']['tmp_name']);
                    imagecopyresized($thumb, $source, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);
                    imagegif($thumb, $files['task_img']['tmp_name']);
                    break;
                case 'png' : $source = imagecreatefrompng($files['task_img']['tmp_name']);
                    imagecopyresized($thumb, $source, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);
                    imagepng($thumb, $files['task_img']['tmp_name']);
                    break;
                default    : $stop = true;
                    break;
            }
            if(!isset($stop)) {
                move_uploaded_file($files['task_img']['tmp_name'], dirname(dirname(dirname(__FILE__))) . $uploadfile);
                $sql = "INSERT INTO tasks (username, email, description, picture) VALUES (". $user_name .", ". $user_email .", ". $text .", '". $uploadfile ."')";
            }
        }
        $sth = $db->prepare($sql);
        $sth->execute();
    }
    public static function saveTaskChanges($id,$desc,$status)
    {
        $status=isset($status)? 1:0;
        if(!empty($id)) {
            $db = DBConnection::getConnection();
            $sql = "UPDATE tasks SET status=".$status.", description='".$desc."' WHERE id=" . $id;
            $sth = $db->prepare($sql);
            $sth->execute();
        }
    }
}