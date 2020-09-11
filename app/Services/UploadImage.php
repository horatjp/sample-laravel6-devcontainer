<?php namespace App\Services;

use Image, File;

use Illuminate\Support\Str;

class UploadImage
{

    protected $config;
    protected $thubnailName = 'thumbnail_';

    public function __construct($type = null)
    {
        if ($type && isset(config('upload.image')[$type])) {

            $this->config = config('upload.image')[$type];

        } else {

            $this->config = config('upload.image')['default'];
        }

        File::makeDirectory($this->config['path'], 0777, true, true);
        File::makeDirectory($this->config['tmpPath'], 0777, true, true);
    }

    /*
     * アップロードファイルをテンポラリに保存
     */
    public function saveUploadFileTemporary($uploadFile)
    {

        // 拡張子設定
        $mimeExtensions = ['image/gif' => 'gif', 'image/jpeg' => 'jpg', 'image/png' => 'png'];

        $imageInfo = @getimagesize($uploadFile);  // 画像情報取得

        if (isset($mimeExtensions[$imageInfo['mime']])) {
            $fileExtension = $mimeExtensions[$imageInfo['mime']];
        } else {
            $fileExtension = strtolower($uploadFile->getClientOriginalExtension());
        }

        $fileMark = Str::random(10);


        $imagePath = $this->config['tmpPath'].'/'.$fileMark.'.'.$fileExtension;
        $imageThumbnailPath = $this->config['tmpPath'].'/'.$this->thubnailName.$fileMark.'.'.$fileExtension;

        // ファイル移動
        File::move($uploadFile, public_path().'/'.$imagePath);

        // サムネイル作成
        Image::make(public_path().'/'.$imagePath)->resize(500, 500, function ($constraint) {

            $constraint->aspectRatio();
            $constraint->upsize();

        })->save(public_path().'/'.$imageThumbnailPath);



        $data = array();


        $data['original_path'] = $imagePath;
        $data['path'] = $imageThumbnailPath;


        return $data;
    }


    /*
     * ファイルを保存
     */
    public function save($imagePath)
    {

        // サムネイルの場合 オリジナルへ
        $imagePath = str_replace($this->thubnailName, '', $imagePath);

        $saveImagePath = $this->config['path'].'/'.basename($imagePath);


        $data = [];

        Image::make(public_path().'/'.$imagePath)
            ->resize($this->config['size']['width'], $this->config['size']['height']
                 ,function ($constraint) {
                      $constraint->aspectRatio();
                      $constraint->upsize();

                 })->save(public_path().'/'.$saveImagePath);

        $data['path'] = $saveImagePath;

        $data['pathOhers'] = [];

        // サイズ毎
        foreach ($this->config['sizeOthers'] as $key => $size) {

            $filename = preg_replace('/(.*?)(\.(.*?))$/', '${1}_'.$key.'${2}', basename($imagePath));

            $filePath = $this->config['path'].'/'.$filename;

            Image::make(public_path().'/'.$imagePath)
                ->resize($size['width'], $size['height']
                     ,function ($constraint) {
                          $constraint->aspectRatio();
                          $constraint->upsize();

                     })->save(public_path().'/'.$filePath);

            $data['pathOhers'][$key] = $filePath;
        }


        return $data;
    }

    /*
     * ファイルを削除
     */
    public function delete($imagePath)
    {

        if (file_exists(public_path().'/'.$imagePath)) {
            unlink(public_path().'/'.$imagePath);
        }

        foreach ($this->config['sizeOthers'] as $key => $value) {

            $imagePathOther = preg_replace('/(.*?)(\.(.*?))$/', '${1}_'.$key.'${2}', $imagePath);

            if (file_exists(public_path().'/'.$imagePathOther)) {
                unlink(public_path().'/'.$imagePathOther);
            }
        }
    }
}
