<?php

namespace App\Http\Controllers\User;

use SmyPhp\Core\Controller\Controller;
use SmyPhp\Core\Http\Request;
use SmyPhp\Core\Http\Response;
use SmyPhp\Core\DatabaseModel;
use SmyPhp\Core\Application;
use SmyPhp\Core\Auth;
use App\Models\Post;
use App\Http\Middleware\Authenticate;
use App\Providers\Token;
use App\Providers\Image;
use App\Http\Middleware\ApiMiddleware;

class PostController extends Controller{

    public function __construct(){
        $this->authenticatedMiddleware(new ApiMiddleware(['create']));
    }

    public function create(Request $request, Response $response){
        $title = $_POST["title"];
        $body = $_POST["body"];
        $user = Auth::User();
        $filename = null;
        if (empty($title) || empty($body)) {
            return $response->json([
                "success" => false,
                "message" => "All fields are required"
            ], 400);
        }
        if(isset($_POST["file"])){
            $base64Image = $_POST["file"];
            $path = Application::$ROOT_DIR."/routes/assets/uploads";
            $filename = "uploads".uniqid()."jpg";
            $convertImage = Image::convert($base64Image, $path, $filename);
        }
        // add to posts database
        $stmt = DatabaseModel::prepare("INSERT INTO posts SET user_id =  :user_id, title = :title, body = :body, image = :image");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':user_id', $user);
        $stmt->bindParam(':body', $body);
        $stmt->bindParam(':image', $filename);
        if($stmt->execute()){
            return $response->json([
                "success" => true,
                "message" => "post created"
            ], 200);
        }
    }

    public function viewAll(){

    }

    public function viewOne(){
        
    }

    public function edit(){
        
    }

    public function delete(){
        
    }
}