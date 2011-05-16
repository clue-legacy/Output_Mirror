<?php

/**
 * mirror output to given string reference
 * 
 * output (echo, print, etc.) will work as-is and all contents will be
 * mirrored to the referenced string as long as and instance of the mirror
 * lives.
 * 
 * @author Christian Lück <christian@lueck.tv>
 * @copyright Copyright (c) 2011, Christian Lück
 * @license http://www.opensource.org/licenses/mit-license MIT License
 * @version v0.1.0
 * @link https://github.com/clue/Output_Mirror
 */
class Output_Mirror{
    /**
     * reference to output string
     * 
     * @var string
     */
    private $ref;
    
    /**
     * instanciate new output mirror to given string reference
     * 
     * @param string $ref
     * @uses ob_start() to start smallest possible output buffer (flush data automatically ASAP)
     */
    public function __construct(&$ref){
        $this->ref =& $ref;
        
        $fn = function($chunk) use (&$ref){
            $ref .= $chunk;
            return false;  // display original output
        };
        
        if(ob_start($fn,2) === false){ // start smallest possible output buffer (chunksize=2 as 1 is reserved)
            throw new Exception('Unable to start output buffer');
        }
    }
    
    /**
     * destruct output mirror (leave scope, clear remaining buffer)
     * 
     * @uses ob_end_flush() to flush remaining buffer
     */
    public function __destruct(){
        if(ob_end_flush() === false){
            throw new Exception('Unable to end output buffer');
        }
    }
    
    /**
     * get string contents of output mirror
     * 
     * @return string
     */
    public function __toString(){
        return $this->ref;
    }
}
