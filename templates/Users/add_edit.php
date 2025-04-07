
<h1><?= $user->isNew() ? 'Add New User' : 'Edit User' ?></h1>

<?= $this->Form->create($user, ['type' => 'file']) ?>
    <fieldset>
        <legend><?= __('User Details') ?></legend>
        <!-- Name Input -->
        <?= $this->Form->control('name', [
            'label' => 'Name',
            'placeholder' => 'Enter your name'
        ]) ?>

        <!-- Email Input -->
        <?= $this->Form->control('email', [
            'label' => 'Email',
            'placeholder' => 'Enter your email'
        ]) ?>

        <!-- Password Input -->
        <?= $this->Form->control('password', [
            'label' => 'Password',
            'placeholder' => 'Enter your password',
            'type' => 'password' // Password field
        ]) ?>

        <!-- Role Select -->
        <?= $this->Form->control('role', [
            'type' => 'select',
            'options' => ['admin' => 'Admin', 'user' => 'User'],
            'label' => 'Role'
        ]) ?>

        <!-- Status Checkbox -->
        <?= $this->Form->control('status', [
            'type' => 'checkbox',
            'label' => 'Active?',
            'checked' => $user->status ?? false
        ]) ?>

        <!-- Profile Picture File Upload -->
        <?= $this->Form->control('profile_picture', [
            'type' => 'file',
            'label' => 'Profile Picture'
        ]) ?>
    </fieldset>

    <!-- Save Button -->
    <?= $this->Form->button(__('Save')) ?>

<?= $this->Form->end() ?>
