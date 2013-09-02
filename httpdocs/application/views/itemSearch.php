<h2>Searching: <?php echo "$realm->name [$realm->region]";?></h2>
<p>Enter your search string to see how you can make profit with cross faction trading.</p>
<form action="/auctions/items" method="get">
<input type="text" id="item" name="item" value="<?php echo $searchTerm;?>">
<input type="submit" value="Search">
</form>