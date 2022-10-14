<?php

namespace App\Models;

use CodeIgniter\Model;

class Book extends Model
{
    protected $table = 'books';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'id', 'name', 'author', 'category', 'pages', 'price', 'publisher', 'translator', 'barcode', 'description'
    ];

    protected $useTimestamps = false;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [
        'id' => 'required|numeric',
        'name' => 'required|is_unique[books.name]',
        'price' => 'required|numeric'
    ];
    protected $validationMessages = [
        'id' => [
            'required' => 'id alani bos birakilamaz',
            'numeric' => 'sadece sayisal karakter girebilirsiniz'
        ],
        'name' => [
            'required' => 'isim alani bos birakilamaz',
            'is_unique' => 'Veri zaten kayitli, farkli bir isim deneyin'
        ],
        'price' => [
            'required' => 'fiyat alani bos birakilamaz',
            'numeric' => 'lutfen sadece sayisal karakter giriniz'
        ]
    ];
    protected $skipValidation = false;

    public function testing()
    {

        $query = $this->db->query("SELECT * FROM books");
        return $query->getResultArray();
    }
    
    public function insertBook($data)
    {

        // $sql="INSERT INTO books set name= :name:, author= :author:, price= :price:";
        // $query=$this->db->query($sql,[
        //     'name'=>$data['name'],
        //     'author'=>$data['author'],
        //     'price'=>$data['price']
        // ]);

        $query = $this->db->query("INSERT INTO books set name= :name:, author= :author:, price=:price:", [
            'name' => $data['name'],
            'author' => $data['author'],
            'price' => $data['price']
        ]);
        return $query;
    }

    public function deleteBook($data)
    {
        $query = $this->db->query("DELETE FROM books where id= :id:", [
            'id' => trim($data['id'], ' ')
        ]);
        return $query;
    }
    public function updateBook($data)
    {
        $query = $this->db->query("UPDATE books SET name= :name:, author= :author:, price= :price: where id= :id:", [
            'author' => $data['author'],
            'name' => $data['name'],
            'price' => $data['price'],
            'id' => trim($data['id'], ' ')
        ]);
        return $query;
    }
}
