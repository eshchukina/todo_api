<?php

    

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

    $taskFilter = new Filter\InputFilter();
    $taskFilter->add('title', [new Filter\TrimFilter()]);
    $taskFilter->add('title', [new Filter\UpperFilter()]);
    $taskFilter->add('description', [new Filter\TrimFilter()]);

    $commentFilter = new Filter\InputFilter();
    $commentFilter->add('message', [new Filter\TrimFilter()]);
  
    $userFilter = new Filter\InputFilter();
    $userFilter->add('name', [new Filter\TrimFilter()]);
    $userFilter->add('name', [new Filter\UpperFilter()]);
    $userFilter->add('surname', [new Filter\TrimFilter()]);
    $userFilter->add('surname', [new Filter\UpperFilter()]);

    // $taskFilter = new Filter\CompositeFilter();
    // $taskFilter->add(new Filter\TrimFilter());
    // $taskFilter->add(new Filter\UpperFilter());

    // $taskValidator = new Validator\CompositeValidator();
    // $taskValidator->add(new Validator\TitleLenght());
    // $taskValidator->add(new Validator\DescriptionLenght());

    $taskValidator = new Validator\inputValidator();
    $taskValidator->add('title', [new Validator\LenghtValidator(5, 30)]);
    $taskValidator->add('description', [new Validator\LenghtValidator(10, 60)]);
 

    $taskNotificator = new Notificator\CompositeEvents();
    $taskNotificator->add(new Notificator\Notifier($storageEvent));
    
    $app = new App\App($storageTask, $storageComment, $taskFilter, $commentFilter, $userFilter, $taskValidator, $taskNotificator, $storageUser);

    $routes = new Presentation\Routes($app);

    $router = new Http\Router();
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
