<?php

    Class ShowPic{
        //=================单例
        private static $_instance = NULL;
        //单例 禁止外部直接实例化
        private function __construct() {
        }

        public static function getInstance() {
            if (is_null(self::$_instance)) {
                self::$_instance = new MyModel();
            }

            return self::$_instance;
        }
        //单例 禁止克隆实例
        public function __clone(){
            die('Clone is not allowed.' . E_USER_ERROR);
        }

        public static function showPic($data){
            echo "<a href='/pic/{$data['picid']}'>";
            echo '<div class="picBoxBig">';
            echo "<div class='picBox'>";
            echo    "<img class='imgInBox' src='{$data['picpath']}'/>";
            echo "</div>";
            echo "<p class='picName' style=''>{$data['picname']}</p>";
            echo '</div>';
            echo '</a>';
        }

        public static function showPics($datas){
            for($i=0;$i<count($datas);$i++){
                ShowPic::showPic($datas[$i]);
            }
            echo '<div style="clear:both;"></div>';
        }
    }
