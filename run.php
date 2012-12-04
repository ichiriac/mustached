<?php
class processor{
    protected $stack;
    protected $offset;
    protected $memory;
    protected $adr;
    public function __construct( $stack ) {
        $this->stack = $stack;
    }
    public function run( $debug = false ) {
        $this->offset = $this->adr = 0;
        $this->memory = null;
        while( !$this->isEnd() ) {
            $this->tick( $debug );
        }
        if ( $debug ) echo "\n--- : Stop at " . $this->offset . "\n";
        return $this->offset > -1;
    }
    public function tick( $debug = false ) {
        $action = $this->stack[ $this->offset ];
        if ($debug) echo "\n" . $action . " : " . $this->offset . ' ['.$this->adr.']';
        switch( $action ) {
            case '+':
                return ++$this->offset && $this->adr += $this->stack[ $this->offset++ ];
            case '-':
                return ++$this->offset && $this->adr -= $this->stack[ $this->offset++ ];
            case '>':
                return $this->offset += $this->adr && $this->adr = 0;
            case '<':
                return $this->offset -= $this->adr  && $this->adr = 0;
            case '$':
                return ($this->memory .= substr($this->stack, ++$this->offset, $this->adr) )
                    && ($this->offset+=$this->adr) 
                    && ($this->adr = 0)
                ;
            case '@':
                return $this->output() && ++$this->offset && $this->memory = null || $this->adr = 0;
            case '?':
                return $this->input() && $this->offset++ && $this->adr = 0;
            default:
               echo ' >>> Segment fault @ '.$this->offset.' ! ';
               $this->offset = -1;
        }
    }
    public function output() {
        echo empty($this->adr) ? $this->memory : substr($this->memory, 0, $this->adr);
        return true;
    }
    public function input() {
        $this->memory .= substr(fgets(STDIN), 0, $this->adr);
        return true;
    }
    public function isEnd() {
        return $this->offset === -1 || $this->offset >= strlen($this->stack);
    }
}

$run = new processor(
    ($offset = array_search('--script', $argv)) ?
    file_get_contents($argv[ ++$offset ]) :
    '+9+3$Your name : @+6$Hello +9?+6+9@'
);

if ( !$run->run(  in_array('--debug', $argv) ) ) {
    print_r($run);
}