<?php
    function canLog($type,$force=false){
        // can_logForce > $force > can_log
        // can_logForce 1 一定log ,-1 禁止log, 0 由$force 和 can_log判断
        // $force true log, flase 由 can_log判断
        $c=$GLOBALS['MyConf'];
        if($type=="M"){//m代表数据库  
            if($c['can_logMForce']==1){
                return true;
            }else if($c['can_logMForce']==-1){
                return false;
            }else{
                if($force){
                    return true;
                }else{
                    return ($c['can_logM']);
                }
            }
        }else{
            if($c['can_logForce']==1){
                return true;
            }else if($c['can_logForce']==-1){
                return false;
            }else{
                if($force){
                    return true;
                }else{
                    return ($c['can_log']);
                }
            }
        }
    }
// ===================一般 用
    function loge2($obj2,$name="no name ",$force=false){
        $type="N";
        if(canLog($type,$force))
            loge2__($obj2,$name);
    }

    function logvar($obj2,$name="no name ",$force=false){
        $type="N";
        if(canLog($type,$force))
            logvar__($obj2,$name);
    }
    function logr($obj2,$name="no name ",$force=false){
        $type="N";
        if(canLog($type,$force))
            logr__($obj2,$name);
    }

// ===================model 用
    function loge2M($obj2,$name="no name ",$force=false){
        $type="M";
        if(canLog($type,$force))
            loge2__($obj2,$name);
    }

    function logvarM($obj2,$name="no name ",$force=false){
        $type="M";
        if(canLog($type,$force))
            logvar__($obj2,$name);
    }
    function logrM($obj2,$name="no name ",$force=false){
        $type="M";
        if(canLog($type,$force))
            logr__($obj2,$name);
    }
//===========本体
    function loge2__($obj2,$name){
        echo "<pre>";
        echo $name." : ".$obj2;
        echo "</pre>";
    }
    function logvar__($obj2,$name){
        echo "<pre>";
        echo $name." : ";
        var_dump($obj2);
        echo "</pre>";
    }
    function logr__($obj2,$name){
        echo "<pre>";
        echo $name." : ";
        print_r($obj2);
        echo "</pre>";
    }
?>