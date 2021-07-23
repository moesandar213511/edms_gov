<?php

namespace App\CustomClass;

use App\Main_department;

class MainDepartment{
    private $id;
    private $depart_name;

    public function __construct($id)
    {
        $depart=Main_department::where('id',$id)->firstOrFail();
        $this->setId($depart->id);
        $this->setDepart_name($depart->depart_name);
    }

    public function singleDepart(){
        $arr=[
            'id' => $this->getId(),
            'depart_name' => $this->getDepart_name()
        ];
        return $arr;
    }

    // public static function allDepartData($data_arr){
    //    return $data_arr;
    // }

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
     * Get the value of depart_name
     */ 
    public function getDepart_name()
    {
        return $this->depart_name;
    }

    /**
     * Set the value of depart_name
     *
     * @return  self
     */ 
    public function setDepart_name($depart_name)
    {
        $this->depart_name = $depart_name;

        return $this;
    }
}