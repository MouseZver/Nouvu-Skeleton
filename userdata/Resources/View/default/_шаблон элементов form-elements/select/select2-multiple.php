<?php $name = md5 ( microtime ( true ) . mt_rand () ) ?>
<label class="form-label" for="select-<?= $name ?>-multiple">{{label}}</label>
<select class="select2 form-select" id="select-<?= $name ?>-multiple" name="{{select-name}}" multiple="">
	{{options}}
</select>