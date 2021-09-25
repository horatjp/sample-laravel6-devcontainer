<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

class UploadImageControler extends Controller
{

    public function store()
    {

        \Debugbar::disable();


        $base64 = request()->get('base64');

        $tmpFile = tempnam(sys_get_temp_dir(), 'up');

        file_put_contents($tmpFile, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64)));

        $uploadFile = new \Illuminate\Http\UploadedFile($tmpFile, '');

        $data = array();


        try {

            // 画像情報取得
            $imageInfo = @getimagesize($uploadFile);

            if (!preg_match('/^image*/i', $imageInfo['mime'])) {
                throw new \Exception('画像ファイルを選択してください。');
            }

            // 画像ファイルを一時保存
            $uploadImage = new \App\Services\UploadImage();
            $data = $uploadImage->saveUploadFileTemporary($uploadFile);
        } catch (\Exception $e) {

            $data['error'] = $e->getMessage();
        }

        return response()->json($data);
    }
}
