<?php
date_default_timezone_set('Asia/Jakarta');
class LoginForm extends DbConn
{
    public function checkLogin($myusername, $mypassword, $mytapel, $mysmt)
    {
        $conf = new GlobalConf;
        $ip_address = $conf->ip_address;
        $login_timeout = $conf->login_timeout;
        $max_attempts = $conf->max_attempts;
        $timeout_minutes = $conf->timeout_minutes;
        $attcheck = checkAttempts($myusername);
        $curr_attempts = $attcheck['attempts'];

        $datetimeNow = date("Y-m-d H:i:s");
        $oldTime = strtotime($attcheck['lastlogin']);
        $newTime = strtotime($datetimeNow);
        $timeDiff = $newTime - $oldTime;

        try {

            $db = new DbConn;
            $tbl_members = $db->tbl_members;
            $err = '';

        } catch (PDOException $e) {

            $err = "Error: " . $e->getMessage();

        }

        $stmt = $db->conn->prepare("SELECT * FROM ".$tbl_members." WHERE username = :myusername AND level='5'");
        $stmt->bindParam(':myusername', $myusername);
        $stmt->execute();

        // Gets query result
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($curr_attempts >= $max_attempts && $timeDiff < $login_timeout) {

            //Too many failed attempts
			$success = '
			<div class="empty-state" data-height="100"><div class="empty-state-icon bg-danger"><i class="fas fa-times"></i></div><h2>Anda diblokir</h2><p class="lead">Kesempatan login sudah melebihi 5x...tunggu sekitar '.$timeout_minutes.' menit sebelum melakukan login ulang</p><a href="./" class="btn btn-warning mt-4">Coba Lagi</a></div>
			';
        
        } else {

             //If max attempts not exceeded, continue
            // Checks password entered against db password hash
            if (password_verify($mypassword, $result['password']) && $result['verified'] == '1') {

                //Success! Register $myusername, $mypassword and return "true"
                $success = 'true';
                    session_start();

                    $_SESSION['username'] = $myusername;
                    $_SESSION['password'] = $mypassword;
					$_SESSION['tapel'] = $mytapel;
					$_SESSION['smt'] = $mysmt;
					$_SESSION['userid'] = $result['ptk_id'];
					switch ($result['level']) {
						case 94: //guru Bahasa Inggris
							$_SESSION['lokasi'] = 'guru';
							break;
						case 95: //guru PJOK
							$_SESSION['lokasi'] = 'guru';
							break;
						case 96: //guru PAI
							$_SESSION['lokasi'] = 'guru';
							break;
						case 97: //guru Pendamping
							$_SESSION['lokasi'] = 'guru';
							break;
						case 98: //guru Kelas
							$_SESSION['lokasi'] = 'guru';
							break;
						case 99: //guru Kepsek
							$_SESSION['lokasi'] = 'kepsek';
							break;
						case 5: //guru Tata Usaha
							$_SESSION['lokasi'] = 'tatausaha';
							break;
						default:
							$_SESSION['lokasi'] = 'operator'; 
							break;
					};
					

            } elseif (password_verify($mypassword, $result['password']) && $result['verified'] == '0') {

                //Account not yet verified
				$success = '
				<div class="alert alert-danger alert-has-icon">
                      <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                      <div class="alert-body">
						<button class="close" data-dismiss="alert">
                          <span>&times;</span>
                        </button>
                        <div class="alert-title">Error</div>
                        Your account has been created, but you cannot log in until it has been verified
                      </div>
                    </div>
				';

            } else {

                //Wrong username or password
				$success = '
				<div class="empty-state" data-height="100"><div class="empty-state-icon bg-danger"><i class="fas fa-times"></i></div><h2>Login Gagal</h2><p class="lead">Username atau Password tidak ditemukan!</p><a href="./" class="btn btn-warning mt-4">Coba Lagi</a></div>
				';

            }
        }
        return $success;
    }

    public function insertAttempt($username)
    {
        try {
            $db = new DbConn;
            $conf = new GlobalConf;
            $tbl_attempts = $db->tbl_attempts;
            $ip_address = $conf->ip_address;
            $login_timeout = $conf->login_timeout;
            $max_attempts = $conf->max_attempts;

            $datetimeNow = date("Y-m-d H:i:s");
            $attcheck = checkAttempts($username);
            $curr_attempts = $attcheck['attempts'];

            $stmt = $db->conn->prepare("INSERT INTO ".$tbl_attempts." (ip, attempts, lastlogin, username) values(:ip, 1, :lastlogin, :username)");
            $stmt->bindParam(':ip', $ip_address);
            $stmt->bindParam(':lastlogin', $datetimeNow);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $curr_attempts++;
            $err = '';

        } catch (PDOException $e) {

            $err = "Error: " . $e->getMessage();

        }

        //Determines returned value ('true' or error code)
        $resp = ($err == '') ? 'true' : $err;

        return $resp;

    }

    public function updateAttempts($username)
    {
        try {
            $db = new DbConn;
            $conf = new GlobalConf;
            $tbl_attempts = $db->tbl_attempts;
            $ip_address = $conf->ip_address;
            $login_timeout = $conf->login_timeout;
            $max_attempts = $conf->max_attempts;
            $timeout_minutes = $conf->timeout_minutes;

            $att = new LoginForm;
            $attcheck = checkAttempts($username);
            $curr_attempts = $attcheck['attempts'];

            $datetimeNow = date("Y-m-d H:i:s");
            $oldTime = strtotime($attcheck['lastlogin']);
            $newTime = strtotime($datetimeNow);
            $timeDiff = $newTime - $oldTime;

            $err = '';
            $sql = '';

            if ($curr_attempts >= $max_attempts && $timeDiff < $login_timeout) {

                if ($timeDiff >= $login_timeout) {

                    $sql = "UPDATE ".$tbl_attempts." SET attempts = :attempts, lastlogin = :lastlogin where ip = :ip and username = :username";
                    $curr_attempts = 1;

                }

            } else {

                if ($timeDiff < $login_timeout) {

                    $sql = "UPDATE ".$tbl_attempts." SET attempts = :attempts, lastlogin = :lastlogin where ip = :ip and username = :username";
                    $curr_attempts++;

                } elseif ($timeDiff >= $login_timeout) {

                    $sql = "UPDATE ".$tbl_attempts." SET attempts = :attempts, lastlogin = :lastlogin where ip = :ip and username = :username";
                    $curr_attempts = 1;

                }

                $stmt2 = $db->conn->prepare($sql);
                $stmt2->bindParam(':attempts', $curr_attempts);
                $stmt2->bindParam(':ip', $ip_address);
                $stmt2->bindParam(':lastlogin', $datetimeNow);
                $stmt2->bindParam(':username', $username);
                $stmt2->execute();

            }

        } catch (PDOException $e) {

            $err = "Error: " . $e->getMessage();

        }

        //Determines returned value ('true' or error code) (ternary)
        $resp = ($err == '') ? 'true' : $err;

        return $resp;

    }

}
