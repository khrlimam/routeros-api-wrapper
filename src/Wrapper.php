<?php 

namespace KhairulImam\ROSWrapper;

use RouterosAPI;

class Wrapper extends RouterosAPI {

    function __construct($hostname, $username = 'admin', $password = '') {
        $this->connect($hostname, $username, $password);
    }

    /**
     * $command    The command that will be executed
     * $arguments  The argument that gonna be passed to the command
     * 
     * return Array of responses
     */
    public function run($command, Array $arguments = []) {
        $cmd = $this->getValidCmd($command);
        return $this->comm($cmd, $arguments);
    }

    /**
     * @param Sequential $sequential
     * @throws RollbackedException
     */
    public function runSequentialProcess(Sequential $sequential) {
        SequentialExecutor::execute($sequential);
    }

    /**
     * @Deprecated  this method already exists on the original class
     * $command    The command that will be executed
     * $arguments  The argument that gonna be passed to the command
     * 
     * return Array of responses
     */
    public function exec($command, Array $arguments = []) {
        $cmd = $this->getValidCmd($command);
        if (count($arguments) <= 0) $this->write($cmd);
        else {
            $this->write($cmd, false);
            foreach($arguments as $param => $value) {
                $isLastArgument = true;
                if (next($arguments)) 
                    $isLastArgument = false;
                $this->write("=$param=$value", $isLastArgument);
            }
        }
        return $this->read();
    }

    /**
     * $cmd     Command string that gonna be checked
     * 
     * return   Boolean (true if valid else otherwise)
     */
    private function isValidCmd($cmd) {
        return strpos($cmd, "/") != FALSE;
    }

    /**
     * $cmd     Command that has no trailing slash
     * 
     * return String of slashed command
     */
    private function appendSlash($cmd) {
        return "/".join("/", explode(" ", $cmd));
    }

    /**
     * $cmd     Command that will be transformed into correct command
     * 
     * return   String command that has been transformed
     */
    public function getValidCmd($cmd) {
        if (!$this->isValidCmd($cmd))
            return $this->appendSlash($cmd);
        return $cmd;
    }

}