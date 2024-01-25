<?php

class ContrlrCmd{
    # Call on controller flag detect
    public static function excCmd($arg){

        $instance = new ContrlrCmd();

        # Removeing make:controller
        unset($arg['action_name']);
        
        # Get controller name
        $ctrlrNm = $arg['file_name'] ?? '';
        if(!$ctrlrNm){
            HlprCls::errorInCmd("User valid controller name!\n eg: UserController,HomeController.");
        }

        if(preg_match("/^\-.*/", $ctrlrNm)){
            HlprCls::cmdRunnStrt("$ctrlrNm is flag type!", "\033[33m"); 
            HlprCls::errorInCmd("Make sure to use correct command");
        }
        $ctrlrNm = ucfirst($ctrlrNm);
        $ctrlrNm = preg_replace("/[\.\-]/", '', $ctrlrNm);

        # Create controller process
        $instance->createContrlr($ctrlrNm, $arg['dir_name']);
        unset($arg['file_name']); // Removing controller name
    }

    # Create controller File
    private function createContrlr($ctrlrNm, $appDr){
        $appDirPath = getcwd()."/".$appDr;
        HlprCls::checkDirectory($appDirPath."/controllers/", "controllers - Folder does not exist! Create it? (Y/N): ");

        $ctrlrFllNm = $appDirPath."/controllers/".$ctrlrNm.".php";
        
        if(!file_exists($ctrlrFllNm)){
            HlprCls::createFile($ctrlrFllNm, "<?php\nclass $ctrlrNm extends MyAppController{\n    public function index(\$param = ''){\n\n    }\n}\n    public function create(\$param = ''){\n\n    }\n}\n    public function store(\$param = ''){\n\n    }\n}\n    public function edit(\$param = ''){\n\n    }\n}\n    public function update(\$param = ''){\n\n    }\n}");
            HlprCls::cmdRunnStrt($ctrlrNm." created successfully!", "\033[33m");
        }else{
            if(strtolower(trim(readline("Override existing controller? (Y/N): "))) == "y"){
                HlprCls::createFile($ctrlrFllNm, "<?php\nclass $ctrlrNm extends MyAppController{\n    public function index(\$param = ''){\n\n    }\n}\n    public function create(\$param = ''){\n\n    }\n}\n    public function store(\$param = ''){\n\n    }\n}\n    public function edit(\$param = ''){\n\n    }\n}\n    public function update(\$param = ''){\n\n    }\n}");
                HlprCls::cmdRunnStrt($ctrlrNm." overrided!", "\033[33m");
            }
        }
    }
}