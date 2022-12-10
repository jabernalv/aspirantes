<?php
class Person
    {
       public $name;

       public function save()
       {
          print_r($this);
       }
    }

   $p = new Person;
   $p->name = "Ganga";
   $p->age = 23;

   $p->save();

