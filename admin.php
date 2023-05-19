<?php 
    if(!isset($_SESSION)){
        session_start();
    }

    include "includes/enteteAdmin.php";
    include "includes/menuAdmin.php";
?>

<p><h6 style="width: 50%;" class=""> Bonjour , <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>.</h6></p>
<p> <div id="plemx-root"></div> </p>
  

<div class="line">
    <div>
        <section class="section dashboard">
                <iframe title="Agenda" style="width: 100%;" src="https://calendar.google.com/calendar/embed?height=600&wkst=1&bgcolor=%237986CB&ctz=America%2FToronto&showTitle=0&showNav=1&showTabs=1&showCalendars=1&showTz=0&title=Marie%20M&src=NHdvbWVuZnJvbXdvbWVuQGdtYWlsLmNvbQ&src=YWRkcmVzc2Jvb2sjY29udGFjdHNAZ3JvdXAudi5jYWxlbmRhci5nb29nbGUuY29t&src=ZnItY2EuY2FuYWRpYW4jaG9saWRheUBncm91cC52LmNhbGVuZGFyLmdvb2dsZS5jb20&color=%23039BE5&color=%2333B679&color=%230B8043" style="border-width:0" width="1300" height="780" ></iframe>
        </section> 
    </div>
</div>

<!-- jQuery CDN - Slim version (=without AJAX) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<!-- Popper.JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });
    });
</script>

</body>




