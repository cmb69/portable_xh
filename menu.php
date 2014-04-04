<!DOCTYPE html>
<html>
    <head>
        <title>Portable_XH</title>
    </head>
    <body>
        <ul>
<?php foreach (subfolders() as $subfolder):?>
            <li>
                <a href="/<?php echo $subfolder;?>/"><?php echo $subfolder;?></a>
            </li>
<?php endforeach;?>
        </ul>
    </body>
</html>