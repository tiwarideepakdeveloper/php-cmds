<?php

class ViewCmd{
    # Call on controller flag detect
    public static function excCmd($arg){

        $instance = new ViewCmd();

        # Removeing make:controller
        unset($arg['action_name']);
        
        # Get controller name
        $viewNm = $arg['file_name'] ?? [];
        if(!$viewNm){
            HlprCls::errorInCmd("Use valid view folder!\n eg: ControllerName/ActionName.");
        }

        # Create controller process
        $instance->createModel($viewNm, $arg['dir_name']);
        unset($arg['file_name']); // Removing controller name
    }

    # Create controller File
    private function createModel($viewNm, $appDr){
        $appDirPath = getcwd()."/".$appDr; 
        HlprCls::checkDirectory($appDirPath."/views/".$viewNm['controller'], "views - Folder does not exist! Create it? (Y/N): ");

        $viewFllNm = $appDirPath."/views/".$viewNm['controller']."/".$viewNm['action'].".php";
        
        if(!file_exists($viewFllNm)){
            HlprCls::createFile($viewFllNm, "<?php\n");
            HlprCls::cmdRunnStrt($viewNm['controller']."/".$viewNm['action']." created successfully!", "\033[33m");
        }else{
            if(strtolower(trim(readline("Override existing view? (Y/N): "))) == "y"){
                HlprCls::createFile($viewFllNm, "<?php\n");
                HlprCls::cmdRunnStrt($viewNm." overrided!", "\033[33m");
            }
        }
    }
}