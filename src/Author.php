<?php
class Author {

  private $last_name;
  private $first_name;
  private $id;

  function __construct($last_name, $first_name, $id = null)
  {
    $this->last_name = $last_name;
    $this->first_name = $first_name;
    $this->id = $id;
  }

  function getLastName()
  {
    return $this->last_name;
  }
  function getFirstName()
  {
    return $this->first_name;
  }
  function getId()
  {
    return $this->id;
  }

  function setFirstName($new_first_name)
  {
    $this->first_name = $new_first_name;
  }
  function setLastName($new_last_name)
  {
    $this->last_name = $new_last_name;
  }


  

} ?>
