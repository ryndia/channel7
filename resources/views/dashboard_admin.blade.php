<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    Welcome the admin Dasboard!
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 row d-flex ">
            <button id="review_ads" class="btn btn-danger col-1 shadow sm:rounded-lg">
                <a href="{{ route('smart-ad-manager') }}"><i class="bi bi-badge-ad"></i></a>
            </button>
            <button class="ms-3 me-3 btn btn-dark col shadow sm:rounded-lg">
                <a href="{{ route('write') }}">Create Article</a>
            </button>
            <button id="edit_article" class="btn btn-dark col shadow sm:rounded-lg">
                <a>Edit Article</a>
            </button>
            @if($admin->level == "admin" || $admin->level == "reviewer")
            <button id="app_article" class="ms-3 btn btn-dark col shadow sm:rounded-lg">
                <a>Approve Article</a>
            </button>
            <button id="carousel_display" class="ms-3 btn btn-dark col shadow sm:rounded-lg">
                <a>Carousel Display</a>
            </button>
            <button id="add_cat" class="ms-3 btn btn-dark col shadow sm:rounded-lg">
                <a>Add Category</a>
            </button>
            @endif
        </div>
        <div id="display_article">
        <form action="{{ route('display_article') }}" method="POST">
            @csrf
            @foreach($article as $a)
            <div class="max-w-7xl mt-4 mx-auto sm:px-6 lg:px-8 row d-flex">
                <div class="rounded-lg d-flex col bg-white">
                    <div class="align-self-start overflow-hidden">
                        @if($a->image)
                        <img class="display_edit my-2 rounded-lg" src="{{ asset( 'storage/' . $a->image )}}">
                        @else
                            <div class="display_edit my-2 rounded-lg" style="width: 5rem;"></div>
                        @endif
                    </div>
                    <div class="align-self-center ms-auto">
                        <h3 class="fs-3">{!! $a->title !!}</h3>
                    </div>
                    <div class="ms-auto align-self-center ">
                        @if($a->approved)
                            <i class="bi bi-check text-info fs-2"></i>
                        @else
                            <i class="bi text-danger bi-x fs-2"></i>
                        @endif
                        <a href="{{ route('edit', ['article' => $a]) }}" onclick="" ><i class="bi bi-pencil-square text-success ps-4 fs-4 pe-4"></i></a>
                        <a href="{{route('delete',['article' => $a])}}" onclick="return confirm('Are you sure you want to delete the article? The change will not be reversible.')" ><i class="bi bi-trash3 text-danger pe-3 fs-4"></i></a>
                    </div>
                    <div class="align-self-center pb-1">
                      <label class="switch" style="">
                        <input type="checkbox" id="{{ $a->id }}" onchange="toggle_not_display({{$a->id}})" 
                                name="{{ $a->id }}"
                            @if($a->display)
                                checked
                            @endif
                        >
                        <span class="slider round"></span>
                      </label>
                    <input style = "visibility: hidden;" type="checkbox" name ="uncheck_{{ $a->id }}" id ="uncheck_{{ $a->id }}"
                            @if(!$a->display)
                                checked
                            @endif
                    >
                    </div>
                </div>
            </div>
            @endforeach
            <div class="max-w-7xl mt-4 mx-auto sm:px-6 lg:px-8 row d-flex ">
                <button type="submit" class="btn col btn-dark bg-dark mb-3">Save</button>
            </div>
        </form>
        </div>
        @if($admin->level == "admin" || $admin->level == "reviewer")
        <div id="approve_article">
        <form action="{{ route('approve_article') }}" method="POST">
            @csrf
            @foreach($article as $a)
            <div class="max-w-7xl mt-4 mx-auto sm:px-6 lg:px-8 row d-flex">
                <div class="rounded-lg d-flex col bg-white">
                    <div class="align-self-start overflow-hidden">
                        @if($a->image)
                        <img class="display_edit my-2 rounded-lg" src="{{ asset( 'storage/' . $a->image )}}">
                        @else
                            <div class="display_edit my-2 rounded-lg" style="width: 5rem;"></div>
                        @endif
                    </div>
                    <div class="align-self-center ms-auto">
                        <a href="{{ route('read', ['article' => $a]) }}"><h3 class="fs-3">{!! $a->title !!}</h3></a>
                    </div>
                    <div class="ms-auto align-self-center ">
                        @if($a->approved)
                            <i class="bi bi-check text-info fs-2"></i>
                        @else
                            <i class="bi text-danger bi-x fs-2"></i>
                        @endif
                    </div>
                    <div class="align-self-center ps-4 pb-2">
                      <label class="switch" style="">
                        <input type="checkbox" id="approved_{{ $a->id }}" onchange="toggle_not_approved({{$a->id}})" 
                                name="approved_{{ $a->id }}"
                            @if($a->approved)
                                checked
                            @endif
                        >
                        <span class="slider round"></span>
                      </label>
                    <input style = "visibility: hidden;" type="checkbox" name ="unapproved_{{ $a->id }}" id ="unapproved_{{ $a->id }}"
                            @if(!$a->approved)
                                checked
                            @endif
                    >
                    </div>
                </div>
            </div>
            @endforeach
            <div class="max-w-7xl mt-4 mx-auto sm:px-6 lg:px-8 row d-flex ">
                <button type="submit" class="btn col btn-dark bg-dark mb-3">Approve Article</button>
            </div>
        </form>
        </div>

        <div id="carousel_disp">
            <form action="{{ route('display_carousel')}}" method="POST">
                @csrf
                @foreach($article as $a)
                <div class="max-w-7xl mt-4 mx-auto sm:px-6 lg:px-8 row d-flex">
                    <div class="rounded-lg d-flex col bg-white">
                        <div class="align-self-start overflow-hidden">
                            @if($a->image)
                            <img class="display_edit my-2 rounded-lg" src="{{ asset( 'storage/' . $a->image )}}">
                            @else
                                <div class="display_edit my-2 rounded-lg" style="width: 5rem;"></div>
                            @endif
                        </div>
                        <div class="align-self-center ms-auto">
                            <a href="{{ route('read', ['article' => $a]) }}"><h3 class="fs-3">{!! $a->title !!}</h3></a>
                        </div>
                        <div class="ms-auto align-self-center ">
                            @if($a->carousel_display)
                                <i class="bi bi-check text-info fs-2"></i>
                            @else
                                <i class="bi text-danger bi-x fs-2"></i>
                            @endif
                        </div>
                        <div class="align-self-center ps-4 pb-2">
                          <label class="switch" style="">
                            <input type="checkbox" id="carousel_approved_{{ $a->id }}" onchange="toggle_not_dislay_carousel({{$a->id}})" 
                                    name="carousel_approved_{{ $a->id }}"
                                @if($a->carousel_display)
                                    checked
                                @endif
                            >
                            <span class="slider round"></span>
                          </label>
                        <input style = "visibility: hidden;" type="checkbox" name ="carousel_unapproved_{{ $a->id }}" id ="carousel_unapproved_{{ $a->id }}"
                                @if(!$a->carousel_display)
                                    checked
                                @endif
                        >
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="max-w-7xl mt-4 mx-auto sm:px-6 lg:px-8 row d-flex ">
                    <button type="submit" class="btn col btn-dark bg-dark mb-3">Display on Carousel</button>
                </div>    
            </form>
        </div>


        <div id="add_category">
            <form action="{{ route('add_category') }}" method="POST">
                @csrf
                <div class="max-w-7xl mt-4 mx-auto sm:px-6 lg:px-8 row d-flex">
                    <div class="rounded-lg d-flex col bg-white">
                        <div class="input-group">
                          <span class="input-group-text">Add new Category</span>
                          <textarea name = "category" class="form-control" aria-label="With textarea" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="max-w-7xl mt-4 mx-auto sm:px-6 lg:px-8 row d-flex ">
                    <button type="submit" class="btn col btn-dark bg-dark mb-3">Save Category</button>
                </div>
            </form>


            <form action="{{ route('add_sub_catergory') }}" method="POST">
                @csrf
                <div class="max-w-7xl mt-4 mx-auto sm:px-6 lg:px-8 row d-flex">
                    <div class="rounded-lg d-flex col bg-white pt-2">
                      <div class="form-group col-2 me-2">
                        <label for="selectCat" >Select Category</label>
                        <select name="cat" class="form-control" id="selectCat">
                          @foreach($category as $c)
                            <option value="{{$c->id}}">{{$c->name}}</option>
                          @endforeach
                        </select>
                      </div>
                        <div class="input-group my-4">
                          <span class="input-group-text">Add new subcatergory</span>
                          <textarea name = "subcategory" class="form-control" aria-label="With textarea" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="max-w-7xl mt-4 mx-auto sm:px-6 lg:px-8 row d-flex ">
                    <button type="submit" class="btn col btn-dark bg-dark mb-3">Save sub category</button>
                </div>
            </form>

            <form action="{{route('display_category')}}" method="POST">
                @csrf
                @foreach($category as $c)
                <div class="max-w-7xl mt-4 mx-auto sm:px-6 lg:px-8 row d-flex">
                    <div class="rounded-lg d-flex col bg-white">
                        <div class="align-self-center ms-auto">
                           <h3>{{$c->name}}</h3> 
                        </div>
                        <div class="align-self-center ms-auto">
                        @if($c->name != "sidebar" && $c->name != "opinion")
                                                  <label class="switch_small" style="">
                            <input type="checkbox" id="cat_approved_{{ $c->id }}" onchange="toggle_not_dislay_cat({{$c->id}})" 
                                    name="cat_approved_{{ $c->id }}"
                                    @if($c->display)
                                    checked
                                    @endif
                            >
                            <span class="slider_small round"></span>
                          </label>
                        <input style = "visibility: hidden;" type="checkbox" name ="cat_unapproved_{{ $c->id }}" id ="cat_unapproved_{{ $c->id }}"
                            @if(!$c->display)
                                    checked
                            @endif
                        >
                            <a href="{{route('delete_category', ['category_type' => $c])}}" onclick="return confirm('Are you sure you want to delete the category? The change will not be reversible.')"><i class="bi bi-trash3 text-danger pe-3 fs-4"></i></a>
                        @endif
                        </div>
                    </div>
                    <div class="rounded-bottom bg-white">
                        <hr>
                        <div class="my-2">
                            <h3 class="text-center">Sub Category</h3>
                        </div>
                        <hr>
                        @foreach($sub as $s)
                        <div class="d-flex">
                                @if($s->cID == $c->id)
                                <div class="align-self-center ms-auto">
                                    <h3>{{$s->subcategory}}</h3>
                                </div>
                                <div class="ms-auto">
                                    <a href="{{route('delete_sub_category', ['subcategory' => $s])}}" onclick="return confirm('Are you sure you want to delete the sub category? The change will not be reversible.')"><i class="ms-auto bi bi-trash3 text-danger pe-3 fs-4"></i></a>
                                </div>
                                @endif 
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
                <div class="max-w-7xl mt-4 mx-auto sm:px-6 lg:px-8 row d-flex ">
                    <button type="submit" class="btn col btn-dark bg-dark mb-3">Display Category</button>
                </div>
            </form>
        </div>
        @endif
    </div>
</x-app-layout>


<script type="text/javascript">
    function toggle_not_display(id){
        var uncheck = "uncheck_" + (id);
        var checkboxElement = document.getElementById(uncheck);
        if(checkboxElement.checked){
            checkboxElement.checked = false;
        }
        else{
            checkboxElement.checked = true;
        }
    }
    function toggle_not_approved(id){
        var uncheck = "unapproved_" + (id);
        var checkboxElement = document.getElementById(uncheck);
        if(checkboxElement.checked){
            checkboxElement.checked = false;
        }
        else{
            checkboxElement.checked = true;
        }
    }

    function toggle_not_dislay_cat(id){
        var uncheck = "cat_unapproved_" + (id);
        var checkboxElement = document.getElementById(uncheck);
        if(checkboxElement.checked){
            checkboxElement.checked = false;
        }
        else{
            checkboxElement.checked = true;
        }
    }

    function toggle_not_dislay_carousel(id){
        var uncheck = "carousel_unapproved_" + (id);
        var checkboxElement = document.getElementById(uncheck);
        if(checkboxElement.checked){
            checkboxElement.checked = false;
        }
        else{
            checkboxElement.checked = true;
        }
    }


    $(document).ready(function(){
    $("#display_article").hide();
    $("#approve_article").hide();
    $("#add_category").hide();
    $("#carousel_disp").hide();

    $("#edit_article").click(function(){
        if($("#approve_article").is(":visible")){
            $("#approve_article").slideToggle();
        }
        if($("#add_category").is(":visible")){
            $("#add_category").slideToggle();
        }
        if($("#carousel_disp").is(":visible")){
            $("#carousel_disp").slideToggle();
        }
      $("#display_article").slideToggle();
    });

    $("#app_article").click(function(){
        if($("#display_article").is(":visible")){
            $("#display_article").slideToggle();
        }
        if($("#add_category").is(":visible")){
            $("#add_category").slideToggle();
        }
        if($("#carousel_disp").is(":visible")){
            $("#carousel_disp").slideToggle();
        }
      $("#approve_article").slideToggle();
    });

    $("#add_cat").click(function(){
        if($("#display_article").is(":visible")){
            $("#display_article").slideToggle();
        }
        if($("#approve_article").is(":visible")){
            $("#approve_article").slideToggle();
        }
        if($("#carousel_disp").is(":visible")){
            $("#carousel_disp").slideToggle();
        }
      $("#add_category").slideToggle();
    });

    $("#carousel_display").click(function() {
        if($("#display_article").is(":visible")){
            $("#display_article").slideToggle();
        }
        if($("#approve_article").is(":visible")){
            $("#approve_article").slideToggle();
        }
        if($("#add_category").is(":visible")){
            $("#add_category").slideToggle();
        }
        $("#carousel_disp").slideToggle();
    })
});
</script>