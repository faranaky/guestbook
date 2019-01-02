<?php

$url = url('guestbook/update');
$imageSrc = \App\Helpers\Image::getImageUrl($guestbook->image_url);
$image = !empty($guestbook->image_url) ? '<img class="img-thumbnail" src="' . $imageSrc .'">' : '';
$content = <<<HTML
    <div class="col-md-6">
        <div class="card gedf-card">
            <div class="card-header">
                <h5>Create new Guestbook entry</h5>
            </div>
            <div class="card-body">
                <form action="$url" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="" for="text">Text</label>
                        <textarea name="text" class="form-control" id="text" rows="5" placeholder="Write your text here">$guestbook->text</textarea>
                    </div>
                    <div class="form-group">
                      $image
                      <label for="image">Image</label>
                      <input type="file" class="form-control" name="image" id="image">
                    </div>
                    <input type="hidden" name="id" value="$guestbook->id">
                  <button class="btn btn-primary" type="submit">Submit form</button>
                </form>
            </div>
        </div>
    </div>
HTML;

include MASTER_LAYOUT;
