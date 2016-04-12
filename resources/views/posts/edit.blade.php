@extends('app')

@section('title')
Edit Post
@endsection

@section('content')
<script type="text/javascript" src="{{ asset('/js/tinymce/tinymce.min.js') }}"></script>
<script type="text/javascript">
	tinymce.init({
		selector : "textarea",
//		plugins : ["advlist autolink lists link image charmap print preview anchor", "searchreplace visualblocks code fullscreen", "insertdatetime media table contextmenu paste jbimages"],
//		toolbar : "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages"
//
		forced_root_block : ""
	});
</script>

<form method="post" action='{{ url("/update") }}'>
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="post_id" value="{{ $post->id }}{{ old('post_id') }}">
	<div class="form-group">
		<select name="category" class="form-control" required="required">
			<option value="{{$post->category}}" disabled selected hidden>{{$post->category}}</option>
			@if($categories->count())
				@foreach($categories as $category)
					<option value="{{$category->name}}">{{$category->name}}</option>
				@endforeach
			@endif
		</select>
	</div>
	<div class="form-group">
		<input required="required" placeholder="Enter title here" type="text" name = "title" class="form-control" value="@if(!old('title')){{$post->title}}@endif{{ old('title') }}"/>
	</div>
	<div class="form-group">
		<textarea name='body'class="form-control">
			@if(!old('body'))
			{!! $post->body !!}
			@endif
			{!! old('body') !!}
		</textarea>
	</div>
	@if($post->active == '1')
	<input type="submit" name='update' class="btn btn-success" value = "Update"/>
	@endif
	<a href="{{  url('delete/'.$post->id.'?_token='.csrf_token()) }}" class="btn btn-danger">Delete</a>
</form>
@endsection
