<?php

$dise = mt_rand(1, 6);

print "サイコロの目 : $dise \n";

if ($dise % 2 === 1) {
    print "奇数\n";
} else {
    print "偶数\n";
}
