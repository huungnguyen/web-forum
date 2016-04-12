<?php namespace App\Http\Controllers;

use App\Posts;
use App\User;
use Illuminate\Support\Facades\Auth;
use Redirect;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostFormRequest;
use App\Categories;
use App\Notifications;
use Illuminate\Http\Request;

// note: use true and false for active posts in postgresql database
// here '0' and '1' are used for active posts because of mysql database

class PostController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 */
	public function index()
	{
		$posts = Posts::join('users','users.id','=','posts.author_id')->where('posts.active','1')->orderBy('posts.created_at','desc')->paginate(10);
		$title = 'Latest Posts';
		$category=Categories::get();
		if(Auth::user()) {
			$notifications = Notifications::join('posts', 'posts.id', '=', 'notifications.on_post')->where('posts.author_id', Auth::user()->id)->where('notifications.status', 'no')->get();
			return view('home')->withPosts($posts)->withTitle($title)->with('category', $category)->withNotifications($notifications);
		}else
			return view('home')->withPosts($posts)->withTitle($title)->with('category', $category);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
		// 
		if($request->user()->can_post())
		{
			if(Auth::user()) {
				$notifications = Notifications::join('posts', 'posts.id', '=', 'notifications.on_post')->where('posts.author_id', Auth::user()->id)->where('notifications.status', 'no')->get();
				return view('posts.create')->withNotifications($notifications);
			}
			return view('posts.create');
		}	
		else 
		{
			return redirect('/')->withErrors('You have not sufficient permissions for writing post');
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(PostFormRequest $request)
	{
		$post = new Posts();
		$post->title = $request->get('title');
		$post->body = $request->get('body');
		$post->slug = str_slug($post->title);
		$post->category=$request->get('category');
		$post->author_id = $request->user()->id;
		$post->active = 1;
		$message = 'Post successfully';
		$post->save();
		return redirect('/'.$post->slug)->withMessage($message);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($slug)
	{
		$post=Posts::select('author_id','id')->where('slug',$slug)->first();
		if(Auth::user()->id==$post['author_id']) {
			Notifications::where('on_post', $post['id'])->update(array('status' => 'yes'));
		}
		$post = Posts::where('slug',$slug)->first();
		if($post)
		{
			if($post->active == false) {
				if(Auth::user()) {
					$notifications = Notifications::join('posts', 'posts.id', '=', 'notifications.on_post')->where('posts.author_id', Auth::user()->id)->where('notifications.status', 'no')->get();
					return redirect('/')->withErrors('requested page not found')->withNotifications($notifications);
				}
				return redirect('/')->withErrors('requested page not found');
			}
			$comments = $post->comments;	
		}
		else 
		{
			if(Auth::user()) {
				$notifications = Notifications::join('posts', 'posts.id', '=', 'notifications.on_post')->where('posts.author_id', Auth::user()->id)->where('notifications.status', 'no')->get();
				return redirect('/')->withErrors('requested page not found')->withNotifications($notifications);
			}
			return redirect('/')->withErrors('requested page not found');
		}
		if(Auth::user()) {
			$notifications = Notifications::join('posts', 'posts.id', '=', 'notifications.on_post')->where('posts.author_id', Auth::user()->id)->where('notifications.status', 'no')->get();
			return view('posts.show')->withPost($post)->withComments($comments)->withNotifications($notifications);
		}
		return view('posts.show')->withPost($post)->withComments($comments);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(Request $request,$slug)
	{
		$post = Posts::where('slug',$slug)->first();
		$notifications = Notifications::join('posts', 'posts.id', '=', 'notifications.on_post')->where('posts.author_id', Auth::user()->id)->where('notifications.status', 'no')->get();
		if($post && ($request->user()->id == $post->author_id || $request->user()->is_admin())) {

			return view('posts.edit')->with('post', $post)->withNotifications($notifications);
		}
		else 
		{
			return redirect('/')->withErrors('you have not sufficient permissions')->withNotifications($notifications);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request)
	{
		//
		$post_id = $request->input('post_id');
		$post = Posts::find($post_id);
		$notifications = Notifications::join('posts', 'posts.id', '=', 'notifications.on_post')->where('posts.author_id', Auth::user()->id)->where('notifications.status', 'no')->get();
		if($post && ($post->author_id == $request->user()->id || $request->user()->is_admin()))
		{
			$title = $request->input('title');
			$slug = str_slug($title);
			$duplicate = Posts::where('slug',$slug)->first();
			if($duplicate)
			{
				if($duplicate->id != $post_id)
				{
					return redirect('edit/'.$post->slug)->withErrors('Title already exists.')->withInput()->withNotifications($notifications);
				}
				else 
				{
					$post->slug = $slug;
				}
			}
			
			$post->title = $title;
			$post->body = $request->input('body');
			if($request->input('category')!=null)
			$post->category=$request->input('category');
			if($request->has('update')){
				$post->active = 1;
				$message = 'Post updated successfully';
				$landing = $post->slug;
			}
			$post->save();
	 		return redirect($landing)->withMessage($message)->withNotifications($notifications);
		}
		else
		{
			return redirect('/')->withErrors('you have not sufficient permissions')->withNotifications($notifications);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Request $request, $id)
	{
		//
		$notifications=Notifications::where('id_user',Auth::user()->id)->where('status','no')->get();
		$post = Posts::find($id);
		if($post && ($post->author_id == $request->user()->id || $request->user()->is_admin()))
		{
			$post->delete();
			$data['message'] = 'Post deleted Successfully';
		}
		else 
		{
			$data['errors'] = 'Invalid Operation. You have not sufficient permissions';
		}
		
		return redirect('/')->with($data)->withNotifications($notifications);
	}
	public function test(){
		return "ok";
	}
}
