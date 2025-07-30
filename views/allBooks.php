<?php
?>
<div class="all-books-container">
    <div class="search-field-container">
        <h1>Nos livres à l'échange</h1>
        <label for="bsearch"></label>
        <input
            class="search-field"
            type="search" id="bsearch"
            placeholder="Rechercher un livre"
        >
    </div>
    <section class="book-card-container">
        <?php foreach ($books as $book) : ?>
            <article class="book-card">
                <a href="index.php?action=singleBook&id=<?= (int)$book['id'] ?>">
                    <img
                        src="<?= Helpers::sanitizeUrl($book['cover']) ?>"
                        alt="Couverture du livre <?= Helpers::sanitize($book['title']) ?>"
                    >
                    <h4>
                        <?= Helpers::sanitize($book['title']) ?>
                    </h4>
                    <div class="inter-text light-grey-text">
                        <?= Helpers::sanitize($book['author']) ?>
                    </div>
                    <div class="small-text-10 italic-text light-grey-text">
                        Vendu par : <?= Helpers::sanitize($book['vendor']) ?>
                    </div>
                </a>
            </article>
        <?php endforeach; ?>
    </section>

    <p id="no-results" class="light-grey-text">
        Aucun livre trouvé.
    </p>

</div>

<script>
    document.getElementById('bsearch').addEventListener('input', function() {
        const query = this.value.toLowerCase();
        const books = document.querySelectorAll('.book-card');
        let visibleCount = 0;

        books.forEach(book => {
            const title = book.querySelector('h4').textContent.toLowerCase();
            if (title.includes(query)) {
                book.style.display = '';
                visibleCount ++;
            } else {
                book.style.display = 'none';
            }
        });
        document.getElementById('no-results').style.display = visibleCount === 0 ? 'block' : 'none';
    });
</script>



