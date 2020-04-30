<pre>
    <?php
    $var1 = 1;
    print '数字のvar_dump';
    print "\n";
    var_dump($var1);
    print "\n";

    $var2 = '1';
    print '文字列のvar_dump';
    print "\n";
    var_dump($var2);
    print "\n";

    $var3 = null;
    print 'nullのvar_dump';
    print "\n";
    var_dump($var3);
    print "\n";

    $var4 = true;
    print 'booleanのvar_dump';
    print "\n";
    var_dump($var4);
    print "\n";

    // 追加
    $var5 = -1;
    print '負の数のvar_dump';
    print "\n";
    var_dump($var5);
    print "\n";

    $var6 = date('Y');
    print '日付(文字列)のvar_dump';
    print "\n";
    var_dump($var6);
    print "\n";

    $var7 = mb_strlen('文字数は9文字です', 'UTF-8');
    print '文字数(int)のvar_dump';
    print "\n";
    var_dump($var7);
    print "\n";

    // plus alpha

    $var_test = "a";
    var_dump($var_test == true);

    print "\n";


    ?>
</pre>