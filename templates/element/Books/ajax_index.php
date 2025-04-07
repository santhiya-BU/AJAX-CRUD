<table>
    <thead>
        <tr>
        <th><?= $this->Paginator->sort('id', 'ID') ?></th>
            <th><?= $this->Paginator->sort('title', 'Title') ?></th>
            <th><?= $this->Paginator->sort('author_id', 'Author') ?></th>
            <th><?= $this->Paginator->sort('publisher_id', 'Publisher') ?></th>
            <th><?= $this->Paginator->sort('published_year', 'Published Date') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($books as $book): ?>
            <tr>
                <?php echo $book; ?>
                <td><?= h($book->id) ?></td>
                <td><?= h($book->title) ?></td>
                <td><?= h($book->author->name ?? 'Unknown Author') ?></td>
                <td><?= h($book->publisher->name ?? 'Unknown Publisher') ?></td>
                <td><?= h($book->published_year) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="paginator">
    <ul class="pagination">
        <?= $this->Paginator->first('<<') ?>
        <?= $this->Paginator->prev('<') ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next('>') ?>
        <?= $this->Paginator->last('>>') ?>
    </ul>
</div>
