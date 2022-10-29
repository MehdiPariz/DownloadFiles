<?php
$conn = new PDO('mysql:host=localhost; dbname=demo', 'root', '') or die(mysql_error());
if (isset($_POST['submit']) != "") {
    $name = $_FILES['file']['name'];
    $size = $_FILES['file']['size'];
    $type = $_FILES['file']['type'];
    $temp = $_FILES['file']['tmp_name'];
    $fname = date("YmdHis") . '_' . $name;
    $chk = $conn->query("SELECT * FROM  upload where name = '$name' ")->rowCount();
    if ($chk) {
        $i = 1;
        $c = 0;
        while ($c == 0) {
            $i++;
            $reversedParts = explode('.', strrev($name), 2);
            $tname = (strrev($reversedParts[1])) . "_" . ($i) . '.' . (strrev($reversedParts[0]));
            $chk2 = $conn->query("SELECT * FROM  upload where name = '$tname' ")->rowCount();
            if ($chk2 == 0) {
                $c = 1;
                $name = $tname;
            }
        }
    }
    $move =  move_uploaded_file($temp, "upload/" . $fname);
    if ($move) {
        $query = $conn->query("insert into upload(name,fname)values('$name','$fname')");
        if ($query) {
            header("location:index.php");
        } else {
            die(mysql_error());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Files</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<style>
    .copyright{
        -webkit-text-size-adjust: 100%;
    -webkit-tap-highlight-color: rgba(0,0,0,0);
    -webkit-font-smoothing: antialiased;
    color: #3c3c3c;
    font: 300 14px open sans,sans-serif;
    letter-spacing: 0.5px;
    box-sizing: border-box;
    display: block;
    font-size: 13px;
    padding: 30px 0;
    align-items: center;
    }
</style>
<body style="background-color: #E0F8F7;">
<div class="container">

<h3 style="color:#5882FA;"><b></b></h3>

        <br>
        <br>
<br>
<br>
<h1 style="color:#5858FA; text-align: center;"><b>Web and Software Developer</b></h1>
<br>
<br>
<h3 style="color:#5882FA; text-align: center;"><b>Download Files</b></h3>
        <br>    
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
            <thead>
                <tr>
                    <th width="90%" align="center">Files</th>
                    <th align="center">Action</th>
                </tr>
            </thead>
            <?php
            $query = $conn->query("select * from upload order by id desc");
            while ($row = $query->fetch()) {
                $name = $row['name'];
            ?>
                <tr>
                    <td>
                        &nbsp;<?php echo $name; ?>
                    </td>
                    <td>
                        <button class="alert-success"><a href="download.php?filename=<?php echo $name; ?>&f=<?php echo $row['fname'] ?>">Download</a></button>
                    </td>
                </tr>
            <?php } ?>
        </table>


        <br>  <br>  <br> 
       <!-- Footer -->
       <footer class="copyright">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-9 col-sm-offset-3 footer-background">
                        <div class="row">
                        <div  class="col-sm-6 text-left">
                            Copyright &copy; 2022 Mehdi Pariz. All Right Reserved 
                        </div> 
                    </div>
                </div><!-- end row -->
            </div><!-- end container -->
        </footer>
        <!-- end Footer -->
    </div>
        <!-- ##### JAVASCRIPTS ##### -->
        <!-- jQuery Library -->
        <script src="js/jquery.min.js"></script>
        <!-- Bootstrap js -->
        <script src="js/bootstrap.min.js"></script>
        <!-- Retina Graphics -->
        <script src="js/retina.min.js"></script>
        <!-- Magnific popup -->
        <script src="js/jquery.magnific-popup.min.js"></script>
        <!-- Theme Plugins -->
        <script src="js/theme-plugins.min.js"></script>
        <!-- Custom Scripts -->
        <script src="js/scripts.min.js"></script>
    </body>
</html>