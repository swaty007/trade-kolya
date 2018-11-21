<div data-course data-marketplace_id="<?php //echo $marketplace_id; ?>">
    <div class="currency">
        <select name="currency[0]">
            <option value="">валюта 1</option>
            <?php foreach ($currency as $code => $value) { ?>
                <option value="<?php echo $code ?>"><?php echo $value['name']; ?></option>
            <?php } ?>
        </select>
        <select name="currency[1]">
            <option value="">валюта 2</option>
            <?php foreach ($currency as $code => $value) { ?>
                <option value="<?php echo $code ?>"><?php echo $value['name']; ?></option>
            <?php } ?>
        </select>
    </div>
</div>
