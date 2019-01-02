<?php
$actionUrl = url('user/authenticate');
$content = <<<EOD

<h2 class="form-heading">Login</h2>
<div class="login-form">
    <div class="main-div">

       <div class="col-md-6">
               <div class="panel">
               <p>Please enter your username and password</p>
               </div>
            <form id="Login" action="$actionUrl" method="POST">  
                <div class="form-group">
                    <input type="text" class="form-control" id="inputEmail" placeholder="Username" name="username" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="inputPassword" placeholder="Password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
        </div>
    </div>
</div>

EOD;
?>

<?php include_once MASTER_LAYOUT ?>
