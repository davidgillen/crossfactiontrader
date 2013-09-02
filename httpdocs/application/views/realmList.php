<ul class="datalist">
<?php foreach($realms as $realm):?>
<li><a href="/realms/<?php echo $region;?>/<?php echo $realm->slug;?>"><?php echo $realm->name;?></a></li>
<?php endforeach; ?>
</ul>
