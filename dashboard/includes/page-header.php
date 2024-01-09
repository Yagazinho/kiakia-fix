   <div class="row page-header py-3">
       <div class="col-md-6">
           <h3 class="pl-5 text-white text-uppercase">
               <?php 
               
               if(defined("HEADER")){
                   print HEADER ;
               }
               else{
                   print "Dashboard";
               }
               ?>
           </h3>
       </div>
       <div class="col-md-6 text-right">
           <p class="lead pr-5">
               <a href="index.php" class="text-white mr-2"><i class="fa fa-home"></i></a>
               <span class="mr-2 text-light"><i class="fa fa-caret-right"></i></span>
               <span class="text-info">
                   <?php 
               
               if(defined("BREADCRUMB")){
                   print BREADCRUMB;
               }
               else{
                   print "Dashboard";
               }
               ?>
               </span>
           </p>
       </div>
   </div>
