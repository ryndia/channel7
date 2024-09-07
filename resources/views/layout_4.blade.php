<body>
	<div class="container-fluid">
		@if(!$carousel->isEmpty())
		<div id="carousel1" class="carousel slide mt-2 mx-5" data-bs-ride="carousel">
			<div class="carousel-inner">
			@foreach($carousel as $c)	
			    <div class="carousel-item
			    	@if($loop->index == 0)
			    	active
			    	@endif
			    ">
			    	<img class="image_frame" src="{{ asset('storage/' . $c->image) }}" style="filter: brightness(50%);">
			    	<div class="ms-5 mt-5 mask  text-light d-flex justify-content-center flex-column text-center position-absolute top-0 start-0">
			    		<a href=" {{ route('read', ['article' => $c]) }}" ><h1 class="display-3">{!! $c->title !!}</h1></a>
 					</div>
				</div>
			   @endforeach
		  	</div>
		    <button class="carousel-control-prev" type="button" data-bs-target="#carousel1" data-bs-slide="prev">
		      <span class="carousel-control-prev-icon"></span>
		      <span class="visually-hidden">Previous</span>
		    </button>
		    <button class="carousel-control-next" type="button" data-bs-target="#carousel1" data-bs-slide="next">
		      <span class="carousel-control-next-icon"></span>
		      <span class="visually-hidden">Next</span>
		    </button>
		</div>
		@endif

		<hr class="mx-5">
		<div class="row mt-1 mx-5">
			<!--main display-->
			<div class="col-12 col-sm-12 col-md-9 main">
		@foreach($category as $c)
				<h1 class= "display-1" style="padding-top: 2rem;">{{$c->name}}</h1>
				<hr>
				@foreach($data[$c->id] as $item)
				@if(count($item) == 1)
					<div class="row">
					<img class="image_frame" src="{{ asset('storage/' . $item[0]->image) }}">
						<div class="col-12 title_frame">
						<a href=" {{ route('read', ['article' => $item[0]]) }}" ><h4 class="title mt-3">	{!! $item[0]->title !!}</h4></a>
						</div>
					</div>
				@else
					<div class="row">
						<div class="col-12 col-sm-12 col-md-4 title_frame">
						 @if ($item->has(0))
							<div class="row my-1">
								<a href=" {{ route('read', ['article' => $item[0]]) }}" ><h4 class="title mt-3">	{!! $item[0]->title !!}</h4></a>
								<p class="title_short_text">
									{!! preg_replace('/<[^>]+>/', '', $item[0]->content) !!}
		                		</p>
							</div>
							<hr>
						@endif
						 @if ($item->has(1))
							<div class="row my-1">
								<a href=" {{ route('read', ['article' => $item[1]]) }}" ><h4 class="title mt-3">	{!! $item[1]->title !!}</h4></a>
								<p class="title_short_text">
									{!! preg_replace('/<[^>]+>/', '', $item[1]->content) !!}
		                		</p>
							</div>
							<hr>
						@endif
						 @if ($item->has(2))
							<div class="row my-1">
								<a href=" {{ route('read', ['article' => $item[2]]) }}" ><h4 class="title mt-3">	{!! $item[2]->title !!}</h4></a>
								<p class="title_short_text">
									{!! preg_replace('/<[^>]+>/', '', $item[2]->content) !!}
		                		</p>
							</div>
						@endif
					  	@if ($item->has(0))
						</div>
						<div class="col-12 col-sm-12 col-md-8 py-5">
							<img class="image_frame" src="{{ asset('storage/' . $item[0]->image) }}">
						</div>
						<div class="end">
							<hr>
						</div>
						@endif
					</div>
				@endif
				@endforeach
			@endforeach
			</div>

			<div class="col-12 col-sm-12 col-md-3 side_panel_main">
				<div class="row">
					<div class="p-4 pb-5 row weather_widget">
						<div class="d-flex">
							<div><h3>{{ $weather->weather[0]->main }}</h3></div>
							<div class="ms-auto"><h4>{{(date("Y/m/d"))}}</h4></div>
						</div>
						<div class="d-flex"><img class="logo mt-3" style="height:10rem" src="https://openweathermap.org/img/wn/{{$weather->weather[0]->icon}}@4x.png"></div>
						<div class="d-flex">
							<div class="mt-3">
								<div>{{ $weather->weather[0]->description }}</div>
								<div><i class="fa-solid fa-droplet"></i> Humidity: {{ $weather->main->humidity }}%</div>
								<div><i class="fa-solid fa-gauge"></i> Pressure: {{ $weather->main->pressure }}</div>
							</div>
							<div class="ms-auto"><h1 style=" font-size: 6rem">{{ round($weather->main->temp) }}</h1></div>
						</div>
					</div>
					<div class="model_1 ms-1 row">
						<hr>
						<h2 class="mt-3">Recipe of the Day</h2>
            			<img class="mt-1 model_1_image" src="{{ asset('storage/' . $menu->image) }}">
						<a href="{{ route('read', ['article' => $menu]) }}"><h4 class="mt-2 title_frame">{{$menu->title}}</h4></a>
						<p class="model_1_text">
							{!! preg_replace('/<[^>]+>/', '', $menu->content) !!}
						</p>
						<hr>
					</div>
					@foreach($sidebar as $s)
					@if(strlen($s[0]->title) < 25)
					<div class="model_2 ms-1 row">
						<div class="col-6">
							<img class="model_2_image" src="{{ asset('storage/' . $s[0]->image) }}">
							<a href="{{ route('read', ['article' => $s[0]]) }}"><h5 class="mt-2 title_frame">{{$s[0]->title}}</h5></a>
						</div>
						@if($s->has(1))
						<div class="col-6 side_bar">
							<img class="model_2_image" src="{{ asset('storage/' . $s[1]->image) }}">
							<a href="{{ route('read', ['article' => $s]) }}"><h5 class="mt-2 title_frame">{{$s[1]->title}}</h5></a>
						</div>
						@endif
						<hr class="mt-2">
					</div>
					@else
					<div class="model_3 ms-1 row">
						<div class="col-6">
							<a href="{{ route('read', ['article' => $s[0]]) }}"><h5 class="mt-2 title_frame">{{$s[0]->title}}</h5></a>
						</div>
						<div class="col-6 side_bar">
							<img class="model_3_image" src="{{ asset('storage/' . $s[0]->image) }}">
						</div>
						<hr class="mt-3">
					</div>
					@if($s->has(1))
					<div class="model_5 ms-1 row">
						<div class="col-8">
							<a href="{{ route('read', ['article' => $s[1]]) }}"><h5 class="mt-2 title_frame">{{$s[1]->title}}</h5></a>
						</div>
						<div class="col-4">
							<img class="model_5_image" src="{{ asset('storage/' . $s[1]->image) }}">
						</div>
						<hr class="mt-3">
					</div>
					@endif
					@endif
					@endforeach
					<p class="fw-bold ms-1">Opinion</p>
					@foreach($opinion as $o)
					<div class="model_6 ms-1 row">
						<div class="col-9">
							<a href="{{ route('read', ['article' => $o]) }}"><h5 class="mt-2 title_frame">{{$o->title}}</h5></a>	
						</div>
						<div class="col-3">
							<img src="{{ asset('storage/' . $o->image) }}" class="avatar_model_6">
						</div>
						<hr class="mt-3">
					</div>
					@endforeach
					<!--
					<div class="model_7 ms-1 row">
						<div class="col">
							<a href=""><h5 class="mt-2 title_frame">Title</h5></a>	
						</div>
					</div>
					-->
				</div>
			</div>
		</div>


		<hr class="">
		<div class="row mx-5"> 
		@foreach($perCat as $pc)
		    <div class="col-12 col-sm-6 col-md-3 col-lg card_popular">
		      <div class="col">
		      	<a class="display-5 title" href="{{ route('section', ['category' => $pc->category_id]) }}"><p>{{$pc->category_name}}</p></a>
		        <div class="overflow-hidden" style="height: 17rem;">
		          <img src="{{ asset('storage/' . $pc->image) }}">
		        </div>
		        <a href="{{ route('read', ['article' => $pc->article_id]) }}"><h3 class="title" style="margin-top: 0.7rem;">{{$pc->article_title}}</h3></a>
		        <p class="te_card_popular side_bar">
		        </p>
		      </div>
		    </div>
		@endforeach
	  	</div>
	</div>
</body>
