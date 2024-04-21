<body>
	<div class="container-fluid">
		<div class="row mt-5 mx-5">
	  		@if(!$article->isEmpty())
	  		<h1>Search Result</h1>
	  		<hr>
	  		<div class="col-8">
	  		@foreach($article as $ra)
	  			<div class="row">
		  			<div class="col-3 mt-3">
		  				<p>{{ $ra->created_at }}</p>
		  			</div>
		  			<div class="col-6">
						<a href="{{ route('read', ['article' => $ra]) }}" ><h4 class="title mt-3">{!! $ra->title !!}</h4></a>
		  				<p class="title_short_text">
		  					{!! preg_replace('/<[^>]+>/', '', $ra->content) !!}
						</p>
		  			</div>
		  			<div class="col-3">
		  				<img class="model_4_image" src="{{ asset('storage/' . $ra->image) }}">
		  			</div>
	  			</div>
	  			<hr>
	  		@endforeach
	  		</div>
	  		<div class="col-4">
	  			
	  		</div>
	  		@endif
	  	</div>
	</div>
</body>
