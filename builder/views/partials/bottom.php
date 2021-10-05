<?php
$builder = new Builder;
$installation = $builder->get_installation();
?>
    </div>
    <div class="nav bg-white shadow w-full py-8">
        <div class="text-center text-sm font-bold text-indigo-800">
            <?= $installation->app_name ?><br>
            Copyright &copy; 2021
        </div>
    </div>
    <script>
    function toggleNav()
    {
        document.querySelector('.nav-box').classList.toggle('hidden')
    }
    </script>
</body>
</html>
