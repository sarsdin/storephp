<?php

namespace App\Controllers;

use App\Models\Deliver_address;
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

    //배송지 수정 화면에서 기본배송지 설정하기.
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









}