<?php

use App\Helpers\Image;

$posts = '';

foreach ( $entries['data'] as $entry ){
    $time        = "<time date='$entry->created_at'>". getTimeAgo($entry->created_at) . "</time>";
    $text        = $entry->text;
    $image       = !empty($entry->image_url) ? '<img class="img-thumbnail" src="'. Image::getImageUrl($entry->image_url) . '">' : '';
    $username    = $entry->username;
    $isValidated = $entry->is_validated;
    $canEdit     = $user ? $user->can('edit_guestbook_entry') : false;
    $canDelete   = $user ? $user->can('delete_guestbook_entry') : false;
    $canValidate = $user ? $user->can('validate_guestbook_entry') : false;

    $canEdit     = $canEdit ?'<a class="dropdown-item" href="'. url('guestbook/edit?id=' . $entry->id ) . '">Edit</a>' : '';
    $canDelete   = $canDelete ? '<a class="dropdown-item" href="'. url('guestbook/delete?id=' . $entry->id ) . '">Delete</a>' : '';
    $canValidate = ($canValidate && !$isValidated) ? '<a class="dropdown-item" href="'. url('guestbook/validate?id=' . $entry->id ) . '">Validate</a>' : '';
    $headerColor = $isValidated ? '' : 'style ="background-color: antiquewhite;"';

    $actions     = '';
    if($canEdit || $canDelete || $canValidate){
        $actions = "<div class='dropdown'>
                        <button class='btn btn-link dropdown-toggle' type='button' id='gedf-drop1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                            <i class='fa fa-ellipsis-h'></i>
                        </button>
                        <div class='dropdown-menu dropdown-menu-right' aria-labelledby='gedf-drop1' 
                            x-placement='bottom-end' 
                            style='position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(38px, 38px, 0px);'>        
                            $canValidate
                            $canEdit
                            $canDelete
                        </div>
                    </div>";
    }

    $posts .= <<<HTML
            <div class="card gedf-card">
                <div class="card-header" $headerColor>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="ml-2">
                                <div class="h5 m-0">$username</div>
                            </div>
                        </div>
                        <div>       
                           $actions
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="text-muted h7 mb-2"> <i class="fa fa-clock-o"></i>$time</div>
                    <a class="card-link" href="#">
                        <h5 class="card-title"></h5>
                    </a>
                    <p class="card-text">
                        <p>$text</p>
                       $image
                    </p>
                </div>
            </div>
        </div>
HTML;

}

$pagination = '';

if( $entries['total_pages'] > 1 ) {

    $pagination .= '<ul class="pagination">';

    for ($i = 1;  $i <= $entries['total_pages']; $i++) {
        $isActive = ($i == $entries['current_page']) ? 'active' : '';
        $pagination .= "<li class='page-item $isActive'><a  class='page-link' href='" . url('guestbook?page=' . $i) . "'>$i</a></li>";
    }

    $pagination .= '</ul>';
}

$posts = !empty($posts) ? $posts : '<h5>No entry ...</h5>';
$content = $posts . $pagination;

include_once MASTER_LAYOUT;

