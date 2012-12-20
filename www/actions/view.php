<h2>Viewing Output</h2>
<?php
/**
 * User: larry
 */

$output_dir = glob('output/*');
foreach ($output_dir as $subdir) {
    print"<section>";
    print"<h3>{$subdir}</h3>";
    print"<ul>";
    $subdir_contents = glob("$subdir/*.*");
    foreach ($subdir_contents as $image_path) {
        ?>
        <li>
            <a href="<?=$image_path?>">
            <img border="0"  src="<?=$image_path?>">
            <div><?=str_replace($subdir."/",'',$image_path)?></div>
            </a>
        </li>
    <?
    }
    print"</ul></section>";
}