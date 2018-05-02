<?php 

$db = new mysqli("localhost", 'root', '', 'pweb_b');

if($db->connect_errno > 0){
    die("Gagal bos..!!!");
}

// if(isset($_POST['nama_barang'])){
//     $nama = $_POST['nama_barang'];
//     $deskripsi = $_POST['deskripsi_barang'];
//     $harga = $_POST['harga_barang'];

//     $query = "INSERT INTO barang(nama, deskripi, harga) VALUES('$nama','$deskripsi', '$harga')";
//     $db->query($query);
// }

if(isset($_GET['act']) && isset($_GET['id']))
{
    $aksi = $_GET['act']; //edit
    $id = $_GET['id'];  //5

    if($aksi == "edit"){
        $sql = 'SELECT * FROM barang WHERE id='.$id;
        $result = $db->query($sql);

        $row = $result->fetch_assoc();

        $id = $row['id'];
        $nama = $row['nama'];
        $deskripsi = $row['deskripi'];
        $harga = $row['harga'];

        if(isset($_POST['update'])){
            $id = $row['id'];
            $nama = $_POST['nama_barang'];
            $deskripsi = $_POST['deskripsi_barang'];
            $harga = $_POST['harga_barang'];
            $update = "UPDATE barang SET nama='$nama',deskripi='$deskripsi',harga='$harga' WHERE id='$id'";
            $result = $db->query($update);
            if($result){
                echo "Data berhasil diupdate <br>";
            }
            else{
                echo "ERROR: Could not able to execute $sql. " . mysqli_error($db);
            }
        }
    }
    else if($aksi == 'delete'){
        $sql = 'DELETE FROM barang WHERE id=' . $id;
        $result = $db->query($sql);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Barang</title>
    <link href="./css/bootstrap.min.css" rel="stylesheet" />
    <script language="JavaScript" type="text/javascript">
        function konfirmasi(){
            return confirm('Hapus data ini ?');
        }
</script>
</head>
<body>

<div class="container">
  <!-- Content here -->
  <h1>CRUD Barang</h1>

    <div class="row">
        <div class="col-md">
            <h2>Form Barang</h2>

            <form action="crud.php" method="POST">
            
                <div class="form-group">
                    <label >Nama Barang</label>
                    <input type="text" name="nama_barang" value="<?php 
                    if(isset($_GET['act'])){
                        if($aksi == 'edit'){
                            echo $nama;
                        }
                        else{
                            echo "";    
                        }
                    }
                    else{
                        echo "";
                    }
                     ?>" class="form-control" placeholder="Nama Barang">
                </div>

                <div class="form-group">
                    <label >Deskripsi Barang</label>
                    <input type="text" name="deskripsi_barang" value="<?php 
                    if(isset($_GET['act'])){
                        if($aksi == 'edit'){
                            echo $deskripsi;
                        }
                        else{
                            echo "";    
                        }
                    }
                    else{
                        echo "";
                    }
                     ?>" class="form-control" placeholder="Deskripsi">
                </div>

                <div class="form-group">
                    <label >Harga Barang</label>
                    <input type="text" name="harga_barang" value="<?php 
                    if(isset($_GET['act'])){
                        if($aksi == 'edit'){
                            echo $harga;
                        }
                        else{
                            echo "";    
                        }
                    }
                    else{
                        echo "";
                    }
                     ?>" class="form-control" placeholder="Harga Barang">
                </div>
    
                <?php
                    if(isset($_GET['act'])){
                        if($aksi == "edit"){
                            echo '<button type="submit" name="update" class="btn btn-primary">Update</button>';
                        }
                        else{
                            echo '<button type="submit" name="simpan" class="btn btn-primary">Simpan</button>';
                        }
                    }
                    else
                    {
                        echo '<button type="submit" name="simpan" class="btn btn-primary">Simpan</button>';
                    }
                 ?>   
                
            </form>
        </div>
    </div>
    <!-- ROW untuk form -->


    <?php
        $query = 'SELECT * FROM barang';
        $result = $db->query($query);
    ?>

    <hr>

    <div class="row">
        <div class="col-md">
            <h2>Table Barang</h2>
            <table class="table">

                <thead class="thead-dark">
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Deskripsi</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    while($row = $result->fetch_assoc())
                    {
                    ?>
                    <tr>
                        <th scope="row">1</th>
                        <td><?php echo $row['nama'] ?></td>  <!-- Nama Barang -->
                        <td><?php echo $row['deskripi'] ?></td>  <!-- Deskripsi Barang -->
                        <td><?php echo $row['harga'] ?></td>  <!-- harga Barang -->
                        <td>
                            <a href="crud.php?act=edit&id=<?php echo $row['id']; ?>" class="btn btn-primary">Edit</a>
                            <a href="crud.php?act=delete&id=<?php echo $row['id']; ?>" onclick="return konfirmasi()" class="btn btn-danger">Delete</a>

                        </td>
                    </tr>
                    <?php
                    }
                    $result->free();
                    ?>
                </tbody>

                </table>
        </div>
    </div> 
    <!-- ROW untuk table -->
</div>


</body>
</html>

<?php

$db->close();    

?>