<?php
/**
 * Created by PhpStorm.
 * User:ttt
 * Date: 2019/10/29
 * Time: 17:10
 */
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Handlers\ImageUploadHandler;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    /**
     * 富文本编辑器上传图片
     * @param Request $request
     * @param ImageUploadHandler $uploader
     * @return array
     */
    public function upImage(Request $request, ImageUploadHandler $uploader)
    {

        // 初始化返回数据，默认是失败的
        $data = ['errno'=> 1];
        // 判断是否有上传文件，并赋值给 $file
        if ($file = $request->upload) {
            // 保存图片到本地，参数分别是：文件，目标文件夹，文件前缀，文件最大宽度
            $result = $uploader->save($request->upload, 'articleimg', 'admin', 650);
            // 图片保存成功的话
            if ($result) {
                $data['data'][] = $result['path'];
                $data['errno']   = 0;
            }
        }

        return $result['path'];
    }
}