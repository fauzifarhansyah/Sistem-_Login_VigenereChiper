# Sistem-_Login_VigenereChiper ini bertujuan untuk menyelesaikan tugas kripto
#membuat source code sesuai di file sistem login
#1. index.php
'''<?php

// inisialisasi variabel
$key = "";
$text = "";
$error = "";
$color = "#FF0000";

// declare encrypt and decrypt funtions
require_once('vigenere.php');

$key = $_POST['key'];
$text = $_POST['text'];

// jika menekan tombol enkripsi
if (isset($_POST['encrypt']))
{
	$text = encrypt($key, $text);
	$error = "Text berhasil di enkripsi!";
}
	
// jika menekan tombol dekripsi
if (isset($_POST['decrypt']))
{
	$text = decrypt($key, $text);
	$error = "Text berhasil di dekripsi!";
}

?>

<html>
	<head>
		<title>Vigenere Cipher</title>
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" 
		integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	</head>
	<body>
		<br><br><br><br><br>
		<main role="main" class="container">
			<div class="row">
				<div class="col-md-8 mx-auto">
					<div class="card">
						<div class="card-header">
						<caption><h2 style="text-align: center;"><b>Vigenere Cipher</b></h2></caption>
						</div>
						<div class="card-body">
							<form action="index.php" method="post">
								<div class="form-group">
									<label for="Kunci">Kunci</label>
									<input type="text" class="form-control" name="key" id="kunci" aria-describedby="inputKunci" placeholder="Masukkan Kunci" value="<?php echo $key; ?>">
								</div>
								<div class="form-group">
									<label for="Plaintext">Plaintext</label>
									<textarea class="form-control" name="text" id="text" rows="5"><?php echo $text; ?></textarea>
								</div>
								<button type="submit" class="btn btn-success" name="encrypt" value="Encrypt">Encrypt</button>
								<button type="submit" class="btn btn-danger" name="decrypt" value="Decrypt">Decrypt</button>
							</form>
						</div>
						<div class="card-footer text-center text-success">
							<strong><?php echo $error; ?></strong>
						</div>
					</div>
				</div>
			</div>
		</main>

	<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
	</body>
</html>'''

#2. regist.php
'''<?php

require_once("config.php");

if(isset($_POST['register'])){

    // filter data yang diinputkan
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    // enkripsi password
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);


    // menyiapkan query
    $sql = "INSERT INTO users (name, username, email, password) 
            VALUES (:name, :username, :email, :password)";
    $stmt = $db->prepare($sql);

    // bind parameter ke query
    $params = array(
        ":name" => $name,
        ":username" => $username,
        ":password" => $password,
        ":email" => $email
    );

    // eksekusi query untuk menyimpan ke database
    $saved = $stmt->execute($params);

    // jika query simpan berhasil, maka user sudah terdaftar
    // maka alihkan ke halaman login
    if($saved) header("Location: login.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>

    <link rel="stylesheet" href="css/bootstrap.min.css" />
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">

        <p>&larr; <a href="index.php">Home</a>

        <h4>Bergabunglah bersama kami...</h4>
        <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>

        <form action="" method="POST">

            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input class="form-control" type="text" name="name" placeholder="Nama kamu" />
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input class="form-control" type="text" name="username" placeholder="Username" />
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input class="form-control" type="email" name="email" placeholder="Alamat Email" />
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input class="form-control" type="password" name="password" placeholder="Password" />
            </div>

            <input type="submit" class="btn btn-success btn-block" name="register" value="Daftar" />

        </form>
            
        </div>

        <div class="col-md-6">
            <img class="img img-responsive" src="img/connect.png" />
        </div>

    </div>
</div>

</body>
</html>'''

#3. login.php
'''<?php 

require_once("config.php");

if(isset($_POST['login'])){

    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    $sql = "SELECT * FROM users WHERE username=:username OR email=:email";
    $stmt = $db->prepare($sql);
    
    // bind parameter ke query
    $params = array(
        ":username" => $username,
        ":email" => $username
    );

    $stmt->execute($params);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // jika user terdaftar
    if($user){
        // verifikasi password
        if(password_verify($password, $user["password"])){
            // buat Session
            session_start();
            $_SESSION["user"] = $user;
            // login sukses, alihkan ke halaman timeline
            header("Location: timeline.php");
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    <link rel="stylesheet" href="css/bootstrap.min.css" />
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">

        <p>&larr; <a href="index.php">Home</a>

        <h4>Masuk</h4>
        <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>

        <form action="" method="POST">

            <div class="form-group">
                <label for="username">Username</label>
                <input class="form-control" type="text" name="username" placeholder="Username atau email" />
            </div>


            <div class="form-group">
                <label for="password">Password</label>
                <input class="form-control" type="password" name="password" placeholder="Password" />
            </div>

            <input type="submit" class="btn btn-success btn-block" name="login" value="Masuk" />

        </form>
            
        </div>

        <div class="col-md-6">
            <!-- isi dengan sesuatu di sini -->
        </div>

    </div>
</div>
    
</body>
</html>'''

#4.log_out.php
'''<?php

session_start();
session_unset("users");
header("Location: indeks.php");

#5. config.php
'''<?php

$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "";

try {    
    //create PDO connection 
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
} catch(PDOException $e) {
    //show error
    die("Terjadi masalah: " . $e->getMessage());
}'''

#6. auth.php
'''<?php

session_start();
if(!isset($_SESSION["user"])) header("Location: login.php"); '''

#7. timeline.php
'''<?php require_once("auth.php"); ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pesbuk Timeline</title>

    <link rel="stylesheet" href="css/bootstrap.min.css" />
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">

            <div class="card">
                <div class="card-body text-center">

                    <img class="img img-responsive rounded-circle mb-3" width="160" src="img/<?php echo $_SESSION['user']['photo'] ?>" />
                    
                    <h3><?php echo  $_SESSION["user"]["name"] ?></h3>
                    <p><?php echo $_SESSION["user"]["email"] ?></p>

                    <p><a href="logout.php">Logout</a></p>
                </div>
            </div>

            
        </div>


        <div class="col-md-8">

            <form action="" method="post" />
                <div class="form-group">
                    <textarea class="form-control" placeholder="Apa yang kamu pikirkan?"></textarea>
                </div>
            </form>

            <?php for($i=0; $i < 6; $i++){ ?>
            <div class="card mb-3">
                <div class="card-body">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis veritatis nemo ad recusandae labore nihil iure qui eum consequatur, officiis facere quis sunt tempora impedit ullam reprehenderit facilis ex amet!
                </div>
            </div>
            <?php } ?>
            
        </div>
    
    </div>
</div>

</body>
</html>'''

#8. users.sql
'''-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 08, 2017 at 07:09 PM
-- Server version: 5.7.20-0ubuntu0.16.04.1
-- PHP Version: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pesbuk`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL DEFAULT 'default.svg'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `name`, `photo`) VALUES
(1, 'fauzi', 'fauzzzrrrrr@gmail.com', '$2y$10$HIEq2w.8Et9RsJmY4TMKye4aVCxOd9xJTOtG4vyOEmo.GIBxaPQHK', 'fauzi', 'default.svg'),
(3, 'fauji', 'fauzi.f3067@gmail.com', '$2y$10$uXa.Hz9rr8gkv4ztaqf6FO84iW64gXHbeyEOy1tIQ5wmqMjTk0yQa', 'fauji', 'default.svg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;'''

#9. vigenere.php
'''<?php

// membuat fungsi enkripsi
function encrypt($key, $text)
{
	
	// inisialisasi variable
	$ki = 0;
	$kl = strlen($key);
	$length = strlen($text);
	
	// lakukan perulangan untuk setiap abjad
	for ($i = 0; $i < $length; $i++)
	{
		// jika text merupakan alphabet
		if (ctype_alpha($text[$i]))
		{
			// jika text merupakan huruf kapital (semua)
			if (ctype_upper($text[$i]))
			{
				$text[$i] = chr(((ord($text[$i]) - ord("A") + ord($key[$ki]) - ord("A")) % 26) + ord("A"));
			}
			// jika text merupakan huruf kecil (semua)
			else
			{
				$text[$i] = chr(((ord($text[$i]) - ord("a") + ord($key[$ki]) - ord("a")) % 26) + ord("a"));
			}
			
			$ki++;
			if ($ki >= $kl)
			{
				$ki = 0;
			}
		}
	}
	
	// mengembalikan nilai text
	return $text;
}

// membuat fungsi dekripsi
function decrypt($key, $text)
{
	// inisialisasi variable
	$ki = 0;
	$kl = strlen($key);
	$length = strlen($text);
	
	// lakukan perulangan untuk setiap abjad
	for ($i = 0; $i < $length; $i++)
	{
		if (ctype_alpha($text[$i]))
		{
			if (ctype_upper($text[$i]))
			{
				$x = ((ord($text[$i]) - ord("A")) - (ord($key[$ki]) - ord("A")) % 26);

				if ($x < 0)
				{
					$x += 26;
				}
				
				$x = $x + ord("A");
				
				$text[$i] = chr($x);
			}
			
			// jika text merupakan huruf kecil (semua)
			else
			{
				$x = ((ord($text[$i]) - ord("a")) - (ord($key[$ki]) - ord("a")) % 26);

				if ($x < 0)
				{
					$x += 26;
				}
				
				$x = $x + ord("a");
				
				$text[$i] = chr($x);
			}

			$ki++;
			if ($ki >= $kl)
			{
				$ki = 0;
			}
		}
	}
	
	// mengembalikan nilai text
	return $text;
}

?>'''

# 10. decript.php
'''<?php
 if(isset($_POST["submit"])) {
    // process form data, send email, output message
 
    // $str = "rasamautau";
    // $key = "blog";

    $str = $_POST["encrypttext"];
    $key = $_POST["keytext"];
    
    // printf("Text: %s\n", $str);
    // printf("key:  %s\n", $key);
    
    // $cod = encipher($str, $key, true); 
    // printf("Code: %s\n", $cod);

    $dec = encipher($str, $key, false); 
    // printf("Back: %s\n", $dec);
    $result = $dec;
    // printf("ord:  %s\n", ord('B'));
    // printf("ord:  %s\n", ord('A'));
    
    

 }

 function encipher($src, $key, $is_encode)
    {
        $key = strtoupper($key);
        $src = strtoupper($src);
        $dest = '';
    
        /* strip out non-letters */
        for($i = 0; $i <= strlen($src); $i++) {
            $char = substr($src, $i, 1);
            if(ctype_upper($char)) {
                $dest .= $char;
            }
        }
    
        for($i = 0; $i <= strlen($dest); $i++) {
            $char = substr($dest, $i, 1);
            if(!ctype_upper($char)) {
                continue;
            }
            $dest = substr_replace($dest,
                chr (
                    ord('A') +
                    ($is_encode
                    ? ord($char) - ord('A') + ord($key[$i % strlen($key)]) - ord('A')
                    : ord($char) - ord($key[$i % strlen($key)]) + 26
                    ) % 26
                )
            , $i, 1);
        }
    
        return $dest;
    }
 
?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Algoritme Vigenere Chiper</title>
</head>

<body>
    <nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Algoritme Vigenere Chiper</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText"
            aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Encrypt </a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">Decrypt <span class="sr-only">(current)</span></a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <br>
        <form action="" method="post">
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Encrypted text</label>
                <textarea class="form-control" name="encrypttext" id="exampleFormControlTextarea1" rows="3"
                    placeholder="masukkan encrypted text"></textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Key</label>
                <input type="text" class="form-control" name="keytext" id="keytext" aria-describedby="emailHelp"
                    placeholder="masukkan key text">
            </div>

            <div class="form-group">
                <input type="submit" name="submit" value="Decrypt" class="btn btn-info">
            </div>
        </form>

        <div class="card text-center">
            <div class="card-header">
                Hasil Decrypt
            </div>
            <div class="card-body">
                <p class="card-text">
                    <?php 
                if(isset($result)) {
                    echo "Encrypted Text: <b>". $str ."</b><br>";
                    echo "Key: <b>". $key . "</b><br>";
                    echo "Decrypted Text: <b>". $result ."</b><br>"; 
                }
                ?>
                </p>
                <!-- <h5 class="card-title">Special title treatment</h5>
            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a> -->
            </div>
            <div class="card-footer text-muted">
                coded with <span style="color: Tomato;"> <i class="fa fa-heart"></i> </span> by Rivaldi Rizalul Akhsan
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
</body>

</html>'''


# untuk tampilan bisa disesuaikan ( js, css, boostrap) sesuai keinginan yang mau dibuat
# Apabila ada kata atau sumber source code yang salah ketik mohon dimaaf kan dikarnakan ada beberapa file yang hilang, dan sistem login ini dibuat untuk menyelesaikan tugas kripto
