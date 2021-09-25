<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Exception, DB, Carbon\Carbon, Image;
use App\Models\Article;

use App\Http\Requests\Backend\ArticleUpdateRequest;

class ArticleController extends Controller
{

    public function index()
    {

        session()->forget('searchArticle');

        return $this->list();
    }

    /**
     * 一覧
     */
    public function list()
    {

        if (request()->get('search')) {
            $search = request()->get('search');
            session()->put('searchArticle', $search);
        } else {
            $search = session()->get('searchArticle');
            request()->merge(['search' => $search]);
        }


        $articles = Article::getPagerBySearch($search);

        return view('backend.article.list', ['articles' => $articles]);
    }

    /**
     * 編集
     */
    public function edit($id = null, $page = 1)
    {

        // デフォルト値設定
        if (!request()->old('_token')) {

            if ($article = Article::find($id)) {

                $inputs = $article->getAttributes();

                $inputs['published_at'] = $article->published_at->format('Y/m/d H:i');

                session()->flashInput($inputs);
            } else {

                $inputs = [];
                $inputs['published_at'] = date('Y/m/d H:i');

                session()->flashInput($inputs);
            }

            session()->flashInput(array_merge(request()->old(), ['page' => request()->get('page')]));
        }


        return view('backend.article.edit', ['id' => $id]);
    }


    /**
     * 編集実行
     */
    public function update(ArticleUpdateRequest $articleUpdateRequest, $id = null)
    {

        try {

            $articleData = [];

            foreach (DB::getSchemaBuilder()->getColumnListing('article') as $column) {

                if (array_key_exists($column, request()->all())) {

                    $articleData[$column] = request()->get($column);
                }
            }

            $articleData['published_at'] = Carbon::parse($articleData['published_at']);

            $article = Article::find($id);

            if (!$article) {
                $article = new Article();
            }


            // 画像処理
            $uploadImage = new \App\Services\UploadImage();

            // 画像がある場合
            if (request()->get('image')) {

                if ($article->image != request()->get('image')) {

                    // 画像ファイルを保存
                    $imageResult = $uploadImage->save(request()->get('image'));

                    $articleData['image'] = $imageResult['path'];

                    $imagePathDelete = $article->image;
                }
            }

            // 画像がない場合
            if (empty(request()->get('image'))) {

                $imagePathDelete = $article->image;

                $articleData['image'] = null;
            }


            $article->fill($articleData);
            $article->save();


            // 画像削除
            if (!empty($imagePathDelete)) {
                $uploadImage->delete($imagePathDelete);
            }
        } catch (Exception $e) {

            return redirect()->route('backend.article.edit', ['id' => $id])->withErrors(['message' => $e->getMessage()])->withInput();
        }

        return redirect()->route('backend.article.show', ['id' => $article->id, 'page=' . request()->get('_page')]);
    }


    /**
     * 詳細
     */
    public function show($id, $page = 1)
    {

        $article = Article::find($id);
        if (!$article) {
            return redirect()->route('backend.article.list', ['page=' . request()->get('page')]);
        }


        $data = array();
        $data['article'] = $article;
        $data['page'] = $page;


        return view('backend.article.show', $data);
    }

    /**
     * 表示変更
     */
    public function changeActive($id, $page = 1)
    {

        $article = Article::find($id);
        $article->active = !$article->active;
        $article->save();

        return redirect()->route('backend.article.list', ['page=' . request()->get('page')]);
    }

    /**
     * 順番変更
     */
    public function changePriority($page = 1)
    {

        foreach (request()->get('priority') as $id => $value) {

            if (is_numeric($value)) {
                $article = Article::find($id);
                $article->priority = $value;
                $article->save();
            }
        }


        return redirect()->route('backend.article.list', ['page=' . request()->get('page')]);
    }


    /**
     *  削除
     */
    public function destroy($id, $page = 1)
    {

        $article = Article::find($id);
        $article->delete();

        return redirect()->route('backend.article.list', ['page=' . request()->get('page')]);
    }
}
