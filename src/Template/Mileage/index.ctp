<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Mileage</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="dropdown">
            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Manage
            </a>

            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item" href="<?php echo BASE_URL; ?>/mileage/add">Add</a>
                <a class="dropdown-item" href="<?php echo BASE_URL; ?>/mileage/export">Export</a>
            </div>
        </div>
    </div>
</div>

<p>A listing of all your mileage.</p>

<table class="table table-hover">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Date</th>
        <th scope="col">Distance</th>
        <th scope="col">Notes</th>
        <th scope="col">Manage</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($mileage as $item) { ?>
    <tr>
        <th scope="row"><?php echo $item->id; ?></th>
        <td><?php echo $item->date; ?></td>
        <td><?php echo $item->distance; ?></td>
        <td><?php echo $item->notes; ?></td>
        <td>
            <a class="btn btn-warning" href="<?php echo BASE_URL; ?>/mileage/edit/<?php echo $item->id; ?>">Edit</a>
            <a class="btn btn-danger confirm" href="<?php echo BASE_URL; ?>/mileage/delete/<?php echo $item->id; ?>">Delete</a>
        </td>
    </tr>
    <?php } ?>
    </tbody>
</table>