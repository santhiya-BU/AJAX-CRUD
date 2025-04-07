<!-- <h2>Books List (AJAX)</h2>

<?= $this->Form->create(null, ['type' => 'get', 'id' => 'searchForm']) ?>
    
    <div>
        <?= $this->Form->control('title', ['label' => 'Title']) ?>
        <?= $this->Form->control('published_', ['label' => 'Publishesd Year']) ?>
        <?= $this->Form->control('author', ['label' => 'Author']) ?>
        <?= $this->Form->control('publisher', ['label' => 'Publisher']) ?>
    </div>
    <button type="submit">Search</button>

<?= $this->Form->end() ?>

<div id="ajax-content">
    <?= $this->element('Books/ajax_index', ['books' => $books]) ?>
</div>

<script>
    function loadAjaxContent(url) {
        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(res => res.text())
            .then(html => {
                document.getElementById('ajax-content').innerHTML = html;
                attachLinks(); // reattach event listeners to new pagination links
            });
    }

    function attachLinks() {
        document.querySelectorAll('#ajax-content a').forEach(el => {
            el.addEventListener('click', function(e) {
                e.preventDefault();
                loadAjaxContent(this.href);
            });
        });
    }

    // Trigger search with AJAX
    document.getElementById('searchForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const params = new URLSearchParams(new FormData(this)).toString();
        const url = '<?= $this->Url->build(['controller' => 'Books', 'action' => 'index']) ?>?' + params;
        loadAjaxContent(url);
    });

    attachLinks();
</script> -->


<h2>Books Search & Sort</h2>

<!-- Search Form -->
<form id="searchForm">
    <input type="text" name="title" placeholder="Search by title">
    <input type="text" name="year" placeholder="Published year">
    <select name="sort">
        <option value="">Sort by title</option>
        <option value="title_asc">Title A-Z</option>
        <option value="title_desc">Title Z-A</option>
    </select>
    <button type="submit">Search</button>
</form>

<!-- Results Table -->
<table border="1">
    <thead>
        <tr>
            <th>ID</th><th>Title</th><th>Author</th><th>Publisher</th><th>Year</th>
        </tr>
    </thead>
    <tbody id="booksTable"></tbody>
</table>

<!-- JavaScript -->
<?= $this->Html->scriptStart(['block' => true]) ?>
<script>
function loadBooks(params = {}) {
    const url = new URL('/books/fetch', window.location.origin);
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

    fetch(url)
        .then(res => res.json())
        .then(data => {
            // Log the data structure to the console for debugging
            console.log(data);

            // Check if data.books is an array and then generate the table rows
            let rows = '';
            if (data.books && Array.isArray(data.books)) {
                data.books.forEach(b => {
                    rows += `<tr>
                        <td>${b.id}</td>
                        <td>${b.title}</td>
                        <td>${b.author ? b.author.name : '—'}</td>
                        <td>${b.publisher ? b.publisher.name : '—'}</td>
                        <td>${b.published_year}</td>
                    </tr>`;
                });
            } else {
                rows = '<tr><td colspan="5">No books found</td></tr>';
            }
            console.log(rows);
            // Update the table body with new rows
            document.getElementById('booksTable').innerHTML = rows;
        })
        .catch(error => {
            // Handle any error in the fetch request
            console.error('Error fetching books:', error);
        });
}

document.getElementById('searchForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const params = {};
    for (let [key, value] of formData.entries()) {
        params[key] = value;
    }
    loadBooks(params);
});

// Initial load
loadBooks();
</script>
<?= $this->Html->scriptEnd() ?>


