<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Author $author
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $author->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $author->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Authors'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="authors form content">
            <?= $this->Form->create($author) ?>
            <fieldset>
                <legend><?= __('Edit Author') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('bio');
                ?>
                <!-- Publisher Selection -->
                <?= $this->Form->control('publishers._ids', [
                    'type' => 'select',
                    'multiple' => 'checkbox',
                    'options' => $publishers,
                    'label' => 'Select Publishers'
                ]) ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>




