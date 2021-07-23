<?php

namespace App\CustomClass;

use App\Letter;
use App\Sub_department;

class LetterData{
   private $id;
   private $letter_no;
   private $date;
   private $title;
   private $purpose_letter;
   private $detail;
   private $attach_file;
   private $created_at;
   private $su_depart_letter_data;
   private $is_read;
   private $type;
   private $key_code;

   public function __construct($id)
   {    
       $letter=Letter::where('id',$id)->firstOrfail();
       $this->setId($letter->id);
       $this->setLetter_no($letter->letter_no);
       $this->setDate($letter->date);
       $this->setTitle($letter->title);
       $this->setPurpose_letter($letter->purpose_letter);
       $this->setDetail($letter->detail);
       $this->setAttach_file($letter->attach_file);   
       $this->setCreated_at($letter->created_at->format('h:i:s(a)'));
       $this->setSu_depart_letter_data($letter->subDepartmentLetters);
       $this->setIs_read($letter->is_read);
       $this->setType($letter->type);
       $this->setKey_code($letter->key_code);
   }

   public function dateBetweenSearchData($from,$to,$out_sub_depart_id){
      $res=[];
      if($from <= $this->date && $this->date <= $to){
         $res=$this->singleLetterData();
         $out_sub_depart=Sub_department::where('id',$out_sub_depart_id)->first();
         $res['from_sub_depart_name']=$out_sub_depart->name;
         return $res;
      }
   }

   public function singleLetterData(){
      return [
         'id' => $this->getId(),
         'letter_no' => $this->getLetter_no(),
         'date' => $this->getDate(),
         'title' => $this->getTitle(),
         'purpose_letter' => $this->getPurpose_letter(),
         'detail' => $this->getDetail(),
         'attach_file' => $this->getAttach_file(),
         'created_at' => $this->getCreated_at(),
         'sub_depart_letter_data' => $this->getSu_depart_letter_data(),
         'is_read' => $this->getIs_read(),
         'type' => $this->getType(),
         'key_code' => $this->getKey_code()
      ];
   }

   public static function allLetterData($data_arr){
      $arr=[];
      foreach($data_arr as $data){
         $obj=new LetterData($data->id);
         array_push($arr,$obj->singleLetterData());
      }
      return $arr;
   }

   /**
    * Get the value of letter_no
    */ 
   public function getLetter_no()
   {
      return $this->letter_no;
   }

   /**
    * Set the value of letter_no
    *
    * @return  self
    */ 
   public function setLetter_no($letter_no)
   {
      $this->letter_no = $letter_no;

      return $this;
   }

   /**
    * Get the value of date
    */ 
   public function getDate()
   {
      return $this->date;
   }

   /**
    * Set the value of date
    *
    * @return  self
    */ 
   public function setDate($date)
   {
      $this->date = $date;

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
    * Get the value of purpose_letter
    */ 
   public function getPurpose_letter()
   {
      return $this->purpose_letter;
   }

   /**
    * Set the value of purpose_letter
    *
    * @return  self
    */ 
   public function setPurpose_letter($purpose_letter)
   {
      $this->purpose_letter = $purpose_letter;

      return $this;
   }

   /**
    * Get the value of detail
    */ 
   public function getDetail()
   {
      return $this->detail;
   }

   /**
    * Set the value of detail
    *
    * @return  self
    */ 
   public function setDetail($detail)
   {
      $this->detail = $detail;

      return $this;
   }

   /**
    * Get the value of attach_file
    */ 
   public function getAttach_file()
   {
      return $this->attach_file;
   }

   /**
    * Set the value of attach_file
    *
    * @return  self
    */ 
   public function setAttach_file($attach_file)
   {
      $this->attach_file = $attach_file;

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
    * Get the value of created_at
    */ 
   public function getCreated_at()
   {
      return $this->created_at;
   }

   /**
    * Set the value of created_at
    *
    * @return  self
    */ 
   public function setCreated_at($created_at)
   {
      $this->created_at = $created_at;

      return $this;
   }

   /**
    * Get the value of su_depart_letter_data
    */ 
   public function getSu_depart_letter_data()
   {
      return $this->su_depart_letter_data;
   }

   /**
    * Set the value of su_depart_letter_data
    *
    * @return  self
    */ 
   public function setSu_depart_letter_data($su_depart_letter_data)
   {
      $this->su_depart_letter_data = $su_depart_letter_data;

      return $this;
   }

   /**
    * Get the value of is_read
    */ 
   public function getIs_read()
   {
      return $this->is_read;
   }

   /**
    * Set the value of is_read
    *
    * @return  self
    */ 
   public function setIs_read($is_read)
   {
      $this->is_read = $is_read;

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

   /**
    * Get the value of key_code
    */ 
   public function getKey_code()
   {
      return $this->key_code;
   }

   /**
    * Set the value of key_code
    *
    * @return  self
    */ 
   public function setKey_code($key_code)
   {
      $this->key_code = $key_code;

      return $this;
   }
}