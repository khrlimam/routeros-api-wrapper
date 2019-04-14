<?php 

namespace KhairulImam\ROSWrapper;

use RouterosAPI;

class Wrapper extends RouterosAPI {
    public function exec(String $cmd, Array $arguments = []) {
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
}