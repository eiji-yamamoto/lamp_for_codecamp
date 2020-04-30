<pre>
<?php

$var1 = mt_rand(0, 2);
$var2 = mt_rand(0, 2);

print "var1 : $var1 \n";
print "var2 : $var2 \n";

if ($var1 > $var2) {
    print "var1 grater than var2\n";
} else if ($var1 === $var2) {
    print "var1 is same as var2\n";
} else {
    print "var1 smaler than var2\n";
}
?>
</pre>