<?php if($delItem): ?>
<div class="clearfix mb-3">
    <div class="w-50 float-right">
        <div class="alert alert-warning">
            <p>
                You are about to delete <?= $itemType." ($item)" ?> <br>
                <strong>Are you sure?</strong>
            </p>
            <form action="" method="post">
                <button type="submit" name="doDlt" class="btn btn-sm btn-success">yes</button>
                <a href="<?= $pageURL?>" class="btn btn-sm btn-danger">no</a>
            </form>
        </div>
    </div>
</div>
<?php endif ?>
