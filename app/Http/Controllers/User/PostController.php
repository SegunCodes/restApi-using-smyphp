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
            if (empty($base64Image)) {
                return $response->json([
                    "success" => false,
                    "message" => "Image field is required"
                ], 400);
            }
            $path = Application::$ROOT_DIR."/routes/assets/uploads";
            $filename = "uploads_".uniqid().".jpg";
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

    public function viewAll(Request $request, Response $response){
        $allPosts = new Post;
        return $response->json([
            "success" => true,
            "message" => "Ok",
            "data" => $allPosts->findAll()
        ],200);
    }

    public function viewOne(Request $request, Response $response){
        $id = $request->getParams();
        $post = new Post;
        $value = $post->findAllWhere([
            'id' => implode("",$id)
        ]);
        if(!empty($value)){
            return $response->json([
                "success" => true,
                "message" => "Ok",
                "data" => $value
            ],200);
        }else{
            return $response->json([
                "success" => true,
                "message" => "invalid post id",
                "data" => []
            ],200);
        }
    }

    public function edit(){
        
    }

    public function delete(){
        
    }
}