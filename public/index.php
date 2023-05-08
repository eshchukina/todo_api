<?php

use Eshchukina\TodoApi\Storage;
    

require('../vendor/autoload.php');

$host = 'mysql_server';
$dbname = 'todolist';
$username = 'root';
$password = 'password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $storageTask = new Storage\SqlTask($pdo);
    $storageComment = new Storage\SqlComment($pdo);
    $storageEvent = new Storage\SqlEventLog($pdo);
    $storageUser = new Storage\SqlUser($pdo);

    $taskFilter = new Eshchukina\TodoApi\Filter\InputFilter();
    $taskFilter->add('title', [new Eshchukina\TodoApi\Filter\TrimFilter()]);
    $taskFilter->add('title', [new Eshchukina\TodoApi\Filter\UpperFilter()]);
    $taskFilter->add('description', [new Eshchukina\TodoApi\Filter\TrimFilter()]);

    $commentFilter = new Eshchukina\TodoApi\Filter\InputFilter();
    $commentFilter->add('message', [new Eshchukina\TodoApi\Filter\TrimFilter()]);
  
    $userFilter = new Eshchukina\TodoApi\Filter\InputFilter();
    $userFilter->add('name', [new Eshchukina\TodoApi\Filter\TrimFilter()]);
    $userFilter->add('name', [new Eshchukina\TodoApi\Filter\UpperFilter()]);
    $userFilter->add('surname', [new Eshchukina\TodoApi\Filter\TrimFilter()]);
    $userFilter->add('surname', [new Eshchukina\TodoApi\Filter\UpperFilter()]);

    // $taskFilter = new Filter\CompositeFilter();
    // $taskFilter->add(new Filter\TrimFilter());
    // $taskFilter->add(new Filter\UpperFilter());

    // $taskValidator = new Validator\CompositeValidator();
    // $taskValidator->add(new Validator\TitleLenght());
    // $taskValidator->add(new Validator\DescriptionLenght());

    $taskValidator = new Eshchukina\TodoApi\Validator\inputValidator();
    $taskValidator->add('title', [new Eshchukina\TodoApi\Validator\LenghtValidator(5, 30)]);
    $taskValidator->add('description', [new Eshchukina\TodoApi\Validator\LenghtValidator(10, 60)]);
 

    $taskNotificator = new Eshchukina\TodoApi\Notificator\CompositeEvents();
    $taskNotificator->add(new Eshchukina\TodoApi\Notificator\Notifier($storageEvent));
    
    $app = new Eshchukina\TodoApi\App\App($storageTask, $storageComment, $taskFilter, $commentFilter, $userFilter, $taskValidator, $taskNotificator, $storageUser);

    $routes = new Eshchukina\TodoApi\Presentation\Routes($app);

    $router = new Eshchukina\TodoApi\Http\Router();
    $router->register('GET', '/', [$routes, 'appInfo']);
    $router->register('POST', '/tasks', [$routes, 'createTask']);
    $router->register('GET', '/tasks', [$routes, 'getTaskList']);
    $router->register('GET', '/^\/tasks\/([0-9]+)$/', [$routes, 'getTask']);
    $router->register('PUT', '/^\/tasks\/([0-9]+)$/', [$routes, 'updateTask']);
    $router->register('DELETE', '/^\/tasks\/([0-9]+)$/', [$routes, 'deleteTask']);

    $router->register('POST', '/^\/tasks\/([0-9]+)\/comments$/', [$routes, 'createComment']);
    $router->register('GET', '/^\/tasks\/([0-9]+)\/comments$/', [$routes, 'getComment']);

    $router->register('POST', '/users', [$routes, 'createUser']);
    $router->register('GET', '/users', [$routes, 'getUserList']);
    $router->register('GET', '/^\/users\/([0-9]+)$/', [$routes, 'getUser']);
    $router->register('DELETE', '/^\/users\/([0-9]+)$/', [$routes, 'deleteUser']);

    


    $router->exec();

} catch (PDOException $e) {
    echo "DB connection error: " . $e->getMessage();
    exit;
}
