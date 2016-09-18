<?php

namespace App\Http\Controllers\Admin;

use App\Models\Comment;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use Requests;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
//    public $signNature = '';
////
//    public $callBackUrl = 'http://api.duoshuo.com/log/list.json';
////
//    public $shortName = 'iphpt';
////
//    public $secret      = 'e0dd247d8feab69c43985ab89d454016';



    private $short_name = 'iphpt';
    private $secret = 'e0dd247d8feab69c43985ab89d454016';
    private $get_data_limit;
    public $last_log_id = 0;
    /**
     *
     * 获取评论数据
     *
     */
    public function sync_log() {
        Log::info('123456789');
        if ($this->check_signature($_POST)) {
            Log::info('2222224444444422');
            $limit = 20;

            $params = array(
                'limit' => $limit,
                'order' => 'asc',
            );


            $posts = array();

            if (!$this->last_log_id)
                $this->last_log_id = 0;

            $params['since_id'] = $this->last_log_id;
            //自己找一个php的 http 库

            $response = Requests::get( 'http://api.duoshuo.com/log/list.json', $params);

            if (!isset($response['response'])) {
                //处理错误,错误消息$response['message'], $response['code']
                //...
                Log::info('22222222');
            } else {
                Log::info(json_encode($response['response']));
                //遍历返回的response，你可以根据action决定对这条评论的处理方式。
                foreach($response['response'] as $log){

                    switch($log['action']){
                        case 'create':
                            //这条评论是刚创建的
                            break;
                        case 'approve':
                            //这条评论是通过的评论
                            break;
                        case 'spam':
                            //这条评论是标记垃圾的评论
                            break;
                        case 'delete':
                            //这条评论是删除的评论
                            break;
                        case 'delete-forever':
                            //彻底删除的评论
                            break;
                        default:
                            break;
                    }

                    //更新last_log_id，记得维护last_log_id。（如update你的数据库）
                    if (strlen($log['log_id']) > strlen($this->last_log_id) || strcmp($log['log_id'], $this->last_log_id) > 0) {
                        $this->last_log_id = $log['log_id'];
                    }

                }


            }


        }
    }

    /**
     *
     * 检查签名
     *
     */
    public function check_signature($input){

        $signature = $input['signature'];
        unset($input['signature']);

        ksort($input);
        $baseString = http_build_query($input, null, '&');
        $expectSignature = base64_encode($this->hmacsha1($baseString, $this->secret));
        if ($signature !== $expectSignature) {
            return false;
        }
        return true;
    }

    // from: http://www.php.net/manual/en/function.sha1.php#39492
    // Calculate HMAC-SHA1 according to RFC2104
    // http://www.ietf.org/rfc/rfc2104.txt
   public function hmacsha1($data, $key) {
        if (function_exists('hash_hmac'))
            return hash_hmac('sha1', $data, $key, true);

        $blocksize=64;
        if (strlen($key)>$blocksize)
            $key=pack('H*', sha1($key));
        $key=str_pad($key,$blocksize,chr(0x00));
        $ipad=str_repeat(chr(0x36),$blocksize);
        $opad=str_repeat(chr(0x5c),$blocksize);
        $hmac = pack(
            'H*',sha1(
                ($key^$opad).pack(
                    'H*',sha1(
                        ($key^$ipad).$data
                    )
                )
            )
        );
        return $hmac;
    }






























//    public function getCallBackComment()
//    {
//        $ch = curl_init();
//
//        $url = $this->callBackUrl.'?short_name='.$this->shortName.'&secret='.$this->secret;
//
//        curl_setopt($ch,CURLOPT_URL,$url);
//        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
//        curl_setopt($ch,CURLOPT_HEADER,0);
//
//        $output = curl_exec($ch);
//
//        return $output;
//    }
//
//    public function postComment(Request $request)
//    {
//        if ($this->signNature == $request->get('signature')) {
//            $this->getCallBackComment();
//        } else {
//
//        }
//    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('Admin.Comment.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
