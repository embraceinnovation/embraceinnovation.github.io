<?php
    class DBUtil
    {
        static private $conn;

        static public function Connect() {
            $Host="aws-0-us-west-1.pooler.supabase.com";
            $Database="postgres";
            $User="postgres.hpiypchogihjtfcfiypu";
            $Port="5432";
            $Password="mxAgDWXqif1kUOlX";

            self::$conn = new PDO('pgsql:host='.$Host.';dbname='.$Database, $User, $Password);
        }

        static public function FetchItems($page = 1, $limit = 50) {
            $offset = $limit * ($page - 1);
            $exec_sql = self::_SelectQuery(). " LIMIT $limit OFFSET $offset";
            $q = self::$conn->query($exec_sql);
            $q->setFetchMode(PDO::FETCH_ASSOC);
            $arr = $q->fetchAll();

            return $arr;
        }

        static public function FetchItem($id) {
            $exec_sql = self::_SelectQuery(). " WHERE sfid = '".pg_escape_string($id)."'";
            $q = self::$conn->query($exec_sql);
            $q->setFetchMode(PDO::FETCH_ASSOC);
            $item = $q->fetch();
            return $item;
        }

        static private function _GenerateUniqueId() {
            return str_pad(uniqid().random_int(0,9999), 18,"0");
        }
        // 

        static public function InsertItem($data) {
            $extra_cols = [
                'sfid' => "'".self::_GenerateUniqueId()."'",
                'isdeleted'=> 'false',
                'createddate'=> 'current_timestamp',
                // 'systemmodstamp'=> 'current_timestamp',
                // 'account__c'=> "''",
                // 'createdbyid'=> "'005d0000001IKOpAAO'",
            ];
            $cols =  array_diff(self::_GetColumns(), array("sfid"));


            $sql = "INSERT INTO salesforce.directory_account__c ( ";
            
            //Columns to be inserted in table
            foreach($cols as $col) {
                $sql .= $col . ",";
            }
            foreach($extra_cols as $col=>$val) {
                $sql .= $col . ",";
            }
            $sql = trim($sql, ",");

            $sql .= ") VALUES ( ";

            //Setting values to be inserted in specific columns.
            foreach($cols as $col) {
                $sql .= "'" . pg_escape_string($data[$col]) . "',";
            }
            foreach($extra_cols as $col=>$val) {
                $sql .= pg_escape_string($val) . ",";
            }
            $sql = trim($sql, ","). ")";

            $stmt= self::$conn->prepare($sql);
            $stmt->execute();
            $count = $stmt->rowCount();

            return $count;
        }

        static public function UpdateItem($data) { 

            $cols =  array_diff(self::_GetColumns(), array("sfid"));
            $sql = "UPDATE salesforce.directory_account__c SET ";

            //Columns to be updated in table
            foreach($cols as $col) {
                $sql .= $col . " = '" . pg_escape_string(@$data[$col])."',";
            }
            $sql = trim($sql, ",");

            $sql .= " WHERE sfid = '".pg_escape_string($data['sfid'])."'";

            $stmt= self::$conn->prepare($sql);
            $stmt->execute();
            $count = $stmt->rowCount();

            return $count;
        }

        static private function _GetColumns() {
            $cols = [
                "sfid",
                "directory_contact_last_name__c", 
                "directory_address_street__c", 
                "directory_phone_area_code__c", 
                "directory_address_country__c", 
                "directory_phone_country_code__c", 
                "name", 
                "booth__c", 
                "directory_mobile_number__c", 
                "directory_address_state__c", 
                "directory_phone_number__c", 
                "directory_contact_email__c", 
                "directory_contact_first_name__c", 
                "directory_website__c", 
                "directory_address_city__c", 
                "company_name_in_directory__c", 
                "directory_address_postal_code__c", 
                "other_seafood__c", 
                "quality_control__c", 
                "packing_equipment__c", 
                "refrigeration_freezing_equipment__c", 
                "service__c", 
                "fishing_machinery_gear__c", 
                "aquaculture_tech_equipment__c", 
                "value_added_products__c", 
                "processing_equipment_matls__c", 
                "shellfish__c", 
                "finfish__c", 
                "directory_mobile_country_code__c", 
                "directory_mobile_area_code__c",
                "other_products_services__c"
            ];

            return $cols;
        }

        static private function _SelectQuery() {
            $cols = self::_GetColumns();

            $sql = "SELECT ";
            foreach($cols as $col) {
                $sql .= $col . ",";
            }
            $sql = trim($sql, ",");

            $sql .= " FROM public.directory_account__c";

            return $sql;
        }
    }

    class PathUtil {
        static private function _GetRequestProtocol() {
            if(!empty($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
                return $_SERVER['HTTP_X_FORWARDED_PROTO'];
            } else {
                return !empty($_SERVER['HTTPS']) ? "https" : "http";
            }
        }

        static public function GetCurrentPath() {
            $path = self::_GetRequestProtocol() . "://".$_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']);
            $path = trim(str_replace("\\","/",$path),"/")."/";
            return $path;
        }
    }
?>
