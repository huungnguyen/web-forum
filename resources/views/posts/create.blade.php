@extends('app')

@section('title')
Add New Post
@endsection

@section('content')

<script type="text/javascript" src="{{ asset('/js/tinymce/tinymce.min.js') }}"></script>
<script type="text/javascript">
	tinymce.init({
		selector : "textarea",
//		plugins : ["advlist autolink lists link image charmap print preview anchor", "searchreplace visualblocks code fullscreen", "insertdatetime media table contextmenu paste jbimages"],
//		toolbar : "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages",

		forced_root_block : ""
	});
</script>

<form action='{{url("/new-post")}}' method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="form-group">
		<select name="category" class="form-control" required="required">
			<option value="" disabled selected hidden>Select your category</option>
			<option value="category1">category1</option>
			<option value="category2">category2</option>
			<option value="category3">category3</option>
			<option value="category4">category4</option>
		</select>
	</div>
	<div class="form-group">
		<input required="required" value="{{ old('title') }}" placeholder="Enter title here" type="text" name = "title"class="form-control" />
	</div>
	<div class="form-group">
		<textarea name='body'class="form-control">{{ old('body') }}</textarea>
	</div>
	{{--<input type="submit" name='publish' class="btn btn-success" value = "Publish"/>--}}
	<input type="submit" name='post' class="btn btn-default" value = "Post" />
</form>
@endsection
