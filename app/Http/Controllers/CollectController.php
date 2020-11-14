<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\CollectHelper; // add

class CollectController extends Controller
{
    
    public function create (){

        $base_url = "https://graph.facebook.com/v9.0/";
        $user_id = 17841403264434334;
        $token = "EAAJs6HttIbYBALTSCwpXhpZBksfHEbMrMZAoHd7WneFImqWBackiq3HvidZBjaJ63JZBZBJYPWq02rijzIlh2oZCEny7QtEc88ZAyZC53PsJpRQZC60XS7GUJxZCKvSZCF1limcAcOVbXgKA3BaQ3FaoVtnBIylxFgX7s6uZBm2EKeRCG3ZAesP9BpTUb";

        $collect = new CollectHelper($base_url,$user_id,$token);

        // hash_id
        $collect->get_posts_info("belta");
        //$collect->get_posts_info("instagood");
        //$collect->get_posts_info("おなかがいっぱいすぎる");

        $collect->store();
        
    }

    



}
