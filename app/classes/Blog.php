<?php


namespace App\classes;


class Blog
{

    protected $title;
    protected $a_name;
    protected $description;
    protected $imageName;
    protected $image;
    protected $directory;
    protected $fileName;
    protected $file;
    protected $data;
    protected $array;
    protected $array1;
    protected $array2;

    public function __construct($post = null)
    {
        if ($post){
            $this->title = $post['title'];
            $this->a_name = $post['a_name'];
            $this->description = $post['description'];
        }


//        echo '<pre>';
//        print_r($post);
//        print_r($_FILES);
    }

    public function index(){

        $this->image = $this->imageUpload();
        $this->fileName = 'db.txt';
        $this->file = fopen('db.txt', 'a');
        $this->data = "$this->title,$this->a_name,$this->description,$this->image$";
        fwrite($this->file, $this->data);
        fclose($this->file);
        return 'Data set successfully';
    }
    protected function imageUpload(){

        $this->imageName = $_FILES['image']['name'];
        $this->directory = 'assets/img/upload/'.$this->imageName;
        move_uploaded_file($_FILES['image']['tmp_name'], $this->directory);
        return $this->directory;
    }
    public function getAllBlogs(){

        $this->fileName = 'db.txt';
        $this->data = file_get_contents($this->fileName);
        $this->array = explode('$', $this->data);
        foreach ($this->array as $key => $value){

            $this->array2 = explode(',', $value);

            if ($this->array2[0]){

                $this->array1[$key]['title'] = $this->array2[0];
                $this->array1[$key]['author'] = $this->array2[1];
                $this->array1[$key]['description'] = $this->array2[2];
                $this->array1[$key]['image'] = $this->array2[3];
            }

        }
        return $this->array1;
    }
}