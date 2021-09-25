<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;

class Article extends Model
{

    protected $table = 'article';

    protected $guarded = [];

    protected $dates = ['published_at'];

    public $timestamps = true;


    public function categorys()
    {
        return $this->belongsToMany(Category::class, 'article_category')->orderBy('priority');
    }

    public function delete() {

        $imagePath = $this->image;

        parent::delete();

        if ($imagePath) {

            // 画像処理
            $uploadImage = new \App\Services\UploadImage();

            $uploadImage->delete($imagePath);
        }
    }


    public static function getPagerBySearch($search = [])
    {

        $query = self::query();


        if (!empty($search['title'])) {
            $query->where('title', 'like', '%'.$search['title'].'%');
        }

        if (!empty($search['category_id'])) {

            $categoryId = $search['category_id'];

            $query->whereExists(function ($query) use($categoryId) {

                $query->select(DB::raw(1));
                $query->from('article_category');
                $query->whereRaw('article_category.article_id = article.id');

                $query->where('article_category.category_id', $categoryId);
            });
        }

        $query->orderBy('published_at', 'desc');


        return $query->paginate(config('backend.pager.default'));
    }
}
