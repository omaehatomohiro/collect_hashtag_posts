<?php

namespace App\Helper;

class CollectHelper{

  public $page;

  public function __construct($base_url,$user_id,$token){
    $this->base_url = $base_url;
    $this->user_id  = $user_id;
    $this->token    = $token;
    $this->hash_id_arr = [];
    $this->asset_arr = [];
    $this->is_hash_exsist = false;
    $this->page = 1;
  }

  public function store(){

  }


  /**
   * Undocumented function
   *
   * @param [String] $hash_name
   * @return void
   */
  public function get_posts_info($hash_name){
    $this->get_hash_id($hash_name);
    if($this->is_hash_exsist){
      $this->get_posts_media();
    }
    dd($this);

  }


  /**
   * ハッシュIDをもとに投稿データを取得
   *
   * @return void
   */
  private function get_posts_media(){
    $url_after  = "/recent_media?user_id=" . $this->user_id;
    $url_after .= "&fields=media_url,media_type,comments_count,permalink,caption&limit=30";
    $url_after .= "&access_token=".$this->token;

  
    foreach($this->hash_id_arr as $hash_id){
        $url = $this->base_url . $hash_id . $url_after;
        $media = $this->curlRequest($url);
        $this->asset_arr[] = $media->data;

        // nextがあったら
        if(isset($media->paging->next)){
          $this->re_get_media($media->paging->next);
        }

    }
        
  }

  private function re_get_media($next_url){
    $media = $this->curlRequest($next_url);
    if(!isset($media->data)){
      //echo "dataの中身がからなので停止";
      return;
    }
    $this->asset_arr[] = $media->data;
    $this->page++;
    dd($media);
    $url = $media->paging->next;
    if($this->page < 5){
      return $this->re_get_media($url);
    }
    return;
  }



  /**
   * ハッシュ名から該当するハッシュIDを取得
   *
   * @param [String] $hash_name
   * @return void
   */
  private function get_hash_id($hash_name){

    $url = $this->base_url."ig_hashtag_search?user_id=".$this->user_id;
    $url .= "&q=".$hash_name;
    $url .= "&access_token=".$this->token; 

    $hash_obj = $this->curlRequest($url);

    if(isset($hash_obj->error)){
      return false;
    }

    $this->is_hash_exsist = true;

    foreach($hash_obj->data as $hash){
      $this->hash_id_arr[] = $hash->id;
    }

  }


  /**
   * Requestして、Responseをdecodeして返すだけ
   *
   * @param [String] $url
   * @return void
   */
  private function curlRequest($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 実行結果を文字列で返す
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // サーバー証明書の検証を行わない
    $response =  curl_exec($ch);
    $obj = json_decode($response);
    curl_close($ch);
    return $obj;
  }
  
}