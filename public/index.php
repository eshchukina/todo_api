<?php

function autoload_src($class_name) {
    require  '../src/' . implode('/', explode('\\', $class_name)) . '.php';
}
spl_autoload_register('autoload_src');

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

    $taskFilter = new Filter\CompositeFilter();
    $taskFilter->add(new Filter\TrimFilter());
    $taskFilter->add(new Filter\UpperFilter());

    $taskValidator = new Validator\CompositeValidator();
    $taskValidator->add(new Validator\TitleLenght());
    $taskValidator->add(new Validator\DescriptionLenght());

    $taskNotificator = new Notificator\CompositeEvents();
    $taskNotificator->add(new Notificator\Notifier($storageEvent));
    
    $app = new App\App($storageTask, $storageComment, $taskFilter, $taskValidator, $taskNotificator, $storageUser);

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
