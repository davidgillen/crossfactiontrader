<p>If the item was not present on the last update no price will be shown.<br/>Also, if we have not yet found an item at all, it will not appear, e.g. Queen's Garnet epic gems.<br/>Results shown are per single item.</p>
<table>
<thead>
<tr>
  <th>Name</th><th>Alliance Average</th><th>Horde Average</th>
</tr>
</thead>
<tbody>
  <?php foreach($items as $item):?>
  <tr>
    <td><a href="#" rel="item=<?php echo $item->itemId;?>"><?php echo $item->name;?></a></td>
    <td class="wowprice"><?php echo $item->tidyAllianceAvg;?></td>
    <td class="wowprice"><?php echo $item->tidyHordeAvg;?></td>
  </tr>
  <?php endforeach;?>
</tbody>
</table>