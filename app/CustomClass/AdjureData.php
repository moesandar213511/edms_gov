<?php

namespace App\CustomClass;

use App\Adjure;

class AdjureData{
    private $id;
    private $title;
    private $file;
    private $description;

    public function __construct($id)
    {
        $adjure=Adjure::where('id',$id)->firstOrFail();
        $this->setId($adjure->id);
        $this->setTitle($adjure->title);
        $this->setFile($adjure->file);
        $this->setDescription($adjure->description);        
    }

    public function singleAdjureData(){
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'file' => $this->getFile(),
            'description' => $this->getDescription()
        ];
    }

    public static function allAdjureData($data_arr){
        $arr=[];
        foreach($data_arr as $data){
            $obj=new AdjureData($data->id);
            array_push($arr,$obj->singleAdjureData());
        }
        return $arr;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of file
     */ 
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set the value of file
     *
     * @return  self
     */ 
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }
}