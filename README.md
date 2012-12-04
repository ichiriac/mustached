mustached
=========

http://www.pltgames.com/competition/2012/12

The greatest language in da world ... coz it's great for drawing dragons :)

Give a try :

```
php run.php --script dragon.txt
```

## Semantics :

### Memory allocation
The + increment the allocated memory size
The - decrement the allocated memory size

NOTE : After each statement (excluding allocations) the allocated memory is distructed

### Memory writers
The $ puts the input from the stack and jumps to the next statement
The ? gets the input from STDIN

### Memory output
The greatest part : the @ outputs the memory contents

TODO : Handle comparison and jumps

---------------------------------

## Samples

The hello world : 
```
+9+2$Hello world@+4$ !!!@
```

Inteactive sample : 
```
+9+3$Your name : @+6$Hello +9?+6+9@
```