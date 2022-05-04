<?php

namespace App\Controllers;

use App\Models\Deliver_address;
use App\Models\Product;
use App\Models\Product_reply;
use App\Models\User_order;
use App\Models\Userorder_detail;
use CodeIgniter\Controller;
use CodeIgniter\Database\Exceptions\DataException;
use CodeIgniter\HTTP\ResponseInterface;
use DateInterval;
use Exception;

class Paymentc extends Controller
{

    public function getAddressList() :ResponseInterface
    {
        $req = $this->request; //get() - 응답줄 url을 입력하면 response interface객체를 반환함
        $res = $this->response;
        $deliverAddress = new Deliver_address();

        $data = $req->getGet();
        log_message('debug', '[Paymentc] getAddressList::$data: '.print_r($data, true));

        try {
            $result = $deliverAddress->where('user_id', $data['user_id'])->findAll();
            if (count($result) == 0) {
                return $res->setJSON([
                    'result' => $result,
                    'msg' => '주소읽기작업을 실패하거나 데이터가 0개 입니다.'
                ]);
            } else{
                return $res->setJSON([
                    'result' => $result,
                    'msg' => '읽기성공'
                ]);
            }

        } catch (\ReflectionException | DataException $e){
            return $res->setJSON($e->getMessage());
        }
    }

    //todo:배송지 수정 화면에서 기본배송지 설정하기.
    public function basicAddressClicked() :ResponseInterface
    {
        $req = $this->request; //get() - 응답줄 url을 입력하면 response interface객체를 반환함
        $res = $this->response;
        $deliverAddress = new Deliver_address();

        $data = $req->getGet();
        log_message('debug', '[Paymentc] basicAddressClicked::$data: '.print_r($data, true));

        try {
            $result = $deliverAddress->where('user_id', $data['user_id'])->findAll();
            if (count($result) == 0) {
                return $res->setJSON([
                    'result' => $result,
                    'msg' => '실패'
                ]);
            } else{
                return $res->setJSON([
                    'result' => $result,
                    'msg' => '읽기성공'
                ]);
            }

        } catch (\ReflectionException | DataException $e){
            return $res->setJSON($e->getMessage());
        }
    }

    //배송지 추가
    public function addAddress() :ResponseInterface
    {
        $req = $this->request; //get() - 응답줄 url을 입력하면 response interface객체를 반환함
        $res = $this->response;
        $deliverAddress = new Deliver_address();

        $data = $req->getJson(true);
        log_message('debug', '[Paymentc] addAddress::$data'.print_r($data, true));

        try {
            $result = $deliverAddress->where('user_id', $data['user_id'])->insert($data);
            if ($result == false) {
                return $res->setJSON([
                    'result' => $result,
                    'msg' => 'insert작업을 실패했습니다.'
                ]);
            } else{
                return $res->setJSON([
                    'result' => true,
                    'msg' => $result.'를 주소록에 추가했습니다.'
                ]);
            }

        } catch (\ReflectionException | DataException $e){
            return $res->setJSON($e->getMessage());
        }
    }

    //배송지 수정
    public function updateAddress() :ResponseInterface
    {
        $req = $this->request; //get() - 응답줄 url을 입력하면 response interface객체를 반환함
        $res = $this->response;
        $deliverAddress = new Deliver_address();

        $data = $req->getJson(true);
        log_message('debug', '[Paymentc] updateAddress::$data'.print_r($data, true));

        try {
//            $tmp = [
//                ''
//            ];
            $deliverAddress->db->transStart();
            //기본 배송지 값이 설정되면 다른쪽 기본 배송지 설정값은 0으로 바꿔야함.
            if ($data['basic_address'] == 'true') {
                $sql = "update deliver_address set basic_address = 0 
                           where basic_address = 1 ";
                $deliverAddress->db->query($sql);
            }

            $result = $deliverAddress->update($data['address_no'], $data);
            $deliverAddress->db->transComplete();

            if ($result == false) {
                return $res->setJSON([
                    'result' => $result,
                    'msg' => 'update작업을 실패했습니다.'
                ]);
            } else{
                return $res->setJSON([
                    'result' => true,
                    'msg' => $data['address_no'].'의 주소록을 업데이트하였습니다.'
                ]);
            }

        } catch (\ReflectionException | DataException $e){
            return $res->setJSON($e->getMessage());
        }
    }

    //배송지 삭제
    public function deleteAddress() :ResponseInterface
    {
        $req = $this->request; //get() - 응답줄 url을 입력하면 response interface객체를 반환함
        $res = $this->response;
        $deliverAddress = new Deliver_address();

        $data = $req->getJson(true);
        log_message('debug', '[Paymentc] deleteAddress::$data'.print_r($data, true));

        try {
//            $tmp = [
//                ''
//            ];
            $result = $deliverAddress->delete($data['address_no']);
            if ($result == false) {
                return $res->setJSON([
                    'result' => $result,
                    'msg' => 'delete작업을 실패했습니다.'
                ]);
            } else{
                return $res->setJSON([
                    'result' => true,
                    'msg' => $data['address_no'].'의 주소록을 삭제하였습니다.'
                ]);
            }

        } catch (\ReflectionException | DataException $e){
            return $res->setJSON($e->getMessage());
        }
    }


    //결제시 사전 주문 레고드 생성 및 생성된 번호 반환 - 결제에 이용할 번호를 사전에 db에 생성해두는 절차.
    //결제 취소시 주문번호로 다시 레코드 삭제하고, 완료시에는 응답받는 feedback메소드로 나머지 데이터를 추가저장?
    public function createOrder() :ResponseInterface
    {
        $req = $this->request; //get() - 응답줄 url을 입력하면 response interface객체를 반환함
        $res = $this->response;
        $userOrder = new User_order();

        $data = $req->getJson(true);
        log_message('debug', '[Paymentc] createOrder::$data'.print_r($data, true));

        try {
            $userOrder->db->transStart();
            $data['order_date'] = date('Y-m-d H:i:s');
            log_message('debug', '[Paymentc] createOrder::$data'.print_r($data, true));
            $result = $userOrder->insert($data);


            if ($result == false) {
                $userOrder->db->transComplete();
                return $res->setJSON([
                    'result' => $result,
                    'msg' => 'insert작업을 실패했습니다.'
                ]);
            } else{
                $userOrder->db->transComplete();
                return $res->setJSON([
                    'result' => $result,
                    'msg' => $result.' order_no 생성.'
                ]);
            }

        } catch (\ReflectionException | DataException $e){
            return $res->setJSON($e->getMessage());
        }
    }


    //결제시 재고 확인 로직
    public function stockVerify() :ResponseInterface
    {
        $req = $this->request; //get() - 응답줄 url을 입력하면 response interface객체를 반환함
        $res = $this->response;
        $product = new Product();

//        computedItemsInfo
        $data = $req->getJson(true);
        log_message('debug', '[Paymentc] stockVerify::$data: '.print_r($data, true));

        try {
            $resultF = true;
            $resultF_stockless = [];
            for ($i=0; $i<count($data); $i++){
                $result = $product->where('product_no', $data[$i]['product_no'])->findColumn('product_stock');
                log_message('debug', '[Paymentc] stockVerify::$result: '.print_r($result, true));

                if ($result[0] < $data[$i]['product_count']) {
                    $resultF = false;
                    array_push($resultF_stockless, $result[$i]) ;
                    break; //재고 검증 순회중 재고가 주문수량보다 적으면 false로 바꾸고 빠져나옴.
                }
            }

            if ($resultF == false) {
                return $res->setJSON([
                    'result' => $resultF,
                    'msg' => '재고가 부족합니다.',
                    '재고부족상품정보' => $resultF_stockless
                ]);
            } else{
                return $res->setJSON([
                    'result' => $resultF,
                    'msg' => $resultF.' 재고 충분함 검증성공.'
                ]);
            }

        } catch (\ReflectionException | DataException $e){
            return $res->setJSON($e->getMessage());
        }
    }


    //bootpay 로부터 결제완료시 응답 받는 정보
    public function feedback() :ResponseInterface
    {
        $req = $this->request; //get() - 응답줄 url을 입력하면 response interface객체를 반환함
        $res = $this->response;
//        $deliverAddress = new Deliver_address();

        $data = $req->getJson(true);
        log_message('debug', '[Paymentc] feedback::$data'.print_r($data, true));

//        try {
//            $result = $deliverAddress->where('user_id', $data['user_id'])->insert($data);
//            if ($result == false) {
//                return $res->setJSON([
//                    'result' => $result,
//                    'msg' => 'insert작업을 실패했습니다.'
//                ]);
//            } else{
//                return $res->setJSON([
//                    'result' => true,
//                    'msg' => $result.'를 주소록에 추가했습니다.'
//                ]);
//            }
//
//        } catch (\ReflectionException | DataException $e){
//            return $res->setJSON($e->getMessage());
//        }
            return $res->setJSON('OK');
    }



    //bootpay 로부터 결제중 취소시 주문테이블에 주문삭제 처리
    public function cancelPaymentInProcessing() :ResponseInterface
    {
        $req = $this->request; //get() - 응답줄 url을 입력하면 response interface객체를 반환함
        $res = $this->response;
        $userOrder = new User_order();

        $data = $req->getVar();
        log_message('debug', '[Paymentc] cancelPaymentInProcessing $data'.print_r($data, true));

        try {
            $result = $userOrder->delete($data['order_no']);
            if ($result == false) {
                return $res->setJSON([
                    'result' => $result,
                    'msg' => '취소(delete)작업을 실패했습니다.'
                ]);
            } else{
                return $res->setJSON([
                    'result' => true,
                    'msg' => '취소(delete)작업 성공.'
                ]);
            }

        } catch (\ReflectionException | DataException $e){
            return $res->setJSON($e->getMessage());
        }
    }


    //bootpay 로부터 결제완료시 마무리 처리 - user_order table에 결제정보 추가 및 userorder_detail table에 구매상품목록 추가.
    /**
     * @throws Exception
     */
    public function orderCompleted() :ResponseInterface
    {
        $req = $this->request; //get() - 응답줄 url을 입력하면 response interface객체를 반환함
        $res = $this->response;
        $userOrder = new User_order();
        $userOrderDetail = new Userorder_detail();

        $data = $req->getJSON(true);
        log_message('debug', '[Paymentc] orderCompleted $data'.print_r($data, true));

        //결제일 객체를 만들고, 그 날짜에 12시간만큼 지난 시간을 설정. 즉, 결제취소 만료시간을 설정하는 것.
        $date = new \DateTime($data['purchased_at']);
        $date->add(new DateInterval('PT12H'));  //DateInterval format -- P(date)나 PT(time)로 시작. P2Y3M4DPT5H26M33S == 2년3개월4일 5시간26분33초 추가한다는 뜻

        //insertBatch 에 데이터로 넣을 row정보들을 받아온 데이터를 순회하여 만듦.
        $computedItemsInfo = [];
        for ($i = 0; $i < count($data['computedItemsInfo']); $i++){
            $tmpArray = [
                'order_no' => $data['computedItemsInfo'][$i]['order_no'],
                'product_no' => $data['computedItemsInfo'][$i]['product_no'],
                'product_count' => $data['computedItemsInfo'][$i]['product_count'],
                'product_price' => $data['computedItemsInfo'][$i]['product_price'],
                'order_detail_status' => $data['computedItemsInfo'][$i]['order_detail_status'],
                'refund_check' => $date,        //결제 취소 만료시간 설정 // 포맷변경후 넣을려면 ->format( 'Y-m-d H:i:s' )
            ];
            array_push($computedItemsInfo, $tmpArray);
        }

        try {
            $userOrder->db->transStart();
            $result = $userOrder->update($data['order_no'], $data); //update작업 먼저 진행 후 성공시 밑의 주문상품상세정보를 insertBatch로 여러줄 추가
            if ($result == true) {
                $result = $userOrderDetail->insertBatch($computedItemsInfo);
            }

            if ($result == false) {
                $userOrder->db->transComplete();
                return $res->setJSON([
                    'result' => $result,
                    'msg' => '결제마무리작업을 실패했습니다.'
                ]);
            } else{
                $userOrder->db->transComplete();
                return $res->setJSON([
                    'result' => "주문상세정보까지 추가완료. ('$result'줄)",
                    'msg' => '결제마무리작업을 성공.'
                ]);
            }

        } catch (\ReflectionException | DataException $e){
            return $res->setJSON($e->getMessage());
        }
    }



    //주문조회 리스트 로드
    public function getOrderCheckList() :ResponseInterface
    {
        $req = $this->request; //get() - 응답줄 url을 입력하면 response interface객체를 반환함
        $res = $this->response;
        $userOrder = new User_order();
//        $userOrderDetail = new Userorder_detail();

        $data = $req->getJSON(true);
        log_message('debug', '[Paymentc] getOrderCheckList $data'.print_r($data, true));

        $namedBinding = [
            'user_id' => $data['user_id'],
            'date_range' => $data['date_range'],
        ];

        $sql = " SELECT * 
                from user_order WHERE user_id = :user_id:
                        and 
                            case
                                when :date_range: != '99' 
                                then order_date between date_sub(curdate(), interval :date_range: DAY ) and curdate()
                                else order_date between '2022-01-01' and curdate()
                            end ";
        //: << 바인딩 오류는 ide 의 valid engine 문제

        try {
            $userOrder->db->transStart();
            $result = $userOrder->db->query($sql, $namedBinding);
            log_message('debug', '[Paymentc] getOrderCheckList $result'.print_r($result, true));
            log_message('debug', '[Paymentc] getOrderCheckList $ getLastQuery'.print_r($userOrder->db->getLastQuery(), true));
            $result = $result->getResultArray();

            if ($result == false) {   //query 결과 주문이 없으면 0 row 인데 0이라서 false 로 처리됨.
                $userOrder->db->transComplete();
                return $res->setJSON([
                    'result' => $result,
                    'msg' => '주문조회리스트 로딩 실패'
                ]);
            } else{
                $userOrder->db->transComplete();
                return $res->setJSON([
                    'result' => $result,
                    'msg' => '주문조회리스트 로딩 성공.'
                ]);
            }

        } catch (\ReflectionException | DataException $e){
            return $res->setJSON($e->getMessage());
        }
    }


    //주문상세 상품들 로드
    public function getOrderCheckDetail() :ResponseInterface
    {
        $req = $this->request; //get() - 응답줄 url을 입력하면 response interface객체를 반환함
        $res = $this->response;
        $userOrder = new User_order();
        $userOrderDetail = new Userorder_detail();

        $data = $req->getJSON(true);
        log_message('debug', '[Paymentc] getOrderCheckDetail $data'.print_r($data, true));

        $namedBinding = [
            'user_id' => $data['user_id'],
            'order_no' => $data['order_no'],
        ];

//      -- 각 제품의 이미지 중 가장 작은 수(가장먼저등록된)를 group by절로 번호를(min) 추출하고 그룹으로 추출된 인라인뷰(각상품의 대표이미지를 가짐)
//      -- 와 디테일테이블을 조인하여 완성된 정보를 가진 하나의 테이블로 만든다. 결국, product_no를 이용해 맨처음 등록된 사진을 가져오기 위한 것.
//      -- 이 후 다시 이미지파일의 경로를 얻기위해 완성된 테이블과 상품이미지테이블을 조인하여 최종 테이블을 완성한다.
        $sql = " select fi.*, pio.stored_file_name as product_image, p.product_name  from 
                (
                    SELECT *  from userorder_detail ud 
                    join ( select min(image_no) as image_no , product_no as pno
                        from product_image  
                        group by product_no ) pi
                    on ud.product_no = pi.pno
                    WHERE order_no = :order_no:
                ) fi join product_image pio on fi.image_no  = pio.image_no
                    join product p on fi.product_no = p.product_no ";

        //: << 바인딩 오류는 ide 의 valid engine 문제

        try {
            $userOrderDetail->db->transStart();
            $result = $userOrderDetail->db->query($sql, $namedBinding);
            log_message('debug', '[Paymentc] getOrderCheckDetail $result'.print_r($result, true));
            log_message('debug', '[Paymentc] getOrderCheckDetail $ getLastQuery'.print_r($userOrderDetail->db->getLastQuery(), true));
            $result = $result->getResultArray();

            if ($result == false) {   //query 결과 주문이 없으면 0 row 인데 0이라서 false 로 처리됨.
                $userOrderDetail->db->transComplete();
                return $res->setJSON([
                    'result' => $result,
                    'msg' => '주문상세 조회리스트 로딩 실패'
                ]);
            } else{
                $userOrderDetail->db->transComplete();
                return $res->setJSON([
                    'result' => $result,
                    'msg' => '주문상세 조회리스트 로딩 성공.'
                ]);
            }

        } catch (\ReflectionException | DataException $e){
            return $res->setJSON($e->getMessage());
        }
    }




    //주문상세상품 리뷰 작성
    public function reviewCreate() :ResponseInterface
    {
        $req = $this->request; //get() - 응답줄 url을 입력하면 response interface객체를 반환함
        $res = $this->response;
        $userOrder = new User_order();
        $userOrderDetail = new Userorder_detail();
        $productReply = new Product_reply();

        $data = $req->getJSON(true);
        log_message('debug', '[Paymentc] reviewCreate $data'.print_r($data, true));

//        $namedBinding = [
//            'user_id' => $data['user_id'],
//            'order_no' => $data['order_no'],
//        ];
//
//        $sql = " select fi.*, pio.stored_file_name as product_image, p.product_name  from
//                (
//                    SELECT *  from userorder_detail ud
//                    join ( select min(image_no) as image_no , product_no as pno
//                        from product_image
//                        group by product_no ) pi
//                    on ud.product_no = pi.pno
//                    WHERE order_no = :order_no:
//                ) fi join product_image pio on fi.image_no  = pio.image_no
//                    join product p on fi.product_no = p.product_no ";

        //: << 바인딩 오류는 ide 의 valid engine 문제

        try {
            $data['write_date'] = date('Y-m-d H:i:s'); //리뷰작성 날짜입력
            $userOrderDetail->db->transStart();
//            $result = $userOrderDetail->db->query($sql, $namedBinding);
//            log_message('debug', '[Paymentc] reviewCreate $result'.print_r($result, true));
//            log_message('debug', '[Paymentc] reviewCreate $ getLastQuery'.print_r($userOrderDetail->db->getLastQuery(), true));
//            $result = $result->getResultArray();

            $result = $productReply->insert($data);
            log_message('debug', '[Paymentc] reviewCreate $result'.print_r($result, true));
            $userOrderDetail->set('is_review_created', 1)->update($data['order_detail_no']);    //위에 리뷰작성 insert작업끝나면 주문상세레코드의 리뷰작성 유무를 true(1)로 업데이트해준다.

            if ($result == false) {   //query 결과 주문이 없으면 0 row 인데 0이라서 false 로 처리됨.
                $userOrderDetail->db->transComplete();
                return $res->setJSON([
                    'result' => $result,
                    'msg' => '주문상세 리뷰작성 실패'
                ]);
            } else{
                $userOrderDetail->db->transComplete();
                return $res->setJSON([
                    'result' => $result,
                    'msg' => '주문상세 리뷰작성 성공.'
                ]);
            }

        } catch (\ReflectionException | DataException $e){
            return $res->setJSON($e->getMessage());
        }
    }







}