<?php
    class Auth_Vk {

        private $code;
        private $token;
        private $uid;

        public function __construct() {
            require "config.php";
        }

        public function set_code($code) {
            $this->code = $code;
        }

        public function set_token($token) {
            $this->token = $token;
        }

        public function set_uid($id) {
            $this->uid = $id;
        }

        public function redirect($url) {
            header('HTTP/1.1 301 Moved Permanently');
            header("Location:".$url);
            exit();
        }

        public function get_token() {
            if(!$this->code) {
                exit("Не верный код");
            }

            $ku = curl_init();
            $query = "client_id=".APP_ID."&client_secret=".APP_SECRET."&code=".$this->code."&redirect_uri=".REDIRECT_URI;
            curl_setopt($ku,CURLOPT_URL,URL_ACCESS_TOKEN."?".$query);
            curl_setopt($ku,CURLOPT_RETURNTRANSFER,TRUE);

            $result = curl_exec($ku);
            curl_close($ku);

            $ob = json_decode($result);
            if($ob->access_token) {
                $this->set_token($ob->access_token);
                $this->set_uid($ob->user_id);
                return TRUE;
            }
            elseif($ob->error) {
                $_SESSION['error'] = "Ошибка";
                return FALSE;
            }
        }

        public function get_data() {
            if(!$this->token) {
                exit('Wrong code');
            }

            if(!$this->uid) {
                exit('Wrong code');
            }

            $query_1 = "user_id=".$this->uid."&fields=first_name,last_name&access_token=".$this->token;
            $kur_1 = curl_init();

            curl_setopt($kur_1, CURLOPT_URL, URL_GET_USER."?".$query_1);
            curl_setopt($kur_1, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($kur_1, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($kur_1,CURLOPT_RETURNTRANSFER,TRUE);

            $result_user = curl_exec($kur_1);
            print_r($result_user);
            curl_close($kur_1);

            $_SESSION['user'] = json_decode($result_user);

            $query_2 = "user_id=".$this->uid."&order=random&count=5&fields=first_name,last_name&access_token="
                .$this->token;
            $kur_2 = curl_init();

            curl_setopt($kur_2, CURLOPT_URL, URL_GET_FRIENDS."?".$query_2);
            curl_setopt($kur_2, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($kur_2, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($kur_2,CURLOPT_RETURNTRANSFER,TRUE);

            $result_friends = curl_exec($kur_2);
            curl_close($kur_2);

            $_SESSION['friends'] = json_decode($result_friends);

            $this->redirect("http://t-platform.xyz");
        }
    }
?>
