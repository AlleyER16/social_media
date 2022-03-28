<?php

    require_once (dirname(__DIR__).'/classes/config/Dbh.config.php');

    class Users extends Dbh{

        private const USERS_TABLE = "users";

        public function __construct() {
            $this->db_object = $this->getConnection();
        }

        public function user_exists($unique_key, $test){

            //sanitizing variables
            $unique_key = $this->SanitizeVariable($unique_key);
            $test = $this->SanitizeVariable($test);

            //operations
            $sql = "SELECT * FROM ".self::USERS_TABLE." WHERE $unique_key = ?";
            $prepared_statement = $this->db_object->prepare($sql);
            $prepared_statement->execute([$test]);

            if($prepared_statement->rowCount() == 1){

                return [true, $prepared_statement->fetchAll()[0]];

            }else{

                return [false];

            }

        }

        public function user_exists_by_auth($username, $password){

            //sanitizing variables
            $username = $this->SanitizeVariable($username);
            $password = $this->SanitizeVariable($password);

            //operations
            $sql = "SELECT * FROM ".self::USERS_TABLE." WHERE Username = ? AND Password = ?";
            $prepared_statement = $this->db_object->prepare($sql);
            $prepared_statement->execute([$username, $password]);

            if($prepared_statement->rowCount() == 1){

                return [true, $prepared_statement->fetchAll()[0]];

            }else{

                return [false];

            }

        }

        public function add_user($full_name, $gender, $date_of_birth, $telephone, $username, $password){

            //sanitizing variables
            $full_name = $this->SanitizeVariable($full_name);
            $gender = $this->SanitizeVariable($gender);
            $date_of_birth = $this->SanitizeVariable($date_of_birth);
            $telephone = $this->SanitizeVariable($telephone);
            $username = $this->SanitizeVariable($username);
            $password = $this->SanitizeVariable($password);

            //operations
            $sql = "INSERT INTO ".self::USERS_TABLE."(FullName, Gender, DateOfBirth, Telephone, Username, Password, OnlineStatus, Timestamp) VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
            $prepared_statement = $this->db_object->prepare($sql);

            if($prepared_statement->execute([$full_name, $gender, $date_of_birth, $telephone, $username, $password, 1, time()])){
                return [true, $this->db_object->lastInsertId()];
            }else{
                return [false];
            }

        }

        public function update_user_datum($user_id, $datum_key, $new_value){

            //sanitizing variables
            $user_id = $this->SanitizeVariable($user_id);
            $datum_key = $this->SanitizeVariable($datum_key);
            $new_value = $this->SanitizeVariable($new_value);

            //operations
            $sql = "UPDATE ".self::USERS_TABLE." SET $datum_key = ? WHERE UserID = ?";
            $prepared_statement = $this->db_object->prepare($sql);

            return $prepared_statement->execute([$new_value, $user_id]);

        }

        // public function get_num_search_products($search_keyword){
        //
        //     //sanitizing variables
        //     $search_keyword = $this->SanitizeVariable($search_keyword);
        //
        //     $search_keyword = "%$search_keyword%";
        //
        //     //operations
        //     $sql = "SELECT COUNT(ProductID) as NumProducts FROM ".self::PRODUCTS_TABLE." WHERE ProductName LIKE ?";
        //     $prepared_statement = $this->db_object->prepare($sql);
        //     $prepared_statement->execute([$search_keyword]);
        //
        //     return $prepared_statement->fetchAll()[0]->NumProducts;
        //
        // }
        //
        // public function get_search_products_pagination($search_keyword, $division){
        //
        //     //operations
        //     $num_search_products = $this->get_num_search_products($search_keyword);
        //
        //     $pages = floor($num_search_products/$division);
        //
        //     return (($num_search_products % $division) > 0) ? $pages + 1 : $pages;
        //
        // }
        //
        // public function get_search_products($search_keyword, $page, $division){
        //
        //     //sanitizing variables
        //     $search_keyword = $this->SanitizeVariable($search_keyword);
        //     $page = $this->SanitizeVariable($page);
        //     $division = $this->SanitizeVariable($division);
        //
        //     $search_keyword = "%$search_keyword%";
        //
        //     $start = ($page - 1) * $division;
        //
        //     //operations
        //     $sql = "SELECT * FROM ".self::PRODUCTS_TABLE." WHERE ProductName LIKE ? ORDER BY ProductID DESC LIMIT $start, $division";
        //     $prepared_statement = $this->db_object->prepare($sql);
        //     $prepared_statement->execute([$search_keyword]);
        //
        //     return $prepared_statement->fetchAll();
        //
        // }
        //
        // public function get_num_products(){
        //
        //     $sql = "SELECT COUNT(ProductID) as NumProducts FROM ".self::PRODUCTS_TABLE;
        //     $prepared_statement = $this->db_object->prepare($sql);
        //     $prepared_statement->execute([]);
        //
        //     return $prepared_statement->fetchAll()[0]->NumProducts;
        //
        // }
        //
        // public function get_products_pagination($division){
        //
        //     //operations
        //     $num_products = $this->get_num_products();
        //
        //     $pages = floor($num_products/$division);
        //
        //     return (($num_products % $division) > 0) ? $pages + 1 : $pages;
        //
        // }
        //
        // public function get_products($page, $division){
        //
        //     //sanitizing variables
        //     $page = $this->SanitizeVariable($page);
        //     $division = $this->SanitizeVariable($division);
        //
        //     $start = ($page - 1) * $division;
        //
        //     //operations
        //     $sql = "SELECT * FROM ".self::PRODUCTS_TABLE." ORDER BY ProductID DESC LIMIT $start, $division";
        //     $prepared_statement = $this->db_object->prepare($sql);
        //     $prepared_statement->execute([]);
        //
        //     return $prepared_statement->fetchAll();
        //
        // }
        //
        // public function get_transaction_products($transaction_id){
        //
        //     //sanitizing variables
        //     $transaction_id = $this->SanitizeVariable($transaction_id);
        //
        //     //operations
        //     $sql = "SELECT * FROM ".self::TRANSACTIONS_PRODUCTS_TABLE." WHERE Transaction = ?";
        //     $prepared_statement = $this->db_object->prepare($sql);
        //     $prepared_statement->execute([$transaction_id]);
        //
        //     return $prepared_statement->fetchAll();
        //
        // }
        //
        //
        // public function update_product_stock($product_id, $value, $type){
        //
        //     //sanitizing variables
        //     $product_id = $this->SanitizeVariable($product_id);
        //     $value = $this->SanitizeVariable($value);
        //     $type = $this->SanitizeVariable($type);
        //
        //     $operator = ($type == "increase") ? "+" : "-";
        //
        //     //operations
        //     $sql = "UPDATE ".self::PRODUCTS_TABLE." SET Stock = Stock $operator ? WHERE ProductID = ?";
        //     $prepared_statement = $this->db_object->prepare($sql);
        //
        //     return $prepared_statement->execute([$value, $product_id]);
        //
        // }
        //
        // public function delete_product($product_id){
        //
        //     //sanitiing variables
        //     $product_id = $this->SanitizeVariable($product_id);
        //
        //     //operations
        //     $sql = "DELETE FROM ".self::PRODUCTS_TABLE." WHERE ProductID = ?";
        //     $prepared_statement = $this->db_object->prepare($sql);
        //
        //     return $prepared_statement->execute([$product_id]);
        //
        // }
        //
        // public function transaction_product_exists($transaction, $product){
        //
        //     //sanitizing variables
        //     $transaction = $this->SanitizeVariable($transaction);
        //     $product = $this->SanitizeVariable($product);
        //
        //     //operations
        //     $sql = "DELETE FROM ".self::TRANSACTIONS_PRODUCTS_TABLE." WHERE Transaction = ? AND Product = ?";
        //     $prepared_statement = $this->db_object->prepare($sql);
        //     $prepared_statement->execute([$transaction, $product]);
        //
        //     return ($prepared_statement->rowCount() == 1);
        //
        // }
        //
        // public function add_transaction_product($transaction, $product, $quantity, $unit_price, $amount){
        //
        //     //sanitizing variables
        //     $transaction = $this->SanitizeVariable($transaction);
        //     $product = $this->SanitizeVariable($product);
        //     $quantity = $this->SanitizeVariable($quantity);
        //     $unit_price = $this->SanitizeVariable($unit_price);
        //     $amount = $this->SanitizeVariable($amount);
        //
        //     //operations
        //     $sql = "INSERT INTO ".self::TRANSACTIONS_PRODUCTS_TABLE."(Transaction, Product, Quantity, UnitPrice, Amount) VALUES(?, ?, ?, ?, ?)";
        //     $prepared_statement = $this->db_object->prepare($sql);
        //
        //     return $prepared_statement->execute([$transaction, $product, ($quantity != "") ? $quantity : NULL, ($unit_price != "") ? $unit_price : NULL, $amount]);
        //
        // }
        //
        // public function delete_transaction_product($transaction, $product){
        //
        //     //sanitizing variables
        //     $transaction = $this->SanitizeVariable($transaction);
        //     $product = $this->SanitizeVariable($product);
        //
        //     //operations
        //     $sql = "DELETE FROM ".self::TRANSACTIONS_PRODUCTS_TABLE." WHERE Transaction = ? AND Product = ?";
        //     $prepared_statement = $this->db_object->prepare($sql);
        //
        //     return $prepared_statement->execute([$transaction, $product]);
        //
        // }

    }

?>
