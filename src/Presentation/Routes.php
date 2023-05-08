<?php
namespace Presentation;
use App;
use Http;

class Routes {

    private $app;

    public function __construct(App\App $app) {

        $this->app = $app;

    }

    public function appInfo(Http\Request $request, Http\Response $response) {

        $response->setStatus(200);
        $response->setBody($this->app->info());
    }

    public function getTaskList(Http\Request $request, Http\Response $response) {

        try {
            $tasks = $this->app->getTasks();
            $this->respoond($response, $tasks, 200);
        } catch (\Exception $e) {
            $this->respondError($response, $e->getMessage(), [], 500);
        }
    }

    public function getUserList(Http\Request $request, Http\Response $response) {
        try {
            $users = $this->app->getUsers();
            $this->respoond($response, $users, 200);
        } catch (\Exception $e) {
            $this->respondError($response, $e->getMessage(), [], 500);
        }
    }
    

   

    public function getTask(Http\Request $request, Http\Response $response) {

         $url = $request->getUrl();
         $id = preg_replace('/[^0-9]/', '', $url);
    
        try {
            $task = $this->app->getTask($id);
            if (!$task) {
              $this->respondError($response, 'not found', [], 404);
                return;
            }
            $this->respoond($response, $task, 200);
        } catch (\Throwable $e) {
            $this->respondError($response, $e->getMessage()."\n".$e->getFile()." ".$e->getLine()."\n".$e->getTraceAsString(), [], 500);
        }
    }
    

    public function getUser(Http\Request $request, Http\Response $response) {

         $url = $request->getUrl();
         $id = preg_replace('/[^0-9]/', '', $url);

        try {
            $user = $this->app->getUser($id);
            if (!$user) {
              $this->respondError($response, 'not found', [], 404);
                return;
            }
            $this->respoond($response, $user, 200);
        } catch (\Throwable $e) {
            $this->respondError($response, $e->getMessage()."\n".$e->getFile()." ".$e->getLine()."\n".$e->getTraceAsString(), [], 500);
        }
    }

    public function createTask(Http\Request $request, Http\Response $response) {
        $task = $this->getTaskFromRequest($request);
      
        try {
            $this->app->addTask($task);
             
            $response->setHeaders([
                'Location' => '/tasks/' . $task->getId(),
            ]);
            $this->respoond($response, $task, 201);
        } catch (\UnexpectedValueException $e) {
            $this->respondError($response, $e->getMessage(), [], 400);
        } catch (\Exception $e) {
            $this->respondError($response, $e->getMessage(), [], 500);
        }
    }

    public function createUser(Http\Request $request, Http\Response $response) {

        $user = $this->getUserFromRequest($request);
      
        try {
            $this->app->addUser($user);
            $response->setHeaders([
                'Location' => '/users/' . $user->getId(),
            ]);
            $this->respoond($response, $user, 201);
        } catch (\UnexpectedValueException $e) {
            $this->respondError($response, $e->getMessage(), [], 400);
        } catch (\Exception $e) {
            $this->respondError($response, $e->getMessage(), [], 500);
        }
    }

    private function getUserFromRequest(Http\Request $request): App\User {
        
        $data = $request->getBody();
        $user = new App\User();
        $user->setName($data['name'] ?? false);
        $user->setSurname($data['surname'] ?? false);
        $user->setPosition($data['position'] ?? false); //????
        
        return $user;
    }

    public function createComment(Http\Request $request, Http\Response $response)
    {
        
        $comment = $this->getCommentFromRequest($request);
    
        try {
            $this->app->addComment($comment);
    
            $response->setHeaders([
                'Location' => '/comments/' . $comment->getId(),
            ]);
            $this->respoond($response, $comment, 201);
        } catch (\UnexpectedValueException $e) {
            $this->respondError($response, $e->getMessage(), [], 400);
        } catch (\Exception $e) {
            $this->respondError($response, $e->getMessage(), [], 500);
        }
    }
    
    private function getCommentFromRequest(Http\Request $request): App\Comment
    {
        $data = $request->getBody();
        $comment = new App\Comment();
        $comment->setTaskId($data['task_id'] ?? false);
        $comment->setAuthor($data['author'] ?? false);
        $comment->setMessage($data['message'] ?? false);
        $comment->setDate($data['date'] ?? false); //????
        
        return $comment;
    }
   
    public function getComment(Http\Request $request, Http\Response $response)
    {
        $url = $request->getUrl();
        preg_match("/\/([0-9]+)\//", $url, $matches);

        $taskId = $matches[1];
        try {
            $comments = $this->app->getComment($taskId);
            $this->respoond($response, $comments, 200);
        } catch (\Exception $e) {
            $this->respondError($response, $e->getMessage(), [], 500);
        }
    }


    public function updateTask(Http\Request $request, Http\Response $response)
    {
        $url = $request->getUrl();
        $id = preg_replace('/[^0-9]/', '', $url);

        $task = $this->getTaskFromRequest($request);
        $task->setId($id);

        try {
            $this->app->updateTask($task);

            $this->respoond($response, $task, 200);
        } catch (\UnexpectedValueException $e) {
            $this->respondError($response, $e->getMessage(), [], 400);
        } catch (\Exception $e) {
            $this->respondError($response, $e->getMessage(), [], 500);
        }
    }

    public function deleteTask(Http\Request $request, Http\Response $response)
    {
        
        $url = $request->getUrl();
         $id = preg_replace('/[^0-9]/', '', $url);

        try {
            $this->app->deleteTask($id);

            $this->respoond($response, null, 200);
            
        } catch (\Exception $e) {
            $this->respondError($response, $e->getMessage(), [], 500);
        }
    }




    public function deleteUser(Http\Request $request, Http\Response $response)
    {
        
        $url = $request->getUrl();
         $id = preg_replace('/[^0-9]/', '', $url);

        try {
            $this->app->deleteUser($id);
            $this->respoond($response, null, 200);
            
        } catch (\Exception $e) {
            $this->respondError($response, $e->getMessage(), [], 500);
        }
    }







    private function getTaskFromRequest(Http\Request $request): App\Task
    {
        $data = $request->getBody();
        $task = new App\Task();
        $task->setTitle($data['title'] ?? false);
        $task->setDescription($data['description'] ?? false);
        // 'author_id' => $task->getAuthorId(),
        //     'executor_id' => $task->getexecutorId(),
        $task->setStatus($data['status'] ?? false); //????
        $task->setAuthor($data['author'] ?? false);
        $task->setAssignee($data['assignee'] ?? false);
        $task->setStartTime($data['start_time'] ?? false);
        $task->setEndTime($data['end_time'] ?? false);
        
       
        // TODO: set the rest of the fields

        // $data = $request->getBody();
        //        $status = $data['status'] ?? false;

        return $task;
    }


   


    private function respoond(Http\Response $response, $body, $statusCode)
    {
        $response->setStatus($statusCode);
        $response->setHeaders([
            'Content-Type' => 'application/json',
        ]);
        $response->setBody($body);
    }

    private function respondError(Http\Response $response, $errorMsg, $params, $statusCode)
    {
        file_put_contents('logs.log', $errorMsg."\n", FILE_APPEND);
         
        $response->setStatus($statusCode);
        $response->setHeaders([
            'Content-Type' => 'application/json',
        ]);
        $response->setBody([
            'error' => $statusCode < 500 ? $errorMsg : 'ops, mistake',
        ]);
    }
}