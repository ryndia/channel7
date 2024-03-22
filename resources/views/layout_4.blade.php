<body>
	<div class="container-fluid">
		@if($carousel)
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
		<div class="row mt-2 mx-5">
			<!--main display-->
			<div class="col-12 col-sm-12 col-md-9 main">
		@foreach ($data as $d)
			@foreach ($d as $item)
					<div class="row">
						<div class="col-12 col-sm-12 col-md-4 title_frame">
							<div class="row my-1">
								<a href=" {{ route('read', ['article' => $item]) }}" ><h4 class="title mt-3">	{!! $item->title !!}</h4></a>
								<p class="title_short_text">
									{!! preg_replace('/<[^>]+>/', '', $item->content) !!}
		                		</p>
							</div>
							@if(!$item->image)
							<hr>
							<div class="row my-1">
								<a href="/read"><h4 class="title mt-3"></h4></a>
							</div>
							@endif
						</div>
						<div class="col-12 col-sm-12 col-md-8 py-5">
							<img class="image_frame" src="{{ asset('storage/' . $item->image) }}">
						</div>
						<div class="end">
							<hr>
						</div>
					</div>
				@endforeach
			@endforeach
			<!--
				<div class="row">
					<div class="col-4 title_frame">
						<div class="row my-1">
							<a href="/read"><h4 class="title mt-3">Title</h4></a>
							<p class="title_short_text">
								Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam ut ligula eget dolor venenatis consequat. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Integer at nisl augue. Mauris feugiat tincidunt
	                		</p>
						</div>
						<hr>
						<div class="row my-1">
							<a href="/read"><h4 class="title mt-3">Title</h4></a>
							<p class="title_short_text">
								Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam ut ligula eget dolor venenatis consequat. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Integer at nisl augue. Mauris feugiat tincidunt
	                		</p>
						</div>
					</div>
					<div class="col-4 py-4">
            			<img class="image_frame_2" src="{{ asset('image/canne_2.jpg') }}">
					</div>
					<div class="col-4">
						<div class="row my-1">
							<a href="/read"><h4 class="title mt-3">Title</h4></a>
							<p class="title_short_text">
								Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam ut ligula eget dolor venenatis consequat. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Integer at nisl augue. Mauris feugiat tincidunt
	                		</p>
						</div>
						<hr>
					</div>
					<div class="end">
						<hr>
					</div>
				</div>
				<div class="row">
					<div class="col py-4">
            			<img class="image_frame_3" src="{{ asset('image/canne_2.jpg') }}">
            			<a href="/read"><h2 class="title mt-3 text-center">Title</h2></a>
					</div>
					<div class="end">
						<hr>
					</div>
				</div>
			-->
			</div>

<!-- 			<div class="col-12 col-sm-12 col-md-3 side_panel_main">
				<div class="row">
					@foreach($sidebar as $s)
					<div class="model_1 ms-1 row">
            			<img class="mt-5 model_1_image" src="{{ asset('storage/' . $s->image) }}">
						<a href="{{ route('read', ['article' => $s]) }}"><h4 class="mt-2 title_frame">{{$s->title}}</h4></a>
						<p class="model_1_text">
							{!! preg_replace('/<[^>]+>/', '', $s->content) !!}
						</p>
						<hr>
					</div>
					@endforeach
					<div class="model_2 ms-1 row">
						<div class="col-6">
							<img class="model_2_image" src="{{ asset('image/test.jpg') }}">
							<a href="/read"><h5 class="mt-2 title_frame">Title</h5></a>
						</div>
						<div class="col-6 side_bar">
							<img class="model_2_image" src="{{ asset('image/test.jpg') }}">
							<a href="/read"><h5 class="mt-2 title_frame">Title</h5></a>
						</div>
						<hr class="mt-2">
					</div>
					<div class="model_3 ms-1 row">
						<div class="col-6">
							<a href="/read"><h5 class="mt-2 title_frame">Title</h5></a>
						</div>
						<div class="col-6 side_bar">
							<img class="model_3_image" src="{{ asset('image/test.jpg') }}">
						</div>
						<hr class="mt-3">
					</div>
					<div class="model_4 ms-1 row">
						<div class="row">
							<div class="col-6">
								<a href="/read"><h5 class="mt-2 title_frame">Title</h5></a>
							</div>
							<div class="col-6 side_bar">
								<a href="/read"><h5 class="mt-2 title_frame">Title</h5></a>
							</div>				
						</div>
						<center class="col">
							<i class="bi bi-arrow-left-circle-fill"></i>
							<i class="bi bi-arrow-right-circle-fill"></i>
						</center>
						<hr class="mt-3">
					</div>
					<div class="model_5 ms-1 row">
						<div class="col-8">
							<a href="/read"><h5 class="mt-2 title_frame">Title</h5></a>
						</div>
						<div class="col-4">
							<img class="model_5_image" src="{{ asset('image/test.jpg') }}">
						</div>
						<hr class="mt-3">
					</div>
					<div class="model_6 ms-1 row">
						<div class="col-9">
							<p>name of author or opinion</p>
							<a href="/read"><h5 class="mt-2 title_frame">Title</h5></a>	
						</div>
						<div class="col-3">
							<img src="{{ asset('image/test.jpg') }}" class="avatar_model_6">
						</div>
						<hr class="mt-3">
					</div>
					<div class="model_6 ms-1 row">
						<div class="col-9">
							<p>name of author or opinion</p>
							<a href="/read"><h5 class="mt-2 title_frame">Title</h5></a>	
						</div>
						<div class="col-3">
							<img src="{{ asset('image/test.jpg') }}" class="avatar_model_6">
						</div>
						<hr class="mt-3">
					</div>
					<div class="model_6 ms-1 row">
						<div class="col-9">
							<p>name of author or opinion</p>
							<a href="/read"><h5 class="mt-2 title_frame">Title</h5></a>	
						</div>
						<div class="col-3">
							<img src="{{ asset('image/test.jpg') }}" class="avatar_model_6">
						</div>
						<hr class="mt-3">
					</div>
					<div class="model_7 ms-1 row">
						<div class="col">
							<a href="/read"><h5 class="mt-2 title_frame">Title</h5></a>	
						</div>
					</div>
				</div>
			</div> -->
		</div>


		<hr class="">
		<div class="row mx-5"> 
		@foreach($perCat as $pc)
		    <div class="col-12 col-sm-6 col-md-3 col-lg card_popular">
		      <div class="col">
		      	<a href="{{ route('section', ['category' => $pc->category_id]) }}"><p>{{$pc->category_name}}</p></a>
		        <div class="overflow-hidden" style="height: 17rem;">
		          <img src="{{ asset('storage/' . $pc->image) }}">
		        </div>
		        <a href="{{ route('read', ['article' => $pc]) }}"><h3 class="title" style="margin-top: 0.7rem;">{{$pc->article_title}}</h3></a>
		        <p class="te_card_popular side_bar">
		        </p>
		      </div>
		    </div>
		@endforeach
	  	</div>
	</div>
</body>
