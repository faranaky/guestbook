<?php
namespace App\Controllers;


use App\Helpers\Image;
use App\Libraries\Request;
use App\Libraries\View;
use App\Models\GuestbookEntry;
use App\Models\User;

class GuestbookController
{
    /**
     * shows list of guestbook entries
     */
    public function index()
    {
        $user = User::isLoggedIn();

        $conditions = ['is_validated' => 1];
        $entries = GuestbookEntry::paginate(10, $conditions);

        return View::make('guestbook_entries.index', ['entries' => $entries, 'user' => $user]);
    }

    public function unpublished()
    {
        $user = User::isLoggedIn();
        if ($user && $user->can('validate_guestbook_entry')) {

            $conditions = ['is_validated' => 0];
            $entries = GuestbookEntry::paginate(10, $conditions);

            return View::make('guestbook_entries.index', ['entries' => $entries, 'user' => $user]);
        }

        redirectHome();
    }

    /**
     * returns view of guestbook entry creation form
     */
    public function create()
    {
        return View::make('guestbook_entries.create');
    }

    /**
     * creates new guestbook entry
     */
    public function save()
    {
        $text = Request::post('text');
        $image = Request::file('image');

        $result = null;

        $user = User::isLoggedIn();
        if (empty($user)) {
            redirectHome();
        }

        if (!file_exists($image['tmp_name']) && empty($text)) {
            setSession('warning', 'Please fill at least one of the fields');
            redirectBack();
        }

        if (file_exists($image['tmp_name'])) {
            $result = Image::upload($image);
        }

        if (is_array($result)) {
            setSession('errors', $result);
            redirectBack();
        }

        $guestbook = new GuestbookEntry();
        $guestbook->setText($text);
        $guestbook->setImageUrl($result);

        $message = '';
        if ($user->can('validate_guestbook_entry')) {
            $guestbook->setIsValidated(true);
        }

        else {
            $guestbook->setIsValidated(false);
            $message = ' and after validation will be published';
        }
        $guestbook->setUserId($user->getId());
        $guestbook->save();

        setSession('success', 'Your entry has been added successfully' . $message);
        redirect('guestbook');
    }

    /**
     * admin deletes guestbook entry
     */
    public function delete()
    {
        $user = User::isLoggedIn();
        if ($user && $user->can('delete_guestbook_entry')) {
            $id = Request::get('id');
            GuestbookEntry::delete($id);
            setSession('success', 'Selected guestbook entry has been deleted successfully');
        }
        else {
            setSession('error', 'You are not allowed to do this action');
        }
        redirectBack();
    }

    public function validate()
    {
        $user = User::isLoggedIn();
        if ($user && $user->can('validate_guestbook_entry')) {
            $id = Request::get('id');
            GuestbookEntry::validate($id);
            setSession('success', 'Selected guestbook entry has been validated successfully, it is visible on wall now');
        }
        else {
            setSession('error', 'You are not allowed to do this action');
        }
        redirectBack();
    }

    public function edit()
    {
        $user = User::isLoggedIn();
        if ($user && $user->can('edit_guestbook_entry')) {
            $id = Request::get('id');
            $guestbook = GuestbookEntry::find($id);
            return View::make('guestbook_entries.edit', ['guestbook' => $guestbook]);
        }
        redirectBack();
    }

    public function update()
    {
        $user = User::isLoggedIn();

        if ($user && $user->can('edit_guestbook_entry')) {

            $id    = Request::post('id');
            $text  = Request::post('text');
            $image = Request::file('image');

            $result = null;

            $guestbook = GuestbookEntry::find($id);

            if (file_exists($image['tmp_name'])) {

                if ( !empty($guestbook->image_url)) {
                    Image::remove($guestbook->image_url);
                }
                $result = Image::upload($image);
                $guestbook->setImageUrl($result);
            }

            if (is_array($result)) {
                setSession('errors', $result);
                redirectBack();
            }

            $guestbook->setText($text);
            $guestbook->save();

            setSession('success', 'Guestbook entry has been updated successfully');

            redirectBack();
        }
    }
}