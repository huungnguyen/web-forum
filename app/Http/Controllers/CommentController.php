<?php namespace App\Http\Controllers;

use App\Notifications;
use App\Posts;
use App\Comments;
use App\User;
use Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class CommentController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		//on_post, from_user, body
		$input['from_user'] = $request->user()->id;
		$input['on_post'] = $request->input('on_post');
		$input['body'] = $request->input('body');
		$slug = $request->input('slug');
		$notification=new Notifications();
		$notification->on_post=$request->input('on_post');
		$notification->from_user=User::find($request->user()->id)->name;
		$notification->status='no';
		$notification->save();
		Comments::create( $input );
 
		return redirect($slug);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
