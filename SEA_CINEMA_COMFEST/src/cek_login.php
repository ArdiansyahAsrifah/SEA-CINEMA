<?php 


 include 'config.php';
 
 if(isset($_POST["tujuan"])){

        $tujuan = $_POST["tujuan"];
        
        if($tujuan == "LOGIN"){
            $username = $_POST["username"];
            $password = md5($_POST["password"]);
            
            $query_sql = "SELECT * FROM users 
                                   WHERE username = '$username' AND password = '$password'";
            
            $result = mysqli_query($conn, $query_sql);
			
			
            if(mysqli_num_rows($result) > 0){
				$row = mysqli_fetch_array ($result);
				 session_start();
				$_SESSION['id'] = $row['id'];
				$_SESSION['username'] = $username;
				$_SESSION['nama'] = $row['nama'];
				$_SESSION['umur'] = $row['umur'];	
			
				
                echo "<h1>Selamat Datang, ".$_SESSION['username']."!</h1>";
				header("location: Movies.php");
				
            }else{
                echo "<h2>Username atau Password Salah!</h2>";
				header("location: Login.html");
            }
    
        }else{
            $username = $_POST["username"];
            $password = md5($_POST["password"]);
            $nama = $_POST["nama"];
			$umur = $_POST["umur"];
            
            $query_sql = "INSERT INTO users (username,  password, nama, umur) 
                                               VALUES ('$username', '$password', '$nama', '$umur')";

            if (mysqli_query($conn, $query_sql)) {
                echo " <h1>Username $username berhasil terdaftar</h1> ";
				header("location: Login.html");
				
            } else {
                echo "Pendaftaran Gagal : " . mysqli_error($conn);
				header("location: Login.html");
            }
        }
    }
    
    
   
?>
 
