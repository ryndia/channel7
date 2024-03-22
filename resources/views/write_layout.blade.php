<div class="container">
  <form action="{{ route('save_article') }}" method="POST" onsubmit="savefile(false)" enctype="multipart/form-data">
    @csrf
    <input type="text" id="title_input" name="title" style="visibility: hidden;">
    <input type="text" id="content_input" name="content" style="visibility: hidden;">
    <input type="text" id="category_input" name="category" style="visibility: hidden;">
    <div class="row">
      <div class="dropdown col-2">
        <div class="row">
          <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="cat_tag_button">
            Article Category
          </button>
          <ul class="dropdown-menu">
            @foreach($category_type as $c)
            <li><a class="dropdown-item" id="option{{$c->id}}">{{$c->name}}</a></li>
            @endforeach
          </ul> 
        </div>
        <div class="row">
          <select class="form-select" multiple="multiple" name="subcat[]" aria-label="Default select example" data-live-search="true">
            @foreach($subcategory as $sub)
              @foreach($sub as $s)
                <option value="{{$s}}" style="visibility: hidden;" class="suboption{{$s->cID}}">{{$s->subcategory}}</option>
              @endforeach
            @endforeach
          </select>
        </div>
      </div>
      <div class="col-3">
        <label class="form-label" for="imageInput">Image File</label>
        <div class="row">
          <div class="col">
            <input type="file" class="form-control" name="image" accept="image/* "id="imageInput"/>
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
      <button type="submit" class="btn col-1 btn-dark mb-3">Save</button>
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
      <div id="editor" class="mb-3"></div>
    </div>
  </div>
</div>

