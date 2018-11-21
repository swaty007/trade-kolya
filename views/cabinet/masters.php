<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <td>Имя пользователя</td>
            <td>Название биржи</td>
            <td>Управление</td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($masters as $master) { ?>
        <tr>
            <td><?php echo $master['username']; ?></td>
            <td><?php echo $master['marketplace_id']; ?></td>
            <td>
                <a class="btn btn-primary" set-slave="<?php echo $master['user_marketplace_id']; ?>" href="#"><i class="icon-signin"></i> Выбрать</a>
                <a class="btn btn-warning" profit="<?php echo $master['user_id']; ?>" href="#"><i class="icon-eye-open"></i> Профит</a>
            </td>
        </tr>
        <?php } ?>       
    </tbody>
</table>