<?php

class HndlCmd{
    
    public static function excCmd($arg){

        # Removing script file name
        array_shift($arg);

        # Execute information by command
        $mySelf = new HndlCmd();

        # Finding all actions flag
        $actnFlg = array_filter($arg, function($elem){
            return preg_match("/^-[cmv].*=/", $elem);
        });

        $actnFlg = array_map(function($elem){
            $elem = explode('=', $elem);
            
            $elem['action_name'] = $elem[0] ?? '';
            $elem['file_name'] = $elem[1] ?? '';

            $elem['action_name'] = preg_replace("/^-[c].*/", 'make:controller', $elem['action_name'] ?? '');
            $elem['action_name'] = preg_replace("/^-[v].*/", 'make:view', $elem['action_name'] ?? '');
            $elem['action_name'] = preg_replace("/^-[m].*/", 'make:model', $elem['action_name'] ?? '');

            return $elem;
        }, $actnFlg);

        # Finding directory of application
        $dirFlg = array_filter($arg, function($elem){
            return preg_match("/^-d.*=/", $elem);
        });
        $dirNm = preg_replace("/^-d.*=/", '', implode("", $dirFlg) ?? '');

        if(!$dirNm){
            HlprCls::errorInCmd("Provide valid application directory!\n eg: -d=admin,user.");
        }
        HlprCls::checkDirectory(getcwd()."/".$dirNm, $dirNm." Folder does not exist! Create it? (Y/N): ");

        # Call every action
        foreach ($actnFlg as $actns) {
            
            if($actns['action_name'] == 'make:view'){
                $lstFldrCnB = ['controller', 'action'];

                $lstFldr = explode("/", $actns['file_name']);
                $lstFldr = array_map(function($elemKey) use(&$lstFldr){
                    return $lstFldr[$elemKey] ?? '';
                }, array_keys($lstFldrCnB));
                $lstFldr = array_combine($lstFldrCnB, $lstFldr);


                foreach ($lstFldr as $fldr => $name) {
                    if(!$name){
                        $name = readline("File name on level of ".$fldr.":- ");
                    }

                    if(!$name){
                        HlprCls::errorInCmd("You cannot proceed without controller & action!");
                    }
                    $name = strtolower(preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1-', $name));
                    HlprCls::cmdRunnStrt("File/Folder name on level of ".$fldr.":- ".$name);

                    $lstFldr[$fldr] = $name;
                }
                $actns['file_name'] = $lstFldr;
            }

            $actns = $actns+['dir_name' => $dirNm];
            $mySelf->exctCmdFor($actns);
        }

        # On success fully completing all information
        HlprCls::succsInCmd("Command executed successfully!");
    }

    private function exctCmdFor(&$cmdFor){
        switch ($cmdFor['action_name'] ?? '') {
            case 'make:controller':
                HlprCls::cmdRunnStrt("Creating controller files...", "\033[42m"); 
                ContrlrCmd::excCmd($cmdFor);
                break;
            case 'make:model':
                HlprCls::cmdRunnStrt("Creating model files...", "\033[42m");
                ModelCmd::excCmd($cmdFor);
                break;
            case 'make:view':
                HlprCls::cmdRunnStrt("Creating view files...", "\033[42m");
                ViewCmd::excCmd($cmdFor);
                break;
            default:
                HlprCls::cmdRunnStrt("Command execting start..", "\033[42m");
                HlprCls::errorInCmd("Use valid command!\nphp fatbit -m=ModelName -c=ControllerName -v=ControllerName/ActionName");
                break;
        }
    }
}