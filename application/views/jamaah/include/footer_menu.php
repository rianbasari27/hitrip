<?php if (!isset($home) && !isset($pages) && !isset($feature) && !isset($search) && !isset($setting)) {
    $home = true;
} ?>
<div id="footer-bar" class="footer-bar-3" style="font-size:5px;">
    <a href="#" class="<?php echo isset($pages) ? 'active-nav' :'' ;?>"><i class="fa fa-heart"></i><span>Pages</span></a>
    <a href="#" class="<?php echo isset($feature) ? 'active-nav' :'' ;?>"><i class="fa fa-star"></i><span>Features</span></a>
    <a href="#" class="<?php echo isset($home) ? 'active-nav' :'' ;?>"><i class="fa fa-home"></i><span>Home</span><strong></strong></a>
    <a href="#" class="<?php echo isset($search) ? 'active-nav' :'' ;?>"><i class="fa fa-search"></i><span>Search</span></a>
    <a href="#" class="<?php echo isset($setting) ? 'active-nav' :'' ;?>"><i class="fa fa-cog"></i><span>Settings</span><em class="badge bg-highlight">3</em></a>
</div>