@extends('app')

@section('title')
		<!-- {{$title}} -->
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	<ul class="nav navbar-nav">
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Category<span class="caret"></span></a>
			<ul class="dropdown-menu" role="menu">
				@foreach($category as $i)
					<li>
						<a href="{{ url('/category/$i->name') }}"> {{$i->name}}</a>
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

	@if ( !$posts->count() )
		There is no post till now. Login and write a new post now!!!
		@else
				<!-- <div class="">
	@foreach( $posts as $post )
				<div class="list-group">
                    <div class="list-group-item">
                        <h3><a href="{{ url('/'.$post->slug) }}">{{ $post->title }}</a>
				@if(!Auth::guest() && ($post->author_id == Auth::user()->id || Auth::user()->is_admin()))
		@if($post->active == '1')
				<button class="btn" style="float: right"><a href="{{ url('edit/'.$post->slug)}}">Edit Post</a></button>
					@else
				<button class="btn" style="float: right"><a href="{{ url('edit/'.$post->slug)}}">Edit Draft</a></button>
					@endif
		@endif
				</h3>
                <p>{{ $post->created_at->format('M d,Y \a\t h:i a') }} By <a href="{{ url('/user/'.$post->author_id)}}">{{ $post->author->name }}</a></p>

		</div>
		<div class="list-group-item">
			<article>
				{!! str_limit($post->body, $limit = 1500, $end = '....... <a href='.url("/".$post->slug).'>Read More</a>') !!}
				</article>
            </div>
        </div>

        @endforeach
		<?php echo $posts->render(); ?>

				</div>
                 -->
		<style type="text/css">
			.body_post
			{
				text-decoration: none;
				color: red;

			}
			.body_post:hover{
				color: blue;
				text-decoration: none;
			}
		</style>
		<div style="width: 100%">
			<table>
				<tr style="color: red">
					<th width="70%">
						<a href="" style="text-decoration: none;">Topic</a>
					</th>
					<th width="15%">
						<a href=""style="text-decoration: none;">User</a>
					</th>
					<th width="15%">
						<a href=""style="text-decoration: none;">Active</a>
					</th>
				</tr>
				<tr>

					<th>
						<hr />
					</th>
					<th>
						<hr />
					</th>
					<th>
						<hr width="130%" />
					</th>
				</tr>
				@foreach ($posts as $post)
					<tr>
						<td>
							<a class="body_post"href="{{ url('/'.$post->slug) }}">
								<?php if(strlen($post->title)>60){
									echo substr($post->title,0,60);
									echo ".......";
								}else{
									echo $post->title;
								}
								?>
							</a>
						</td>
						<td>
							<a class="body_post"href="{{ url('/'.$post->slug) }}">{{$post->name}}</a>
						</td>
						<td>
							<a class="body_post"href="{{ url('/'.$post->slug) }}">{{$post->created_at}}</a>
						</td>
					</tr>
				@endforeach
			</table>
			<div class="row">
				<div class="col-md-10"></div>
				<div class="col-md-2"><a href="">More>>></a></div>
			</div>
		</div>
	@endif


@endsection
