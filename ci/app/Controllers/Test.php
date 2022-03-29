<?php

namespace App\Controllers;

use CodeIgniter\CodeIgniter;

class Test extends BaseController
{
    public function index()
    {
        return view('welcome_message');
    }
    public function index2()
    {
      return view('dist/index.html');
    }

    /**
     * @return CLIRequest|IncomingRequest
     */
    public function testRes() : \CodeIgniter\HTTP\Response
    {
        $data = [
            'name'=>"ci4",
            'type'=>"json",
            'age'=>"20"
        ];

        $res = $this->response->setJSON($data);

        return $res;
    }

    public function valid(){ // (1)
        $input = $this->validate([ // (2) post&get 등의 요청을 유효성 검사하는 메소드
            "name" => [ // (3)
                'rules' => 'required|min_length[4]|max_length[10]', // (4)
                'errors' => [ // (5)
                    'required' => '이름이 필요합니다',
                    'min_length' => '이름은 최소 4글자 이상입니다.',
                    'max_length' => '이름은 최대 10글자 이하입니다.'
                ]
            ],
            "age" => [ // (6)
                'rules' => 'required|is_natural|less_than[150]', // (7)
                'errors' => [ // (8)
                    'required' => '필수값입니다', // (9)
                    'is_natural' => "나이는 자연수여야 합니다.",
                    'less_than' => "정말 150세 이상이신가요?"
                ]
            ]
        ]);

        if ($input){ // (10)
            return $this->response->setJSON("성공했습니다."); // (11)
        }else{
            $errors = $this->validator->getErrors();
            return // (12)
                $this
                    ->response
                    ->setStatusCode(400, "bad parameter") // (13)
                    ->setJSON($errors);
        }
    }

    public function redirect()  //리다이렉트 /로 감.
    {
        $this->response->redirect("/"); // (1)
    }

}
