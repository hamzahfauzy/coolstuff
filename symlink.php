<?php
$res = '"'.getcwd() . '/storage"';
$dst = '"'.getcwd() . '/public"';
$cmd = 'ln -s '.$res.' '.$dst;
exec($cmd);
echo "Exec symlink ".$cmd."\n";