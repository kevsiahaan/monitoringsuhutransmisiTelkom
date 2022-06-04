<?php 
require 'data.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Grafik Sensor</title>
	<!-- Panggil file bootstrap -->

	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
	<script type="text/javascript" src="assets/js/jquery-3.4.0.min.js"></script>
	<script type="text/javascript" src="assets/js/mdb.min.js"></script>
	<script type="text/javascript" src="jquery-latest.js"></script>

	    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">


    <!-- My CSS -->
    <link rel="stylesheet" href="style.css" />
    <!-- End My CSS -->

</head>

<body id="home">
    <!-- Navbar -->
    <nav class="navbar  navbar-expand-lg navbar-dark shadow-sm " style="background-color: #8B0000 ">
      <div class="container">
        <a class="navbar-brand fw-bold fs-4" href="#">
        	<img src="img/logo.png" alt="" width="50pt" height="45pt" class="d-inline-block align-text-center">
        	Monitoring Suhu Ruangan Transmisi
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#home"><h4>Home</h4></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#about"><h4>About</h4></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#projects"><h4>Project</h4></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#contact"><h4>Rangkaian</h4></a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- Akhir Navbar -->

    <!-- About -->
    <section id="about">
      <div class="container">
        <div class="row text-center mb-2">
          <div class="col">
            <h2>Tentang Projek</h2>
          </div>
        </div>
        <div class="row justify-content-center fs-4 text-center">
          <div class="col">
            <h4 class="text-start">
              Ruang Transmisi memiliki berbagai macam perangkat di dalamnya yang dimana beroperasi selama 24 jam.Perangkat yang terdapat didalamnya beroperasi secara berkesinambungan sehingga diperlukan pemantauan untuk suhu ruangannya ,agar suhu perangkat yang bekerja terus menerus itu dapat di pantau, dan juga agar pengoperasian perangkat tidak terganggu akibat suhu panas yg dihasilkan.
            </h4> 
              
              <h4 class="text-start">Sistem monitoring suhu pada ruangan transmisi dengan menggunakan sensor LM35 dimana sensor 
              tersebut terhubung ke NodeMCU ESP8266,untuk output dapat dilihat melalui telegram dan juga Web.
              Suhu yang terdeteksi diatas 21°C buzzer akan menyala yang berfungsi untuk memberi tanda ke operator jika suhu berada diatas batas normal lalu melalui NodeMCU ESP8266 diinput ke database, tapi jika suhu dibawah 21°C maka data akan langsung diinput ke database untuk selanjutnya ditampilkan ke web, dimana dalam web tersebut terdapat tabel yang menampilkan data tiap beberapa detik tergantung jaringan dan grafik yang bergerak secara real 
              time. Dengan adanya sistem ini suhu ruangan akan lebih terpantau dengan baik sehingga memperkecil resiko kerusakan pada perangkat yang terdapat pada ruangan transmisi.
            </h4>
            </p>
            <br>
          </div>
        </div>
      </div>
     </section>

    <!-- Akhir About -->


 <!-- Projek -->
    <section id="projects">

    	<!-- Letak Grafik -->
	 <div class="container" style="text-align : center;">
	<br><br>
	<h3>Grafik Sensor Secara Realtime</h3>
	<p>(Data yang ditampilkan adalah 5 data terakhir)</p>
	</div>
	<!-- Div untuk Grafik -->
	<div class="container" id="responsecontainer" style="width : 70%">	
		<!-- Tampilan grafik -->
 <div class="panel panel-succes" style="text-align: center;"> 
 	<div class="panel-heading fs-4">
 		PT. Telkom Pematang Siantar
 	</div>
 	<div class="panel-body">
 	<!-- Canvas pada bagian grafik -->
 	 <canvas id = "myChart"></canvas>
 	 <!-- gambar grafik -->
 	<script type="text/javascript">
 		// baca ID canvas tempat grafik diletakkan
 		var canvas = document.getElementById('myChart');
 		// letakkan data tangga; dan suhu pada grafik
 		var data = {
 			labels : [			
 			<?php 
 				while ($data_tanggal = mysqli_fetch_array($tanggal))
 				{
 					echo '"'.$data_tanggal['tanggal'].'",' ; //"06-08-2021", "07-08-2021"
 				}

 			?>

 			], 
 			datasets : [{
 				label : "Suhu",
 				fill : true,
 				backgroundColor : "rgba(52, 231, 43, 0.5",
 				borderColor : "rgba(52, 231, 43, 1",
 				lineTension : 0.5,
 				data : [
 				<?php 
 					while($data_suhu = mysqli_fetch_array($suhu))
 					{
 						echo $data_suhu['suhu'].',' ;
 					}

 				 ?>
 				]

 			}]

 		};

 		// Opsi Grafik
 		var option = { 
 			showlines : true,
 			animation : {duration : 0}
 		};

 		//cetak grafik kedalam canvas
 		var mylineChart = Chart.Line(canvas, {
 			data : data,
 			options : option
 		});

 	</script>	
 </div>
 </div>
	</div>
    	 </section>

    	 <!-- Gambar -->
   <!-- Projek -->
    <section>
      <div id="contact">
     <div class="container">
        <div class="row text-center">
          <div class="col">
          	<br><br>
            <h2>Rangkaian</h2>
            <br><br>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 mb-3">
            <div class="card">
              <img src="img/projects/proteus.JPG" class="card-img-top" alt="1" />
              <div class="card-body">
                <p class="card-text">Proteus</p>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <div class="card">
              <img src="img/projects/fritzing.JPG" class="card-img-top" alt="2" />
              <div class="card-body">
                <p class="card-text">Fritzing</p>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <div class="card">
              <img src="img/projects/alat.jpg" class="card-img-top" alt="3" />
              <div class="card-body">
                <p class="card-text">“Sistem Monitoring Suhu Pada Ruang Transmisi PT. Telkom Pematang Siantar dengan NodeMCU ESP8266 Berbasis Telegram dan Web “</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    </section>

    <!-- Akhir Projek -->
    <!-- Gambar -->
    <!-- Footer-->
    <footer class="text-dark text-center p-3" style="background-color: #e3e7e1"  >
    <p><i class="bi bi-instagram"></i> <a href="https://www.instagram.com/kevsiahaan/" class=" text-dark" >Kevin Partumpoan Siahaan</a></p>
    </footer>
    <!-- Akhir Footer -->
    


</body>
</html>