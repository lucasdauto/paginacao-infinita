<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostApiController extends Controller
{
    protected $repository;

    public function __construct(Post $post)
    {
       $this->repository = $post;
    }

    public function index()
    {
        $posts = $this->repository->paginate();

        return PostResource::collection($posts);
    }

}
