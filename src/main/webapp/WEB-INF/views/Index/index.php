<h1>Quercus Compatibility Matrix</h1>
<style type="text/css">
    @import "/qtck.css";
</style>
<table>
    <thead>
    <tr>
        <td rowspan="2">Module name</td>
        <td rowspan="2" align="center">Zend <br/>PHP 5.3.3</td>
        <td colspan="5" align="center">Quercus</td>
    </tr>
    <tr>
        <td>1</td>
        <td>1</td>
        <td>1</td>
        <td>1</td>
        <td>1</td>
    </tr>
    </thead>
    <tbody>
    <? foreach($modules as $module) { ?>
            <tr>
                <td><a href='<?= createLink("Module", "show", array("id" => $module->getId())); ?>'><?= $module->getName() ; ?></a></td>
                <td class="success">100%</td>
                <td class="failure">0%</td>
                <td class="failure">0%</td>
                <td class="failure">0%</td>
                <td class="failure">0%</td>
                <td class="failure">0%</td>
            </tr>
    <? } ?>
    </tbody>
</table>
