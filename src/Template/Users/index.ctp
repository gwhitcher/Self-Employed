<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Users</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="dropdown">
            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Manage
            </a>

            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item" href="<?php echo BASE_URL; ?>/users/add">Add</a>
            </div>
        </div>
    </div>
</div>

<p>A listing of all your users.</p>

<table class="table table-hover">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Username</th>
        <th scope="col">Manage</th>
    </tr>
    </thead>
    <tbody>
	<?php foreach($users as $user) { ?>
        <tr>
            <th scope="row"><?php echo $user->id; ?></th>
            <td><?php echo $user->username; ?></td>
            <td>
                <a class="btn btn-warning" href="<?php echo BASE_URL; ?>/users/edit/<?php echo $user->id; ?>">Edit</a>
                <a class="btn btn-danger confirm" href="<?php echo BASE_URL; ?>/users/delete/<?php echo $user->id; ?>">Delete</a>
            </td>
        </tr>
	<?php } ?>
    </tbody>
</table>