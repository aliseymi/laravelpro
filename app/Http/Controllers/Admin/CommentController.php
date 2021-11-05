<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::query();

        if($keyword = \request('search')){
            $comments->where('comment','LIKE',"%{$keyword}%")->whereApprove(1)->orWhereHas('user',function ($query) use($keyword){
                $query->where('name','LIKE',"%{$keyword}%");
            });
        }
        $comments = $comments->whereApprove(1)->latest()->paginate(20);
        return view('admin.comments.approved',compact('comments'));
    }


    public function unapproved()
    {
        $comments = Comment::query();

        if($keyword = \request('search')){
            $comments->where('comment','LIKE',"%{$keyword}%")->whereApprove(0)->orWhereHas('user',function ($query) use($keyword){
                $query->where('name','LIKE',"%{$keyword}%");
            });
        }
        $comments = $comments->whereApprove(0)->paginate(20);
        return view('admin.comments.unapproved',compact('comments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $comment->update([
            'approve' => 1
        ]);
        alert()->success('نظر با موفقیت تایید شد');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        alert()->success('نظر با موفقیت حذف شد');
        return back();
    }
}
