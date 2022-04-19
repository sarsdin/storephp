<?php

namespace App\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Product_image;
use CodeIgniter\Controller;
use CodeIgniter\Database\Exceptions\DataException;
use CodeIgniter\HTTP\ResponseInterface;

class Productc extends Controller
{
    protected $helpers = ['form'];

    //상품 전체 리스트 가져오기
    public function pList() :ResponseInterface
    {
        $req = $this->request; //get() - 응답줄 url을 입력하면 response interface객체를 반환함
        $res = $this->response;
        $product = new Product();
        $productImg = new Product_image();

        $resData = $product->findAll();
        for ($i=0; $i<count($resData); $i++) {
            $product_image = $productImg->where('product_no', $resData[$i]['product_no'])->findColumn('stored_file_name');
            $resData[$i]['product_image'] = $product_image;
//            log_message("debug", '[Productc]:pList $resData[$i]: '.print_r($resData[$i], true));
        }

//        foreach ($resData as $item ){ //각 상품정보당 이미지를 불러와서 새속성'product_image'에 넣어준다.
//            $product_image = $productImg->where('product_no', $item['product_no'])->findColumn('stored_file_name');
//            $item['product_image'] = $product_image;
//            log_message("debug", '[Productc]:pImage $item: '.print_r($item, true));
              //*** foreach의 문제점 *** -- $item에는 속성이 추가됨. 하지만, 정작 $resData에는 적용이 안됨. 이유는 ??? $item이 $resData의 속성을 복사해간후 갱신은 안해주는 것 같다.
//        }
        log_message("debug", '[Productc]:pList resData: '.print_r($resData, true));

        return $res->setJSON($resData);
    }

    //todo: megamenu누를시 해당하는 메뉴의 카테고리 데이터를 전달하는 메소드 작성하기. (완료)
    public function menuProductList() :ResponseInterface
    {
        $req = $this->request; //get() - 응답줄 url을 입력하면 response interface객체를 반환함
        $res = $this->response;
        $product = new Product();
        $productImg = new Product_image();

        $resData = $product->where('category_code', $req->getVar('category_code'))->findAll();
        log_message("debug", '[Productc]:menuProductList category_code: '.print_r($req->getVar(), true));
        log_message("debug", '[Productc]:menuProductList category_code: '.print_r($req->getVar('category_code'), true));
        for ($i=0; $i<count($resData); $i++) {
            $product_image = $productImg->where('product_no', $resData[$i]['product_no'])->findColumn('stored_file_name');
            $resData[$i]['product_image'] = $product_image;
        }
        log_message("debug", '[Productc]:menuProductList $resData[$i] : '.print_r($resData, true));

        return $res->setJSON($resData); //$resData에 데이터가 없어도 [] 은 반환됨(findAll default).
    }

    //상품 이미지 가져오기 -- 사용 안하는 듯??
    public function pImage() :ResponseInterface  //현재 노사용
    {
        $req = $this->request; //get() - 응답줄 url을 입력하면 response interface객체를 반환함
        $res = $this->response;
        $productImg = new Product_image();

        //특정 컬럼의 정보를 가져오는데, **주의할점** -->> 데이터가 없으면 Null을 반환한다는 점을 유의!!
        $resData = $productImg->where('product_no', $req->getVar('product_no'))->findColumn('stored_file_name');
        log_message("debug", '[Productc]:pImage: '.print_r($resData, true));
        return $res->setJSON($resData);
    }

    //상품 등록 클릭시
    public function addProduct() : ResponseInterface
    {
        $req = $this->request; //get() - 응답줄 url을 입력하면 response interface객체를 반환함
        $res = $this->response;
        $product = new Product();
        $productImg = new Product_image();

        $validationRule = [
            'product_image' => [
                'label' => 'Image File',
                'rules' => 'uploaded[product_image]'
                    . '|is_image[product_image]'
                    . '|mime_in[product_image,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                    . '|max_size[product_image,1000]'
                    . '|max_dims[product_image,1924,1024]',
            ],
        ];
        if (! $this->validate($validationRule)) { //이미지파일 검증실패시 result false로 에러메시지 리턴.
            $data = [
                'result' => false,
                'errors' => $this->validator->getErrors()
            ];

            return $res->setJSON($data);
        }

        $data = [
            'category_code' => $req->getVar('category_code'),
            'product_name' => $req->getVar('product_name'),
            'product_stock' => $req->getVar('product_stock'),
            'product_price' => $req->getVar('product_price'),
            'product_spec' => $req->getVar('product_spec'),
            'product_desc' => $req->getVar('product_desc'),
            'product_date' => date('Y-m-d H:i:s'),

        ];
        log_message("debug", "productAdd:\$data: ".print_r($data, true));

        $imgData3 = $req->getFileMultiple('product_image');
//        $imgData2 = $req->getFile('product_image');
        $imgData = $req->getFiles();
        log_message("debug", "productAdd:\$imgData: ".print_r($imgData, true));
//        log_message("debug", "productAdd:\$imgData2: ".print_r($imgData2, true));
        log_message("debug", "productAdd:\$imgData3: ".print_r($imgData3, true));


        try {
            $product->db->transStart();
            //상품 내용 입력
            $result = $product->insert($data);
            log_message("debug", "productAdd:\$result: ".print_r($result, true));

            if ($result === false) {
                $product->db->transComplete(); //실패시 롤백
                return $res->setJSON([
                    'result' => $result,
                    'msg' => $product->errors()
                ]);

            } else {
                //상품 이미지 입력
                if ($imgData != null) {
                    foreach ($imgData['product_image'] as $img) { //받은 이미지파일배열을 반복문으로 돌려 ci기본 upload경로(writable/uploads)에 저장
                        if (! $img->hasMoved()) {
                            $originalName = $img->getClientName(); //원래 파일의 이름
                            $filePath =  $img->store(); //store는 기본경로에 날짜폴더를 생성하고 거기에 랜덤이름의 파일을 저장한다. 그 후 저장된 경로를 리턴
                            log_message("debug", "productAdd:\$originalName: ".print_r($originalName, true));
                            log_message("debug", "productAdd:\$filePath: ".print_r($filePath, true));
            //                $fileName =  $img->getRandomName();
            //                $img->move(WRITEPATH.'uploads', $fileName); //경로명, 저장될이름명(이이름으로저장됨) -- move는 tmp폴더에 임시로 받아진 사진파일을 지정한 경로에 파일명으로 저장한다. 그후 tmp폴더의 사진파일은 메소드종료와 동시에 삭제됨

                            //서버에 저장된 파일경로를 db에 저장함.
                            $productImg->insert([
                                'product_no' => $result,
                                'origin_file_name' => $originalName,
                                'stored_file_name' => $filePath,
                                'file_size' => $img->getSize(),
                                'create_date' => date('Y-m-d H:i:s')
                            ]);
                        }
                    }
                }
                $product->db->transComplete(); //실패시 롤백 성공시 커밋

                return $res->setJSON([
                    'result' => true,
                    'msg' => '상품등록을 하였습니다.'
                ]);
            }

        } catch (\ReflectionException | DataException $e) {
            return $res->setJSON($e->getMessage());
        }

    }


    //상품등록게시판 줄 클릭하여 수정화면 들어갔을때
    public function getProductInfo() : ResponseInterface
    {
        $req = $this->request; //get() - 응답줄 url을 입력하면 response interface객체를 반환함
        $res = $this->response;
        $product = new Product();
        $productImg = new Product_image();

//        $validationRule = [
//            'product_image' => [
//                'label' => 'Image File',
//                'rules' => 'uploaded[product_image]'
//                    . '|is_image[product_image]'
//                    . '|mime_in[product_image,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
//                    . '|max_size[product_image,1000]'
//                    . '|max_dims[product_image,1924,1024]',
//            ],
//        ];
//        if (! $this->validate($validationRule)) { //이미지파일 검증실패시 result false로 에러메시지 리턴.
//            $data = [
//                'result' => false,
//                'errors' => $this->validator->getErrors()
//            ];
//
//            return $res->setJSON($data);
//        }

//        $data = [
//            'category_code' => $req->getVar('category_code'),
//            'product_name' => $req->getVar('product_name'),
//            'product_stock' => $req->getVar('product_stock'),
//            'product_price' => $req->getVar('product_price'),
//            'product_spec' => $req->getVar('product_spec'),
//            'product_desc' => $req->getVar('product_desc'),
//            'product_date' => date('Y-m-d H:i:s'),
//        ];
        $no = $req->getGet('product_no');
        log_message("debug", "getProductInfo:\$no: ".print_r($no, true));

        try {
            $product->db->transStart();     //트랜잭션 시작
            $result = $product->find($no);
            $resultImg = $productImg->where('product_no', $no)->findAll();
            $product->db->transComplete();  //트랜잭션 완료
            log_message("debug", "getProductInfo:\$result: ".print_r($result, true));
            log_message("debug", "getProductInfo:\$resultImg: ".print_r($resultImg, true));

            if ($result == null) {

                return $res->setJSON([
                    'result' => $result,
                    'msg' => $product->errors()
                ]);

            } else {
                return $res->setJSON([      //db에서 가져오기 성공시 상품정보와 해당 이미지 정보를 보냄.
                    'result' => $result,
                    'resultImg' => $resultImg
                ]);
            }
        } catch (\ReflectionException | DataException $e) {
            return $res->setJSON($e->getMessage());
        }

    }


    //상품수정화면에서 수정하기 버튼 누를 시
    public function updateProduct() : ResponseInterface
    {
        helper('filesystem');
        $product = new Product();
        $req = $this->request;
        $res = $this->response;
        $productImg = new Product_image();

        $validationRule = [
            'product_image' => [
                'label' => 'Image File',
                'rules' => 'uploaded[product_image]'
                    . '|is_image[product_image]'
                    . '|mime_in[product_image,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                    . '|max_size[product_image,1000]'
                    . '|max_dims[product_image,1924,1024]',
            ],
        ];
//        if (! $this->validate($validationRule)) { //이미지파일 검증실패시 result false로 에러메시지 리턴.
//            $data = [
//                'result' => false,
//                'errors' => $this->validator->getErrors()
//            ];
//
//            return $res->setJSON($data);
//        }

        $data = [
//            'product_no' => $req->getVar('product_no'),
            'category_code' => $req->getVar('category_code'),
            'product_name' => $req->getVar('product_name'),
            'product_stock' => $req->getVar('product_stock'),
            'product_price' => $req->getVar('product_price'),
            'product_spec' => $req->getVar('product_spec'),
            'product_desc' => $req->getVar('product_desc'),
//            'product_date' => date('Y-m-d H:i:s'),
        ];
        log_message("debug", "updateProduct:\$data: ".print_r($data, true));

        $imgData = $req->getFileMultiple('product_image');
//        $imgData2 = $req->getFile('product_image');
        $imgData3 = $req->getFiles();
        log_message("debug", "updateProduct:\$imgData: ".print_r($imgData, true));
//        log_message("debug", "productAdd:\$imgData2: ".print_r($imgData2, true));
        log_message("debug", "updateProduct:\$imgData3: ".print_r($imgData3, true));
        
        //Todo : 이미지 로드된거 addProduct처럼 서버에 있는 파일 삭제하고 변경된(업로드된) 파일로 다시 저장하기 -(완료)
        try {
            $product->db->transStart();
            $result = $product->update($req->getVar('product_no'), $data);

            if ($imgData != null && count($imgData) > 0 ) {
                //기존의 사진 정보 삭제
                $imgPre = $productImg->where('product_no', $req->getVar('product_no'))->findColumn('stored_file_name');
                if ($imgPre != null) {
                    foreach($imgPre as $item) {
                        delete_files('../writable/uploads/'.$item); //경로의 파일 삭제
                    }
                    $productImg->where('product_no', $req->getVar('product_no'))->delete();//db에서 정보삭제
                }

                //새로 업로드된 사진 정보 저장
                //상품 이미지 입력
                foreach ($imgData as $img) { //받은 이미지파일배열을 반복문으로 돌려 ci기본 upload경로에 저장
                    if (! $img->hasMoved()) {
                        $originalName = $img->getClientName(); //원래 파일의 이름
                        $filePath =  $img->store(); //store는 기본경로에 날짜폴더를 생성하고 거기에 랜덤이름의 파일을 저장한다. 그 후 저장된 경로를 리턴
                        log_message("debug", "updateProduct:\$originalName: ".print_r($originalName, true));
                        log_message("debug", "updateProduct:\$filePath: ".print_r($filePath, true));
                        //                $fileName =  $img->getRandomName();
                        //                $img->move(WRITEPATH.'uploads', $fileName); //경로명, 저장될이름명(이이름으로저장됨) -- move는 tmp폴더에 임시로 받아진 사진파일을 지정한 경로에 파일명으로 저장한다. 그후 tmp폴더의 사진파일은 메소드종료와 동시에 삭제됨

                        //서버에 저장된 파일경로를 db에 저장함.
                        $productImg->insert([
                            'product_no' => $req->getVar('product_no'),
                            'origin_file_name' => $originalName,
                            'stored_file_name' => $filePath,
                            'file_size' => $img->getSize(),
                            'create_date' => date('Y-m-d H:i:s')
                        ]);
                    }
                }
            }
            $product->db->transComplete();

            log_message("debug", "updateProduct:\$result: ".print_r($result, true));
            if ($result === false) {
                return $res->setJSON([
                    'result' => $result,
                    'msg' => $product->errors()
                ]);
            } else {
                return $res->setJSON([
                    'result' => true,
                    'msg' => '상품등록을 하였습니다.'
                ]);
            }
        } catch (\ReflectionException | DataException $e) {
            return $res->setJSON($e->getMessage());
        }

    }


    //간이 수정 버튼(게시줄오른쪽) 누를때
    public function modifyProduct() : ResponseInterface
    {
        $product = new Product();
        $req = $this->request;
        $res = $this->response;

        $data = $req->getJSON(true);
        log_message("debug", "modifyProduct:\$data: ".print_r($data, true));

        try {
            //todo: $data에서 price컬럼에 , 값으로 구분된 값이 들어올경우 int형으로 온전히 모두 저장될려면 replace문으로 ','를 ''으로 전환해줘야한다.(완료)
                                                                //replace는 ,를 제거하여 int컬럼에 값을 넣기위해 사용함
            $sql = "update product set product_stock = ?, product_price = replace(? ,',', ''), product_spec = ?
                    where product_no = ?";
            $result = $product->db->query($sql, [$data['product_stock'], $data['product_price'], $data['product_spec'], $data['product_no']]);
//            $result = $product->update($data['product_no'], $data);
            if ($result === false) {
                return $res->setJSON([
                   'result' => $result,
                   'msg' => $product->errors()
                ]);
            } else {
                $resData = $product->find($data['product_no']);
                return $res->setJSON([
                    'result' => $result,
                    'resData' => $resData,
                    'msg' => '상품정보를 수정하였습니다.'
                ]);
            }

        } catch(\ReflectionException | DataException $e){
            return $res->setJSON($e->getMessage());
        }

    }


    //장바구니 담기 - Contentholder에서
    public function addProductInCart() : ResponseInterface
    {
        $req = $this->request;
        $res = $this->response;
        $product = new Product();
        $cart = new Cart();

        //pno , count, id
        $data = $req->getVar();
        log_message('debug', '[addProductInCart] $data: '.print_r($data, true));

        try {
            //현재 회원이 하나의 상품을 추가했을 때 그 상품이 db에 이미 존재하는지 숫자로 확인한 후, 있다면 그상품의 개수를 가져와서 지금 요청된 숫자와 합해 다시 업데이트함
            $count = $cart->where('product_no', $data['product_no'])->where('cart_owner',$data['cart_owner'])->countAllResults();
            if ($count > 0) {
                $product_count = $cart->where('product_no', $data['product_no'])->where('cart_owner',$data['cart_owner'])->findColumn('product_count');
                log_message('debug', '[addProductInCart] $product_count: '.print_r($product_count, true));
                $tmp = [ 'product_count' => $product_count[0] + $data['product_count'] ]; //update될 컬럼과 해당값 지정
                $result = $cart->where('product_no', $data['product_no'])->where('cart_owner',$data['cart_owner'])->set($tmp)->update();
                log_message('debug', '[addProductInCart] $result: '.print_r($result, true));
            } else {
                $result = $cart->insert($data);  //상품이 새로 담긴 상품이라면 추가. 입력된 recode의 기본키 반환됨.
            }
            log_message('debug', '[addProductInCart] $result: '.print_r($result, true));

            if ($result === false) {
                return $res->setJSON([
                    'result' => $result,
                    'msg' => $cart->errors()
                ]);
            } else {
                return $res->setJSON([
                    'result' => true,
                    'msg' => '장바구니에 상품을 담았습니다.'
                ]);
            }

        }catch (\ReflectionException | DataException $e){
            return $res->setJSON($e->getMessage());
        }
    }

    //장바구니 담기 - Cart에서
    public function addProductInCartAtCartPage() : ResponseInterface
    {
        $req = $this->request;
        $res = $this->response;
        $product = new Product();
        $cart = new Cart();

        //pno , count, id
        $data = $req->getVar();
        log_message('debug', '[addProductInCart] $data: '.print_r($data, true));

        try {
            //현재 회원이 하나의 상품을 추가했을 때 그 상품이 db에 이미 존재하는지 숫자로 확인한 후, 있다면 그상품의 개수를 가져와서 지금 요청된 숫자와 합해 다시 업데이트함
            $count = $cart->where('product_no', $data['product_no'])->where('cart_owner',$data['cart_owner'])->countAllResults();
            if ($count > 0) {
                $tmp = [ 'product_count' => $data['product_count'] ]; //update될 컬럼과 해당값 지정
                $result = $cart->where('product_no', $data['product_no'])->where('cart_owner',$data['cart_owner'])->set($tmp)->update();
                log_message('debug', '[addProductInCart] $result: '.print_r($result, true));
            }
            log_message('debug', '[addProductInCart] $result: '.print_r($result, true));

            if ($result === false) {
                return $res->setJSON([
                    'result' => $result,
                    'msg' => $cart->errors()
                ]);
            } else {
                return $res->setJSON([
                    'result' => true,
                    'msg' => '장바구니에 상품을 담았습니다.'
                ]);
            }

        }catch (\ReflectionException | DataException $e){
            return $res->setJSON($e->getMessage());
        }
    }

    //장바구니 목록 가져오기
    public function getCart() :ResponseInterface
    {
        $req = $this->request;
        $res = $this->response;
        $product = new Product();
        $productImg = new Product_image();
        $cart = new Cart();

        $data = $req->getVar();
        log_message('debug', '[getCart] $data: '.print_r($data, true));

        try {
            $resData = $cart->join('product', 'product.product_no = cart.product_no')->where('cart_owner', $data['cart_owner'])->findAll();
            log_message('debug', '[getCart] $result: '.print_r($resData, true));

            for ($i=0; $i<count($resData); $i++) {
                $product_image = $productImg->where('product_no', $resData[$i]['product_no'])->findColumn('stored_file_name');
                $resData[$i]['product_image'] = $product_image;
            }

            return $res->setJSON($resData);

        } catch (\ReflectionException | DataException $e){
            return $res->setJSON($e->getMessage());
        }
    }

    //장바구니에서 상품 삭제
    public function deleteCart(): ResponseInterface
    {
        $req = $this->request;
        $res = $this->response;
        $cart = new Cart();

        $data = $req->getVar();
        log_message('debug', '[deleteCart] $data: '.print_r($data, true));

        try {
            $resData = $cart->delete($data['cart_no']);

            if ($resData === false) {
                return $res->setJSON([
                    'result' => $resData,
                    'msg' => '장바구니 삭제에 실패했습니다.'
                ]);
            } else {
                return $res->setJSON([
                    'result' => true,
                    'msg' => '장바구니 삭제 성공!'
                ]);
            }

        } catch (\ReflectionException | DataException $e){
            return $res->setJSON($e->getMessage());
        }
    }

    //장바구니에서 선택된 상품 모두 삭제
    public function deleteCheckedCart(): ResponseInterface
    {
        $req = $this->request;
        $res = $this->response;
        $cart = new Cart();

        $data = $req->getVar();
        log_message('debug', '[deleteCheckedCart] $data: '.print_r($data, true));

        try {
            $resData = $cart->whereIn('cart_no', $data['cart_numbers'])->delete();

            if ($resData === false) {
                return $res->setJSON([
                    'result' => $resData,
                    'msg' => '장바구니 삭제에 실패했습니다.'
                ]);
            } else {
                return $res->setJSON([
                    'result' => true,
                    'msg' => '장바구니 삭제 성공!'
                ]);
            }

        } catch (\ReflectionException | DataException $e){
            return $res->setJSON($e->getMessage());
        }
    }









}