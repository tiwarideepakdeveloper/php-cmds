<?php
class HlprCls{
    public static function errorInCmd($msg){
        fwrite(STDERR, "\033[41m".$msg."\033[0m". PHP_EOL);
        exit(1);
    }
    
    public static function succsInCmd($msg){
        fwrite(STDOUT, "\033[42m".$msg."\033[0m". PHP_EOL);
        exit(0);
    }

    public static function cmdRunnStrt($msg, $clr = "\033[48;5;208m"){
        fwrite(STDOUT, $clr.$msg."\033[0m". PHP_EOL);
        sleep(1);
    }


    # Create file in directory | File name must have .php 
    public static function createFile($name, $template){
        try {
            $myfile = fopen($name, "w");
            fwrite($myfile, $template);
            fclose($myfile);
        } catch (\Throwable $th) {
            HlprCls::errorInCmd($th->getMessage());
        }
    }

    # Check directory if not create
    public static function checkDirectory($dirName, $cnfMess){
        if(!file_exists($dirName)){
            if(strtolower(trim(readline($cnfMess))) == "y"){
                try {
                    mkdir($dirName, 0777, true);
                } catch (\Throwable $th) {
                    HlprCls::errorInCmd($th->getMessage());
                }
                return;
            }
            HlprCls::errorInCmd("Cannot proceed without directory!");
        }
    }
}