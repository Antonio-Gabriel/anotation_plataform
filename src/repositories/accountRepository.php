<?php

require_once("./src/database/database.php");
require_once("./src/entities/account.php");
require_once("./src/entities/location.php");
require_once("./src/entities/contact.php");

class AccountRepository {

    private $db_ist;    

    public function __construct() {
        $this->db_ist = new Database();
    }

    public function create(Account $userAccount): bool {

        $user_inserted_id = $this->createUser($userAccount->user);

        if($user_inserted_id == 0 ) throw new Exception("Error Processing Request verify your data", 409);
        
        try {

            $statement = $this->db_ist->connect()->prepare(
                " insert into account(
                    attr_password, attr_avatar, 
                    user_iduser
                    ) values (
                        :attr_password, :attr_avatar, 
                        :user_iduser
                    ); "
            );
    
            try {
                
                $this->db_ist->connect()->beginTransaction();
                $statement->execute([
                    ":attr_password" => $userAccount->hash_pass(), 
                    ":attr_avatar" => "Null", 
                    ":user_iduser" => $user_inserted_id
                ]);   
               
                $this->db_ist->connect()->commit();

                if($statement->rowCount() > 0)
                    return true;

                $statement->closeCursor();                              

            } catch (\PDOException $ex) {                
                $this->db_ist->connect()->rollBack();
                throw new PDOException($ex->getMessage());
            }
        
        } catch (\PDOException $ex) {
            throw new PDOException($ex->getMessage());
        }                        

        return false;
    }

    private function createContact(Contact $contact): int {

        try {

            $statement = $this->db_ist->connect()->prepare(
                " insert into contacts(attr_phone) values (:nr_phone); "
            );
    
            try {
                
                $this->db_ist->connect()->beginTransaction();
                $statement->execute([
                    ":nr_phone" => $contact->contact
                ]);   

                // Capture The Last Inserted Id on Current user
                $currentId = 
                    $this->db_ist->connect()
                    ->query("select last_insert_id() as 'id';")
                    ->fetch(PDO::FETCH_ASSOC);

                $this->db_ist->connect()->commit();
                                                
                $statement->closeCursor();
                
                return $currentId['id'];

            } catch (\PDOException $ex) {                
                $this->db_ist->connect()->rollBack();
                throw new PDOException($ex->getMessage());
            }
        
        } catch (\PDOException $ex) {
            throw new PDOException($ex->getMessage());
        }                        
    }

    private function createLocation(Location $location): int {

        try {

            $statement = $this->db_ist->connect()->prepare(
                " insert into usr_location(city, road, district) values (:city, :road, :district); "
            );
    
            try {
                
                $this->db_ist->connect()->beginTransaction();
                $statement->execute([
                    ":city" => $location->city,
                    ":road" => $location->road,
                    ":district" => $location->district
                ]);   

                // Capture The Last Inserted Id on Current user
                $currentId = 
                    $this->db_ist->connect()
                    ->query("select last_insert_id() as 'id';")
                    ->fetch(PDO::FETCH_ASSOC);

                $this->db_ist->connect()->commit();
                                                
                $statement->closeCursor();
                
                return $currentId['id'];

            } catch (\PDOException $ex) {                
                $this->db_ist->connect()->rollBack();
                throw new PDOException($ex->getMessage());
            }
        
        } catch (\PDOException $ex) {
            throw new PDOException($ex->getMessage());
        }                        
    }

    private function createUser(User $user): int {
        try {

            if ($user->isNullOrEmptyAttributes()){                
                throw new PDOException("Have a empty attribute, verify!.");                       

                return 0;
            }

            if (!$user->isValidEmailAddress()) {                
                throw new PDOException("Invalid Email Address");       
                
                return 0;
            }

            if (!$user->isValidPhoneNumber()) {                
                throw new PDOException("Invalid Phone Number");
                
                return 0;
            }

            $location_inserted_id =  $this->createLocation($user->location);
            $contact_inserted_id = $this->createContact($user->contacts);

            $statement = $this->db_ist->connect()->prepare(
                " insert into user(
                    attr_name, attr_email, 
                    stage_area, created_at, 
                    updated_at, contacts_idcontacts, 
                    usr_location_idusr_location
                    ) values (
                        :attr_name, :attr_email, 
                        :stage_area, now(), 
                        now(), :contacts_idcontacts, 
                        :usr_location_idusr_location
                    ); "
            );
    
            try {
                
                $this->db_ist->connect()->beginTransaction();               

                $statement->execute([
                    ":attr_name" => $user->attr_name, 
                    ":attr_email" => $user->attr_email, 
                    ":stage_area" => $user->stage_area,
                    ":contacts_idcontacts" => $contact_inserted_id, 
                    ":usr_location_idusr_location" => $location_inserted_id
                ]);   

                // Capture The Last Inserted Id on Current user
                $currentId = 
                    $this->db_ist->connect()
                    ->query("select last_insert_id() as 'id';")
                    ->fetch(PDO::FETCH_ASSOC);

                $this->db_ist->connect()->commit();
                                                
                $statement->closeCursor();
                
                return $currentId['id'];

            } catch (\PDOException $ex) {                
                $this->db_ist->connect()->rollBack();
                throw new PDOException($ex->getMessage());
            }
        
        } catch (\PDOException $ex) {
            throw new PDOException($ex->getMessage());
        }                       
    }

    public function getUserAccount() {}

}