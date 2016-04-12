@extends('app')

@section('title')
		<!-- {{$title}} -->
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	<ul class="nav navbar-nav">
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Category<span class="caret"></span></a>
			<ul class="dropdown-menu" role="menu">
				@foreach($categories as $category)
					<li>
						<a href="{{ url('/category/'.$category->name) }}"> {{$category->name}}</a>
					</li>
				@endforeach
			</ul>
		</li>
		<li>
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{$title}}</a>
		</li>
	</ul>
</div>

@endsection


@section('content')
	<style type="text/css">
		.body_post
		{
			text-decoration: none;
			color: black;
			font-size: 15px;

		}
		.body_post:hover
		{
			color: #d52233;
			text-decoration: none;
			font-size: 20px;
		}
		.a:hover
		{
			color:red;
		}
	</style>
	@foreach ($categories as $category)
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3><a href="{{ url('/category/'.$category->name) }}" style="text-decoration: none;">{{$category->name}}</a></h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-7"><a href="" style="text-decoration: none; font-size: 20px;">Topic</a></div>
					<div class="col-xs-2"><a href=""style="text-decoration: none; font-size: 20px;">User</a></div>
					<div class="col-xs-3"><a href=""style="text-decoration: none; font-size: 20px;">Active</a></div>
					<hr>
				</div>
				@foreach ($posts as $post)
					@if ( !$posts->count() )
						There is no post till now. Login and write a new post now!!!
					@else
						@if ($post->category==$category->name)

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
						@endif
					@endif
				@endforeach
				<div class="row">
					<div class="col-md-10"></div>
					<div class="col-md-2"><a href="{{ url('/category/'.$category->name) }}">More>></a></div>
				</div>

			</div>
		</div>
	@endforeach

@endsection
