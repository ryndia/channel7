<div class="container">
  <form action="{{ route('update_article') }}" method="POST" onsubmit="savefile(true, {{$data->id}})" enctype="multipart/form-data">
    @csrf
    <input type="text" id="title_input" name="title" style="visibility: hidden;">
    <input type="text" id="content_input" name="content" style="visibility: hidden;">
    <input type="text" id="category_input" name="category" style="visibility: hidden;">
    <input type="text" id="article_id" name="article_id" style="visibility: hidden;">
    <input type="checkbox" id="remove_image" name="remove_image" style="visibility: hidden;">
    <input type="checkbox" id="remove_audio" name="remove_audio" style="visibility: hidden;">
    <input type="checkbox" id="remove_video" name="remove_video" style="visibility: hidden;">
    <div class="row">
      <div class="dropdown col-2">
        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="cat_tag_button">
          Article Category
        </button>
        <ul class="dropdown-menu">
          @foreach($category_type as $c)
          <li><a class="dropdown-item" id="option{{$c->id}}">{{$c->name}}</a></li>
          @endforeach
        </ul>
        <div class="row">
          <select class="form-select" multiple="multiple" name="subcat[]" aria-label="Default select example" data-live-search="true">
          @foreach($subcatall as $sub)
            @foreach($sub as $s)
            @if (in_array($s, $subcategory))
              <option value="{{$s}}" style="visibility: visible;" class="suboption{{$s->cID}}">{{$s->subcategory}}</option>
            @else
              <option value="{{$s}}" style="visibility: hidden;" class="suboption{{$s->cID}}">{{$s->subcategory}}</option>
            @endif
            @endforeach
          @endforeach
        </select>
      </div>
      </div>
      <div class="col-3">
        <label class="form-label" for="imageInput">Image File</label>
        <div class="row">
          <div class="col">
            <input type="file" class="form-control" name="image" accept="image/* "id="imageInput" />
          </div>
        </div>
      </div>
      <div class="col-3">
        <label class="form-label" for="audioInput">Audio File</label>
        <div class="row">
          <div class="col">
            <input type="file" class="form-control" name="audio" accept="audio/* "id="audioInput" />
          </div>
        </div>
      </div>
      <div class="col-3">
        <label class="form-label" for="videoInput">Video File</label>
        <div class="row">
          <div class="col">
            <input type="file" class="form-control" name="video" accept="video/*" id="videoInput" />
          </div>
        </div>
      </div>
      <button type="submit" class="btn col-1 btn-dark mb-3">Update</button>
    </div>
  </form>
  <div class="clear_media mt-3" id="media_pile"></div>
  <hr>
  <div id="tag_category" class="" style="overflow: scroll;"></div>
  <div class="choice row">
    <div class="col-1" style="height:4rem;">
      <h5 class="text-center" style="margin-top:25%;">Edit</h5>
    </div>
    <div class="col-1" style="height:4rem;">
      <label class="switch" style="margin-top:10%;">
        <input type="checkbox" id="toggle" onclick="toggle()">
        <span class="slider round"></span>
      </label>
    </div>
    <div class="col-1" style="height:4rem;">
      <h5 class="text-center" style="margin-top:25%;">Preview</h5>
    </div>
  </div>
  <div class="position-relative">
    <div class="overlay position-absolute border mb-5" style="visibility: hidden; overflow: scroll;" id="preview">
      @include('read_layout_preview')
    </div>
    <div class="edit z-2" style="height: 40rem;" id="content">
      <div id="toolbar"></div>
      <div id="editor" class="mb-3">
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  document.addEventListener("DOMContentLoaded", function() {
    var h1Node = document.createElement('h1');
    h1Node.textContent = "{{ $data->title }}";
    var editorContent = editor.root.innerHTML;
    temp = '{!! $data->content !!}';
    editorContent = temp;
    editor.root.innerHTML = h1Node.outerHTML + editorContent;
    var container = document.getElementById("media_pile");
    @if($data->video)
      var htmlcode = "<button id = \" click_remove_video \" class=\"ms-2 mt-1 mb-1 border btn btn-light shadow rounded-pill\"><i class=\"bi text-danger bi-x\">Remove Video </i></button>";
      container.innerHTML += htmlcode;
      displayVideo("{{ asset('storage/' . $data->video)}}");
      valueofVideo = true;
    @endif

    var img = document.getElementById("main_image_article");
    img.setAttribute("src", "{{asset('storage/' .$data->image)}}");

    @if($data->audio)
      var htmlcode = "<button id = \" click_remove_audio \"  class=\"ms-2 mt-1 mb-1 border btn btn-light shadow rounded-pill\"><i class=\"bi text-danger bi-x\">Remove Audio </i></button>";
      container.innerHTML += htmlcode;   
      wavesurfer.load("{{asset('storage/' .$data->audio)}}");
        valueofAudio = true;
      $("#waveform").show();
    @else
      $("#waveform").hide();
    @endif

  var dropdownItems = document.querySelectorAll(".dropdown-item");
  var tag_category = document.getElementById("tag_category");
  var tag = document.getElementById("cat_tag");
  tag.innerHTML = "Tag(s):";
  @foreach($category as $cat)
      dropdownItems.forEach(function(item){
      if (item.textContent === "{{$cat}}") {
        item.classList.add("disabled");
        tag_category.style.height = "4rem";
        tag_category.classList.add("mb-3");
        var htmlcode = "<button value =\""+ "{{$cat}}" +"\" class=\"ms-2 mt-1 mb-1 border btn btn-light shadow rounded-pill\">"+"{{$cat}}"+"</button>";
        tag_category.innerHTML += htmlcode;
        if (tag.innerHTML === 'Tag(s):'){
          tag.innerHTML += "  " + "{{$cat}}";
        }
        else{
          tag.innerHTML += ", " + "{{$cat}}"; 
        }
      document.getElementById("category_input").value = tag.innerHTML;
      }
    });
  @endforeach

    @if(!$data->image)
      $("#main_image_article").hide();
    @else
      var htmlcode = "<button id = \" click_remove_image \" class=\"ms-2 mt-1 mb-1 border btn btn-light shadow rounded-pill\"><i class=\"bi text-danger bi-x\">Remove Image </i></button>";
      container.innerHTML += htmlcode;    
      $("#main_image_article").show();
      valueofImage = true;
    @endif

  });
</script>