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

#save compoany's comments
    public function apiAddComment(CommentRequest $request)
    {
        try {

            $request->validated();

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
#show companies 's comments
    public function apiShowComments()
    {
        try {

//            $comments = DB::table('comments')
//                ->join('companies', 'comments.company_id', '=', 'companies.id')
//                ->select(
//                    'companies.name',
//                    'comments.title',
//                    'comments.content',
//                    'comments.created_at',
//                )
//                ->get();



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
