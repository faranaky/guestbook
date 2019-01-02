<?php
$errors  = getSession('errors')  ?? (isset($errors) ? $errors : null);
$warning = getSession('warning') ?? (isset($warning) ? $warning : null);
$success = getSession('success') ?? (isset($success) ? $success : null);
$info    = getSession('info')    ?? (isset($info) ? $info : null);

unsetSession('errors');
unsetSession('warning');
unsetSession('success');
unsetSession('info');

$messages = '';

if(!empty($errors) && count($errors)){
    $messages .= '<div class="alert alert-danger"><ul>';
    foreach ($errors as $error) {
        $messages .= '<li>' . $error . '</li>';
    }
    $messages .= '</ul></div>';
}

if(!empty($warning)){
    $messages .= '<div class="alert alert-warning">' . $warning .'</div>';
}

if(!empty($success)){
    $messages .= '<div class="alert alert-success">' . $success .'</div>';
}

if(!empty($info)){
    $messages .= '<div class="alert alert-info">' . $info .'</div>';
}

echo $messages;