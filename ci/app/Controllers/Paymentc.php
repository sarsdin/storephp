<?php

namespace App\Controllers;

use App\Models\Deliver_address;
use App\Models\Product;
use App\Models\User_order;
use CodeIgniter\Controller;
use CodeIgniter\Database\Exceptions\DataException;
use CodeIgniter\HTTP\ResponseInterface;

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
            $resultF_재고부족 = [];
            for ($i=0; $i<count($data); $i++){
                $result = $product->where('product_no', $data[$i]['product_no'])->findColumn('product_stock');
                if ($result[$i] < $data[$i]['product_count']) {
                    $resultF = false;
                    array_push($resultF_재고부족, $result[$i]) ;
                    break; //재고 검증 순회중 재고가 주문수량보다 적으면 false로 바꾸고 빠져나옴.
                }
            }

            if ($resultF == false) {
                return $res->setJSON([
                    'result' => $resultF,
                    'msg' => '재고가 부족합니다.',
                    '재고부족상품정보' => $resultF_재고부족
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







}