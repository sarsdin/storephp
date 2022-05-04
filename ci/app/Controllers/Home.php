<?php

namespace App\Controllers;


use App\Models\Notice;
use App\Models\Notice_reply;
use App\Models\PostTest;
use App\Models\Users;
use CodeIgniter\Cookie\Cookie;
use CodeIgniter\Cookie\CookieInterface;
use CodeIgniter\Database\Exceptions\DataException;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\IncomingRequest;
use Config\Paths;
use DateTime;
use DateTimeZone;
use Exception;

class Home extends BaseController
{
//    public $testProps;
    public $encrypter;
//    public $session;

    public function __construct()
    {
        $this->encrypter = \Config\Services::encrypter();

//        $tmpString = mb_str_split("문자열랜덤생성하기우후훗");
//        shuffle($tmpString);
//        $tmpString = implode('', $tmpString);
//        $resData = [];
//
//        $data = [
//            "no" => 0,
//            "title" => "제목나오는곳",
//            "writer" => substr($tmpString,0, 3), //php에서 한글문자를 substr로 자르면 깨짐. 이유는 한글이 utf-8에서
//            "date" => date('Y-m-d H:i:s'),                //3byte이기때문.
//            "hit" => 123,
//            "content" => "본문"
//        ];
//
//        for ($i=0; $i<10; $i++) {
//            $data['no'] = $i;
//            $data['title'] = "제목나오는곳".$i;
//            $data['writer'] = mb_substr($tmpString, 0, 3); //그래서 멀티byte단위의 문자열처리를 하기위해 mbstring 확장함수를 사용해야한다.
//            $data['date'] = date('Y-m-d H:i:s');
//            $data['hit'] = $i*$i;
//            $data['content'] = "content".$i;
//            array_push($resData, $data);
//        }
//        $this->testProps = $resData;
    }

    //php 기본 설정 정보 페이지 로딩
    public function index2()
    {
        return phpinfo();
    }

    //기본페이지 자동 로딩
    public function index()
    {
      return view('../../public/dist/index.html');
    }

    //회원 가입 처리
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


    //자동로그인일경우 처리
    public function autoLogin() : ResponseInterface
    {
        $session = \Config\Services::session();
        $users = new Users();
        $req = $this->request;
        $res = $this->response;

        $data = $req->getVar();
        log_message("debug", "[Home] autoLogin \$data ".print_r($data, true));

        $user = $users->find($data['user_id']);

        $session->set('sessionInfo', [
            'user_id' => $user['user_id'],
            'user_email' => $user['user_email'],
            'logged_in' => true,
            'ip' => $_SERVER['REMOTE_ADDR'],
            'session_id' => session_id(),
        ]);

        if ($user != null ) {
            $resData = [
                'result' => $user,
                'msg' => $user['user_id'].'님 환영합니다.'
            ];

            //세션 정보 응답할 데이터 배열에 추가
            $resData['sessionInfo'] = $session->get('sessionInfo');
            return $res->setJSON($resData);

        } else {
            $resData = [
                'result' => false,
                'error' => $data['user_id'],
                'msg' => '해당 아이디는 존재하지 않습니다.'
            ];
            return $res->setJSON($resData);
        }



//        if ($session->has($data['user_id'])) {
//
//        } else {
//            //세션이 설정한 자동로그인 기간이 5분이 지나 만료되었을때
//            $resData = [
//                'result' => false,
//                'msg' => '해당 세션정보는 존재하지 않습니다. 자동로그인을 수행할 수 없습니다. 로그인을 해주세요.'
//            ];
//            return $res->setJSON($resData);
//        }


    }


    //로그인 처리
    /**
     * @throws Exception
     */
    public function login() : ResponseInterface
    {
//        $session = \Config\Services::session();
        $session = session();
        $users = new Users();
        $req = $this->request;
        $res = $this->response;
        //암호화가 필요할때 사용
        $testEncript  = 'styner14@naver.com';
        $testE_res = $this->encrypter->encrypt($testEncript);  //decrypt

        log_message("debug", "[Home] login req: ". print_r($req, true));
        log_message("debug", "[Home] login request getjson: ". print_r($req->getJSON(true), true));
        log_message("debug", "[Home] login requesturi: ".$req->uri);
        log_message("debug", "[Home] login requestURI path: " . $req->getUri()->getPath());

//        if ($this->request){
//            if ($this->request->getJSON()) {
//                $json = $this->request->getJSON();
//                log_message("info", "[Home] login requestJsonData.passwd: ".$json->user_pwd);
//            }
//        }

        $data = $req->getJson(true);
//        $data = $req->getVar();
        log_message("debug", "[Home] login \$data: " . print_r($data, true));
        $isUser = $users->find($data['user_id']);

        if ($isUser != null ) {
            $resData = [
                'result' => $isUser,
                'msg' => $isUser['user_id'].'님 환영합니다.'
            ];
            if (count($users->where('user_pwd', $data['user_pwd'])->where('user_id', $data['user_id'])->findAll()) <= 0) {
                $resData['result'] = false;
                $resData['error'] = 'pwd';
                $resData['msg'] = '비밀번호가 일치하지 않습니다.';
                return $res->setJSON($resData);
            }

//            $session->destroy();

            //세션 정보 추가
            if (!session_id()){
//                ini_set('session.cache_expire', 3600);
//                ini_set('session.gc_maxlifetime', WEEK);
//                $session->start();
            }
            $sessionId = session_id();
            $session->set('sessionInfo', [
                'user_id' => $isUser['user_id'],
                'user_email' => $isUser['user_email'],
                'logged_in' => true,
                'ip' => $_SERVER['REMOTE_ADDR'],
                'session_id' => session_id(),
            ]);
            log_message("debug", "[Home] login Current \$sessionId: ".print_r($sessionId, true));
            log_message("debug", "[Home] login Current sessionData: ".print_r($session->get('sessionInfo'), true));

            //자동로그인일 경우 처리
            log_message("debug", "[Home] login \$data['isAutoLogin']: ".print_r($data['isAutoLogin'], true));
//            if ($data['isAutoLogin'] != 'false') {
            if ($data['isAutoLogin'] != 0) {
                $session->set('isAutoLogin', true); //이구문이 의미가 있나?
//                $session->markAsTempdata('sessionInfo', 30); //추가한 세션데이터의 유효기간을 설정할 수 있다. 30이면 30초간 세션안의 데이터가 유지된다.
//                $resData['sessionInfo']['isAutoLogin'] = true;
                $cookie = [
                    'name' => 'autologin',
                    'value' => 'true',
                    'expire' =>  new DateTime('+20 seconds', new DateTimeZone('Asia/Seoul')), //+1 hours +1 minutes
                    'path' => '/',
                    'prefix' => "id_".$isUser['user_id']."__",
                    'secure' => false,
                    'httponly' => false,
//                   'samesite' => 'none'//CookieInterface::SAMESITE_NONE
                ];
                $res->setCookie($cookie);   //자동로그인 관련 쿠키를 응답에 설정해놓음
            }
            //세션 정보 응답할 데이터 배열에 추가
            $resData['sessionInfo'] = $session->get('sessionInfo');

//            $cookie = new Cookie(
//                'autologin',
//                'true',
//                [
//                    'expires' => time() + 600,//new DateTime('+5 minutes', new DateTimeZone('Asia/Seoul')), //'+1 hours'
//                    'path' => '/',
//                    'secure' => false,
//                    'prefix' => "id_".$isUser['user_id']."__",
//                    'httponly' => false,
//                    'samesite' => 'none'//CookieInterface::SAMESITE_NONE
//                ]
//            );
//            return $res->setHeader('cookietest',$cookie->toHeaderString())->setCookie($cookie2)->setJSON($resData);
            return $res->setJSON($resData);

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




    //로그아웃 클릭시
    public function logout() : ResponseInterface
    {
//        $session = \Config\Services::session();
        $session = session();
//        session_start();
        $users = new Users();
        $req = $this->request;
        $res = $this->response;

//        $cookieName = $_COOKIE('ci_session_');
        $is_session_exist = $session->get('sessionInfo') != null;
        $tmp = $is_session_exist ? "세션 값이 존재합니다." : "세션 값이 없습니다.";
        log_message("debug", "[Home] logout \$session->get('sessionInfo'): ".print_r($session->get('sessionInfo'), true));
        log_message("debug", "[Home] logout \$tmp: ".print_r($tmp, true));

//        $data = $req->getJSON(true);
        $data = $req->getVar();
        log_message("debug", "[Home] logout \$data: ".print_r($data, true));


        if ($session->has('sessionInfo')) { //(!session_id())
//            $session->remove('sessionInfo'.$data['session_id']);
            $session->destroy();
//            $session->stop();

            $cookie = new Cookie(
                'autologin',
                'true',
                [
                    'expires' => time() -10,//new DateTime('+5 minutes', new DateTimeZone('Asia/Seoul')), //'+1 hours'
                    'path' => '/',
                    'secure' => false,
                    'prefix' => "id_".$data['user_id']."__",
                    'httponly' => false,
//                    'maxage' => 0
                ]
            );
//            $res->setCookie($cookie);   //자동로그인 관련 쿠키를 응답에 설정해놓음
            $res->setHeader('set-cookie',$cookie->toHeaderString());   //자동로그인 관련 쿠키를 응답에 설정해놓음

            $resData = [
                'result' => true,
                'msg' => '로그아웃 하였습니다'
            ];

            return $res->setJSON($resData);

        } else {
            $session->stop();

            $resData = [
                'result' => false,
                'msg' => '로그아웃을 실패했거나 세션이 만료되었습니다.'
            ];
            return $res->setJSON($resData);
        }
    }





    //세션 있는지 확인
    public function isSession() : ResponseInterface
    {
        $session = session();
        $res = $this->response;
        log_message("debug", "[Home] isSession:".print_r(session_id(), true));

        $resData = null;
        if ($session->has('sessionInfo')) {
            $resData = [
                'result' => true,
                'session_id' => session_id(),
                'sessionInfo' => $session->get('sessionInfo'),
                'msg' => '세션값이 존재.'
            ];

        } else {
            $resData = [
                'result' => false,
                'session_id' => session_id(),
                'msg' => '세션값이 없음.'
            ];
        }
        return $res->setJSON($resData);
    }


    //공지 게시판 글전체 불러오기
    public function notice() : ResponseInterface
    {
        $db = \Config\Database::connect();
        $notice = new Notice();
        $res = $this->response;
        $req = $this->request;
//        $resData = $notice->findAll();
//        return $res->setJSON($resData);
        $data = $req->getVar();
        log_message("debug", "notice:\$data: ".print_r($data, true));
        $totalItems = 0;

        try {
            $sql = " select * from (
                        select @rownum:=@rownum+1 as rownum, i.* from (
                            select * from notice ";

            if ($data['searchValue'] != '') {
                if ($data['searchType'] == '제목') {
//                    $qq = '451';$data['searchValue'],
//                    $sql = $sql." where notice_title =  ?  ";
//                    $sql = $sql." where notice_title like '%'|| ? ||'%' ";  //오라클 전용 문법
                    $sql = $sql." where notice_title like concat_ws(?, '%', '%') "; //mysql 대체문법
//                    $sql = $sql." where notice_title like '%$qq%'  ";
//                    $sql = $sql." where notice_title like ?  ";

                } elseif ($data['searchType'] == '내용'){
                    $sql = $sql." where notice_content like %?% ";
                }
            }
            $sql = $sql." order by notice_no desc
                        ) i, (select @rownum:=0) tmp ) o
                    where o.rownum between ? and ? ";


            log_message("debug", "notice:\$sql: ".print_r($sql, true));

//            $sql2 = "select * from notice where notice_title = '공지제목432' order by notice_no desc limit 0, 33";
//            $notice->select('*')->like('notice_title', $data['searchValue'])

            $result = [];
            //search값 유무에 따라 다른 쿼리바인딩을 실행해야한다. 검색결과에 따른 다른 아이템숫자를 리턴해줘야 페이징시 올바른 페이징이 가능하다.
            if ($data['searchValue'] != '') {
                if ($data['searchType'] != '제목') {
                    $totalItems = $notice->like('notice_title', $data['searchValue'])->countAllResults();

                } elseif ($data['searchType'] != '내용'){
                    $totalItems = $notice->like('notice_content', $data['searchValue'])->countAllResults();
                }
                $result = $notice->db->query($sql, [$data['searchValue'], $data['dbStartNumber'], $data['dbEndNumber']]);

            } else {
                $totalItems = $notice->countAll();
                $result = $notice->db->query($sql,[$data['dbStartNumber'], $data['dbEndNumber']]);
            }

            log_message("debug", "notice:\$result: ".print_r($result->getResult(), true));
            log_message("debug", "notice:\$result2: ".print_r($result->getResultArray(), true));
            $result2 = $notice->db->getLastQuery();
            log_message("debug", "notice:\$result22: ".print_r($result2, true));



            //결과 반환
            return $res->setJSON([
                'result' => $result->getResultArray(),
                'totalItems' => $totalItems,
                'msg' => $notice->errors()
            ]);

        } catch(\ReflectionException | DataException $e){
            return $res->setJSON($e->getMessage());
        }

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


    //공지 게시판 글 작성
    public function createNotice() : ResponseInterface
    {
        $notice = new Notice();
        $res = $this->response;
        $req = $this->request;

        $data = $req->getJSON(true);
        $data['notice_date'] = date('Y-m-d H:i:s');

        log_message("debug", "createNotice:\$data: ".print_r($data, true));

        try {
            $result = $notice->insert($data);  //성공시 insert된 row의 기본키값 리턴됨
            log_message("debug", "createNotice:\$result: ".print_r($result, true));

            if ($result === false) {    //insert 작업이 실패할경우 false를 리턴하는데 이경우 users모델에 지정된 validation error메시지를 클라에 보낸다.
                return $res->setJSON([
                    'result' => $result,
                    'msg' => $notice->errors()
                ]);

            } else {
                return $res->setJSON([
                    'result' => true,
                    'msg' => '회원님의 글을 작성하였습니다.'
                ]);
            }

        } catch (\ReflectionException | DataException $e){
            return $res->setJSON($e->getMessage());
        }
    }


    //공지 게시판 글 수정
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

    //공지게시판 클릭시 조회수 증가
    public function noticeRowClicked() : ResponseInterface
    {
        $notice = new Notice();
        $res = $this->response;
        $req = $this->request;

        $data = $req->getJSON(true);
//        $data['notice_']
        log_message("debug", "noticeRowClicked:\$data: ".print_r($data, true));

        $sql = "update notice set notice_hit = notice_hit+1 where notice_no = ?";

        try {
//            $result = $notice->where('notice_no', $data['notice_no'])->update($data['notice_no'], $data);
            $result = $notice->db->query($sql, $data['notice_no']);
            log_message("debug", "noticeRowClicked:\$result: ".print_r($result, true));

            if ($result === false) {    //insert 작업이 실패할경우 false를 리턴하는데 이경우 users모델에 지정된 validation error메시지를 클라에 보낸다.
                return $res->setJSON([
                    'result' => $result,
                    'msg' => $notice->errors()
                ]);

            } else {
                return $res->setJSON([
                    'result' => true,
                    'msg' => '글의 조회수를 수정하였습니다.'
                ]);
            }

        } catch (\ReflectionException | DataException $e){
            return $res->setJSON($e->getMessage());
        }
    }

    //공지게시판 글 삭제
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



    //공지 게시판의 총 게시물 수 리턴
    public function getNoticeTotalItems() : ResponseInterface
    {
        $req = $this->request;
        $res = $this->response;
        $notice = new Notice();

        $data = $req->getVar();
        log_message('debug', '[Home] getNoticeTotalItems \$data: '.print_r($data, true));

        try {
            $result = 0;
            if ($data['searchValue'] != '') {
                if ($data['searchType'] != '제목') {
                    $result = $notice->like('notice_title', $data['searchValue'])->countAll();

                } elseif ($data['searchType'] != '내용'){
                    $result = $notice->like('notice_content', $data['searchValue'])->countAll();
                }
            } else{
                $result = $notice->countAll();
            }

            return $res->setJSON($result);

        } catch (\ReflectionException | DataException $e){
            return $res->setJSON($e->getMessage());
        }
    }

    //공지 게시판 게시물 댓글 로드
    public function noticeReplyLoad() : ResponseInterface
    {
        $req = $this->request;
        $res = $this->response;
        $noticeReply = new Notice_reply();

        $data = $req->getVar();
        log_message('debug', '[Home] noticeReplyLoad $data: '.print_r($data, true));

        try {
            $result = $noticeReply->where('notice_no', $data['notice_no'])
//                ->where('parent_reply_no', null)
                ->orderBy('reply_group', 'ASC')
                ->orderBy('notice_reply_writedate', 'ASC')->findAll();

            return $res->setJSON($result);

        } catch (\ReflectionException | DataException $e){
            return $res->setJSON($e->getMessage());
        }
    }

    //공지 게시판 게시물 대댓글 로드
    public function noticeAnswerItemsLoad() : ResponseInterface
    {
        $req = $this->request;
        $res = $this->response;
        $noticeReply = new Notice_reply();

        $data = $req->getVar();
        log_message('debug', '[Home] noticeAnswerItemsLoad $data: '.print_r($data, true));

        try {
            $result = $noticeReply->where('notice_no', $data['notice_no'])
                ->where('reply_group', $data['reply_group'])
                ->where('parent_reply_no', $data['parent_reply_no'])->findAll();

            return $res->setJSON($result);

        } catch (\ReflectionException | DataException $e){
            return $res->setJSON($e->getMessage());
        }
    }


    //공지 게시판 게시물 댓글 쓰기
    public function noticeCreateReply() : ResponseInterface
    {
        $req = $this->request;
        $res = $this->response;
        $noticeReply = new Notice_reply();

        $data = $req->getJSON(true);
        log_message('debug', '[Home] noticeCreateReply $data: '.print_r($data, true));

        try {
            $tmp = ['notice_reply_content' => $data['notice_reply_content'],
                'notice_reply_writer' => $data['notice_reply_writer'],
                'notice_reply_writedate' => date('Y-m-d H:i:s'),
                'notice_no' => $data['notice_no']
            ];
            log_message('debug', '[Home] noticeCreateReply $data: '.print_r($tmp, true));
            $noticeReply->db->transStart();
            $result = $noticeReply->insert($tmp);
            $result = $noticeReply->where('notice_reply_no', $result)->set('reply_group', $result)->update();
            $noticeReply->db->transComplete();

            return $res->setJSON($result);

        } catch (\ReflectionException | DataException $e){
            return $res->setJSON($e->getMessage());
        }
    }


    //공지 게시판 게시물 대댓글 쓰기
    public function noticeCreateReplyAnswer() : ResponseInterface
    {
        $req = $this->request;
        $res = $this->response;
        $noticeReply = new Notice_reply();

        $data = $req->getJSON(true);
        log_message('debug', '[Home] noticeCreateReplyAnswer $data: '.print_r($data, true));

        try {
            $tmp = ['notice_reply_content' => $data['notice_reply_content'],
                'notice_reply_writer' => $data['notice_reply_writer'],
                'notice_reply_writedate' => date('Y-m-d H:i:s'),
                'notice_no' => $data['notice_no'],
                'reply_group' => $data['reply_group'],
                'parent_reply_no' => $data['parent_reply_no'],
                'parent_reply_writer' => $data['parent_reply_writer'],
            ];
            log_message('debug', '[Home] noticeCreateReplyAnswer $data: '.print_r($tmp, true));
            $noticeReply->db->transStart();
            $result = $noticeReply->insert($tmp);
//            $result = $noticeReply->where('notice_reply_no', $result)->set('reply_group', $result)->update();
            $noticeReply->db->transComplete();
            if ($result == false) {
                return $res->setJSON($result);

            } else {
                return $res->setJSON(true);
            }

        } catch (\ReflectionException | DataException $e){
            return $res->setJSON($e->getMessage());
        }
    }


    //댓글 수정 완료시
    public function noticeUpdateReplyComplete() : ResponseInterface
    {
        $req = $this->request;
        $res = $this->response;
        $notice_reply = new Notice_reply();

        $data = $req->getJSON(true);
        log_message('debug', '[Home] noticeUpdateReplyComplete $data: '.print_r($data, true));

        try {
            $resData = $notice_reply->update($data['notice_reply_no'], $data );
            if ($resData == true) {
                return $res->setJSON([
                    'result' => $resData,
                    'msg' => '댓글수정 성공'
                ]);
            } else {
                return $res->setJSON([
                    'result' => $resData,
                    'msg' => '댓글수정 실패'
                ]);
            }

        }catch (\ReflectionException|DataException $e){
            return $res->setJSON($e->getMessage());
        }
    }


    //댓글 삭제 완료시
    public function noticeDeleteReply() : ResponseInterface
    {
        $req = $this->request;
        $res = $this->response;
        $notice_reply = new Notice_reply();

        $data = $req->getJSON(true);
        log_message('debug', '[Home] noticeDeleteReply $data: '.print_r($data, true));

        try {
            $resData = $notice_reply->delete($data['notice_reply_no']);
            if ($resData == true) {
                return $res->setJSON([
                    'result' => $resData,
                    'msg' => '댓글삭제 성공'
                ]);
            } else {
                return $res->setJSON([
                    'result' => $resData,
                    'msg' => '댓글삭제 실패'
                ]);
            }

        }catch (\ReflectionException|DataException $e){
            return $res->setJSON($e->getMessage());
        }
    }







///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
            "date" => date('Y-m-d H:i:s'),                //3byte이기때문.
            "hit" => 123,
            "content" => "본문"
        ];

        for ($i=0; $i<10; $i++) {
            $data['no'] = $i;
            $data['title'] = "제목나오는곳".$i;
            $data['writer'] = mb_substr($tmpString, 0, 3); //그래서 멀티byte단위의 문자열처리를 하기위해 mbstring 확장함수를 사용해야한다.
            $data['date'] = date('Y-m-d H:i:s');
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



