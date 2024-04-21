<body>
	<div class="container-fluid">
		<div class="row mx-5 mt-5">
			<h1>{{$category->name}}</h1>
			<hr>
		@if ($article->has(0))
			<div class="col">
				<img class="image_frame" src="{{ asset('storage/' . $article[0]->image) }}">
				<a href="{{ route('read', ['article' => $article[0]]) }}" ><h4 class="title mt-3">{{$article[0]->title}}</h4></a>
				<p class="title_short_text">
					{!! preg_replace('/<[^>]+>/', '', $article[0]->content) !!}
	            </p>
			</div>
	    @endif
			<div class="col">
				<div class="row">	
				@if ($article->has(1))
					<div class="col side_bar">
						<img class="image_frame_2" src="{{ asset('storage/' . $article[1]->image) }}">
						<a href="{{ route('read', ['article' => $article[1]]) }}" ><h4 class="title mt-3">{{$article[1]->title}}</h4></a>
						<p class="text_card_popular">
							{!! preg_replace('/<[^>]+>/', '', $article[1]->content) !!}
	            		</p>
					</div>
				@endif
					<div class="col side_bar">
						<div class="col">
						@if ($article->has(2))
							<div class="row">
								<a href="{{ route('read', ['article' => $article[2]]) }}" ><h4 class="title mt-3">{{$article[2]->title}}</h4></a>
								<div class="row">
									<div class="col">	
										<p class="text_container">
											{!! preg_replace('/<[^>]+>/', '', $article[2]->content) !!}
							            </p>						
									</div>
									<div class="col"><img class="model_4_image" src="{{ asset('storage/' . $article[2]->image) }}"></div>
								</div>
							</div>
						@endif
						</div>
						<hr>	
						<div class="col">
						@if ($article->has(3))
							<div class="row">
								<a href="{{ route('read', ['article' => $article[3]]) }}" ><h4 class="title mt-3">{{$article[3]->title}}</h4></a>
								<div class="row">
									<div class="col">	
										<p class="text_container">
											{!! preg_replace('/<[^>]+>/', '', $article[3]->content) !!}
							            </p>						
									</div>
									<div class="col"><img class="model_4_image" src="{{ asset('storage/' . $article[3]->image) }}"></div>
								</div>
							</div>
						@endif
						</div>	
					</div>
				</div>
			</div>
		</div>
		<hr class="mx-5">
		@foreach($subcategory as $sc)
		@if(!$subcategoryArticle[$sc->id]->isEmpty())
		<div class="row mx-5 mt-5">
			<a href="{{ route('subcategory', ['subcategory' => $sc]) }}"><h2 class="mb-2">{{$sc->subcategory}}</h2></a>
			<hr>
		</div>
		<div class="row mx-5">
		@foreach($subcategoryArticle[$sc->id] as $sca)
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
	  	@endforeach
	  	<x-smart-ad-component slug="leaderboard-IT"/> 
	  	<hr class="mx-5">
	  	<div class="row mt-5 mx-5">
	  		@if(!$remainingArticles->isEmpty())
	  		<h1>Latest News</h1>
	  		<hr>
	  		<div class="col-8">
	  		@foreach($remainingArticles as $ra)
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
