    <?php
    class TSA
    {
            private $db;
            function __construct($DB_con)
            {
                $this->db = $DB_con;
            }

        public function check_existance($file_hash)
        {
            try
            {
                $stmt = $this->db->prepare("SELECT * FROM registered_users WHERE hash=:hash");
                $stmt->execute(array(':hash'=>$file_hash));
                $Row=$stmt->fetch(PDO::FETCH_ASSOC);
                if($file_hash === $Row['hash'])
                {
                    return 0;
                } else
                    {return 1;}
            } catch(PDOException $errorMassage)
            {
                $errorMassage->getMessage();
            }
        }
        public function hash_to_db($name, $email_address, $address, $file_hash, $tsq_hash)
        {
            $sha1hash = sha1($tsq_hash);
            $stmt = $this->db->prepare("INSERT INTO registered_users(name, email,address,hash,tsq)VALUES(:name, :email, :address, :hash, :tsq)");
            $stmt->bindparam(":name", $name);
            $stmt->bindparam(":email", $email_address);
            $stmt->bindparam(":address", $address);
            $stmt->bindparam(":hash", $file_hash);
            $stmt->bindparam(":tsq", $sha1hash);
            $stmt->execute();
        }

        public function user_details($data)
        {
            $stmt = $this->db->prepare("SELECT * FROM registered_users WHERE hash=:hash or tsq=:tsq");
            $stmt->execute(array(':hash'=>$data,':tsq'=>$data ));
            $Row=$stmt->fetch(PDO::FETCH_ASSOC);
            if($data === $Row['hash'] || $data === $Row['tsq'])
            {
                return $Row ;
            }
        }

        public function tsq($file_hash,$algorithm)
        {
            $query = "openssl ts -query -digest ".escapeshellarg($file_hash)." -".escapeshellarg($algorithm)." -cert";
            $return_data = array();
            exec($query, $return_data, $err);
            if($err == 0)
            return implode($return_data);
        }

        public function tsr($tsq)
        {
            $tsa = "https://www.freetsa.org/tsr";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $tsa);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $tsq);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/timestamp-query"));
            $returnToken = curl_exec($ch);
            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if ($status != 200 || !strlen($returnToken))
                throw new Exception("The request failed");
            return $returnToken;
        }

        public function verify_with_tsq_and_tsr($tsq_file,$tsr_file)
        {
            $temp_tsq = tmpfile();
            fwrite($temp_tsq, $tsq_file);
            $path_to_tsq= stream_get_meta_data($temp_tsq)['uri'];

            $temp_tsr = tmpfile();
            fwrite($temp_tsr, $tsr_file);
            $path_to_tsr= stream_get_meta_data($temp_tsr)['uri'];
            $tsa_pem = 'certificates/cacert.pem';
            $tsa_cert = 'certificates/tsa.crt';
            $comand_one = "openssl ts -verify -in ".escapeshellarg($path_to_tsr)." -queryfile ".escapeshellarg($path_to_tsq)." -CAfile ".escapeshellarg($tsa_pem)." -untrusted ".escapeshellarg($tsa_cert);
            $command_two = "openssl ts -reply -in ".escapeshellarg($path_to_tsr)." -text";
            $answer = array();
            exec($comand_one."&&" . $command_two." 2>&1", $answer, $err);
			 if($err == 0)
                 return $answer;
        }

        public function Verify_with_original_file($hash,$tsr )
        {
            $tsr_extracted_data = tmpfile();
            fwrite($tsr_extracted_data, $tsr);
            $path = stream_get_meta_data($tsr_extracted_data)['uri'];
            $cert = 'certificates/cacert.pem';
            $query1 = "openssl ts -verify -digest ".escapeshellarg($hash)." -in ".escapeshellarg($path)." -CAfile ".escapeshellarg($cert);
            $query2 = "openssl ts -reply -in ".escapeshellarg($path)." -text";
            $answer = array();
            exec($query1."&&" . $query2." 2>&1", $answer, $err);
            if($err == 0)
                return $answer;
        
        }

    }