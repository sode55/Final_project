<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\DB;
use APP\Http\Traits\Responses;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Comment;
use Throwable;

class CommentController extends Controller
{
//    use Responses;

#save company's comments
    public function store(CommentRequest $request)
    {
        try {

            $comment = Comment::create([
                'title' => $request->title,
                'content' => $request->content,
                'company_id' => $request->company_id,
            ]);


//            return  $this->getMessage($response->json(), $response->status());
//        }catch (Throwable $e) {
//            return $this->getError($response()->json(), $response()->status());

            return response()->json([
                "success" => true,
                'status' => 200,
                "message" => "نظرات شما با موفقیت ثبت شد.",
                "data" => $comment
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => $e->getCode(),
                'error' => $e->getMessage(),
            ]);
        }
    }
#show company's comments
    public function show()
    {
        try {

            $comments = Company::with(['comments' => function ($query) {
                $query->select('title', 'content', 'created_at', 'company_id');
            }])
                ->select('name','id')
                ->get();




//            return  $this->getMessage($response->json(), $response->status());
//        }catch (Throwable $e) {
//            return $this->getError($response()->json(), $response()->status());

            return response()->json([
                "success" => true,
                'status' => 200,
                "message" => "نظرات شرکت های طرف قرارداد:",
                "data" =>$comments
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => $e->getCode(),
                'error' => $e->getMessage(),
            ]);
        }
    }

}
