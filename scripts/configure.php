<?php

if(count($argv) < 2)
{
    print "Usage: configure (install | upgrade <version> | configure | remove)\n";
    exit(1);
}

$command = $argv[1];

if($command == "upgrade")
{
    exit(0);
}

if($command == "install")
{
    mkdir("/Communigate");
    chdir("/Communigate");
    exit(0);
}

if($command == "remove")
{
    exit(0);
}

if($command == "configure")
{
    exit(0);
}



?>
