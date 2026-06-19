<?php require_once 'layouts/header.php';

?>

    <main class='mainHome container-fluid'>
        <div class="main-text text-warning pt-4">
          <div class="ms-4 text-center">Voyager confortablement</div> 
          <div class='text-center'>avec</div> 
          <div class='text-center'>TransVoyagesCM</div>
        </div>
        <div class="row mt-5 text-center">
            <div class="col-1 col-md-2"></div>
            <div class="col-10 col-md-8 btn btn-info rounded-5 fs-2 text-white">Reserver maintenant</div>
            <div class="col-1 col-md-2"></div>
        </div>
    </main>

    <script>
        $(document).ready(function(){
            $(".main-text, .row").hide();
            $(".main-text, .row").fadeIn(2000);

            $(".row .btn-info").click(function(){
            window.location.href='index.php?action=voyage';
        })
        })
    </script>

<?php require_once 'layouts/footer.php'?>