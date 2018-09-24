<?php
require_once __DIR__ . '/vendor/autoload.php';

use \Illuminate\Database\Capsule\Manager as Capsule;
use \MyFW\App\Users;
use \MyFW\App\Roles;

header('Content-Type: application/json');

// démarage de l'ORM Eloquent
$capsule = new Capsule;
$capsule->addConnection(array(
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => 'rest',
    'username' => 'rest',
    'password' => 'tser',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => ''
));
$capsule->bootEloquent();

/*$u = Users::find(1);
echo $u->firstname;
echo '<br>';
echo $u->lastname;
echo '<hr>';

$u->firstname = strtolower($u->firstname);
$u->lastname = strtoupper($u->lastname);

echo $u->firstname;
echo '<br>';
echo $u->lastname;

$u->save();*/

echo '<hr>';

$users = Users::orderBy('firstname')->get();

foreach ($users as $user) {
    $user->firstname = ucfirst($user->firstname);
    $users->lastname = ucfirst($user->lastname);
    echo $user->firstname;
    echo '<br>';
    echo $user->lastname;
    $user->save();
    echo '<br>';
    echo $user->role->name;
    echo '<br>';
}

echo '<hr>';
echo '<pre>';
$roles = Roles::where('name', 'member')->get();
foreach ($roles as $role) {
    echo $role->users->toJSON();
}
echo '</pre>';

$users = Users::all();
$users = $users->reject(function ($user) {
    return $user->role->name == 'member';
});

foreach ($users as $user) {

    echo $user->firstname;
    echo '<br>';
    echo $user->lastname;
    echo '<br>';
    echo $user->role->name;
    echo '<br>';
}


