<?php $user = isset($user) ? $user : \App\Models\User::isLoggedIn() ?>

<header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="<?php echo url('guestbook') ?>">GuestBook Wall</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <?php if ($user) : ?>
                    <?php if ($user->can('validate_guestbook_entry')) : ?>
                        <li class="nav-item active">
                            <a class="nav-link" href="<?php echo url('guestbook/unpublished') ?>">Unpublished Entries<span class="sr-only">(current)</span></a>
                        </li>
                    <?php endif ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?php echo url('guestbook/create') ?>">Create new entry<span class="sr-only">(current)</span></a>
                    </li>
                <?php endif ?>
            </ul>
            <form class="form-inline mt-2 mt-md-0">
                <?php if($user): ?>
                    <a class="btn btn-outline-warning my-2 my-sm-0" href="<?php echo url('user/logout') ?>">Logout</a>
                <?php else: ?>
                    <a class="btn btn-outline-success my-2 my-sm-0" href="<?php echo url('user/login') ?>">Login</a>
                <?php endif ?>
            </form>
        </div>
    </nav>
</header>