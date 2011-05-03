<?php


require_once 'Output/Mirror.php';

class Output_MirrorTest extends PHPUnit_Framework_TestCase {
    
    public function testOne(){
        $output = 'initial';
        $r = new Output_Mirror($output);
        
        echo 1;
        print 2;
        echo 3;
        print 4;
        
        $this->assertEquals('initial1234',(string)$r);
        $this->assertEquals('initial1234',$output);
        
        unset($r);
        
        echo 5;
        print 6;
        
        $this->assertEquals('initial1234',$output);
    }
    
    public function testInit(){
        $output = '';
        new Output_Mirror($output);
        
        $this->assertEquals('',$output);
    }
    
    public function testMultiple(){
        $a = '';
        $b = '';
        
        $am = new Output_Mirror($a);
        
        echo 1;
        
        $bm = new Output_Mirror($b);
        
        echo 2;
        
        unset($bm);
        
        echo 3;
        
        unset($am);
        
        $this->assertEquals('123',$a);
        $this->assertEquals('2',$b);
    }
    
    public function testNested(){
        $a = '';
        $am = new Output_Mirror($a);
        
        echo 12;
        
        $this->assertEquals('12',(string)$a);
        
        $this->b();
        
        echo 56;
        
        $this->assertEquals('123456',$a);
        $this->assertEquals('123456',(string)$am);
    }
    private function b(){
        $b = '';
        $bm = new Output_Mirror($b);
        
        echo 34;
        
        $this->assertEquals('34',$b);
        $this->assertEquals('34',(string)$bm);
    }
}
