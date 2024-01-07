<?php
include './head.php';
include './side-bar.php';
include './header.php';
?>

<div class="main_content_iner ">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-12">
                <center>
                    <iframe src="http://127.0.0.1:5000/" frameborder="0" style="width:99%;min-height:75vh;border-radius:10px;"></iframe>
                </center>
            </div>
        </div>
    </div>
</div>
<?php
include './footer.php';
include './scripts.php';
?>
<script>
    document.querySelector("#sidebar_menu .plants").classList.add("mm-active");
</script>