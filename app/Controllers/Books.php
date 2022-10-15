<?php

namespace App\Controllers;

use App\Models\Book as bookModel;

class Books extends BaseController
{
    private $books;

    public function __construct()
    {
        $this->books = new bookModel();
    }

    public function index()
    {
        $data["books"] = $this->books->testing();
        echo json_encode($data);
    }

    public function insertBook()
    {
        $data = [
            'name' => $this->request->getVar('name'),
            'author' => $this->request->getVar('author'),
            'price' => $this->request->getVar('price')
        ];
        $valid = $this->books->validate($data);

        if ($valid) {
            $stmt = $this->books->insertBook($data);
        } else {
            $errors = $this->books->errors();
        }


        if (!isset($stmt)) {
            echo json_encode(
                ['hata' => $errors]
            );
        } else {
            echo json_encode(
                ['message' => 'kitap ekleme basarili']
            );
        }
    }

    public function deleteBook()
    {
        $data['id'] = $this->request->getVar('id');

        $valid = $this->books->validate($data);

        if ($valid) {
            $stmt = $this->books->deleteBook($data);
        } else {
            $errors = $this->books->errors();
        }


        if (isset($errors)) {

            echo json_encode(
                ['message' => $errors]
            );
        } else {
            echo json_encode(
                ['message' => 'kitap basariyla silindi']
            );
        }
    }

    public function updateBook()
    {
        $data = [
            'name' => $this->request->getVar('name'),
            'author' => $this->request->getVar('author'),
            'price' => $this->request->getVar('price'),
            'id' => $this->request->getVar('id'),
        ];
        $validate = $this->books->validate($data);

        if ($validate) {
            $stmt = $this->books->updateBook($data);
        } else {
            $errors = $this->books->errors();
            $status = ['message' => $errors];
        }

        if (!isset($errors)) {
            $status = ['message' => 'kitap guncelleme basarili'];
        } else {
            $status = ['message' => $errors];
        }

        echo json_encode($status);
    }

    public function findBook()
    {
        $data["id"] = $this->request->getVar('id');


        $validate = $this->books->validate($data);

        if ($validate) {
            $stmt = $this->books->findBook($data);
        } else {
            $errors = $this->books->errors();
        }

        if (!isset($errors)) {
            if ($stmt) {
                $status = [
                    'message' => 'Aranan kitap bulundu',
                    'result' => $stmt
                ];
            } else {
                $status = [
                    'message' => 'Aranan kitap bulunamadi',

                ];
            }
        } else {
            $status = [
                'message' => 'hata var adamim  ',
                'result' => $errors
            ];
        }
        echo json_encode($status);
    }
}
