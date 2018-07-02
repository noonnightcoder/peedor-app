<div class="row">

    <div class="col-sm-12">
        <div class="col-sm-12" id="lasted-count">
            <?php if(isset($_SESSION['latestCount'])):?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Counted</th>
                            <th style="text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($_SESSION['latestCount'] as $key=>$value):?>
                            <tr>
                                <td width="30"><?=$value['itemId']?></td>
                                <td><?=$value['name']?></td>
                                <td width="100">
                                    <div class="col-sm-12">
                                        <input type="number" onkeypress="updateCount(<?=$value['itemId']?>)" class="txt-counted<?=$value['itemId']?> form-control" value="<?=$value['countNum']?>">
                                    </div>
                                </td>
                                <td width="80" align="center">
                                    <a class="delete-item btn btn-danger btn-xs" onClick="inventoryCount(2,<?=$key?>)">
                                        <span class="glyphicon glyphicon glyphicon-trash "></span>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            <?php endif;?>
        </div>
    </div>
</div>