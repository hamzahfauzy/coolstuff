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
    function toggleNav(id)
    {
        var elm = document.querySelector(id)
        elm.classList.toggle('hidden')

        var boxs = document.querySelectorAll(".nav-box:not("+id+")")

        boxs.forEach(item => {
            if(elm.parentNode.parentNode != item)
                item.classList.add('hidden')
        });
    }

    document.addEventListener('click',function(event){
        if(event.target.classList.contains('dropdown') == false && event.target.parentNode.classList.contains('dropdown') == false){

            document.querySelectorAll('.nav-box').forEach(item => {
                if(item.classList.contains('hidden') == false)
                    item.classList.add('hidden')
            })
            
        }
    })

    </script>
</body>
</html>
