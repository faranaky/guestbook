# Guestbook

This project is written by pure php and the challenge is that no framework and library is allowed.

## Installation

* Use php 7.1 (tested)

* Please be aware of ``.htaccess`` file, it has two rules inside and rewrite engine is on

* Upload file directory which is ```public/uploads/guestbook_entries``` should have 775 permission.

* Please change database config on: ``App/configs/database.php`` and create a database with same name you've specified

* Please write your country timezone in app config file which will be found in: ```App/configs/app.php```

* Run the homepage of code and database structure with data will be installed.

For example if your virtual host is ```http://guestbook.local``` just run it on browser to do the installation.

Two users will be added with below username and passwords:  
``username: admin, password: 123456   --> admin user``  
``username: guest, password: 123456   --> guest user``


## Style and Patterns

In this application I used MVC design pattern as the main pattern of Guestbook.  
  
In this way we have all routes in ``App/routes/web.php``, controllers in ``App/Controllers`` directory, models in ``App/Models`` and views in ``App/views``.  
<br/><img src="/readme/screenshots/mvc_pattern.png" width="250px">

#### Namespace
Used namespace in all of the classes except global classes (this feature is available from php 5.3)


#### Class Autoloading
In the first file ```index.php``` we have a function which is called __autoload.  
Please be aware of this function and read this link that explains [this feature has been DEPRECATED as of PHP 7.2.0](http://php.net/manual/en/function.autoload.php)  
Whenever we try to use a class (object creation) this function includes that class according to it's namespace.

#### Repository Pattern
* Another layer is added to this pattern for interacting with database which is called <b>Repository</b>  
Repositories are located inside Models directory (App/Models/Repositories/Repository)  
Models are not responsible for queries and sql commands anymore.  
Repository class extends parent class ``App\Models\Repositories\Repository`` which is an abstract class and has common functions and attributes.

#### MVC Pattern
* Models are a link between repository (database) and controller.  
They extends ``App\Models\Model`` which has common attributes and functions like save, delete and find.

* Controllers are a link between model and view, they also deal with requests and parameters.  
Each method inside each controller should be responsible for a route  
We can specify routes by defining the name of controller class and it's method.

* Views will show pages content to the end user.  
It has layout structure and different sections of page has been separated.  
For example header, content, messages and etc in order we can create view quick and without redundant code.  
<img src="/readme/screenshots/views_layout.png" width="250px">

* Routes which are located in ``App/routes/web.php`` includes in the beginning of ``index.php`` are responsible for defining routes.  
It accepts POST and GET http methods  
For example for having a route with get method, it would be like: 
```Route::get('user/login', [ 'controller' => 'UserController', 'action' =>'login', 'namespace' => $controllerNameSpace, 'middleware' => \App\Middlewares\Guest::class ]);```  
First parameter is url and the second is an array which specify controller class, method (action), namespace and also <b>Middleware</b>.  

#### Middleware
Middlewares are located in ```App/Middlewares``` and responsible to filtering requests.  
For example there is a Member middleware (guard) that checks if user is loggedin or not.  
If user has logged in pass the request else will redirect to login page and don't let user to go further.

#### Traits
Traits can be found in ```App/Libraries/Traits```.  
They add extra behaviours to other classes (this feature is available from php5.4)  
For instance there are two traits which are called ```Authenticable``` and ```HasPermission```.   
These traits are used in User model and enables user to have authentication and permission.

#### App Config
Configuration files are in ```App/configs```.  
It includes ``database.php`` for database configuration, and ``app.php`` for general configuration like setting Timezone.


#### Other directories
* ``public`` keeps assets and uploaded files. It doesn't obey general routes rule (has it's own rule in .htaccess)
* ``App/Libraries`` includes the main MVC pattern and also primary classes.
* ``App/Helpers`` contains classes with static functions that may be used anytime, anywhere.
* ``diagrams`` has two images inside which are UML class diagram and database diagram related to this project

  
###### Help
If you need help please contact `yazdanfar.faranak@gmail.com`.