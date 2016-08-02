<?php
namespace App\registration;
use PDO;

class Registration
{
	public $id = "";
	public $name = "";
	public $pass = "";
	public $repass = "";
	public $email = "";
	public $conn = "";
	public $dbuser = "root";
	public $dbpass = "";
	public $error = "";
	public $uid = "";
	public $vid = "";
	function __construct()
	{
		session_start();
		$this->conn = new PDO('mysql:host=localhost;dbname=php26', $this->dbuser, $this->dbpass);
	}

	public function ready($data = "")
	{
		if (!empty($data['username'])) {
			$this->name = $data['username'];
		}
		else {
			$_SESSION['name_req'] = '*Username field can not be empty.';
			$this->error = true;
		}
		if (!empty($data['pass'])) {
			$this->pass = $data['pass'];
		}
		else {
			$_SESSION['pass_req'] = '*Password field can not be empty.';
			$this->error = true;
		}
		if (!empty($data['repass'])) {
			$this->repass = $data['repass'];
		}
		else {
			$_SESSION['repass_req'] = '*Password Retype field can not be empty.';
			$this->error = true;
		}
		if (!empty($data['email'])) {
			$this->email = $data['email'];
		}
		else {
			$_SESSION['email_req'] = '*Email field can not be empty.';
			$this->error = true;
		}
	}

	public function validationMessage($msg = "")
	{
		if (isset($_SESSION["$msg"]) && !empty($_SESSION["$msg"])) {
			echo $_SESSION["$msg"];
			unset($_SESSION["$msg"]);
		}
	}

	public function validation()
	{
		if (!empty($this->name)) {
			if (strlen($this->name) >= 6 && strlen($this->name) <= 12) {
				$uniqName = $this->conn->query("SELECT `username` FROM `tbl_users` WHERE `username` = '". $this->name."'");
				$row = $uniqName->fetch();
				if (!empty($row['username'])) {
					$_SESSION['uniq_name'] = $this->name .'Already exist. Please try a new one'."<br/>";
					$this->error = true;
				}
				else {
					$_SESSION['val_username'] = $this->name;
				}
			}
			else {
			$_SESSION['username_length'] = 'Username must be 6 to 12 characters.';
			$this->error = true;
			}
		}
		if (!empty($this->pass) && !empty($this->repass)) {
			if (strlen($this->pass) >= 6 && strlen($this->pass) <=12) {
					if ($this->pass !== $this->repass) {
					$_SESSION['pass_match'] = 'Password does not match. Please check it.'."<br/>";
					$this->error = true;
				}
			}
			else {
				$_SESSION['pass_length'] = 'Password must be 6 to 12 characters';
				$this->error = true;
			}
		}
		if (!empty($this->email)) {
			if (filter_var($this->email, FILTER_VALIDATE_EMAIL) == TRUE) {
                $uniq_email = $this->conn->query("SELECT `email` FROM `tbl_users` WHERE `email`= '" . $this->email . "' ");
                $row = $uniq_email->fetch();
                if (!empty($row['email'])) {
                    $_SESSION['email_uniq'] = $this->email . ' Already Used. Please Try Another Email.<br/>';
                    $this->error = true;
                } else {
                    $_SESSION['val_email'] = $this->email;
                }
            } else {
                $_SESSION['email_valid'] = 'Email Address is not valid.<br/>';
                $this->error = true;
            }
		}
	}

	public function store()
	{
		if ($this->error == False) {
			try {
				$this->uid = uniqid();
				$this->vid = uniqid();
            $query = "INSERT INTO tbl_users(id, unique_id, verification_id, username, password, email, created) VALUES(:id, :unique_id, :verification_id, :username, :password, :email, :created)";
            $stmt = $this->conn->prepare($query);
            $stmt->execute(array(
                ':id' => null,
                ':unique_id' => $this->uid,
                ':verification_id' => $this->vid,
                ':username' => $this->name,
                ':password' => $this->pass,
                ':email' => $this->email,
                ':created' => date("Y-m-d H:i:s")
            ));
           header("location:register.php?id=$this->vid");
        }  catch (PDOException $e) {
           echo 'Error: ' . $e->getMessage();
        }
		} else {
			header('location:signup.php');
			$_SESSION['reg_failed'] = 'Please fill up the form correctly'."<br/>";
		}
		
	}
	
	public function mailVerification()
	{
		$to = "somebody@example.com";
		$subject = "Email Verification.";
		$txt = "<a href="active.php?id=<?php echo $_GET['id']; ?>" target="_blank">Click here...</a>for email verification and complete the registration.";
		$headers = "From: webmaster@example.com" . "\r\n" .
		"CC: somebodyelse@example.com";

		mail($to,$subject,$txt,$headers);
	}
	
	public function active()
	{
		$vid = $this->conn->query("SELECT * FROM `tbl_users` WHERE `verification_id` = '".$_GET['id']."'");
		$row = $vid->fetch();
		if (empty($row['verification_id'])) {
			$_SESSION['error'] = 'Registration Error.';
            header('location:error.php');
		} else {
			if ($row['is_active'] == 1) {
                $_SESSION['error'] = 'Email Already Verified.Go to <a href="login.php">login page</a>.';
                header('location:error.php');
            } else {
                try {
                    $query = $this->conn->prepare("UPDATE `tbl_users` SET `is_active` = '1' WHERE `tbl_users`.`verification_id` = '" . $_GET['id'] . "'");
                    $query->execute();
                    $_SESSION['success'] = "Registration Process Compleated. Now Login."."<br/>";
                    header('location:login.php');
                } catch (PDOException $e) {
                    
                }
            }
		}
		
	}
}


?>