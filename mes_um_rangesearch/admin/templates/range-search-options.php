<div id="mes-um-rs">
    <p>
        <label class="um-admin-half"><strong><?php echo 'Search Fields'; ?></strong>
            <?php $this->tooltip('List numeric fields, you enabled in Search Options section. Removes duplicate fields before listing'); ?></label>
        <label class="um-admin-half"><strong><?php echo 'Make Range Searchable'?></strong>
            <?php $this->tooltip('If turned on, the field will be range searched'); ?></label>
        <input type="hidden" name="_um_search_fields_mes_rs[]" value="" />
    </p><div class="um-admin-clear"></div>

    <div id="mes-um-rs-rows">

    </div>
    <div><div class="mes-um-rs-divider"></div></div>
    <div>
        <p>
            <label class="um-admin-half"><?php echo 'Prefix for placeholder of 1st input of range'; ?>
                <?php $this->tooltip('Customize the prexfix text. For example, if you set it to Min, the input placeholder for a field labelled Age will be Min Age'); ?></label>
			<span class="um-admin-half">

				<input type="text" name="<?php echo MES_UM_RS_META_KEY_PREFIX . MES_UM_RS_PREFIX_MIN; ?>" value="<?php echo $prefix_min ?>" />

			</span>
        </p><div class="um-admin-clear"></div>
        <p>
            <label class="um-admin-half"><?php echo 'Prefix for placeholder of 2nd input of range'; ?>
                <?php $this->tooltip('Customize the prexfix text. For example, if you set it to Max, the input placeholder for a field labelled Age will be Max Age'); ?></label>
			<span class="um-admin-half">

				<input type="text" name="<?php echo MES_UM_RS_META_KEY_PREFIX .  MES_UM_RS_PREFIX_MAX; ?>"  value="<?php echo $prefix_max?>" />


			</span>
        </p><div class="um-admin-clear"></div>

    </div>
</div>