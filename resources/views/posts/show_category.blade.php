@extends('app')

@section('title')
{{$title}}
	<ul class="nav navbar-nav navbar-right" style="font-size: 25px;">
		<li>
			<a href="{{ url('/new-post') }}" role="button">+ Create New Post</a>
		</li>
	</ul>
@endsection

@section('content')
<div class="panel panel-default">	
	<div class="panel-body">
		<div class="row">
			<div class="col-xs-7"><a href="" style="text-decoration: none; font-size: 20px;">Topic</a></div>
				<div class="col-xs-2"><a href=""style="text-decoration: none; font-size: 20px;">User</a></div>
				<div class="col-xs-3"><a href=""style="text-decoration: none; font-size: 20px;">Active</a></div>
			<hr>	
		</div>
		@foreach ($posts as $post)
			<div class="row">
				<div class="col-xs-7">
					<a class="body_post"href="{{ url('/'.$post->slug) }}">
					<?php 
						if(strlen($post->title)>60){
							echo substr($post->title,0,60);
							echo "...";
							}else{
							echo $post->title;
						}
					?>
					</a>
				</div>
				<div class="col-xs-2"><a class="body_post"href="{{ url('/'.$post->slug) }}">{{$post->name}}</a></div>
				<div class="col-xs-3"><a class="body_post"href="{{ url('/'.$post->slug) }}">{{$post->created_at}}</a></div>
			</div>
		@endforeach
	</div>
</div>
@endsection