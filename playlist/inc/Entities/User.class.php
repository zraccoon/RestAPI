
<?php

// +----------+------------------+------+-----+---------+----------------+
//| Field    | Type             | Null | Key | Default | Extra          |
//+----------+------------------+------+-----+---------+----------------+
//| UserID   | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
//| FirstName| varchar(50)      | NO   |     | NULL    |                |
//| LastName | varchar(50)      | NO   |     | NULL    |                |
//| Email    | varchar(50)      | NO   |     | NULL    |                |
//+----------+------------------+------+-----+---------+----------------+
//4 rows in set (0.00 sec)

class User  {

    private $UserID;
    private $FirstName;
    private $LastName;
    private $Email;    


    //Getters
    function getUserID() : string     {
        return $this->UserID;
    }

    function getFirstName() : string   {
        return $this->FirstName;
    }

    function getLastName() : string {
        return $this->LastName;
    }

    function getEmail() : string {
        return $this->Email;
    }

    
    //Setters
    

    function setUserID(string $newUserID)   {
        $this->UserID = $newUserID;
    }

    function setFirstName(string $newFirstName)   {
        $this->FirstName = $newFirstName;
    }

    function setLastName(string $newLastName)  {
        $this->LastName = $newLastName;
    }

    function setEmail(string $newEmail) {
        $this->Email = $newEmail;
    }


    

    //function addition serialize
    function jsonSerialize()    {

        // $vars = get_object_vars($this);
        // return $vars;

        //Make a standard class
        $obj = new StdClass;
        $obj->UserID = $this->getUserID();
        $obj->FirstName = $this->getFirstName();        
        $obj->LastName = $this->getLastName();
        $obj->Email = $this->getEmail();

        //Return the standard class
        return $obj;
    }
}

?>