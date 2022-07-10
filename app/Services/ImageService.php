<?php

namespace App\Services;

use Illuminate\Support\Str;

abstract class ImageService
{
    // base64からイメージファイルを生成し、ローカル環境へ保存
    static function handleBase64(String $image, String $fileName)
    {
        // ファイル名を名前と拡張子に分離
        $NameAndExtension = explode(".", $fileName);

        // ローカル環境に保存するファイル名を生成
        $RandomStr = Str::random(10);

        // バックエンド側に保存するファイル名作成
        $saveFile = $NameAndExtension[0] . '-' . $RandomStr . '.' . $NameAndExtension[1];

        // ファイル名を含めた保存先のパス
        $path = storage_path('postImages/' . $saveFile);

        // base64のデータから、データの中身だけを取得
        $convertedData = str_replace(' ', '+', preg_replace('/^data:image.*base64,/', '', $image));

        // 画像ファイルを生成し、ローカル環境に保存(パス, ファイルの名前(拡張子も含む), ファイルの中身)
        file_put_contents(storage_path('postImages/' . $saveFile), base64_decode($convertedData));

        // ここから下はフロント側からデータを受け取るのではなく、API側で作成したエクセルファイル等をレスポンスで返す際に必要
        $mimeType = mime_content_type($path);

        // DBに保存するbase64のイメージデータを作成
        $base64Image = 'data:' . $mimeType . ';base64,' . base64_encode(file_get_contents($path));

        return $base64Image;
    }

    //  最初は下記のようにフロント側でファイル本体を渡したものをAPI側でエンコードしていた。
    //  Update時にイメージファイルを更新しない場合には個別の処理が必要になる為、上記のようにフロント側でbase64に変換したものを扱う方がわかりやすい。

    // /**
    //  * 画像ファイルをローカル環境に保存。base64に変換し、DBのimageカラムに保存する準備を行う
    //  * @param  \Illuminate\Http\UploadedFile $image
    //  * @param  \Illuminate\Http\String $fileName
    //  * @return \Illuminate\Http\MediumText
    //  */

    // static function convertToBase64(UploadedFile $image, String $fileName)
    // {
    //     // ローカル環境に保存するファイル名を生成
    //     $saveFileName = Str::random(10) . '-' . $fileName;

    //     // ファイルの中身だけをエンコード
    //     $encodedData = base64_encode(file_get_contents($image));
    //     // ファイルの中身をデコード
    //     $decodedData = base64_decode($encodedData);

    //     // ファイル名を含めた保存先のパス
    //     $path = storage_path('postImages/' . $saveFileName);

    //     // 画像ファイルを生成し、ローカル環境に保存(パス, ファイルの名前(拡張子も含む), ファイルの中身)
    //     file_put_contents(storage_path('postImages/' . $saveFileName), $decodedData);

    //     $mimeType = mime_content_type($path);

    //     // DBに保存するbase64データを作成
    //     $base64Data = 'data:' . $mimeType . ';base64,' . base64_encode(file_get_contents($path));

    //     return $base64Data;
    // }
}