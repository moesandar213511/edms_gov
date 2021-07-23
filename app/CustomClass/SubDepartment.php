<?php

namespace App\CustomClass;

use App\Sub_department;

class SubDepartment{
   private $id;
   private $name;
   private $main_depart_id;
   private $office_phone;
   private $human_phone;
   private $address;
   private $logo;
   private $latitude;
   private $longitude;
   private $type;

   public function __construct($id)
   {
        $sub_depart=Sub_department::where('id',$id)->firstOrFail();
        $this->setId($sub_depart->id);
        $this->setName($sub_depart->name);
        $this->setMain_depart_id($sub_depart->main_depart_id);
        $this->setOffice_phone($sub_depart->office_phone);
        $this->setHuman_phone($sub_depart->human_phone);
        $this->setAddress($sub_depart->address);
        $this->setLogo($sub_depart->logo);
        $this->setLatitude($sub_depart->latitude);
        $this->setLongitude($sub_depart->longitude);
        $this->setType($sub_depart->type);
   }

   public function singleSubDepart(){
      return [
         'id' => $this->getId(),
         'name' => $this->getName(),
         'main_depart_id' => $this->getMain_depart_id(),
         'office_phone' => $this->getOffice_phone(),
         'human_phone' => $this->getHuman_phone(),
         'address' => $this->getAddress(),
         'logo' => $this->getLogo(),
         'latitude' => $this->getLatitude(),
         'longitude' => $this->getLongitude(),
         'type' => $this->getType()
      ];
   }

   public static function allSubDepartData($data_arr){
      $arr=[];
      foreach($data_arr as $data){
         $obj=new SubDepartment($data->id);
         array_push($arr,$obj->singleSubDepart());
      }
      return $arr;
   }

   /**
    * Get the value of name
    */ 
   public function getName()
   {
      return $this->name;
   }

   /**
    * Set the value of name
    *
    * @return  self
    */ 
   public function setName($name)
   {
      $this->name = $name;

      return $this;
   }

   /**
    * Get the value of main_depart_id
    */ 
   public function getMain_depart_id()
   {
      return $this->main_depart_id;
   }

   /**
    * Set the value of main_depart_id
    *
    * @return  self
    */ 
   public function setMain_depart_id($main_depart_id)
   {
      $this->main_depart_id = $main_depart_id;

      return $this;
   }

   /**
    * Get the value of office_phone
    */ 
   public function getOffice_phone()
   {
      return $this->office_phone;
   }

   /**
    * Set the value of office_phone
    *
    * @return  self
    */ 
   public function setOffice_phone($office_phone)
   {
      $this->office_phone = $office_phone;

      return $this;
   }

   /**
    * Get the value of human_phone
    */ 
   public function getHuman_phone()
   {
      return $this->human_phone;
   }

   /**
    * Set the value of human_phone
    *
    * @return  self
    */ 
   public function setHuman_phone($human_phone)
   {
      $this->human_phone = $human_phone;

      return $this;
   }

   /**
    * Get the value of address
    */ 
   public function getAddress()
   {
      return $this->address;
   }

   /**
    * Set the value of address
    *
    * @return  self
    */ 
   public function setAddress($address)
   {
      $this->address = $address;

      return $this;
   }

   /**
    * Get the value of logo
    */ 
   public function getLogo()
   {
      return $this->logo;
   }

   /**
    * Set the value of logo
    *
    * @return  self
    */ 
   public function setLogo($logo)
   {
      $this->logo = Path::$path.'upload/sub_depart_logo/'.$logo;

      return $this;
   }

   /**
    * Get the value of latitude
    */ 
   public function getLatitude()
   {
      return $this->latitude;
   }

   /**
    * Set the value of latitude
    *
    * @return  self
    */ 
   public function setLatitude($latitude)
   {
      $this->latitude = $latitude;

      return $this;
   }

   /**
    * Get the value of longitude
    */ 
   public function getLongitude()
   {
      return $this->longitude;
   }

   /**
    * Set the value of longitude
    *
    * @return  self
    */ 
   public function setLongitude($longitude)
   {
      $this->longitude = $longitude;

      return $this;
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
    * Get the value of type
    */ 
   public function getType()
   {
      return $this->type;
   }

   /**
    * Set the value of type
    *
    * @return  self
    */ 
   public function setType($type)
   {
      $this->type = $type;

      return $this;
   }
}