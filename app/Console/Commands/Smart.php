<?php

namespace App\Console\Commands;

use BaiduSmartapp\OpenapiClient\GetAccessToken;
use BaiduSmartapp\OpenapiClient\GetAccessTokenRequest;
use GuzzleHttp\Client;
use App\Models\Article;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Smart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $baidu;
    protected $key;
    protected $expiredAt;
    protected $yesterday;
    protected $array;
    protected $signature = 'smart {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '百度小程序推送';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->key          = 'smart_'.date('Y-m-d', time());
        $this->expiredAt    = now()->addMinutes(1680);
        $this->yesterday    = 'smart_'.date("Y-m-d", strtotime("-1 day"));
        $today              = Cache::get($this->key);
        $yesterday          = Cache::get($this->yesterday);
        $this->array        = $today ? $today : $yesterday;
        
        $baidu              = Cache::get('smart_baidu');
        $this->baidu        = $baidu ? $baidu : $this->main();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $action   = $this->argument('action');
        if ($action == 'day')
        {
            $this->day();
        }
        
        // 周级推送
        if ($action == 'week')
        {
            $this->week();
        }
    }
    
    function day()
    {
        $data = $this->array ? $this->array : []; 
        
        $count  = DB::table('articles')->count();
        $num    = ceil($count/10);
        $num    = ceil($count/10);
        $data['count']   = $count;
        $data['num']     = $num;
        
        if (array_key_exists('page', $data))
        {
            $data['page']    += 1;
        } else {
            $data['page']    = 1;
        }
        $skip   = $data['page'] * 10;
            
        $key    = [];
        $articles   = DB::table('articles')->select('id')->orderBy('id', 'asc')->skip($skip)->take(10)->get()->toArray();
        foreach ($articles as $v)
        {
            $key[]  = '/pages/show/index?id='.$v->id;
        }
        $data['day']['link']    = $key;
        $data['day']['res']     = $this->check($key, 'day');
        if ($data['day']['res']['msg'] == 'success'){
            Cache::put($this->key, $data, $this->expiredAt);
        }
        
        print_r($data);
        return true;
    }
    
    function week()
    {
        $data = $this->array ? $this->array : []; 
        
        $count  = DB::table('articles')->count();
        $num    = ceil($count/10);
        $data['count']   = $count;
        $data['num']     = $num;
        
        if (array_key_exists('page', $data))
        {
            $data['page']    = $data['page'] + 1;
        } else {
            $data['page']    = 1;
        }
        
        $skip   = $data['page'] * 10;
            
        $key    = [];
        $articles   = DB::table('articles')->select('id')->orderBy('id', 'asc')->skip($skip)->take(10)->get()->toArray();
        foreach ($articles as $v)
        {
            $key[]  = '/pages/show/index?id='.$v->id;
        }
        $data['week']['link']    = $key;
        $data['week']['res']     = $this->check($key, 'week');
        if ($data['week']['res']['msg'] == 'success'){
            Cache::put($this->key, $data, $this->expiredAt);
        }
        print_r($data);
        return true;
    }
    
    function main()
    {
        $obj = new GetAccessToken();
        // 开发者在此设置请求参数，文档示例中的参数均为示例参数，实际参数请参考对应接口的文档上方的参数说明填写
        // 注意：代码示例中的参数字段基本是驼峰形式，而文档中的参数说明的参数字段基本是下划线形式
    	// 如果开发者不想传非必需参数，可以将设置该参数的行注释
        $params = new GetAccessTokenRequest();
        $params->grantType = "client_credentials"; // 文档中对应字段：grant_type，实际使用时请替换成真实参数
        $params->clientId = "pi3dRiO4jN9tlESsOyDmkTu2EarYZUPy"; // 文档中对应字段：client_id，实际使用时请替换成真实参数
        $params->clientSecret = "z7HkUHhtEH1y7ZA6N45UcrMiTDC51WXO"; // 文档中对应字段：client_secret，实际使用时请替换成真实参数
        $params->scope = "smartapp_snsapi_base"; // 文档中对应字段：scope，实际使用时请替换成真实参数
    
        if ($obj->doRequest($params)){
            // 如果请求成功 可以直接通过 getData 方法获取到返回结构体里的 data 字段值
            Cache::put('smart_baidu', $obj->getData(), now()->addMinutes(1680));
            $this->baidu    = $obj->getData();
            // 如果请求成功 可以通过 getErrMsg 方法获取到完整的响应信息
            var_dump($obj->getErrMsg());
        } else {
            // 如果请求失败 可以直接通过 getErrMsg 方法获取到报错信息，辅助问题定位
            var_dump($obj->getErrMsg());
        }
    }

    function check($urls, $class)
    {
        if ($class == 'day')
        {
            $data['type'] = 1;
        }
        
        if ($class == 'week')
        {
            $data['type'] = 0;
        }
        
        $data['url_list'] = implode(",", $urls);
        $api = 'https://openapi.baidu.com/rest/2.0/smartapp/access/submitsitemap/api?access_token='.$this->baidu['access_token'];
        $ch = curl_init();
        $options =  array(
            CURLOPT_URL => $api,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_NOBODY => false,
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_HTTPHEADER => array('Content-Type: application/x-www-form-urlencoded'),
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        
        return json_decode($result, true);
    }
}
