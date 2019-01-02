<?php
namespace App\Models;

use App\Helpers\Image;
use App\Libraries\Request;
use App\Models\Repositories\GuestbookEntry as Repository;

class GuestbookEntry extends Model
{
    public $text;
    public $image_url;
    public $user_id;
    public $is_validated;
    public $updated_at;
    public $created_at;

    protected static $repository = Repository::class;

    /**
     * @param $text
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @param $imageUrl
     * @return $this
     */
    public function setImageUrl($imageUrl)
    {
        $this->image_url = $imageUrl;
        return $this;
    }

    /**
     * @param $userId
     * @return $this
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;
        return $this;
    }

    /**
     * @param $isValidated
     * @return $this
     */
    public function setIsValidated($isValidated)
    {
        $this->is_validated = $isValidated ? 1 : 0;
        return $this;
    }

    /**
     * @param $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return mixed
     */
    public function getImageUrl()
    {
        return $this->getImageUrl();
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @return mixed
     */
    public function getIsValidated()
    {
        return $this->is_validated;
    }

    /**
     * @param $pageSize
     * @param array $conditions
     * @return array
     */
    public static function paginate($pageSize, $conditions = [])
    {
        $page = Request::get('page');
        return Repository::paginate($pageSize, $page, $conditions);
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function delete($id)
    {
        $entry = self::find($id);
        if(!empty($entry->image_url))
            Image::remove($entry->image_url);

        return parent::delete($id);
    }

    /**
     * @param $id
     * @return bool
     */
    public static function validate($id)
    {
        $entry = static::find($id);
        if($entry){
            $entry->setIsValidated(true);
            $entry->save();
            return true;
        }

        return false;
    }
}