<section id="page-header" class="py-3 mt-3 rounded-xlg mx-5 bg-dark">
    <div class="container">
        <h2 class="text-center text-white">
            <?php  
            if(defined("HEADER")){
                print HEADER;
            }
            else{
                print "Welcome";
            }
            ?>
        </h2>
    </div>
</section>
