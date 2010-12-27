<?


?>
<style type="text/css">
    @import "/qtck.css";
</style>

<h1><?= $module->name; ?></h1>

    <b>Info</b>:
<div class="infobox">
    <p>
        <label for="module_id">ID</label> <input type="text" id="module_id" value="<?= $module->id; ?>"/>
    </p>
    <p>
        <label for="module_name">Name</label> <input type="text" id="module_name" value="<?= $module->name; ?>"/>
    </p>
    <p>
        <label for="module_shortname">ShortName</label> <input type="text" id="module_shortname" value="<?= $module->shortname; ?>"/>
    </p>
    <p>
        <label for="module_deprecated">Deprecated?</label> <input type="checkbox" id="module_deprecated" <?= ($module->deprecated) ? "checked='checked" : ""; ?> />
    </p>
    <p>
        <label for="module_testscript_bash">Testscript Bash</label> <input type="text" id="module_testscript_bash" value="<?= createAbsoluteLink("Module", "generateTestScript", array("id" => $module->id)); ?>" />
    </p>
</div>

<h2>Constants</h2>
    Success: <?= $constantsSuccessCount; ?><br/>
    Failures: <?= $constantsFailureCount; ?><br/>
    Success-Rate: <?= $constantsSuccessRate ?> %<br/>

<div class="successBar">
    <div class="success" style="width: <?= round($constantsSuccessRate); ?>%; "><?= round($constantsSuccessRate); ?>%</div><div class="failure" style="width: <?= 100-round($constantsSuccessRate); ?>%; "><?= ($constantsSuccessRate < 90) ? ( 100-round($constantsSuccessRate). "%" ) : ''; ?></div>
</div>

    <table>
        <thead>
        <tr>
            <td>Constant Name</td>
            <td>defined?</td>
            <td>default value</td>
            <td>actual value</td>
        </tr>
        </thead>
        <tbody>

        <?
        foreach($constants as $constant)
        {


?>
        <tr>
            <td><?= $constant->name; ?></td>
            <td><?= defined($constant->name)?"yes":"no"; ?></td>
            <td><?= $constant->defaultvalue; ?></td>
            <td class="<?= $constantsStatus[$constant->name] ? 'success':'failure'; ?>"><?= constant($constant->name); ?></td>
        </tr>
            <?
        }
?>
        </tbody>
    </table>


<h2>Functions</h2>
    Success: <?= $functionsSuccessCount; ?><br/>
    Failures: <?= $functionsFailureCount; ?><br/>
    Success-Rate: <?= $functionsSuccessRate; ?> %<br/>

<div class="successBar">
    <div class="success" style="width: <?= round($functionsSuccessRate); ?>%; "><?= ($functionsSuccessRate > 10) ? ( round($functionsSuccessRate) . "%") : ""; ?></div><div class="failure" style="width: <?= 100-round($functionsSuccessRate); ?>%; "><?= ($functionsSuccessRate < 90) ? ( 100-round($functionsSuccessRate). "%" ) : ''; ?></div></div>


        <table border="1">
        <thead>
        <tr>
            <td>Function Name</td>
            <td>exists?</td>
            <td>TestCode</td>
        </tr>
        </thead>
        <tbody>

        <?
        foreach($functions as $func)
        {


?>
        <tr>
            <td><a href="http://de.php.net/manual/en/function.<?= $func->shortname; ?>.php" target="_blank"><?= $func->name; ?></a></td>
            <td class="<?= $functionsStatus[$func->name] ? 'success':'failure'; ?>"><?= function_exists($func->name)?"yes":"no"; ?></td>
            <td><a href="<?= createLink("Function", "testCode", array("id" => $func->id)); ?>" target="_blank">Testcode</a></td>
            <!--            <td>--</td>-->
        </tr>
            <?
        }
?>
        </tbody>
    </table>
