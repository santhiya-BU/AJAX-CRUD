
<h1>Users List</h1>

<?= $this->Html->link('Add New User', ['action' => 'add_edit'], ['class' => 'button']) ?>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Profile Picture</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= h($user->id) ?></td>
            <td><?= h($user->name) ?></td>
            <td><?= h($user->email) ?></td>
            <td>
                <?= $user->profile_picture ? $this->Html->image($user->profile_picture, ['alt' => 'Profile Picture', 'width' => '50']) : 'No image' ?>
            </td>
            <td>
                <?= $this->Html->link('Edit', ['action' => 'add_edit', $user->id]) ?> |
                <?= $this->Form->postLink('Delete', ['action' => 'delete', $user->id], ['confirm' => 'Are you sure?']) ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
