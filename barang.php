<?php 
    include "koneksi.php";

    // hapus
    if(isset($_GET['hapus'])){
        $hapus = "DELETE FROM tb_barang WHERE kd_barang = '$_GET[id]'";
        $query = mysqli_query($con,$hapus);
        if($query){
            echo "<script>alert('Data berhasil dihapus!');document.location.href='barang.php'</script>";
        }else{
            echo "<script>alert('Data gagal dihapus!');document.location.href='barang.php'</script>";
        }
    }

    // simpan
    if(isset($_POST['simpan'])){
        $sim = "INSERT INTO tb_barang VALUES('$_POST[kode_barang]','$_POST[nama_barang]')";
        $pan = mysqli_query($con,$sim);
        if($pan){
            echo "<script>alert('Data berhasil ditambahkan!');document.location.href='barang.php'</script>";
        }else{
            echo "<script>alert('Data gagal dihapus!');document.location.href='barang.php'</script>";
        }
    }

    // edit
    if(isset($_GET['edit'])){
        $am = "SELECT * FROM tb_barang WHERE kd_barang='$_GET[id]'";
        $bil = mysqli_query($con,$am);
        $ambil = mysqli_fetch_array($bil);
    }

    // update
    if (isset($_POST['update'])) {
    	$sql_update = mysqli_query($con,"UPDATE tb_barang set nama_barang = '$_POST[nama_barang]' where kd_barang = '$_POST[kode_barang]'");
    	if ($sql_update) {
    		echo "<script>alert('Data berhasil di update');document.location.href='barang.php';</script>";	
    	}else{
    		echo "<script>alert('Data gagal di update');document.location.href='barang.php';</script>";	
    	}
    	
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Input Barang</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>
<body>

    <p style="margin-left:100px;">Input data Anda <i>disini</i> .. </p>

    <form action="" method="post">
    <table>
        <tr>
        	<?php 
        		$sql_max = mysqli_query($con,"SELECT MAX(kd_barang) as maximal from tb_barang");
        		$sql_satu = mysqli_query($con,"SELECT * FROM tb_barang");
        		$r_max = mysqli_fetch_array($sql_max);
        		$num_max = mysqli_num_rows($sql_satu);
        		$max_kode = $r_max['maximal'];
        		$max_angka = substr($max_kode, 1); 
        		$max_angka++;

        		//generate kode otomatis
        		if ($num_max > 0) {
        			if ($max_angka >= 1000) {
        			$angka_akhir = "B".$max_angka;
        		}elseif($max_angka >= 100){
        			$angka_akhir = "B0".$max_angka;
        		}elseif($max_angka >= 10){
        			$angka_akhir = "B00".$max_angka;
        		}elseif($max_angka > 1){
        			$angka_akhir = "B000".$max_angka;
        		}
        		}else{
        			$angka_akhir = "B0001";
        		}

        		//generate kode otomatis tipe 2
        		if ($num_max > 0) {
        			$angka_akhir2 = "B" . sprintf("%04s",$max_angka);
        		}else{
        			$angka_akhir2 = "B0001";
        		}
        		
        		
        	 ?>
            <td>Kode Barang</td>
            <td>:</td>
            <td><input type="text" name="kode_barang" value="<?php echo $angka_akhir2; ?>"></td>
        </tr>

        <tr>
            <td>Nama Barang</td>
            <td>:</td>
            <td><input type="text" name="nama_barang" value="<?= @$ambil[1]; ?>"></td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td>
            	<?php if (isset($_GET['edit'])) {?>
                	<input type="submit" name="update" value="update">
                <?php }else{ ?>
                	<input type="submit" name="simpan" value="simpan">
                <?php } ?> 
            </td>
        </tr>
    </table>
<br>
            <p>Serach here ..
                <input placeholder="search" type="search" name="tcari" value="<?= @$_POST['tcari']; ?>">
                <input type="submit" name="cari" value="cari"></p>
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <td>No</td>
                <td>Kode Barang</td>
                <td>Nama Barang</td>
                <td>Action</td>
            </tr>
            <?php 
                $sql = "SELECT * FROM tb_barang";
                if(isset($_POST['cari'])){
                    $sql = "SELECT * FROM tb_barang WHERE nama_barang LIKE '%$_POST[tcari]%'";
                }else{
                    $sql = "SELECT * FROM tb_barang";
                }
                $query = mysqli_query($con, $sql);
                $no = 0;
                while($data = mysqli_fetch_array($query)) : 
                    $no++;
            ?>
            <tr>
                <td><?= $no; ?></td>
                <td><?= $data[0]; ?></td>
                <td><?= $data[1]; ?></td>
                <td>
                    <a href="barang.php?hapus&id=<?= $data[0]; ?>">Hapus</a> |
                    <a href="barang.php?edit&id=<?= $data[0] ?>">Edit</a>
                </td>
            </tr>
                <?php endwhile; ?>
        </table>
    </form>
</body>
</html>

<style>
.card{
    font-family:chilanka;
    color:red;
    background-color:darkblue;
    padding:50px;
}
body{margin:0;}
</style>