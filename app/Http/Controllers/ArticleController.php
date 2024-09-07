<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Admin;
use App\Models\Article;
use App\Models\Category;
use App\Models\Category_type;
use App\Models\Comment;
use App\Models\like;
use App\Models\subcategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //weather
        //
        $weather = Storage::disk('public')->get('weather/weather.json');
        $weather = json_decode($weather);
        $weatherDate = Storage::disk('public')->lastModified('weather/weather.json');
        $weatherDate = date('Y-m-d H:i:s', $weatherDate);
        $dateNow = strtotime(date('Y-m-d H:i:s'));
        $weatherDate = strtotime($weatherDate);
        $diffSeconds = $dateNow - $weatherDate;

        if ($diffSeconds > 3600) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'http://api.openweathermap.org/data/2.5/weather?id=934570&APPID=xxxxx&units=metric');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($curl);
            curl_close($curl);
            Storage::put('weather/weather.json', $output);
            $weather = json_decode($output);
        }

        $categories = Category_type::whereNotIn('name', ['sidebar', 'opinion'])->get();
        $articlesByCategory = [];
        $results = collect();

        foreach ($categories as $category) {
            $articles = $category->articles()
                ->where('display', true)
                ->where('approved', true)
                ->get();

            $articles->each(function ($article) {
                $article->content = Storage::disk('public')->get($article->content);
            });

            $chunkedData = $articles->chunk(3)->map(function ($chunk) {
                return $chunk->values();
            });

            $articlesByCategory[$category->id] = $chunkedData;

            $latestArticle = $category->articles()
                ->where('display', true)
                ->where('approved', true)
                ->latest('created_at')
                ->first();

            if ($latestArticle) {
                $results->push((object) [
                    'category_id' => $category->id,
                    'category_name' => $category->name,
                    'article_id' => $latestArticle->id,
                    'article_title' => $latestArticle->title,
                    'image' => $latestArticle->image,
                ]);
            }
        }

        $sidebar = Article::where('display', true)
            ->where('approved', true)
            ->whereHas('categories', function ($query) {
                $query->where('name', 'sidebar')
                    ->where('name', '!=', 'opinion');
            })->get();

        foreach ($sidebar as $value) {
            $data = Storage::disk('public')->get($value->content);
            $value->content = $data;
        }

        $sidebar = collect($sidebar)->chunk(2)->map(function ($chunk) {
            return $chunk->values();
        });

        $opinion = Article::where('display', true)->
            where('approved', true)
                ->whereHas('categories', function ($query) {
                    $query->where('name', 'opinion')
                        ->where('name', '!=', 'sidebar');
                })->get();

        $menu = Article::where('display', true)
            ->where('approved', true)
            ->whereHas('categories', function ($query) {
                $query->where('name', 'Living')
                    ->whereHas('subcategories', function ($subQuery) {
                        $subQuery->where('subcategory', 'recipe');
                    });
            })
            ->orderBy('created_at', 'DESC')
            ->first();

        $menu->content = Storage::disk('public')->get($menu->content);

        $carousel = Article::where('carousel_display', true)->where('display', true)->where('approved', true)->get();
        foreach ($carousel as $value) {
            $data = Storage::disk('public')->get($value->content);
            $value->content = $data;
        }

        $results = $results->values();
        $articles = Article::hydrate($results->toArray());

        return view('home', ['data' => $articlesByCategory, 'category' => $categories, 'sidebar' => $sidebar, 'carousel' => $carousel, 'perCat' => $articles, 'opinion' => $opinion, 'menu' => $menu, 'weather' => $weather]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category_type = Category_type::all();
        $subcat = subcategory::all()->groupBy('cID');

        return view('write', ['category_type' => $category_type, 'subcategory' => $subcat]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ]);
        $file_path = 'article/'.str_replace(' ', '_', $request->title).'_'.(string) Auth::id().$request->_token.'_text.txt';
        $image_path = str_replace(' ', '_', $request->title).'_'.(string) Auth::id().$request->_token.'_image.';
        $video_path = str_replace(' ', '_', $request->title).'_'.(string) Auth::id().$request->_token.'_video.';
        $audio_path = str_replace(' ', '_', $request->title).'_'.(string) Auth::id().$request->_token.'_audio.';
        Storage::put($file_path, $request->content);

        if ($request->hasFile('image')) {
            $image_name = str_replace(' ', '_', $request->title).'_'.(string) Auth::id().$request->_token.'_image.'.$request->file('image')->extension();
            $image_path = $image_path.$request->file('image')->extension();
            Storage::putFileAs('image', $request->file('image'), $image_name);
            $image_path = 'image/'.$image_path;
        } else {
            $image_path = null;
        }

        if ($request->hasFile('video')) {
            $video_name = str_replace(' ', '_', $request->title).'_'.(string) Auth::id().$request->_token.'_video.'.$request->file('video')->extension();
            $video_path = $video_path.$request->file('video')->extension();
            Storage::putFileAs('video', $request->file('video'), $video_name);
            $video_path = 'video/'.$video_path;
        } else {
            $video_path = null;
        }

        if ($request->hasFile('audio')) {
            $audio_name = str_replace(' ', '_', $request->title).'_'.(string) Auth::id().$request->_token.'_audio.'.$request->file('audio')->extension();
            $audio_path = $audio_path.$request->file('audio')->extension();
            Storage::putFileAs('audio', $request->file('audio'), $audio_name);
            $audio_path = 'audio/'.$audio_path;
        } else {
            $audio_path = null;
        }

        $article = Article::create([
            'title' => $request->title,
            'content' => $file_path,
            'image' => $image_path, //$request->file('image'),
            'video' => $video_path, //$request->file('video'),
            'audio' => $audio_path, //$request->file('audio'),
            'writeby' => Auth::id(),
            'approved' => false,
            'display' => true,
            'approved_time' => null,
            'approvedby' => null,
        ]);
        $category = str_replace('Tag(s):', '', $request->category);
        $array_cat = explode(', ', $category);
        foreach ($array_cat as $value) {
            $value = ltrim($value);
            $value = rtrim($value);
            $cat = DB::table('category')->where('name', $value)->first();
            if ($cat) {
                foreach ($request->subcat as $s) {
                    $s = json_decode($s);
                    if ($s->cID == $cat->id) {
                        $cat_insert = Category::create([
                            'aID' => $article->id,
                            'cID' => $cat->id,
                            'sID' => $s->id,
                        ]);
                    }
                }
            }
        }

        return redirect('account');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        $exist = false;
        if (Auth::id()) {
            $exist = Admin::where('uID', Auth::id())->exists();
        }
        //category the article belong
        if (($article->approved && $article->display) || $exist) {
            $category_string = [];
            $related_article = [];
            $subcat = [];
            $data = Storage::disk('public')->get($article->content);
            $article->content = $data;
            $cat = Category::where('aID', $article->id)->get();
            if ($cat) {
                foreach ($cat as $value) {
                    if ($value) {
                        $cat_temp = Category_type::where('id', $value->cID)->first();
                        $sub_cat_temp = subcategory::where('id', $value->sID)->first();
                        $r = Category::where('cID', $value->cID)->whereNot('aID', $article->id)->first();

                        if ($cat_temp) {
                            if ($cat_temp->name != 'sidebar' && $cat_temp->name != 'opinion') {
                                array_push($category_string, $cat_temp->name);
                            }
                        }

                        if ($sub_cat_temp) {
                            $sub_cat_temp->cID = $cat_temp->name;
                            array_push($subcat, $sub_cat_temp);
                        }

                        if ($r) {
                            $related_art = article::where('id', $r->aID)->first();
                            if ($related_art) {
                                if (! in_array($related_art, $related_article)) {
                                    $data = Storage::disk('public')->get($related_art->content);
                                    $related_art->content = $data;
                                    array_push($related_article, $related_art);
                                }
                            }
                        }
                    }
                }
            }
            //comment on the article
            $username = [];
            $comment = Comment::where('aID', $article->id)->get();
            if ($comment) {
                foreach ($comment as $value) {
                    $usr = User::where('id', $value->uID)->first();
                    if ($usr) {
                        array_push($username, $usr->name);
                    }
                }
            }

            //writer information
            $writer = User::where('id', $article->writeby)->first();
            $role = Admin::where('uID', $article->writeby)->first();

            //count number of article published by writer
            $countArticle = Article::where('writeby', $article->writeby)->count();

            //previous and next article
            $nextArticle = Article::where('created_at', '>', $article->created_at)->where('display', true)->where('approved', true)->orderBy('created_at')->first();
            $previousArticle = Article::where('created_at', '<', $article->created_at)->where('display', true)->where('approved', true)->orderBy('created_at', 'desc')->first();

            return view('read', ['data' => $article, 'category' => array_unique($category_string), 'username' => $username, 'comment' => $comment, 'writer' => $writer, 'role' => $role, 'count' => $countArticle, 'next' => $nextArticle, 'previous' => $previousArticle, 'related' => $related_article, 'subcategory' => $subcat]);
        } else {
            return redirect('home');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $data = Storage::disk('public')->get($article->content);
        $article->content = $data;
        $article->content = str_replace("'", "\'", $article->content);
        $article->content = str_replace('"', '"', $article->content);
        if ($article->video) {
            if (str_contains($article->content, '<video')) {
                $pattern = '/<video.*?\/video>/i';
                $replacement = '#video#';
                $article->content = preg_replace($pattern, $replacement, $article->content);
            }
        }
        $category_string = [];
        $subcat = [];
        $subcatall = subcategory::all()->groupBy('cID');
        $cat = Category::where('aID', $article->id)->get();
        if ($cat) {
            foreach ($cat as $value) {
                if ($value) {
                    $cat_temp = Category_type::where('id', $value->cID)->first();
                    if ($cat_temp) {
                        array_push($category_string, $cat_temp->name);
                    }
                    $sub = subcategory::where('id', $value->sID)->first();
                    if ($sub) {
                        array_push($subcat, $sub);
                    }
                }
            }
        }
        $category_type = Category_type::all();

        return view('edit', ['data' => $article, 'category' => $category_string, 'category_type' => $category_type, 'subcategory' => $subcat, 'subcatall' => $subcatall]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request)
    {
        $article = Article::where('id', $request->article_id)->first();
        if ($article) {
            foreach ($request->all() as $key => $value) {
                if ($key == 'image') {
                    $ext = $request->file('image')->extension();
                    $image_path = str_replace(' ', '_', $request->title).'_'.(string) Auth::id().$request->_token.'_image.'.$ext;
                    if ($article->image) {
                        Storage::delete($article->image);
                    }
                    Storage::putFileAs('image', $request->file('image'), $image_path);
                    $image_path = 'image/'.$image_path;
                    $article->update([
                        'image' => $image_path,
                    ]);
                } elseif ($key == 'video') {
                    $ext = $request->file('video')->extension();
                    $video_path = str_replace(' ', '_', $request->title).'_'.(string) Auth::id().$request->_token.'_video.';
                    if ($article->video) {
                        Storage::delete($article->video);
                    }
                    Storage::putFileAs('video', $request->file('video'), $video_path);
                    $video_path = 'video/'.$video_path;
                    $article->update([
                        'video' => $video_path,
                    ]);
                } elseif ($key == 'audio') {
                    $ext = $request->file('audio')->extension();
                    $audio_path = str_replace(' ', '_', $request->title).'_'.(string) Auth::id().$request->_token.'_audio.';
                    if ($article->audio) {
                        Storage::delete($article->audio);
                    }
                    Storage::putFileAs('audio', $request->file('audio'), $audio_path);
                    $audio_path = 'audio/'.$audio_path;
                    $article->update([
                        'audio' => $audio_path,
                    ]);
                } elseif ($key == 'content') {
                    $file_path = 'article/'.str_replace(' ', '_', $request->title).'_'.(string) Auth::id().$request->_token.'_text.txt';
                    Storage::delete($article->content);
                    Storage::put($file_path, $request->content);
                    $article->update([
                        'content' => $file_path,
                    ]);
                } elseif ($key == 'category') {
                    $category = str_replace('Tag(s):', '', $request->category);
                    $array_cat = explode(', ', $category);
                    foreach ($array_cat as $value) {
                        $value = ltrim($value);
                        $value = rtrim($value);
                        $cat = Category_type::where('name', $value)->first();
                        foreach ($request->subcat as $s) {
                            $s = json_decode($s);
                            if ($s->cID == $cat->id) {
                                if (! category::where('aID', $article->id)->where('cID', $cat->id)->where('sID', $s->id)->first()) {
                                    $cat_insert = Category::create([
                                        'aID' => $article->id,
                                        'cID' => $cat->id,
                                        'sID' => $s->id,
                                    ]);
                                }
                            }
                        }
                    }
                } elseif ($key == 'remove_image') {
                    Storage::delete($article->image);
                    $article->update([
                        'image' => null,
                    ]);
                } elseif ($key == 'remove_audio') {
                    Storage::delete($article->audio);
                    $article->update([
                        'audio' => null,
                    ]);
                } elseif ($key == 'remove_video') {
                    Storage::delete($article->video);
                    $article->update([
                        'video' => null,
                    ]);
                }
            }
            $article->update([
                'approved' => false,
                'approvedby' => null,
                'approved_time' => null,
                'title' => $request->title,
                'display' => false,
            ]);
            $article->save();
        }

        return redirect('account');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        like::where('aID', $article->id)->delete();
        Category::where('aID', $article->id)->delete();
        Comment::where('aID', $article->id)->delete();
        Article::where('id', $article->id)->delete();

        return redirect('account');
    }

    public function toggle_display(UpdateArticleRequest $req)
    {
        foreach ($req->all() as $key => $value) {
            if ($key != '_token') {
                if (str_contains($key, 'uncheck_')) {
                    $key = str_replace('uncheck_', '', $key);
                    echo $key;
                    $article = Article::where('id', $key)->first();
                    if ($article) {
                        if ($value == 'on') {
                            $article->update([
                                'display' => 0,
                            ]);
                            $article->save();
                        }
                    }
                } else {
                    $article = Article::where('id', $key)->first();
                    if ($article) {
                        if ($value == 'on') {
                            echo 'change';
                            $article->update([
                                'display' => 1,
                            ]);
                            $article->save();
                        }
                    }
                }
            }
        }

        return redirect('account');
    }

    public function toggle_approve(UpdateArticleRequest $request)
    {
        foreach ($request->all() as $key => $value) {
            if ($key != '_token') {
                if (str_contains($key, 'unapproved_')) {
                    $key = str_replace('unapproved_', '', $key);
                    $article = Article::where('id', $key)->first();
                    if ($article) {
                        if ($value == 'on') {
                            $article->update([
                                'approved' => 0,
                                'approvedby' => null,
                                'approved_time' => null,
                            ]);
                            $article->save();
                        }
                    }
                } else {
                    $key = str_replace('approved_', '', $key);
                    $article = Article::where('id', $key)->first();
                    if ($article) {
                        if ($value == 'on') {
                            echo 'change';
                            $article->update([
                                'approved' => 1,
                                'approvedby' => Auth::id(),
                                'approved_time' => date('Y-m-d H:i:s'),
                            ]);
                            $article->save();
                        }
                    }
                }
            }
        }

        return redirect('account');
    }

    public function display_carousel(UpdateArticleRequest $request)
    {
        $count = 0;
        Article::query()->update(['carousel_display' => 0]);
        foreach (array_reverse($request->all()) as $key => $value) {
            if ($key != '_token') {
                if (str_contains($key, 'carousel_approved_')) {
                    $key = str_replace('carousel_approved_', '', $key);
                    $article = Article::where('id', $key)->
                                        where('display', true)->
                                        where('approved', true)->first();
                    if ($article) {
                        if ($value == 'on' && $count < 3) {
                            $count++;
                            echo 'change';
                            $article->update([
                                'carousel_display' => 1,
                            ]);
                            $article->save();
                        }
                    }
                }
            }
        }

        return redirect('account');
    }

    public function per_category_display($ct)
    {
        $category = Category_type::where('id', $ct)->first();
        $subCategory = subcategory::where('cID', $ct)->get();
        $count = Article::count();
        $article = Article::where('display', true)
            ->where('approved', true)
            ->whereHas('categories', function ($query) use ($ct) {
                $query->where('category.id', $ct);
            })
            ->orderBy('created_at', 'desc')
            ->take(4) // Limit to the first 4 results
            ->get();

        $remainingArticles = Article::where('display', true)
            ->where('approved', true)
            ->whereHas('categories', function ($query) use ($ct) {
                $query->where('category.id', $ct);
            })
            ->orderBy('created_at', 'desc')
            ->get()->skip(4);

        foreach ($article as $value) {
            $data = Storage::disk('public')->get($value->content);
            $value->content = $data;
        }

        foreach ($remainingArticles as $value) {
            $data = Storage::disk('public')->get($value->content);
            $value->content = $data;
        }
        $subcatArticle = [];
        foreach ($subCategory as $sc) {
            $subArticle = Article::where('display', true)
                ->where('approved', true)
                ->whereHas('subcategories', function ($query) use ($sc) {
                    $query->where('subcategories.id', $sc->id);
                })
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            $subcatArticle[$sc->id] = $subArticle;
        }

        return view('section', ['article' => $article, 'category' => $category, 'subcategory' => $subCategory, 'remainingArticles' => $remainingArticles, 'subcategoryArticle' => $subcatArticle]);
    }

    public function per_subcat_display(subcategory $subcategory)
    {
        $subArticle = Article::where('display', true)
            ->where('approved', true)
            ->whereHas('subcategories', function ($query) use ($subcategory) {
                $query->where('subcategories.id', $subcategory->id);  // Filter by subcategory ID
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('subcategory', ['subcategory' => $subcategory, 'subcategoryArticle' => $subArticle]);

    }

    public function search_article(Request $request)
    {
        $query = $request->input('query');
        $articles = Article::search($query)->get(); // Retrieve search results
        foreach ($articles as $value) {
            $data = Storage::disk('public')->get($value->content);
            $value->content = $data;
        }

        return view('search', ['article' => $articles]);
    }
}
