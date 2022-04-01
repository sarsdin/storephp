<?php

namespace App\Controllers;


use App\Models\Notice;
use App\Models\PostTest;
use App\Models\Users;
use CodeIgniter\Database\Exceptions\DataException;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\IncomingRequest;
use Config\Paths;

class Home extends BaseController
{
    public $testProps;

    public function __construct()
    {
        $tmpString = mb_str_split("문자열랜덤생성하기우후훗");
        shuffle($tmpString);
        $tmpString = implode('', $tmpString);
        $resData = [];

        $data = [
            "no" => 0,
            "title" => "제목나오는곳",
            "writer" => substr($tmpString,0, 3), //php에서 한글문자를 substr로 자르면 깨짐. 이유는 한글이 utf-8에서
            "date" => date("Y-m-d"),                //3byte이기때문.
            "hit" => 123,
            "content" => "본문"
        ];

        for ($i=0; $i<10; $i++) {
            $data['no'] = $i;
            $data['title'] = "제목나오는곳".$i;
            $data['writer'] = mb_substr($tmpString, 0, 3); //그래서 멀티byte단위의 문자열처리를 하기위해 mbstring 확장함수를 사용해야한다.
            $data['date'] = date("Y-m-d");
            $data['hit'] = $i*$i;
            $data['content'] = "content".$i;
            array_push($resData, $data);
        }
        $this->testProps = $resData;
    }

    public function index2()
    {
        return phpinfo();
    }
    public function index()
    {
      return view('../../public/dist/index.html');
    }

    public function join() : ResponseInterface
    {
        $users = new Users();
        $req = $this->request;
        $res = $this->response;
//        log_message("debug", "join req: ". print_r($req, true));
//        log_message("debug", "request getjson: ". print_r($req->getJSON(true), true));
//        log_message("debug", "requesturi: ".$req->uri);
//        log_message("debug", "requestURI path: " . $req->getUri()->getPath());
//        log_message("info", "requestData.userid: ".$req->getJSON()->user_id);

        try {
            $result = $users->insert($req->getPost());

            if ($result === false) {    //insert 작업이 실패할경우 false를 리턴하는데 이경우 users모델에 지정된 validation error메시지를 클라에 보낸다.
                return $res->setJSON([
                    'result' => $result,
                    'msg' => $users->errors()
                ]);

            } else {
                return $res->setJSON([
                    'result' => true,
                    'msg' => '회원가입 완료하였습니다. 가입한 아이디로 로그인해주세요.'
                ]);
            }

        } catch (\ReflectionException | DataException $e){
            return $res->setJSON($e->getMessage());
        }

//
//        try {
//            $result = $users->insert($req->getJSON(true));
//        } catch (\ReflectionException | DataException $e){
//
//            return $res->setJSON($e->getMessage());
//        }
//        return $res->setJSON($result);
    }

    public function login() : ResponseInterface
    {
        $users = new Users();
        $req = $this->request;
        $res = $this->response;

        log_message("debug", "ddd req: ". print_r($req, true));
        log_message("debug", "request getjson: ". print_r($req->getJSON(true), true));
        log_message("debug", "requesturi: ".$req->uri);
        log_message("debug", "requestURI path: " . $req->getUri()->getPath());
        log_message("info", "requestData.userid: ".$req->getJSON()->user_id);

        if ($this->request){
            if ($this->request->getJSON()) {
                $json = $this->request->getJSON();
                log_message("info", "requestJsonData.passwd: ".$json->user_pwd);
            }
        }

        $user = $req->getJson(true);
        $isUser = $users->find($user['user_id']);

        if ($isUser != null ) {
            $resData = [
                'result' => true,
                'msg' => $isUser['user_id'].'님 환영합니다.'
            ];
            if (count($users->where('user_pwd', $user['user_pwd'])->where('user_id', $user['user_id'])->findAll()) <= 0) {
                $resData['result'] = false;
                $resData['error'] = 'pwd';
                $resData['msg'] = '비밀번호가 일치하지 않습니다.';
            }

        } else {
            $resData = [
                'result' => false,
                'error' => 'id',
                'msg' => '해당 아이디는 존재하지 않습니다.'
            ];
        }
        return $res->setJSON($resData);     // ********** PHP 의 '특이'한 특징.. 블록안에서 선언한 변수에도 블록밖에서 접근이 가능하다..이런..;; 다만, 함수내 지역변수 스코프 개념은 살아있음!

//        log_message("info", "req-getMethod(): ".$req->getMethod()); //request 메소드 방식보여주기

    }


    public function notice() : ResponseInterface
    {
        $notice = new Notice();
        $res = $this->response;
//        $qst = $this->request->getGet();

        $resData = $notice->findAll();

        return $res->setJSON($resData);
    }

    //noticeContent 글 상세페이지 불러오기
    public function noticeContent() : ResponseInterface
    {
        $notice = new Notice();
        $qst = $this->request->getGet();
        $res = $this->response;

        log_message("debug", "noticeContent:\$qst: ". print_r($qst, true) );

        $resData = $notice->where('notice_no', $qst['notice_no'] )->findAll();

//        $res = [];
//        foreach ($this->testProps as $item){
//            if ($item['no'] == $qst['no'] && $item['content'] == $qst['content'] ) {
//                array_push($res, $item);
//            }
//        }
        return $res->setJSON($resData);
    }

    //공지게시판 검색버튼 클릭시
    public function noticeSearch() : ResponseInterface
    {
        $notice = new Notice();
        $qst = $this->request->getGet();
        $res = $this->response;

        log_message("debug", "noticeSearch:\$data1: ".print_r($this->request->getGet(), true));
//        log_message("debug", "noticeSearch:\$data2: ".print_r($data->getGet()->setJSON(), true)); //안됨
//        log_message("debug", "noticeSearch:\$data3: ".print_r($data->getJSON()->noticeSearch, true)); //안됨
//        log_message("debug", "noticeSearch:\$data: ".$this->request->getJSON()->noticeSearch );  //안됨
//        log_message("debug", "noticeSearch:\$data: ",print_r($data));

        $resData = [];

        if ($qst['noticeSearchType'] == '제목') {
            $resData = $notice->like('notice_title', $qst['noticeSearch'])->findAll();

        } elseif ($qst['noticeSearchType'] == '내용') {
            $resData = $notice->like('notice_content', $qst['noticeSearch'])->findAll();
        }

        return $res->setJSON($resData);

//        foreach ($resData as $item) {
//            if ($qst['noticeSearchType'] == '제목') {
//                //mb_strpos는 문자열에서 찾는 것이 없다면 false를 반환하고 있다면 문자열의 몇번째 인덱스(열)에 있는지 int를 반환한다
//                if (mb_strpos($item['title'], $qst['noticeSearch']) !== false ) {
//                    array_push($res, $item);
//                }
//            } elseif ($qst['noticeSearchType'] == '내용') {
//                if (mb_strpos($item['hit'], $qst['noticeSearch']) !== false) {
//                    array_push($res, $item);
//                }
//            }
//        }
    }

    public function updateNotice() : ResponseInterface
    {
        $notice = new Notice();
        $res = $this->response;
        $req = $this->request;

        $data = $req->getJSON(true);
//        $data['notice_']
        log_message("debug", "updateNotice:\$data: ".print_r($data, true));

        try {
            $result = $notice->update($data['notice_no'], $data);
            log_message("debug", "updateNotice:\$result: ".print_r($result, true));

            if ($result === false) {    //insert 작업이 실패할경우 false를 리턴하는데 이경우 users모델에 지정된 validation error메시지를 클라에 보낸다.
                return $res->setJSON([
                    'result' => $result,
                    'msg' => $notice->errors()
                ]);

            } else {
                return $res->setJSON([
                    'result' => true,
                    'msg' => '회원님의 글을 수정하였습니다.'
                ]);
            }

        } catch (\ReflectionException | DataException $e){
            return $res->setJSON($e->getMessage());
        }
    }

    public function deleteNotice() : ResponseInterface
    {
        $notice = new Notice();
        $res = $this->response;
        $req = $this->request;

        try {
            $result = $notice->delete($req->getGet()['notice_no']);
            log_message("debug", "deleteNotice:\$result: ".print_r($result, true));

            if ($result === false) {    //insert 작업이 실패할경우 false를 리턴하는데 이경우 users모델에 지정된 validation error메시지를 클라에 보낸다.
                return $res->setJSON([
                    'result' => $result,
                    'msg' => $notice->errors()
                ]);

            } else {
                return $res->setJSON([
                    'result' => true,
                    'msg' => '회원님의 글을 삭제하였습니다.'
                ]);
            }

        } catch (\ReflectionException | DataException $e){
            return $res->setJSON($e->getMessage());
        }
    }







///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function testRes() : \CodeIgniter\HTTP\ResponseInterface
    {
        $data = [
            'name'=>"ci4",
            'type'=>"json",
            'age'=>"20"
        ];

        $res = $this->response->setJSON($data);
        //Controller 가 response 내장객체를 이미 가지고 있다. 그래서 $this로 response메소드로 접근하여 객체가져오기 가능.
//        \Kint\Kint::dump($_SERVER);
//        d($GLOBALS, $_SERVER);
//        \Kint\Kint::trace();
//        \Kint\Kint::$enabled_mode = false;
        return $res;
    }

    public function noticeT() :ResponseInterface
    {
        $tmpString = mb_str_split("문자열랜덤생성하기우후훗");
        shuffle($tmpString);
        $tmpString = implode('', $tmpString);
        $resData = [];

        $data = [
            "no" => 0,
            "title" => "제목나오는곳",
            "writer" => substr($tmpString,0, 3), //php에서 한글문자를 substr로 자르면 깨짐. 이유는 한글이 utf-8에서
            "date" => date("Y-m-d"),                //3byte이기때문.
            "hit" => 123,
            "content" => "본문"
        ];

        for ($i=0; $i<10; $i++) {
            $data['no'] = $i;
            $data['title'] = "제목나오는곳".$i;
            $data['writer'] = mb_substr($tmpString, 0, 3); //그래서 멀티byte단위의 문자열처리를 하기위해 mbstring 확장함수를 사용해야한다.
            $data['date'] = date("Y-m-d");
            $data['hit'] = $i*$i;
            $data['content'] = "content".$i;
            array_push($resData, $data);
        }
        log_message("debug", "noticeT:\$resData: ". print_r($resData, true) );

//        $resData = json_encode(mb_convert_encoding($resData, 'UTF-8', 'UTF-8')); //mb_convert_encoding은 utf-8이 아닌 문자를 재인코딩해줌
//        log_message("debug", "noticeT:\$resData22: ". print_r($resData, true) );
//        $res = $this->response->setContentType('application/json')->setBody($resData);
        //이렇게 보면 setJSON == setContentType + setBody + json_encode

        $res = $this->response->setJSON($resData);
        return $res;
    }

}



