<?php

namespace App\CustomClass;

use App\Main_department;

class MainDepartment{
    private $id;
    private $depart_name;
    private $sub_depart_data;

    public function __construct($id)
    {
        $depart=Main_department::where('id',$id)->firstOrFail();
        $this->setId($depart->id);
        $this->setDepart_name($depart->depart_name);
        $this->setSub_depart_data($depart->subDepartments);
    }

    public function singleDepart(){
        $arr=[
            'id' => $this->getId(),
            'depart_name' => $this->getDepart_name(),
            'sub_depart_data' => $this->getSub_depart_data()
        ];
        return $arr;
    }

    public static function allDepartData($data_arr){
        $arr=[];
        foreach($data_arr as $data){
            $obj=new MainDepartment($data->id);
            array_push($arr,$obj->singleDepart());
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

    /**
     * Get the value of sub_depart_data
     */ 
    public function getSub_depart_data()
    {
        return $this->sub_depart_data;
    }

    /**
     * Set the value of sub_depart_data
     *
     * @return  self
     */ 
    public function setSub_depart_data($sub_depart_data)
    {
        $this->sub_depart_data = $sub_depart_data;

        return $this;
    }
}