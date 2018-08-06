<?php 

namespace Instagram;

use Illuminate\Support\ServiceProvider;
 
class InstagramServiceProvider extends ServiceProvider
{
    public function boot(){
    
     $this->loadRoutesFrom(__DIR__.'./routes/web.php');   
    }

    public function register(){
        
    }
}
