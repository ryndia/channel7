<div class="container">
  <div class="row">
    <div class="col-9">
      <hr>
      <div class="d-flex">
        <p class="ps-2 ms-auto" id="view">| - view(s) </p>
        <p class="ps-2 " id="time_to_read"> | - min(s) </p>
        <p class="ps-2 " id="comment_no"> | {{ count($comment) }} comment</p>
      </div>
      <div class="row my-3">
        <h1 class="title" id="main_article_title">{{$data->title}}</h1>
      </div>
      <div class="d-flex">
        <p class="editor_name" style="color: #F36677;">
          {{ $writer->name }}
        </p>
        <p> / {{$role->level}} - </p>
        <p class="date"></p>
        <div class="ms-auto social_logo_share d-flex mb-3">
          <a href="https://www.facebook.com/sharer/sharer.php?u=#url" target="_blank"><i class="ps-2 bi bi-facebook"></i></a>
          <i class="ps-2 bi bi-whatsapp"></i>
          <i class="ps-2 bi bi-twitter"></i>
          <i class="ps-2 bi bi-share-fill"></i>
        </div>
      </div>
      <hr>
      @if($data->image)
      <div class="row" id="main_image_article_con">
        <img id="main_image_article" style="width:;" src="{{ asset('storage/' . $data->image) }}">
      </div>
      @endif
      
      @if($data->audio)
        <script type="text/javascript">
          document.addEventListener('DOMContentLoaded', function() {
            var audioSource  = "{{ asset('storage/' . $data->audio ) }}";
            wavesurfer.load(audioSource);
          });
        </script>
        <div id="waveform">
          <div id="time_wave">0:00</div>
          <div id="duration_wave">0:00</div>
          <div id="hover_wave"></div>
        </div>
      @endif

      <div class="row mt-3" id="article_content">
        {!! $data->content !!}
      </div>
      @if($data->video)
      <script type="text/javascript">
        videoElement = document.getElementById('local_video');
        videoElement.setAttribute("src", "{{ asset('storage/' . $data->video ) }}");
      </script>
      @endif

      <div class="row" id="cat_tag">
        Tags: 
        <br>
        @foreach($category as $cat)
          {{ $cat }}: 
          @foreach($subcategory as $sc)
            @if ($sc->cID == $cat)
              {{$sc->subcategory}}
            @endif
          @endforeach
          <br>
        @endforeach
      </div>
      <hr>
      <div class="more_article row">
        @if($previous)
        <div class="col">
          <div class="row"> 
            <h4>Previous</h4>
          </div>
          <div class="row">
            <a href=" {{ route('read', ['article' => $previous]) }}"><h3>{{ $previous->title }}</h3></a>
          </div>
        </div>
        @endif
        @if($next)
        <div class="col article_next_button">
          <div class="row"> 
            <h4 class="text-end">Next</h4>
          </div>
          <div class="row">
            <a href=" {{ route('read', ['article' => $next]) }}"><h3 class="text-end">{{ $next->title }}</h3></a>
          </div>
        </div>
        @endif
      </div>
      <hr>
      

      <div class="publisher_detail_short mt-2 row">
        <div class="col-3 row align-items-center">
          <img class="avatar" src="{{ asset($role->profil_pic)}}">
        </div>
        <div class="publisher_detail col-9">
          <div class="d-flex">
            <div class="ps-2"> {{ $role->level }} </div>
            <div class="ps-2">Published: </div>
            <div class="ps-2">{{ $count }}</div>
          </div>
          <div class="row mt-2"><h2>{{ $writer->name }}</h2></div>
          <div class="row"><p>
            {{ $role->description}}
          </p></div>
        </div>
      </div>
      <hr>



      <div class="related_post">
        <div><h3 class="text-center related_post_title my-5">Related Article</h3></div>
        <div class="row"> 
          @foreach($related as $r)
          <div class="col-3 card_related">
            <div class="col">
              <div class="overflow-hidden" style="height: 17rem;">
                <img src="{{ asset('storage/' . $r->image) }}">
              </div>
              <a href=" {{ route('read', ['article' => $r]) }}"><h3 class="title" style="margin-top: 0.7rem;">{{ $r->title }}</h3></a>
              <p class="text_card_related">
                {{ preg_replace('/<[^>]+>/', '', $r->content) }}
              </p>
            </div>
          </div>
          @endforeach
        </div>
        <hr>
      </div>



      <div class="comment_section">
        <div class="row">
          <div><h3 class="text-center related_post_title my-5">Comments</h3></div>
        </div>
        <div class="comments_posted">
          <div class="row">
          <hr>
          @if($count != '0')
            @foreach($comment as $key => $c)
            <div class="col">
              <h5 class="row Name">{{ $username[$key]}}</h5>
              <p class="row date">{{ $c->created_at}}</p>
              <center><p class="row comments_text">{{$c->comment_text}}</p></center>
            </div>
            <hr>
            @endforeach
          @else
            <div class="col">
              <center><h5 class="row">No comments</h5></center>
            </div>
            <hr>
          @endif
          </div>
        </div>
        @if(Auth::id())
        <form class="comment_box" action="{{ route('comment') }}" method="POST">
          @csrf
          <div class="form-group">
            <label for="comment">Comment:</label>
            <textarea class="form-control" rows="5" name="comment" id="comment" required></textarea>
            <input type="hidden" name="id" value="{{ $data->id }}">
          </div> 
          <button type="submit" class="btn col-12 my-4 btn-dark">Submit</button>
        </form>
          @else
          <div class="row">
            <center class = "my-3"><h3>Connect with Us to share your opinion.</h3></center>
            <div class="col">
              <center><button type="submit" class="btn col-4 btn-dark mb-3"><a href="{{ route('login') }}">Login</a></button>
              <button type="submit" class="btn col-4 btn-dark mb-3"><a href="/register">Register</a></button></center>
            </div>
          </div>
          @endif
      </div>
    </div>
    <div class="col-3">
      
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
      const text = document.getElementById("article_content").innerText;
      const wpm = 225;
      const words = text.trim().split(/\s+/).length;
      const time = Math.ceil(words / wpm);
      document.getElementById("time_to_read").innerText = " | " + time + " min(s)";
  });
</script>