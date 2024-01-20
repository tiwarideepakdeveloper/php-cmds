<?php

class ModelCmd{
    # Call on controller flag detect
    public static function excCmd($arg){

        $instance = new ModelCmd();

        # Removeing make:controller
        unset($arg['action_name']);
        
        # Get controller name
        $modelNm = $arg['file_name'] ?? '';
        if(!$modelNm){
            HlprCls::errorInCmd("Use valid model name!\n eg: User,Department.");
        }

        if(preg_match("/^\-.*/", $modelNm)){
            HlprCls::cmdRunnStrt("$modelNm is flag type!", "\033[33m"); 
            HlprCls::errorInCmd("Make sure to use correct command");
        }
        $modelNm = ucfirst($modelNm);
        $modelNm = preg_replace("/[\.\-]/", '', $modelNm);
        
        

        # Create controller process
        $instance->createModel($modelNm, $arg['dir_name']);
        unset($arg['file_name']); // Removing controller name
    }

    # Create controller File
    private function createModel($modelNm, $appDr){
        $appDirPath = getcwd()."/".$appDr;
        HlprCls::checkDirectory($appDirPath."/model/", "Model Folder does not exist! Create it? (Y/N): ");

        $modelFllNm = $appDirPath."/model/".$modelNm.".php";
        
        if(!file_exists($modelFllNm)){
            HlprCls::createFile($modelFllNm, "<?php\nclass $modelNm extends MyAppModel{\n    public function index(\$param = ''){\n\n    }\n}");
            HlprCls::cmdRunnStrt($modelNm." created successfully!", "\033[33m");
        }else{
            if(strtolower(trim(readline("Override existing model? (Y/N): "))) == "y"){
                HlprCls::createFile($modelFllNm, "<?php\nclass $modelNm extends MyAppModel{\n    public function index(\$param = ''){\n\n    }\n}");
                HlprCls::cmdRunnStrt($modelNm." overided!", "\033[33m");
            }
        }
    }
}