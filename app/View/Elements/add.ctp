<button id="add" type="button" class="btn btn-primary">
    <?php echo $name; ?> 
    <span class="badge" style="margin-left: 8px;<?php echo (!isset($value) || $value === '') ? 'display:none;' : '' ?>"><?php echo $value; ?></span>
</button>