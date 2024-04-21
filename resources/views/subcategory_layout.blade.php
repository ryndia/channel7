<body>
	<div class="container-fluid">
		@if(!$subcategoryArticle->isEmpty())
		<div class="row mx-5 mt-5">
			<h1 class="mb-2">{{$subcategory->subcategory}}</h1>
			<hr>
		</div>
		<div class="row mx-5">
			@foreach($subcategoryArticle as $sca)
			    <div class="col-12 col-sm-6 col-md-3 col-lg card_popular">
			      <div class="col">
			        <div class="overflow-hidden" style="height: 17rem;">
			          <img src="{{ asset('storage/' . $sca->image) }}">
			        </div>
			        <a href="{{ route('read', ['article' => $sca]) }}"><h3 class="title" style="margin-top: 0.7rem;">{{$sca->title}}</h3></a>
			        <p class="te_card_popular side_bar">
			        </p>
			      </div>
			    </div>
		  	@endforeach
	  	</div>
	  	@endif
	</div>
</body>